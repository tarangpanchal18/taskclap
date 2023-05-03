<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\ProductRepository;
use App\Services\FilesService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{

    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
        private FilesService $fileService
    ) {
        $this->productRepository = $productRepository;
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->productRepository->getRaw($request?->filterData);
            if (empty($request->order)) {
                $data->latest('id');
            }

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('status', function($row) {
                        return '<span class="badge badge-'. ($row->status == "Active" ? "success" : "danger") .'">'. $row->status .'</span>' .
                        PHP_EOL;
                    })
                    ->addColumn('category', function($row) {
                        return ($row?->category->name ? $row->category->name : 'N/A');
                    })
                    ->addColumn('subcategory', function($row) {
                        return ($row?->subCategory->name ? $row->subCategory->name : 'N/A');
                    })
                    ->addColumn('action', function($row) {
                            return '<div style="width: 150px">' .
                            '<a href="'. route('admin.products.edit', $row->id) .'" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                            '<button onclick="removeData('. $row->id. ')" class="edit btn btn-default btn-sm"><i class="fa fa-trash"></i> Remove</button>' .
                            '<div>' .
                            PHP_EOL;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }

        return view('admin.products.index', [
            'categoryData' => $this->categoryRepository->getParentCategory()
        ]);
    }

    public function create()
    {
        return view('admin.products.alter', [
            'action' => 'Add',
            'actionUrl' => route('admin.products.store'),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        if ($request->file('image')) {
            $validated['image'] = $this->fileService->generateFileName('cat', $request->file('image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('image'),
                Product::UPLOAD_PATH,
                $validated['image']
            );
        }
        $this->productRepository->create($validated);

        return redirect(route('admin.products.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(Product $product)
    {
        return view('admin.products.alter', [
            'product' => $product,
            'action' => 'Edit',
            'actionUrl' => route('admin.products.update', $product),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        if ($request->file('image')) {
            $this->fileService->removeFile(Product::UPLOAD_PATH, $product->image);
            $validated['image'] = $this->fileService->generateFileName('pro', $request->file('image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('image'),
                Product::UPLOAD_PATH,
                $validated['image']
            );
        }

        $this->productRepository->update($product->id, $validated);
        return redirect(route('admin.products.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            $this->fileService->removeFile(Product::UPLOAD_PATH, $product->image);
        }

        $this->productRepository->delete($product->id);
        return redirect(route('admin.products.index'))->with('success', 'Data Deleted Successfully !');
    }
}

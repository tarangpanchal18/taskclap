<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Product;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\ServiceRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{

    public function __construct(private ServiceRepository $serviceRepository, private CategoryRepository $categoryRepository) {
        $this->serviceRepository = $serviceRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request, Product $product)
    {
        if ($request->ajax()) {
            $data = $this->serviceRepository->getRaw($request?->filterData);
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
                    ->addColumn('parent', function($row) {
                        return ($row?->parent->title ? $row->parent->title : 'N/A');
                    })
                    ->addColumn('action', function($row) {
                            return '<div style="width: 150px">' .
                            '<a href="'. route('admin.products.services.edit', [$row->parent_id, $row->id]) . '" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>&nbsp;' .
                            '<button onclick="removeData('. $row->id. ')" class="edit btn btn-default btn-sm"><i class="fa fa-trash"></i> Remove</button>' .
                            '<div>' .
                            PHP_EOL;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }

        return view('admin.services.index', [
            'product' => $product,
            'categoryData' => $this->categoryRepository->getParentCategory()
        ]);
    }

    public function create(Product $product)
    {
        return view('admin.services.alter', [
            'action' => 'Add',
            'product' => $product,
            'actionUrl' => route('admin.products.services.store', $product),
        ]);
    }

    public function store(ServiceRequest $request, Product $product)
    {
        $this->serviceRepository->create($request->validated());
        return redirect(route('admin.products.services.index', $product))->with('success', 'Data Created Successfully !');
    }

    public function edit(Product $product, Product $service)
    {
        return view('admin.services.alter', [
            'action' => 'Edit',
            'product' => $product,
            'service' => $service,
            'actionUrl' => route('admin.products.services.update', [$product, $service]),
        ]);
    }

    public function update(ServiceRequest $request, Product $product, Product $service)
    {
        $this->serviceRepository->update($service->id, $request->validated());
        return redirect(route('admin.products.services.index', [$product, $service]))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Product $product, Product $service)
    {
        $this->serviceRepository->delete($service->id);
        return redirect(route('admin.products.services.index', [$product, $service]))->with('success', 'Data Deleted Successfully !');
    }
}

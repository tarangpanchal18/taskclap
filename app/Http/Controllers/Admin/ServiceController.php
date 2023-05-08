<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function index(Request $request)
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
                    ->addColumn('subcategory', function($row) {
                        return ($row?->subCategory->name ? $row->subCategory->name : 'N/A');
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
            'categoryData' => $this->categoryRepository->getParentCategory()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}

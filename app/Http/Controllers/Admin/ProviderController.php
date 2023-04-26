<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use App\Repositories\Admin\ProviderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProviderController extends Controller
{
    public function __construct(private ProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->providerRepository->getRaw($request?->filterData);
            if (empty($request->order)) {
                $data->latest('id');
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    return '<span class="badge badge-' . ($row->status == "Active" ? "success" : "danger") . '">' . $row->status . '</span>' .
                    PHP_EOL;
                })
                ->addColumn('action', function ($row) {
                    return '<div style="width: 150px">' .
                    '<a href="' . route('admin.providers.edit', $row->id) . '" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                    '<button onclick="removeData(' . $row->id . ')" class="edit btn btn-default btn-sm"><i class="fa fa-trash"></i> Remove</button>' .
                    '<div>' .
                        PHP_EOL;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.provider.index');
    }

    public function create()
    {
        return view('admin.provider.alter', [
            'action' => 'Add',
            'actionUrl' => route('admin.providers.store'),
        ]);
    }

    public function store(ProviderRequest $request)
    {
        $this->providerRepository->create($request->validated());
        return redirect(route('admin.providers.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(Provider $provider)
    {
        return view('admin.provider.alter', [
            'provider' => $provider,
            'action' => 'Edit',
            'actionUrl' => route('admin.providers.update', $provider),
        ]);
    }


    public function update(ProviderRequest $request, Provider $provider)
    {
        $this->providerRepository->update($provider->id, $request->validated());
        return redirect(route('admin.providers.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Provider $provider)
    {
        $this->providerRepository->delete($provider->id);
        return redirect(route('admin.providers.index'))->with('success', 'Data Deleted Successfully !');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\ProviderRepository;
use App\Services\FilesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProviderController extends Controller
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProviderRepository $providerRepository,
        private FilesService $fileService
    )
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
            'categoryData' => $this->categoryRepository->getChildCategory()->where('status', 'Active'),
        ]);
    }

    public function store(ProviderRequest $request)
    {
        $validated = $request->validated();
        if ($request->file('image')) {
            $validated['image'] = $this->fileService->generateFileName('pro', $request->file('image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('image'),
                Provider::UPLOAD_PATH,
                $validated['image']
            );
        }
        if ($request->file('id_proof')) {
            $validated['id_proof'] = $this->fileService->generateFileName('doc-', $request->file('id_proof')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('id_proof'),
                Provider::UPLOAD_PATH_DOC,
                $validated['id_proof']
            );
        }
        $this->providerRepository->create($validated);

        return redirect(route('admin.providers.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(Provider $provider)
    {
        return view('admin.provider.alter', [
            'action' => 'Edit',
            'provider' => $provider,
            'actionUrl' => route('admin.providers.update', $provider),
            'categoryData' => $this->categoryRepository->getChildCategory()->where('status', 'Active'),
        ]);
    }


    public function update(ProviderRequest $request, Provider $provider)
    {
        $validated = $request->validated();
        if ($request->file('image')) {
            $this->fileService->removeFile(Provider::UPLOAD_PATH, $provider->image);
            $validated['image'] = $this->fileService->generateFileName('pro', $request->file('image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('image'),
                Provider::UPLOAD_PATH,
                $validated['image']
            );
        }

        if ($request->file('id_proof')) {
            $this->fileService->removeFile(Provider::UPLOAD_PATH_DOC, $provider->image);
            $validated['id_proof'] = $this->fileService->generateFileName('doc-', $request->file('id_proof')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('id_proof'),
                Provider::UPLOAD_PATH_DOC,
                $validated['id_proof']
            );
        }
        $this->providerRepository->update($provider->id, $validated);

        return redirect(route('admin.providers.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Provider $provider)
    {
        $this->providerRepository->delete($provider->id);
        echo json_encode(['success' => true]);
    }
}

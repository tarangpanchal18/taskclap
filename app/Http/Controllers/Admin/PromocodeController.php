<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromocodeRequest;
use App\Models\Promocode;
use App\Repositories\Admin\PromocodeRepository;
use App\Services\FilesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromocodeController extends Controller
{

    public function __construct(private PromocodeRepository $promocodeRepository, private FilesService $fileService)
    {
        $this->promocodeRepository = $promocodeRepository;
    }

    public function index(Request $request): View|JsonResponse
    {
        return view('admin.promocode.index', [
            'pageData' => $this->promocodeRepository->getRaw()->latest()->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('admin.promocode.alter', [
            'action' => 'Add',
            'actionUrl' => route('admin.promocode.store'),
        ]);
    }

    public function store(PromocodeRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->promocodeRepository->create($validated);

        return redirect(route('admin.promocode.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banner.alter', [
            'banner' => $banner,
            'action' => 'Edit',
            'actionUrl' => route('admin.promocode.update', $banner),
        ]);
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $validated = $request->validated();
        if ($request->file('image')) {
            $this->fileService->removeFile(Banner::UPLOAD_PATH, $banner->image);
            $validated['image'] = $this->fileService->generateFileName('banner', $request->file('image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('image'),
                Banner::UPLOAD_PATH,
                $validated['image']
            );
        }

        $this->promocodeRepository->update($banner->id, $validated);
        return redirect(route('admin.promocode.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Promocode $banner)
    {
        if ($banner->image) {
            $this->fileService->removeFile(Promocode::UPLOAD_PATH, $banner->image);
        }

        $this->promocodeRepository->delete($banner->id);
        return redirect(route('admin.promocode.index'))->with('success', 'Data Deleted Successfully !');
    }
}

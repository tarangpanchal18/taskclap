<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Services\FilesService;
use App\Repositories\Admin\PagesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PagesController extends Controller
{
    public function __construct(private PagesRepository $pagesRepository, private FilesService $fileService)
    {
        $this->pagesRepository = $pagesRepository;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->pagesRepository->getRaw($request?->filterData);
            if (empty($request->order)) {
                $data->latest('id');
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    return '<span class="badge badge-' . ($row->status == "Active" ? "success" : "danger") . '">' . $row->status . '</span>' .
                        PHP_EOL;
                })
                ->editColumn('updated_at', function ($row) {
                    return formatDate($row->updated_at) . PHP_EOL;
                })
                ->addColumn('action', function ($row) {
                    return '<div style="width: 150px">' .
                        '<a href="' . route('admin.pages.edit', $row->id) . '" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                        '<div>' .
                        PHP_EOL;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.page.index', [
            'upload_path' => Page::UPLOAD_PATH
        ]);
    }

    public function edit(Page $page)
    {
        return view('admin.page.alter', [
            'page' => $page,
            'action' => 'Edit',
            'actionUrl' => route('admin.pages.update', $page),
        ]);
    }

    public function update(PageRequest $request, Page $page)
    {
        $validated = $request->validated();
        if ($request->file('page_image')) {
            $this->fileService->removeFile(Page::UPLOAD_PATH, $page->page_image);
            $validated['page_image'] = $this->fileService->generateFileName('page', $request->file('page_image')->getClientOriginalExtension());
            $this->fileService->uploadFile(
                $request->file('page_image'),
                Page::UPLOAD_PATH,
                $validated['page_image']
            );
        }
        $validated['slug'] = \Str::slug($validated['title']);
        $this->pagesRepository->update($page->id, $validated);

        return redirect(route('admin.pages.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Page $page)
    {
        if ($page->image) {
            $this->fileService->removeFile(Page::UPLOAD_PATH, $page->image);
        }

        $this->pagesRepository->delete($page->id);
        return redirect(route('admin.pages.index'))->with('success', 'Data Deleted Successfully !');
    }
}

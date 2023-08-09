<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Requests\FaqRequest;
use App\Services\FilesService;
use App\Repositories\Admin\FaqRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\DataTables;

class FaqController extends Controller
{
    public function __construct(private FaqRepository $faqRepository, private FilesService $fileService)
    {
        $this->faqRepository = $faqRepository;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->faqRepository->getRaw($request?->filterData);
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
                        '<a href="' . route('admin.faq.edit', $row->id) . '" class="edit btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                        '<button onclick="removeData(' . $row->id . ')" class="edit btn btn-default btn-sm"><i class="fa fa-trash"></i> Remove</button>' .
                        '<div>' .
                        PHP_EOL;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.faq.index', [
            'upload_path' => Faq::UPLOAD_PATH
        ]);
    }

    public function create(): View
    {
        return view('admin.faq.alter', [
            'action' => 'Add',
            'actionUrl' => route('admin.faq.store'),
        ]);
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->faqRepository->create($validated);

        return redirect(route('admin.faq.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.alter', [
            'faq' => $faq,
            'action' => 'Edit',
            'actionUrl' => route('admin.faq.update', $faq),
        ]);
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        $validated = $request->validated();
        $this->faqRepository->update($faq->id, $validated);

        return redirect(route('admin.faq.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Faq $faq)
    {
        $this->faqRepository->delete($faq->id);
        return redirect(route('admin.faq.index'))->with('success', 'Data Deleted Successfully !');
    }
}

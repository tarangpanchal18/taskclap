<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Models\Promocode;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PromocodeRequest;
use App\Repositories\Admin\PromocodeRepository;

class PromocodeController extends Controller
{

    public function __construct(private PromocodeRepository $promocodeRepository) {
        $this->promocodeRepository = $promocodeRepository;
    }

    public function index(): View
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
        if ($validated['validity'] == "Dynamic") {
            $validated['start_date'] = formatDate($validated['start_date'], 'Y-m-d');
            $validated['end_date'] = formatDate($validated['end_date'], 'Y-m-d');
        } else {
            $validated['start_date'] = $validated['end_date'] = NULL;
        }
        $this->promocodeRepository->create($validated);

        return redirect(route('admin.promocode.index'))->with('success', 'Data Created Successfully !');
    }

    public function edit(Promocode $promocode)
    {
        return view('admin.promocode.alter', [
            'promocode' => $promocode,
            'action' => 'Edit',
            'actionUrl' => route('admin.promocode.update', $promocode),
        ]);
    }

    public function update(PromocodeRequest $request, Promocode $promocode)
    {
        $validated = $request->validated();
        if ($validated['validity'] != "Permanent") {
            $validated['start_date'] = formatDate($validated['start_date'], 'Y-m-d');
            $validated['end_date'] = formatDate($validated['end_date'], 'Y-m-d');
        } else {
            $validated['start_date'] = $validated['end_date'] = NULL;
        }
        $this->promocodeRepository->update($promocode->id, $validated);

        return redirect(route('admin.promocode.index'))->with('success', 'Data Updated Successfully !');
    }

    public function destroy(Promocode $promocode)
    {
        $this->promocodeRepository->delete($promocode->id);
        return redirect(route('admin.promocode.index'))->with('success', 'Data Deleted Successfully !');
    }
}

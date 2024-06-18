<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Http\Requests\Ruangans\{StoreRuanganRequest, UpdateRuanganRequest};
use Yajra\DataTables\Facades\DataTables;

class RuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ruangan view')->only('index', 'show');
        $this->middleware('permission:ruangan create')->only('create', 'store');
        $this->middleware('permission:ruangan edit')->only('edit', 'update');
        $this->middleware('permission:ruangan delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {
            $ruangans = Ruangan::query();

            return DataTables::of($ruangans)
                ->addColumn('action', 'ruangans.include.action')
                ->addIndexColumn()
                ->toJson();
        }

        return view('ruangans.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('ruangans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRuanganRequest $request): \Illuminate\Http\RedirectResponse
    {
        
        Ruangan::create($request->validated());

        return to_route('ruangans.index')->with('success', __('The ruangan was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ruangan $ruangan): \Illuminate\Contracts\View\View
    {
        return view('ruangans.show', compact('ruangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ruangan $ruangan): \Illuminate\Contracts\View\View
    {
        return view('ruangans.edit', compact('ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRuanganRequest $request, Ruangan $ruangan): \Illuminate\Http\RedirectResponse
    {
        
        $ruangan->update($request->validated());

        return to_route('ruangans.index')->with('success', __('The ruangan was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruangan $ruangan): \Illuminate\Http\RedirectResponse
    {
        try {
            $ruangan->delete();

            return to_route('ruangans.index')->with('success', __('The ruangan was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('ruangans.index')->with('error', __("The ruangan can't be deleted because it's related to another table."));
        }
    }
}

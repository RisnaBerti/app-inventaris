<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\Barangs\{StoreBarangRequest, UpdateBarangRequest};
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:barang view')->only('index', 'show');
        $this->middleware('permission:barang create')->only('create', 'store');
        $this->middleware('permission:barang edit')->only('edit', 'update');
        $this->middleware('permission:barang delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {
            $barangs = Barang::query();

            return DataTables::of($barangs)
                ->addColumn('action', 'barangs.include.action')
                ->addIndexColumn()
                ->toJson();
        }

        return view('barangs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('barangs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request): \Illuminate\Http\RedirectResponse
    {
        
        Barang::create($request->validated());

        return to_route('barangs.index')->with('success', __('The barang was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang): \Illuminate\Contracts\View\View
    {
        return view('barangs.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang): \Illuminate\Contracts\View\View
    {
        return view('barangs.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang): \Illuminate\Http\RedirectResponse
    {
        
        $barang->update($request->validated());

        return to_route('barangs.index')->with('success', __('The barang was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang): \Illuminate\Http\RedirectResponse
    {
        try {
            $barang->delete();

            return to_route('barangs.index')->with('success', __('The barang was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('barangs.index')->with('error', __("The barang can't be deleted because it's related to another table."));
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Http\Requests\Jenjangs\{StoreJenjangRequest, UpdateJenjangRequest};
use Yajra\DataTables\Facades\DataTables;

class JenjangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:jenjang view')->only('index', 'show');
        $this->middleware('permission:jenjang create')->only('create', 'store');
        $this->middleware('permission:jenjang edit')->only('edit', 'update');
        $this->middleware('permission:jenjang delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {
            $jenjangs = Jenjang::query();

            return DataTables::of($jenjangs)
                ->addColumn('action', 'jenjangs.include.action')
                ->toJson();
        }

        return view('jenjangs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('jenjangs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJenjangRequest $request): \Illuminate\Http\RedirectResponse
    {
        
        Jenjang::create($request->validated());

        return to_route('jenjangs.index')->with('success', __('The jenjang was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Jenjang $jenjang): \Illuminate\Contracts\View\View
    {
        return view('jenjangs.show', compact('jenjang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jenjang $jenjang): \Illuminate\Contracts\View\View
    {
        return view('jenjangs.edit', compact('jenjang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJenjangRequest $request, Jenjang $jenjang): \Illuminate\Http\RedirectResponse
    {
        
        $jenjang->update($request->validated());

        return to_route('jenjangs.index')->with('success', __('The jenjang was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenjang $jenjang): \Illuminate\Http\RedirectResponse
    {
        try {
            $jenjang->delete();

            return to_route('jenjangs.index')->with('success', __('The jenjang was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('jenjangs.index')->with('error', __("The jenjang can't be deleted because it's related to another table."));
        }
    }
}

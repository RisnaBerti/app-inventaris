<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Jenjangs\{StoreJenjangRequest, UpdateJenjangRequest};

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
                ->addColumn('foto_jenjang', function ($row) {
                    if ($row->foto_jenjang == null) {
                        return 'belum ada gambar';
                    }
                    return asset('storage/uploads/logos/' . $row->foto_jenjang);
                })
                ->addColumn('action', 'jenjangs.include.action')
                ->addIndexColumn()
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
        $attr = $request->validated();

        if ($request->file('foto_jenjang') && $request->file('foto_jenjang')->isValid()) {
            $path = storage_path('app/public/uploads/logos');
            $originalFilename = $request->file('foto_jenjang')->getClientOriginalName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $mimeType = $request->file('foto_jenjang')->getMimeType();

            if (strpos($mimeType, 'image') !== false) {
                // Handle image file
                Image::make($request->file('foto_jenjang')->getRealPath())->resize(500, 500, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . '/' . $originalFilename);
            } else {
                // Handle non-image file
                $request->file('foto_jenjang')->move($path, $originalFilename);
            }

            $attr['foto_jenjang'] = $originalFilename;
        }

        // Jenjang::create($request->validated());

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
        $attr = $request->validated();

        if ($request->file('foto_jenjang') && $request->file('foto_jenjang')->isValid()) {
            $path = storage_path('app/public/uploads/logos/');
            $originalFilename = $request->file('foto_jenjang')->getClientOriginalName();
            $mimeType = $request->file('foto_jenjang')->getMimeType();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            if (strpos($mimeType, 'image') !== false) {
                // Handle image file
                Image::make($request->file('foto_jenjang')->getRealPath())->resize(500, 500, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $originalFilename);
            } else {
                // Handle non-image file
                $request->file('foto_jenjang')->move($path, $originalFilename);
            }

            // Delete old foto_jenjang from storage
            if ($jenjang->foto_jenjang != null && file_exists($path . $jenjang->foto_jenjang)) {
                unlink($path . $jenjang->foto_jenjang);
            }

            $attr['foto_jenjang'] = $originalFilename;
        }


        $jenjang->update($attr);

        // $jenjang->update($request->validated());

        return to_route('jenjangs.index')->with('success', __('The jenjang was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenjang $jenjang): \Illuminate\Http\RedirectResponse
    {
        try {
            $path = storage_path('app/public/uploads/logos/');

            if ($jenjang->foto_jenjang != null && file_exists($path . $jenjang->foto_jenjang)) {
                unlink($path . $jenjang->foto_jenjang);
            }

            $jenjang->delete();

            return to_route('jenjangs.index')->with('success', __('The jenjang was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('jenjangs.index')->with('error', __("The jenjang can't be deleted because it's related to another table."));
        }
    }
}

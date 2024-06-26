<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Jenjang;
use function Laravel\Prompts\alert;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Barangs\{StoreBarangRequest, UpdateBarangRequest};

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
            //get jenjang_id dari user yang login
            $jenjang_id = auth()->user()->jenjang_id;

            //jika user tidak memiliki jenjang_id maka get semua data barang
            if ($jenjang_id == null) {
                $barangs = Barang::with('jenjang')->select('barangs.*');
            } else {
                // $barangs = Barang::with('jenjang')->select('barangs.*')->where('jenjang_id', $jenjang_id);
                $barangs = Barang::with('jenjang')->where('jenjang_id', $jenjang_id)->get();
            }

            return DataTables::of($barangs)
                ->addColumn('foto_barang', function ($row) {
                    if ($row->foto_barang == null) {
                        return 'belum ada gambar';
                    }
                    return asset('storage/uploads/barang/' . $row->foto_barang);
                })
                ->addColumn('nama_jenjang', function ($row) {
                    return $row->jenjang ? $row->jenjang->nama_jenjang : 'Tidak ada jenjang';
                })
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
        //get jenjang_id dari user
        $jenjang_id = auth()->user()->jenjang_id;

        if ($jenjang_id == null) {
            $jenjangs = Jenjang::all();
        } else {
            $jenjangs = Jenjang::where('id', $jenjang_id)->get();
        }

        return view('barangs.create', compact('jenjangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request): \Illuminate\Http\RedirectResponse
    {

        $attr = $request->validated();

        if ($request->file('foto_barang') && $request->file('foto_barang')->isValid()) {
            $path = storage_path('app/public/uploads/barang');
            $originalFilename = $request->file('foto_barang')->getClientOriginalName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $mimeType = $request->file('foto_barang')->getMimeType();

            if (strpos($mimeType, 'image') !== false) {
                // Handle image file
                Image::make($request->file('foto_barang')->getRealPath())->resize(500, 500, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . '/' . $originalFilename);
            } else {
                // Handle non-image file
                $request->file('foto_barang')->move($path, $originalFilename);
            }

            $attr['foto_barang'] = $originalFilename;
        }

        Barang::create($attr);
        // Barang::create($request->validated());
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
        // jenjang
        $jenjang_id = auth()->user()->jenjang_id;

        if ($jenjang_id == null) {
            $jenjangs = Jenjang::all();
        } else {
            $jenjangs = Jenjang::where('id', $jenjang_id)->get();
        }

        return view('barangs.edit', compact('barang', 'jenjangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang): \Illuminate\Http\RedirectResponse
    {

        $attr = $request->validated();

        if ($request->file('foto_barang') && $request->file('foto_barang')->isValid()) {
            $path = storage_path('app/public/uploads/barang/');
            $originalFilename = $request->file('foto_barang')->getClientOriginalName();
            $mimeType = $request->file('foto_barang')->getMimeType();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            if (strpos($mimeType, 'image') !== false) {
                // Handle image file
                Image::make($request->file('foto_barang')->getRealPath())->resize(500, 500, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $originalFilename);
            } else {
                // Handle non-image file
                $request->file('foto_barang')->move($path, $originalFilename);
            }

            // Delete old foto_barang from storage
            if ($barang->foto_barang != null && file_exists($path . $barang->foto_barang)) {
                unlink($path . $barang->foto_barang);
            }

            $attr['foto_barang'] = $originalFilename;
        }


        $barang->update($attr);
        // $barang->update($request->validated());
        return to_route('barangs.index')->with('success', __('The barang was updated successfully.'));
    }

    // public function update(UpdateBarangRequest $request, Barang $barang): \Illuminate\Http\RedirectResponse
    // {
    //     try {
    //         $attr = $request->validated();

    //         if ($request->hasFile('foto_barang') && $request->file('foto_barang')->isValid()) {
    //             $path = 'uploads/barang/';
    //             $file = $request->file('foto_barang');
    //             $originalFilename = $file->getClientOriginalName();
    //             $mimeType = $file->getMimeType();

    //             // Ensure the path exists
    //             if (!Storage::disk('public')->exists($path)) {
    //                 Storage::disk('public')->makeDirectory($path);
    //             }

    //             if (strpos($mimeType, 'image') !== false) {
    //                 // Handle image file
    //                 $image = Image::make($file->getRealPath())->resize(500, 500, function ($constraint) {
    //                     $constraint->upsize();
    //                     $constraint->aspectRatio();
    //                 });

    //                 // Save the image to the specified path
    //                 Storage::disk('public')->put($path . $originalFilename, (string) $image->encode());
    //             } else {
    //                 // Handle non-image file
    //                 $file->storeAs($path, $originalFilename, 'public');
    //             }

    //             // Delete old foto_barang from storage
    //             if ($barang->foto_barang != null && Storage::disk('public')->exists($path . $barang->foto_barang)) {
    //                 Storage::disk('public')->delete($path . $barang->foto_barang);
    //             }

    //             $attr['foto_barang'] = $originalFilename;
    //         }

    //         //ingin mengecek apakah file foto barang sudah ada atau blm sebelum update barang

    //         $barang->update($attr);


    //         return to_route('barangs.index')->with('success', __('The barang was updated successfully.'));
    //     } catch (\Exception $e) {
    //         // Handle the exception and provide a meaningful error message
    //         return back()->withErrors(['error' => $e->getMessage()]);
    //     }
    // }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang): \Illuminate\Http\RedirectResponse
    {
        //     try {
        //         $barang->delete();

        //         return to_route('barangs.index')->with('success', __('The barang was deleted successfully.'));
        //     } catch (\Throwable $th) {
        //         return to_route('barangs.index')->with('error', __("The barang can't be deleted because it's related to another table."));
        //     }
        // }

        try {
            $path = storage_path('app/public/uploads/barang/');

            if ($barang->foto_barang != null && file_exists($path . $barang->foto_barang)) {
                unlink($path . $barang->foto_barang);
            }

            $barang->delete();

            return to_route('barangs.index')->with('success', __('The barang was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('barangs.index')->with('error', __("The barang can't be deleted because it's related to another table."));
        }
    }
}

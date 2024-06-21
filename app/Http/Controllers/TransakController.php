<?php

namespace App\Http\Controllers;

use App\Models\Transak;
use App\Models\Barang;
use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Transaks\{StoreTransakRequest, UpdateTransakRequest};

class TransakController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:transak view')->only('index', 'show');
        $this->middleware('permission:transak create')->only('create', 'store');
        $this->middleware('permission:transak edit')->only('edit', 'update');
        $this->middleware('permission:transak delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    // public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    // {
    //     if (request()->ajax()) {
    //         $transaks = Transak::with('barang:id,nama_barang', 'ruangan:id,nama_ruangan');

    //         return DataTables::of($transaks)
    //             ->addColumn('barang', function ($row) {
    //                 return $row->barang ? $row->barang->nama_barang : '';
    //             })
    //             ->addColumn('ruangan', function ($row) {
    //                 return $row->ruangan ? $row->ruangan->nama_ruangan : '';
    //             })
    //             ->addColumn('action', function ($row) {
    //                 // Pass the transak instance to the view
    //                 return view('transaks.include.action', ['transak' => $row])->render();
    //             })
    //             ->rawColumns(['action']) // Ensure the action column is not escaped
    //             ->toJson();
    //     }

    //     return view('transaks.index');
    // }





    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {
            // $transaks = Transak::with('barang:id,nama_barang', 'ruangan:id,nama_ruangan');

            $transaks = Transak::select([
                'transaks.id AS id_transaksi',
                'transaks.no_inventaris',
                'transaks.jenis_pengadaan',
                'transaks.tgl_mutasi',
                'transaks.jenis_mutasi',
                'transaks.tahun_akademik',
                'transaks.periode',
                'transaks.jml_mutasi',
                'transaks.tempat_asal',
                'transaks.qrcode',
                'barangs.id AS id_barang',
                'barangs.nama_barang',
                'barangs.kode_barang',
                'ruangans.id AS id_ruangan',
                'ruangans.nama_ruangan',
                'ruangans.jenjang_id',
                'jenjangs.nama_jenjang',
            ])
                ->join('barangs', 'barangs.id', '=', 'transaks.barang_id')
                ->join('ruangans', 'ruangans.id', '=', 'transaks.ruangan_id')
                ->join('jenjangs', 'jenjangs.id', '=', 'ruangans.jenjang_id')
                ->with('ruangan.jenjang')
                ->get();

            return DataTables::of($transaks)
                ->addColumn('nama_ruangan', function ($transak) {
                    if ($transak->jenjang_id && $transak->nama_jenjang) {
                        return $transak->nama_jenjang . ' - ' . $transak->nama_ruangan;
                    } else {
                        return 'Data Ruangan Tidak Tersedia';
                    }
                })
                ->addColumn('action', function ($row) {
                    return view('transaks.include.action', ['transak' => $row]);
                })
                ->addIndexColumn()
                ->toJson();
        }

        return view(
            'transaks.index'

        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        // Assuming $transak needs to be initialized here
        $transak = new Transak(); // Replace with your actual model and initialization logic

        $data = Ruangan::with('jenjang')->get();

        return view('transaks.create', compact('data', 'transak'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransakRequest $request): \Illuminate\Http\RedirectResponse
    {
        $attr = $request->validated();
        $attr['periode'] = $request->periode ? \Carbon\Carbon::createFromFormat('Y-m', $request->periode)->toDateTimeString() : null;

        Transak::create($attr);

        //jika ada data transak jenis_mutasi = Barang Masuk Maka jml_barang dari tabel barang bertambah
        if ($request->jenis_mutasi == 'Barang Masuk') {
            $barang = \App\Models\Barang::find($request->barang_id);
            $barang->jml_barang += $request->jml_mutasi;
            $barang->save();
        }
        // elseif ($request->jenis_mutasi == 'Barang Keluar') {
        //     $barang = \App\Models\Barang::find($request->barang_id);
        //     $barang->jml_barang -= $request->jml_mutasi;
        //     $barang->save();
        // }

        return to_route('transaks.index')->with('success', __('The transak was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transak $transak): \Illuminate\Contracts\View\View
    {
        $transak->load('barang:id,nama_barang', 'ruangan:id,nama_ruangan');

        return view('transaks.show', compact('transak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transak $transak): \Illuminate\Contracts\View\View
    {
        $transak->load('barang:id,nama_barang', 'ruangan:id,nama_ruangan');

        $data = Ruangan::with('jenjang')->get();

        return view('transaks.edit', compact('transak', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransakRequest $request, Transak $transak): \Illuminate\Http\RedirectResponse
    {
        $attr = $request->validated();
        $attr['periode'] = $request->periode ? \Carbon\Carbon::createFromFormat('Y-m', $request->periode)->toDateTimeString() : null;

        $originalJmlMutasi = $transak->jml_mutasi;
        $originalJenisMutasi = $transak->jenis_mutasi;

        $transak->update($attr);

        $barang = \App\Models\Barang::find($request->barang_id);

        // Revert the changes made by the original transaction
        if ($originalJenisMutasi == 'Barang Masuk') {
            $barang->jml_barang -= $originalJmlMutasi;
        }
        // elseif ($originalJenisMutasi == 'Barang Keluar') {
        //     $barang->jml_barang += $originalJmlMutasi;
        // }

        // Apply the changes based on the updated transaction
        if ($request->jenis_mutasi == 'Barang Masuk') {
            $barang->jml_barang += $request->jml_mutasi;
        }
        // elseif ($request->jenis_mutasi == 'Barang Keluar') {
        //     $barang->jml_barang -= $request->jml_mutasi;
        // }

        $barang->save();

        return to_route('transaks.index')->with('success', __('The transak was updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Transak $transak): \Illuminate\Http\RedirectResponse
    {
        try {
            // If the 'jenis_mutasi' is 'Barang Masuk' or 'Barang Keluar', adjust the 'jml_barang' accordingly
            if ($transak->jenis_mutasi == 'Barang Masuk') {
                $barang = \App\Models\Barang::find($transak->barang_id);
                if ($barang) {
                    $barang->jml_barang -= $transak->jml_mutasi;
                    $barang->save();
                }
            } elseif ($transak->jenis_mutasi == 'Barang Keluar') {
                $barang = \App\Models\Barang::find($transak->barang_id);
                if ($barang) {
                    $barang->jml_barang += $transak->jml_mutasi;
                    $barang->save();
                }
            }

            $transak->delete();

            return to_route('transaks.index')->with('success', __('The transak was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('transaks.index')->with('error', __("The transak can't be deleted because it's related to another table."));
        }
    }
}

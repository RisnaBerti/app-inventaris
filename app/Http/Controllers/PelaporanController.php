<?php

namespace App\Http\Controllers;

use App\Models\Transak;
use App\Models\Pelaporan;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Pelaporans\{StorePelaporanRequest, UpdatePelaporanRequest};

class PelaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pelaporan view')->only('index', 'show');
        $this->middleware('permission:pelaporan create')->only('create', 'store');
        $this->middleware('permission:pelaporan edit')->only('edit', 'update');
        $this->middleware('permission:pelaporan delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        if (request()->ajax()) {
            $pelaporans = Pelaporan::with(['transak' => function ($query) {
                $query->where('jenis_mutasi', 'Barang Keluar')
                    ->with('barang:id,nama_barang,kode_barang,merk_model,ukuran,bahan,tahun_pembuatan_pembelian')
                    ->with('ruangan:id,nama_ruangan,jenjang_id')
                    ->with('ruangan.jenjang:id,nama_jenjang'); // Ensure to load jenjang
            }])
                ->join('transaks', 'pelaporans.transak_id', '=', 'transaks.id')
                ->join('barangs', 'transaks.barang_id', '=', 'barangs.id')
                ->join('ruangans', 'transaks.ruangan_id', '=', 'ruangans.id')
                ->join('jenjangs', 'ruangans.jenjang_id', '=', 'jenjangs.id') // Correct join
                ->select(
                    'pelaporans.*',
                    'barangs.nama_barang',
                    'barangs.kode_barang',
                    'barangs.merk_model',
                    'barangs.ukuran',
                    'barangs.bahan',
                    'barangs.tahun_pembuatan_pembelian',
                    'ruangans.nama_ruangan',
                    'jenjangs.nama_jenjang', // Add the field to select statement
                    'transaks.tahun_akademik',
                    'transaks.jml_mutasi'
                );

            return DataTables::of($pelaporans)
                ->addColumn('ruangan', function ($row) {
                    return $row->nama_jenjang . ' - ' . $row->nama_ruangan;
                })
                ->addColumn('kode_barang', function ($row) {
                    return $row->kode_barang ?? '';
                })
                ->addColumn('merk_model', function ($row) {
                    return $row->merk_model ?? '';
                })
                ->addColumn('ukuran', function ($row) {
                    return $row->ukuran ?? '';
                })
                ->addColumn('bahan', function ($row) {
                    return $row->bahan ?? '';
                })
                ->addColumn('tahun_pembuatan_pembelian', function ($row) {
                    return $row->tahun_pembuatan_pembelian ?? '';
                })
                ->addColumn('nama_barang', function ($row) {
                    return $row->nama_barang ?? '';
                })
                ->addColumn('tahun_akademik', function ($row) {
                    return $row->tahun_akademik ?? '';
                })
                ->addColumn('jml_mutasi', function ($row) {
                    return $row->jml_mutasi ?? '';
                })
                ->addColumn('action', 'pelaporans.include.action')
                ->addIndexColumn()
                ->toJson();
        }

        return view('pelaporans.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        $data = Transak::with(['barang', 'ruangan.jenjang'])
            ->get();

        return view('pelaporans.create', ['data' => $data, 'pelaporan' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePelaporanRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated(); // ambil semua data yang telah divalidasi

        // Hitung total_barang dan tambahkan ke dalam data yang akan disimpan
        $total_barang = $request->jml_hilang + $request->jml_baik + $request->jml_kurang_baik + $request->jml_rusak_berat;
        $data['total_barang'] = $total_barang;

        Pelaporan::create($data); // simpan data ke dalam database

        //update jml_barang di tabel barang, dari seluruh total_barang di tabel pelaporans
        $transak = Transak::find($request->transak_id);
        $transak->barang->increment('jml_barang', $total_barang);
        $transak->barang->save();

        return to_route('pelaporans.index')->with('success', __('The pelaporan was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelaporan $pelaporan): \Illuminate\Contracts\View\View
    {
        // $pelaporan->load('barang:id,nama_barang', 'ruangan:id,nama_ruangan', 'transak:id,tahun_akademik');
        $pelaporan->load([
            'barang:id,nama_barang',
            'ruangan:id,nama_ruangan,jenjang_id',
            'ruangan.jenjang:id,nama_jenjang',
            'transak:id,tahun_akademik'
        ]);

        dd($pelaporan->toArray());

        return view('pelaporans.show', compact('pelaporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelaporan $pelaporan): \Illuminate\Contracts\View\View
    {
        $pelaporan->load('barang:id,nama_barang', 'ruangan:id,nama_ruangan', 'transak:id,tahun_akademik');

        $data = Transak::with(['barang', 'ruangan'])
            ->get();

        return view('pelaporans.edit', compact('pelaporan', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdatePelaporanRequest $request, Pelaporan $pelaporan): \Illuminate\Http\RedirectResponse
    {
        // Retrieve the current total_barang before updating
        $currentTotalBarang = $pelaporan->total_barang;

        // Calculate new total_barang
        $newTotalBarang = $request->jml_hilang + $request->jml_baik + $request->jml_kurang_baik + $request->jml_rusak_berat;

        // Update the pelaporan with the new data, including the new total_barang
        $pelaporan->update(array_merge($request->validated(), ['total_barang' => $newTotalBarang]));

        // Find the related transaction and the associated barang
        $transak = Transak::find($request->transak_id);
        $barang = $transak->barang;

        // Adjust jml_barang in the barang table
        // Subtract the old total_barang
        $barang->decrement('jml_barang', $currentTotalBarang);
        // Add the new total_barang
        $barang->increment('jml_barang', $newTotalBarang);

        // Save the changes to the barang
        $barang->save();

        return to_route('pelaporans.index')->with('success', __('The pelaporan was updated successfully.'));
    }


    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Pelaporan $pelaporan): \Illuminate\Http\RedirectResponse
    // {
    //     try {
    //         $pelaporan->delete();

    //         return to_route('pelaporans.index')->with('success', __('The pelaporan was deleted successfully.'));
    //     } catch (\Throwable $th) {
    //         return to_route('pelaporans.index')->with('error', __("The pelaporan can't be deleted because it's related to another table."));
    //     }
    // }

    public function destroy(Pelaporan $pelaporan): \Illuminate\Http\RedirectResponse
    {
        try {
            // Retrieve the related Transak and Barang before deleting the Pelaporan
            $transak = Transak::find($pelaporan->transak_id);
            $barang = $transak->barang;

            // Decrement jml_barang in the barang table by the pelaporan's total_barang
            $barang->decrement('jml_barang', $pelaporan->total_barang);

            // Save changes to the barang table
            $barang->save();

            // Delete the Pelaporan record
            $pelaporan->delete();

            return to_route('pelaporans.index')->with('success', __('The pelaporan was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('pelaporans.index')->with('error', __("The pelaporan can't be deleted because it's related to another table."));
        }
    }
}

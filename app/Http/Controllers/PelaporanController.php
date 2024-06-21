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
            //     $pelaporans = Pelaporan::with('barang:id,nama_barang,kode_barang,merk_model,ukuran,bahan,tahun_pembuatan_pembelian', 'ruangan:id,nama_ruangan', 'transak:id,tahun_akademik,jml_mutasi');

            $pelaporans = Pelaporan::with(['transak' => function ($query) {
                $query->where('jenis_mutasi', 'Barang Keluar')
                    ->with('barang:id,nama_barang,kode_barang,merk_model,ukuran,bahan,tahun_pembuatan_pembelian')
                    ->with('ruangan:id,nama_ruangan');
            }])
                ->join('transaks', 'pelaporans.transak_id', '=', 'transaks.id')
                ->join('barangs', 'transaks.barang_id', '=', 'barangs.id')
                ->join('ruangans', 'transaks.ruangan_id', '=', 'ruangans.id')
                ->select('pelaporans.*', 'barangs.nama_barang', 'barangs.kode_barang', 'barangs.merk_model', 'barangs.ukuran', 'barangs.bahan', 'barangs.tahun_pembuatan_pembelian', 'ruangans.nama_ruangan', 'transaks.tahun_akademik', 'transaks.jml_mutasi');

            return DataTables::of($pelaporans)
                ->addColumn('nama_barang', function ($row) {
                    return $row->nama_barang ?? '';
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
                ->addColumn('ruangan', function ($row) {
                    return $row->nama_ruangan ?? '';
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
        $data = Transak::with(['barang', 'ruangan'])
            ->get();


        return view('pelaporans.create', ['data' => $data, 'pelaporan' => null]);

        // return view('pelaporans.create', compact('data'));
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

        // Pelaporan::create($request->validated());

        return to_route('pelaporans.index')->with('success', __('The pelaporan was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelaporan $pelaporan): \Illuminate\Contracts\View\View
    {
        $pelaporan->load('barang:id,nama_barang', 'ruangan:id,nama_ruangan', 'transak:id,tahun_akademik');

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
        // Hitung total_barang
        $total_barang = $request->jml_hilang + $request->jml_baik + $request->jml_kurang_baik + $request->jml_rusak_berat;

        // Update data pelaporan dengan menambahkan total_barang ke dalam data yang akan disimpan
        $pelaporan->update(array_merge($request->validated(), ['total_barang' => $total_barang]));

        return to_route('pelaporans.index')->with('success', __('The pelaporan was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelaporan $pelaporan): \Illuminate\Http\RedirectResponse
    {
        try {
            $pelaporan->delete();

            return to_route('pelaporans.index')->with('success', __('The pelaporan was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('pelaporans.index')->with('error', __("The pelaporan can't be deleted because it's related to another table."));
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Ruangan;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan view')->only('index');
        $this->middleware('permission:laporan print')->only('print');
    }

    //fungsi index
    public function index(Request $request)
    {
        //jika ajax
        if ($request->ajax()) {
            $pelaporans = Pelaporan::with(['transak' => function ($query) {
                $query->with('barang:id,nama_barang,kode_barang,merk_model,ukuran,bahan,tahun_pembuatan_pembelian')
                    ->with('ruangan:id,nama_ruangan');
            }])
                ->join('transaks', 'pelaporans.transak_id', '=', 'transaks.id')
                ->join('barangs', 'transaks.barang_id', '=', 'barangs.id')
                ->join('ruangans', 'transaks.ruangan_id', '=', 'ruangans.id')
                ->select(
                    'pelaporans.*',
                    'barangs.nama_barang',
                    'barangs.kode_barang',
                    'barangs.merk_model',
                    'barangs.ukuran',
                    'barangs.bahan',
                    'barangs.tahun_pembuatan_pembelian',
                    'ruangans.nama_ruangan',
                    'transaks.tahun_akademik',
                    'transaks.jml_mutasi'
                );

            if ($request->ruangan_id) {
                $pelaporans = $pelaporans->where('transaks.ruangan_id', $request->ruangan_id);
            }

            if ($request->tahun_akademik) {
                $pelaporans = $pelaporans->where('transaks.tahun_akademik', $request->tahun_akademik);
            }

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

                // ->addColumn('action', 'pelaporans.include.action')
                ->addIndexColumn()
                ->toJson();
        }

        //get data semua ruangans
        $ruangans = Ruangan::all();
        return view('laporans.index', compact('ruangans'));
    }

    //fungsi print
    public function print(Request $request)
    {
        $ruangan_id = $request->ruangan_id; // Tangkap ruangan_id dari request
        $tahun_akademik = $request->tahun_akademik; // Tangkap tahun akademik dari request

        // Ambil nama ruangan berdasarkan ruangan_id
        $ruangan = Ruangan::find($ruangan_id);

        $inventaris = Pelaporan::with(['transak' => function ($query) {
            $query->with('barang:id,nama_barang,kode_barang,merk_model,ukuran,bahan,tahun_pembuatan_pembelian')
                ->with('ruangan:id,nama_ruangan');
        }])
            ->join('transaks', 'pelaporans.transak_id', '=', 'transaks.id')
            ->join('barangs', 'transaks.barang_id', '=', 'barangs.id')
            ->join('ruangans', 'transaks.ruangan_id', '=', 'ruangans.id')
            ->select(
                'pelaporans.*',
                'barangs.nama_barang',
                'barangs.kode_barang',
                'barangs.merk_model',
                'barangs.ukuran',
                'barangs.bahan',
                'barangs.tahun_pembuatan_pembelian',
                'ruangans.nama_ruangan',
                'transaks.tahun_akademik',
                'transaks.jml_mutasi'
            );

        if ($ruangan_id) {
            $inventaris = $inventaris->where('transaks.ruangan_id', $ruangan_id);
        }

        if ($tahun_akademik) {
            $inventaris = $inventaris->where('transaks.tahun_akademik', $tahun_akademik);
        }

        $inventaris = $inventaris->get(); // Pastikan data diambil dengan get()

        // Get data name dari tabel user yang memiliki jabatan Kepala Sekolah dari tabel pegawai
        $kepsek = Pegawai::join('users', 'pegawais.user_id', '=', 'users.id')
            ->where('pegawais.jabatan', 'Kepala Sekolah')
            ->select('users.name')
            ->first();
        $kepsek_name = $kepsek ? $kepsek->name : '';

        // Get data name dari tabel user yang memiliki jabatan Waka Sapras dari tabel pegawai
        $sapras = Pegawai::join('users', 'pegawais.user_id', '=', 'users.id')
            ->where('pegawais.jabatan', 'Waka Sapras')
            ->select('users.name')
            ->first();
        $sapras_name = $sapras ? $sapras->name : '';

        // var_dump($kepsek_name);
        // die();



        return view('laporans.print', compact('inventaris', 'ruangan', 'tahun_akademik', 'kepsek_name', 'sapras_name'));
    }
}

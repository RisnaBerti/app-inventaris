<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Jenjang;
use App\Models\Pegawai;
use App\Models\Ruangan;
use App\Models\Pelaporan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transak;
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
            $jenjang_id = auth()->user()->jenjang_id;

            if ($jenjang_id == null) {
                $pelaporans = Pelaporan::with(['transak.barang', 'transak.ruangan.jenjang'])
                    ->join('transaks', 'pelaporans.transak_id', '=', 'transaks.id')
                    ->join('barangs', 'transaks.barang_id', '=', 'barangs.id')
                    ->join('ruangans', 'transaks.ruangan_id', '=', 'ruangans.id')
                    ->join('jenjangs', 'ruangans.jenjang_id', '=', 'jenjangs.id')
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
                        'transaks.jml_mutasi',
                        'transaks.no_inventaris',
                        'jenjangs.nama_jenjang',
                        'ruangans.jenjang_id'
                    );

                if ($request->jenjang_id) {
                    $pelaporans = $pelaporans->where('transak.ruangan.jenjang.jenjangs_id', $request->jenjang_id);
                }

                if ($request->ruangan_id) {
                    $pelaporans->where('transaks.ruangan_id', $request->ruangan_id);
                }

                if ($request->tahun_akademik) {
                    $pelaporans->where('transaks.tahun_akademik', $request->tahun_akademik);
                }
            } else {

                $pelaporans = Pelaporan::with(['transak.barang', 'transak.ruangan.jenjang'])
                    ->join('transaks', 'pelaporans.transak_id', '=', 'transaks.id')
                    ->join('barangs', 'transaks.barang_id', '=', 'barangs.id')
                    ->join('ruangans', 'transaks.ruangan_id', '=', 'ruangans.id')
                    ->join('jenjangs', 'ruangans.jenjang_id', '=', 'jenjangs.id')
                    ->where('ruangans.jenjang_id', $jenjang_id)
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
                        'transaks.jml_mutasi',
                        'transaks.no_inventaris',
                        'jenjangs.nama_jenjang'
                    );

                //jika filter jenjang_id


                if ($request->ruangan_id) {
                    $pelaporans = $pelaporans->where('transaks.ruangan_id', $request->ruangan_id);
                }

                if ($request->tahun_akademik) {
                    $pelaporans = $pelaporans->where('transaks.tahun_akademik', $request->tahun_akademik);
                }
            }

            return DataTables::of($pelaporans)
                //nama_ruangan - nama_jenjang add kolom nama_ruangan
                // ->addColumn('nama_ruangan', function ($row) {
                //     return $row->nama_jenjang . ' - ' . $row->nama_ruangan;
                // })
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
                ->addColumn('nama_ruangan', function ($row) {
                    return  $row->nama_ruangan ?? '';
                })
                ->addColumn('tahun_akademik', function ($row) {
                    return $row->tahun_akademik ?? '';
                })
                ->addColumn('jml_mutasi', function ($row) {
                    return $row->jml_mutasi ?? '';
                })
                ->addColumn('no_inventaris', function ($row) {
                    return $row->no_inventaris ?? '';
                })
                ->addIndexColumn()
                ->toJson();
        }

        //get data semua ruangans
        $ruangans = Ruangan::all();
        $jenjangs = Jenjang::all(); 

        $jenjang_id = auth()->user()->jenjang_id;

        if($jenjang_id == null)
        {
        $tahun_akademiks = Transak::select('tahun_akademik')->distinct()->orderBy('tahun_akademik', 'desc')->get();
        }
        else
        {
            $tahun_akademiks = Transak::select('tahun_akademik')->distinct()->where
            ('jenjang_id', $jenjang_id)->orderBy('tahun_akademik', 'desc')->get();
        }

        return view('laporans.index', compact('ruangans', 'jenjangs', 'tahun_akademiks'));
    }

    //fungsi print
    public function print(Request $request)
    {
        $ruangan_id = $request->ruangan_id; // Tangkap ruangan_id dari request
        $tahun_akademik = $request->tahun_akademik; // Tangkap tahun akademik dari request

        // Ambil nama ruangan berdasarkan ruangan_id
        $ruangan = Ruangan::find($ruangan_id);

        $jenjang_id = auth()->user()->jenjang_id;

        // Jika jenjang_id kosong, maka ambil semua data
        // Jika jenjang_id tidak kosong, maka ambil data berdasarkan jenjang_id
        if ($jenjang_id == null) {
            $inventaris = Pelaporan::with(['transak' => function ($query) {
                $query->with('barang:id,nama_barang,kode_barang,merk_model,ukuran,bahan,tahun_pembuatan_pembelian')
                    ->with('ruangan:id,nama_ruangan');
            }])
                ->join('transaks', 'pelaporans.transak_id', '=', 'transaks.id')
                ->join('barangs', 'transaks.barang_id', '=', 'barangs.id')
                ->join('ruangans', 'transaks.ruangan_id', '=', 'ruangans.id')
                ->join('jenjangs', 'ruangans.jenjang_id', '=', 'jenjangs.id')
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
                    'transaks.jml_mutasi',
                    'jenjangs.nama_jenjang',
                    'jenjangs.id as jenjang',



                );

            if ($ruangan_id) {
                $inventaris = $inventaris->where('transaks.ruangan_id', $ruangan_id);
            }

            if ($tahun_akademik) {
                $inventaris = $inventaris->where('transaks.tahun_akademik', $tahun_akademik);
            }
            $inventaris = $inventaris->get()->sortBy('nama_ruangan'); // Pastikan data diambil dengan get()

            $kepsek = Pegawai::join('users', 'pegawais.user_id', '=', 'users.id')
                ->where('pegawais.jabatan', 'Kepala Yayasan')
                ->select('users.name')
                ->first();
            $kepsek_name = $kepsek ? $kepsek->name : '';

            $sapras = Pegawai::join('users', 'pegawais.user_id', '=', 'users.id')
                ->where('pegawais.jabatan', 'Waka Sapras Pusat')
                ->select('users.name')
                ->first();
            $sapras_name = $sapras ? $sapras->name : '';
        } else {
            $inventaris = Pelaporan::with(['transak' => function ($query) {
                $query->with('barang:id,nama_barang,kode_barang,merk_model,ukuran,bahan,tahun_pembuatan_pembelian')
                    ->with('ruangan:id,nama_ruangan');
            }])
                ->join('transaks', 'pelaporans.transak_id', '=', 'transaks.id')
                ->join('barangs', 'transaks.barang_id', '=', 'barangs.id')
                ->join('ruangans', 'transaks.ruangan_id', '=', 'ruangans.id')
                ->join('jenjangs', 'ruangans.jenjang_id', '=', 'jenjangs.id')
                ->where('jenjangs.id', $jenjang_id)
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
                    'transaks.jml_mutasi',
                    'jenjangs.nama_jenjang',
                    'jenjangs.id as jenjang',

                );

            if ($ruangan_id) {
                $inventaris = $inventaris->where('transaks.ruangan_id', $ruangan_id);
            }

            if ($tahun_akademik) {
                $inventaris = $inventaris->where('transaks.tahun_akademik', $tahun_akademik);
            }

            $inventaris = $inventaris->get()->sortBy('nama_ruangan'); // Pastikan data diambil dengan get()

            $kepsek = Pegawai::join('users', 'pegawais.user_id', '=', 'users.id')
                ->where('pegawais.jabatan', 'Kepala Sekolah')
                ->where('pegawais.jenjang_id', $jenjang_id)
                ->select('users.name')
                ->first();
            $kepsek_name = $kepsek ? $kepsek->name : '';

            $sapras = Pegawai::join('users', 'pegawais.user_id', '=', 'users.id')
                ->where('pegawais.jabatan', 'Waka Sapras')
                ->where('pegawais.jenjang_id', $jenjang_id)
                ->select('users.name')
                ->first();
            $sapras_name = $sapras ? $sapras->name : '';
        }

        // $namaSekolah = auth()->user()->jenjang->nama_sekolah;

        $user = auth()->user();
        $namaSekolah = 'Pondok Pesantren DIY - Darul Qur\'an Wal Irsyad'; // default value

        if ($user && $user->jenjang && $user->jenjang->nama_sekolah) {
            $namaSekolah = $user->jenjang->nama_sekolah;
        }

        return view('laporans.print', compact('inventaris', 'ruangan', 'tahun_akademik', 'kepsek_name', 'sapras_name', 'namaSekolah'));
    }
}

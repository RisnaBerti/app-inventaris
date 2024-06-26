<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transak;
use App\Models\Pelaporan;
use Illuminate\Support\Carbon;
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
            $jenjang_id = auth()->user()->jenjang_id;

            if ($jenjang_id == null) {
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
            } else {
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
                    //where jenjang_id
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
                        'jenjangs.nama_jenjang', // Add the field to select statement
                        'transaks.tahun_akademik',
                        'transaks.jml_mutasi'
                    );
            }

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
        //get jenjang_id dari user
        $jenjang_id = auth()->user()->jenjang_id;

        if ($jenjang_id == null) {
            $data = Transak::with(['barang', 'ruangan.jenjang'])
                ->get();
        } else {
            $data = Transak::with(['barang', 'ruangan.jenjang'])
                ->whereHas('ruangan', function ($query) use ($jenjang_id) {
                    $query->where('jenjang_id', $jenjang_id);
                })
                ->get();
        }

        return view('pelaporans.create', ['data' => $data, 'pelaporan' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StorePelaporanRequest $request): \Illuminate\Http\RedirectResponse
    // {
    //     $data = $request->validated(); // ambil semua data yang telah divalidasi

    //     // Hitung total_barang dan tambahkan ke dalam data yang akan disimpan
    //     $total_barang = $request->jml_hilang + $request->jml_baik + $request->jml_kurang_baik + $request->jml_rusak_berat;
    //     $data['total_barang'] = $total_barang;

    //     Pelaporan::create($data); // simpan data ke dalam database




    //     return to_route('pelaporans.index')->with('success', __('The pelaporan was created successfully.'));
    // }

    public function store(StorePelaporanRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated(); // Ambil semua data yang telah divalidasi

        // Hitung total_barang dan tambahkan ke dalam data yang akan disimpan
        $total_barang = $request->jml_hilang + $request->jml_baik + $request->jml_kurang_baik + $request->jml_rusak_berat;
        $data['total_barang'] = $total_barang;

        // Simpan data ke dalam database
        $pelaporan = Pelaporan::create($data);

        // Tentukan periode 6 bulan saat ini
        $currentMonth = now()->month;
        $currentYear = now()->year;

        if ($currentMonth >= 1 && $currentMonth <= 6) {
            // Periode Januari - Juni
            $startDate = Carbon::create($currentYear, 1, 1);
            $endDate = Carbon::create($currentYear, 6, 30);
        } else {
            // Periode Juli - Desember
            $startDate = Carbon::create($currentYear, 7, 1);
            $endDate = Carbon::create($currentYear, 12, 31);
        }

        // Ambil barang_id dari tabel transak
        $barang_id = $pelaporan->transak->barang_id;

        // Ambil data pelaporan untuk periode 6 bulan saat ini
        $totalBarangCurrentPeriod = Pelaporan::whereHas('transak', function ($query) use ($barang_id) {
            $query->where('barang_id', $barang_id);
        })->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_barang');

        // Perbarui jml_barang di tabel barang
        Barang::where('id', $barang_id)->update(['jml_barang' => $totalBarangCurrentPeriod]);

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

        // $data = Transak::with(['barang', 'ruangan'])
        //     ->get();

        $jenjang_id = auth()->user()->jenjang_id;

        if ($jenjang_id == null) {
            $data = Transak::with(['barang', 'ruangan.jenjang'])
                ->get();
        } else {
            $data = Transak::with(['barang', 'ruangan.jenjang'])
                ->whereHas('ruangan', function ($query) use ($jenjang_id) {
                    $query->where('jenjang_id', $jenjang_id);
                })
                ->get();
        }

        return view('pelaporans.edit', compact('pelaporan', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdatePelaporanRequest $request, Pelaporan $pelaporan): \Illuminate\Http\RedirectResponse
    {
        // Hitung total_barang baru
        $newTotalBarang = $request->jml_hilang + $request->jml_baik + $request->jml_kurang_baik + $request->jml_rusak_berat;

        // Perbarui pelaporan dengan data baru, termasuk total_barang baru
        $pelaporan->update(array_merge($request->validated(), ['total_barang' => $newTotalBarang]));

        // Tentukan periode 6 bulan saat ini
        $currentMonth = now()->month;
        $currentYear = now()->year;

        if ($currentMonth >= 1 && $currentMonth <= 6) {
            // Periode Januari - Juni
            $startDate = Carbon::create($currentYear, 1, 1);
            $endDate = Carbon::create($currentYear, 6, 30);
        } else {
            // Periode Juli - Desember
            $startDate = Carbon::create($currentYear, 7, 1);
            $endDate = Carbon::create($currentYear, 12, 31);
        }

        // Ambil barang_id dari tabel transak
        $barang_id = $pelaporan->transak->barang_id;

        // Ambil data pelaporan untuk periode 6 bulan saat ini
        $totalBarangCurrentPeriod = Pelaporan::whereHas('transak', function ($query) use ($barang_id) {
            $query->where('barang_id', $barang_id);
        })->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_barang');

        // Perbarui jml_barang di tabel barang
        Barang::where('id', $barang_id)->update(['jml_barang' => $totalBarangCurrentPeriod]);

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
            // Ambil barang_id terkait dari tabel transak sebelum menghapus Pelaporan
            $barangId = $pelaporan->transak->barang_id;

            // Hapus catatan Pelaporan
            $pelaporan->delete();

            // Tentukan periode 6 bulan saat ini
            $currentMonth = now()->month;
            $currentYear = now()->year;

            if ($currentMonth >= 1 && $currentMonth <= 6) {
                // Periode Januari - Juni
                $startDate = Carbon::create($currentYear, 1, 1);
                $endDate = Carbon::create($currentYear, 6, 30);
            } else {
                // Periode Juli - Desember
                $startDate = Carbon::create($currentYear, 7, 1);
                $endDate = Carbon::create($currentYear, 12, 31);
            }

            // Ambil data pelaporan untuk periode 6 bulan saat ini setelah penghapusan
            $totalBarangCurrentPeriod = Pelaporan::whereHas('transak', function ($query) use ($barangId) {
                $query->where('barang_id', $barangId);
            })->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_barang');

            // Perbarui jml_barang di tabel barang
            Barang::where('id', $barangId)->update(['jml_barang' => $totalBarangCurrentPeriod]);

            return to_route('pelaporans.index')->with('success', __('The pelaporan was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('pelaporans.index')->with('error', __("The pelaporan can't be deleted because it's related to another table."));
        }
    }
}

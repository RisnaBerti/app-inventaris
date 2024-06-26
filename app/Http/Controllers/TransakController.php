<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Transak;
use Carbon\Carbon;
use Milon\Barcode\DNS2D;
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
        $this->middleware('permission:transak label')->only('printLabel');
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
            $jenjang_id = auth()->user()->jenjang_id;

            // Jika user tidak memiliki jenjang_id, maka ambil semua data transaksi
            if ($jenjang_id == null) {
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
            } else {
                // Jika user memiliki jenjang_id, maka ambil data transaksi berdasarkan jenjang_id
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
                    ->where('ruangans.jenjang_id', $jenjang_id) // Filter berdasarkan jenjang pegawai
                    ->get();
            }

            return DataTables::of($transaks)
                ->addColumn('nama_ruangan', function ($transak) {
                    if ($transak->jenjang_id && $transak->nama_jenjang) {
                        return $transak->nama_jenjang . ' - ' . $transak->nama_ruangan;
                    } else {
                        return 'Data Ruangan Tidak Tersedia';
                    }
                })

                ->addColumn('qrcode', function ($row) {
                    if ($row->qrcode == null) {
                        return 'belum ada gambar';
                    }
                    return asset('storage/uploads/qrcodes/' . $row->qrcode);
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

    // public function index()
    // {
    //     if (request()->ajax()) {
    //         $user = auth()->user();

    //         // Pastikan user memiliki data pegawai terkait
    //         if (!$user->pegawai) {
    //             return response()->json(['error' => 'User tidak memiliki data pegawai terkait.']);
    //         }

    //         // Ambil id jenjang dari pegawai yang terkait dengan user
    //         $jenjang_id = $user->pegawai->jenjang_id;
    //         dd($jenjang_id);

    //         // Ambil data transaksi dengan menggunakan select yang sesuai
    //         $transaks = Transak::select([
    //             'transaks.id AS id_transaksi',
    //             'transaks.no_inventaris',
    //             'transaks.jenis_pengadaan',
    //             'transaks.tgl_mutasi',
    //             'transaks.jenis_mutasi',
    //             'transaks.tahun_akademik',
    //             'transaks.periode',
    //             'transaks.jml_mutasi',
    //             'transaks.tempat_asal',
    //             'transaks.qrcode',
    //             'barangs.id AS id_barang',
    //             'barangs.nama_barang',
    //             'barangs.kode_barang',
    //             'ruangans.id AS id_ruangan',
    //             'ruangans.nama_ruangan',
    //             'ruangans.jenjang_id',
    //             'jenjangs.nama_jenjang',
    //         ])
    //             ->join('barangs', 'barangs.id', '=', 'transaks.barang_id')
    //             ->join('ruangans', 'ruangans.id', '=', 'transaks.ruangan_id')
    //             ->join('jenjangs', 'jenjangs.id', '=', 'ruangans.jenjang_id')
    //             ->where('ruangans.jenjang_id', $jenjang_id) // Filter berdasarkan jenjang pegawai
    //             ->get();

    //         // Proses data untuk DataTables
    //         return DataTables::of($transaks)
    //             ->addColumn('nama_ruangan', function ($transak) {
    //                 if ($transak->jenjang_id && $transak->nama_jenjang) {
    //                     return $transak->nama_jenjang . ' - ' . $transak->nama_ruangan;
    //                 } else {
    //                     return 'Data Ruangan Tidak Tersedia';
    //                 }
    //             })
    //             ->addColumn('qrcode', function ($row) {
    //                 if ($row->qrcode == null) {
    //                     return 'belum ada gambar';
    //                 }
    //                 return asset('storage/uploads/qrcodes/' . $row->qrcode);
    //             })
    //             ->addColumn('action', function ($row) {
    //                 return view('transaks.include.action', ['transak' => $row]);
    //             })
    //             ->addIndexColumn()
    //             ->toJson();
    //     }

    //     // Jika bukan request ajax, tampilkan view biasa
    //     return view('transaks.index');
    // }



    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        // Assuming $transak needs to be initialized here
        $transak = new Transak();
        $barangs = Barang::all();
        $data = Ruangan::with('jenjang')->get();

        return view('transaks.create', compact('data', 'transak', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransakRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Validasi dan ambil atribut dari request yang sudah divalidasi
        $attr = $request->validated();

        // Konversi periode jika ada
        $attr['periode'] = $request->periode ? Carbon::createFromFormat('Y-m', $request->periode)->toDateTimeString() : null;

        // Buat transaksi baru
        $transak = Transak::create($attr);

        // Update kolom no_inventaris
        $ruangan = Ruangan::with('jenjang')->find($request->ruangan_id);
        $barang = Barang::find($request->barang_id);
        $no_inventaris = $ruangan->jenjang->kode_jenjang . '.' . $barang->kategori_barang . '.' . date('m') . '.' . date('Y');

        // Generate data untuk QR Code
        $data = $barang->nama_barang . ' ' . $barang->kode_barang . ' ' . $request->periode . ' ' . $ruangan->nama_ruangan . ' ' . $ruangan->jenjang->nama_jenjang;

        // Generate QR Code menggunakan Milon Barcode (DNS2D)
        $qrCode = DNS2D::getBarcodePNGPath($data, 'QRCODE');

        // Simpan QR Code sebagai file PNG
        $qrcodeName = $no_inventaris . '.png';
        $qrcodePath = public_path('storage/uploads/qrcodes/' . $qrcodeName);
        file_put_contents($qrcodePath, file_get_contents($qrCode));

        // Update no_inventaris dan qrcode pada transaksi yang baru dibuat
        $transak->update([
            'no_inventaris' => $no_inventaris,
            'qrcode' => $qrcodeName,
        ]);

        // Jika jenis_mutasi adalah 'Barang Masuk', tambahkan jumlah barang
        // if ($request->jenis_mutasi == 'Barang Masuk') {
        //     $barang->jml_barang += $request->jml_mutasi;
        //     $barang->save();
        // }
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

        // Hapus QR Code lama jika ada
        if ($transak->qrcode) {
            $qrcodePath = public_path('storage/uploads/qrcodes/' . $transak->qrcode);
            if (file_exists($qrcodePath)) {
                unlink($qrcodePath); // Hapus file QR Code lama dari sistem file
            }
        }

        $transak->update($attr);

        // Update no_inventaris dan qrcode pada transaksi yang baru dibuat
        $ruangan = \App\Models\Ruangan::with('jenjang')->find($request->ruangan_id);
        $transak->no_inventaris = $ruangan->jenjang->kode_jenjang . '.' . $transak->barang->kategori_barang . '.' . date('m') . '.' . date('Y');

        $data = $transak->barang->nama_barang . ' ' . $transak->barang->kode_barang . ' ' . $request->periode . ' ' . $ruangan->nama_ruangan . ' ' . $ruangan->jenjang->nama_jenjang;
        $qrCode = DNS2D::getBarcodePNGPath($data, 'QRCODE');
        $qrcodeName = $transak->no_inventaris . '.png';
        $qrcodePath = public_path('storage/uploads/qrcodes/' . $qrcodeName);
        file_put_contents($qrcodePath, file_get_contents($qrCode));
        $transak->qrcode = $qrcodeName;
        $transak->save();

        $barang = \App\Models\Barang::find($request->barang_id);

        // Revert the changes made by the original transaction
        // if ($originalJenisMutasi == 'Barang Masuk') {
        //     $barang->jml_barang -= $originalJmlMutasi;
        // }
        // elseif ($originalJenisMutasi == 'Barang Keluar') {
        //     $barang->jml_barang += $originalJmlMutasi;
        // }

        // Apply the changes based on the updated transaction
        // if ($request->jenis_mutasi == 'Barang Masuk') {
        //     $barang->jml_barang += $request->jml_mutasi;
        // }
        // elseif ($request->jenis_mutasi == 'Barang Keluar') {
        //     $barang->jml_barang -= $request->jml_mutasi;
        // }

        $barang->save();
        // $transak->barang()->update(['jml_barang' => $barang->jml
        //     _barang]);
        // $transak->save();

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

    //fungsi untuk membuat label inventaris dari data no_inventaris dan qrcode 

    // $barang = \App\Models\Barang::find($transak->barang_id);
    // $ruangan = \App\Models\Ruangan::find($transak->ruangan_id);
    // $label = [
    //     'no_inventaris' => $transak->no_inventaris,
    //     'nama_barang' => $barang->nama_barang,
    //     'kode_barang' => $barang->kode_barang,
    //     'periode' => $transak->periode,
    //     'nama_ruangan' => $ruangan->nama_ruangan,
    //     'nama_jenjang' => $ruangan->jenjang->nama_jenjang,
    //     'qrcode' => asset('storage/uploads/qrcodes/' . $transak->qrcode),
    // ];

    public function printLabel($id)
    {
        // Ambil data Transak berdasarkan $id
        $transak = Transak::with('ruangan.jenjang')->findOrFail($id);

        // Ambil data no inventaris dan jml mutasi dari transaksi
        $label = [
            'no_inventaris' => $transak->no_inventaris,
            'jml_mutasi' => $transak->jml_mutasi,
            'qrcode' => asset('storage/uploads/qrcodes/' . $transak->qrcode),
            'foto_jenjang' => asset('storage/uploads/logos/' . $transak->ruangan->jenjang->foto_jenjang),
        ];

        // Inisialisasi array untuk menyimpan label-label inventaris
        $labels = [];

        // Generate label inventaris dengan format no_inventaris-no_urut sesuai dengan jml_mutasi
        for ($i = 1; $i <= $label['jml_mutasi']; $i++) {
            $labels[] = [
                'no_inventaris' => $label['no_inventaris'] . '-' . $i,
                'qrcode' => $label['qrcode'],
                'foto_jenjang' => $label['foto_jenjang'],
            ];
        }

        // Tampilkan data no inventaris dan qrcode nya di view
        return view('transaks.print_label', compact('labels'));
    }
}

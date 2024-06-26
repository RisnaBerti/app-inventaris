<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Ruangan;
use App\Models\Transak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dashboard view')->only('index');
    }

    public function index(Request $request)
    {
        // $jenjang_id = auth()->user()->jenjang_id;
        $jenjang_id = auth()->user()->jenjang_id;

        // Get the selected year from the request, default to current year
        $selectedYear = $request->input('year', date('Y'));

        if ($jenjang_id == null) {
            // Fetch and process data
            $data = Transak::with('barang', 'ruangan', 'ruangan.jenjang')
                ->whereYear('tgl_mutasi', $selectedYear)
                ->get();
        } else {
            $data = Transak::with('barang', 'ruangan', 'ruangan.jenjang')
                ->whereHas('ruangan', function ($query) use ($jenjang_id) {
                    $query->where('jenjang_id', $jenjang_id);
                })
                ->whereYear('tgl_mutasi', $selectedYear)
                ->get();
        }

        // Get unique years for the filter
        $years = Transak::select(DB::raw('YEAR(tgl_mutasi) as year'))
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = [
                'nama_barang' => $item->barang->nama_barang,
                'jml_mutasi' => $item->jml_mutasi,
                'ruangan' => $item->ruangan->nama_ruangan
            ];
        }

        if ($jenjang_id == null) {
            //get total jml barang
            $total_barang = Barang::count();
            //get total jml ruangan
            $total_ruangan = Ruangan::count();
            //get total jml user
            $total_user = User::count();
        } else {
            // get total jml barang
            $total_barang = Barang::where('jenjang_id', $jenjang_id)->count();
            // get total jml ruangan
            $total_ruangan = Ruangan::where('jenjang_id', $jenjang_id)->count();
            // get total jml user
            $total_user = User::where('jenjang_id', $jenjang_id)->count();
        }

        // dd($total_barang);

        return view('dashboard', compact('formattedData', 'years', 'selectedYear', 'total_barang', 'total_ruangan', 'total_user'));
    }
}

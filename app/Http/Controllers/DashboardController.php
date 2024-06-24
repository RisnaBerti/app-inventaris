<?php

namespace App\Http\Controllers;

use App\Models\Transak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dashboard view')->only('index');
    }

    public function index(Request $request)
    {
        // Get the selected year from the request, default to current year
        $selectedYear = $request->input('year', date('Y'));

        // Fetch and process data
        $data = Transak::with('barang', 'ruangan')
            ->whereYear('tgl_mutasi', $selectedYear)
            ->get();

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


        return view('dashboard', compact('formattedData', 'years', 'selectedYear'));
    }
}

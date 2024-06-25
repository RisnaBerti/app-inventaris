<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\Pegawai;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Pegawais\{StorePegawaiRequest, UpdatePegawaiRequest};

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pegawai view')->only('index', 'show');
        $this->middleware('permission:pegawai create')->only('create', 'store');
        $this->middleware('permission:pegawai edit')->only('edit', 'update');
        $this->middleware('permission:pegawai delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
    {
        // $pegawais = Pegawai::with('user:id,name');


        // var_dump($pegawais);
        // die();

        if (request()->ajax()) {
            // $pegawais = Pegawai::with('user:id,name');
            $pegawais = Pegawai::select(
                'pegawais.id AS pegawai_id',
                'pegawais.user_id',
                'pegawais.jabatan',
                'pegawais.alamat',
                'pegawais.no_tlpn',
                'pegawais.jenis_jenjang',
                'pegawais.nama_sekolah',
                'users.name AS user_name',
                'jenjangs.nama_jenjang AS nama_jenjang',
                'jenjangs.kode_jenjang AS kode_jenjang',
                'jenjangs.id AS jenjang_id',
            )
                ->join('users', 'users.id', '=', 'pegawais.user_id')
                ->join('jenjangs', 'jenjangs.id', '=', 'pegawais.jenjang_id')
                ->get();

            return DataTables::of($pegawais)
                ->addColumn('user', function ($row) {
                    return $row->user_name;
                })
                ->addColumn('action', function ($row) {
                    return view('pegawais.include.action', ['pegawais' => $row]);
                })
                ->addIndexColumn()
                ->toJson();
        }

        return view('pegawais.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        $jenjangs = Jenjang::all();
        return view('pegawais.create', compact('jenjangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePegawaiRequest $request): \Illuminate\Http\RedirectResponse
    {

        Pegawai::create($request->validated());

        return to_route('pegawais.index')->with('success', __('The pegawai was created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai): \Illuminate\Contracts\View\View
    {
        $pegawai->load('user:id,name');

        return view('pegawais.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai): \Illuminate\Contracts\View\View
    {
        $pegawai->load('jenjang', 'user:id,name');
        $jenjangs = Jenjang::all(); // atau dapat menggunakan $pegawai->jenjang jika sudah dimuat relasinya

        return view('pegawais.edit', compact('pegawai', 'jenjangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai): \Illuminate\Http\RedirectResponse
    {

        $pegawai->update($request->validated());

        return to_route('pegawais.index')->with('success', __('The pegawai was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai): \Illuminate\Http\RedirectResponse
    {
        try {
            $pegawai->delete();

            return to_route('pegawais.index')->with('success', __('The pegawai was deleted successfully.'));
        } catch (\Throwable $th) {
            return to_route('pegawais.index')->with('error', __("The pegawai can't be deleted because it's related to another table."));
        }
    }
}

<?php

namespace App\Http\Requests\Transaks;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransakRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'barang_id' => 'required|exists:App\Models\Barang,id',
			'ruangan_id' => 'required|exists:App\Models\Ruangan,id',
			'tgl_mutasi' => 'required|date',
			'jenis_mutasi' => 'required|in:Barang Keluar,Barang Masuk',
			'tahun_akademik' => 'required|string|max:15',
			'periode' => 'required',
			'jml_mutasi' => 'required|numeric',
			'tempat_asal' => 'required|string|max:50',
            'no_inventaris' => 'required|string|max:50',
            'jenis_pengadaan' => 'required|string|max:50',
            'qrcode' => 'required|string|max:50',
        ];
    }
}

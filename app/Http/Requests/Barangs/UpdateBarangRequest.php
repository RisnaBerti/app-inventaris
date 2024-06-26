<?php

namespace App\Http\Requests\Barangs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
            'jenjang_id' => 'required', 'exists:jenjang,id',
            'kategori_barang' => 'required|string|max:25',
            'nama_barang' => 'required|string|max:50',
            'kode_barang' => 'required|string|max:15',
            'merk_model' => 'required|string|max:25',
            'ukuran' => 'string|max:25',
            'bahan' => 'string|max:25',
            'tahun_pembuatan_pembelian' => 'required|numeric',
            'satuan' => 'required|string|max:25',
            'jml_barang' => 'required|numeric',
            'foto_barang' => 'nullable|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}

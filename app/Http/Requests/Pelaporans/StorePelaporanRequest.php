<?php

namespace App\Http\Requests\Pelaporans;

use Illuminate\Foundation\Http\FormRequest;

class StorePelaporanRequest extends FormRequest
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
            // 'barang_id' => 'nullable|exists:App\Models\Barang,id',
			// 'ruangan_id' => 'nullable|exists:App\Models\Ruangan,id',
			'transak_id' => 'required|exists:App\Models\Transak,id',
			'no_inventaris' => 'required|string|max:50',
			'jml_baik' => 'nullable|numeric',
			'jml_kurang_baik' => 'nullable|numeric',
			'jml_rusak_berat' => 'nullable|numeric',
			'jml_hilang' => 'nullable|numeric',
			'keterangan' => 'nullable|string',
            'total_barang' => 'nullable|numeric',
        ];
    }
}

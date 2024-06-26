<?php

namespace App\Http\Requests\Pegawais;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePegawaiRequest extends FormRequest
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
            // 'jenjang_id' => 'required|exists:App\Models\Jenjang,id',
            'user_id' => 'required|exists:App\Models\User,id',
			'jabatan' => 'required|string|max:50',
			'no_tlpn' => 'nullable|string|max:15',
			'alamat' => 'nullable|string|max:100',
            // 'jenis_jenjang' => 'nullable|string|max:50',
            // 'nama_sekolah' => 'nullable|string|max:50',
        ];
    }
}

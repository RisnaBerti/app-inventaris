<?php

namespace App\Http\Requests\Ruangans;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRuanganRequest extends FormRequest
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
            'nama_ruangan' => 'required|string|max:25',
            'jenjang_id' => 'required|exists:App\Models\Jenjang,id',
        ];
    }
}

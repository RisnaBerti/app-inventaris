<?php

namespace App\Http\Requests\Jenjangs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJenjangRequest extends FormRequest
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
            'kode_jenjang' => 'required|string|max:25',
			'nama_jenjang' => 'required|string|max:10',
        ];
    }
}

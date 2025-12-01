<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('kelas')?->id;
        return [
            'nama_kelas' => ['required', 'string', 'unique:kelas,nama_kelas' . ($id ? (',' . $id) : '')],
        ];
    }
}


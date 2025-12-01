<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('siswa')?->id;
        return [
            'nis' => ['required', 'numeric', 'unique:siswa,nis' . ($id ? (',' . $id) : '')],
            'nama_lengkap' => ['required', 'string'],
            'kelas_id' => ['required', 'integer', 'exists:kelas,id'],
        ];
    }
}


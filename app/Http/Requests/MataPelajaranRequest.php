<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MataPelajaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('mata_pelajaran')?->id;
        return [
            'kode_mapel' => ['required', 'string', 'unique:mata_pelajaran,kode_mapel' . ($id ? (',' . $id) : '')],
            'nama_mapel' => ['required', 'string'],
        ];
    }
}


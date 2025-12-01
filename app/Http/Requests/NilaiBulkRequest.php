<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiBulkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelas_id' => ['required', 'integer', 'exists:kelas,id'],
            'mapel_id' => ['required', 'integer', 'exists:mata_pelajaran,id'],
            'items' => ['required', 'array'],
            'items.*.siswa_id' => ['required', 'integer', 'exists:siswa,id'],
            'items.*.tugas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'items.*.ulangan_harian' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'items.*.uts' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'items.*.uas' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }
}


@extends('layouts.app')

@section('title','Input Nilai')

@section('content')
<div x-data="{ kelasId:'{{ $selectedKelas }}', mapelId:'{{ $selectedMapel }}' }" class="space-y-4">
    <div class="bg-white rounded shadow p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="text-sm text-gray-600">Pilih Kelas</label>
            <select x-model="kelasId" @change="window.location='{{ route('nilai.input') }}?kelas_id='+kelasId+'&mapel_id='+mapelId" class="mt-1 border rounded w-full px-3 py-2">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $k)
                <option value="{{ $k->id }}" @selected($selectedKelas==$k->id)>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm text-gray-600">Pilih Mata Pelajaran</label>
            <select x-model="mapelId" @change="window.location='{{ route('nilai.input') }}?kelas_id='+kelasId+'&mapel_id='+mapelId" class="mt-1 border rounded w-full px-3 py-2">
                <option value="">-- Pilih Mapel --</option>
                @foreach($mapelList as $m)
                <option value="{{ $m->id }}" @selected($selectedMapel==$m->id)>{{ $m->nama_mapel }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($selectedKelas && $selectedMapel)
    <form method="POST" action="{{ route('nilai.save') }}" x-data="{ items: [] }" x-init="items = [
        @foreach($items as $it)
        {
            siswa_id: {{ $it['siswa']->id }},
            nis: '{{ $it['siswa']->nis }}',
            nama: '{{ $it['siswa']->nama_lengkap }}',
            tugas: {{ optional($it['nilai'])->tugas ?? 'null' }},
            ulangan_harian: {{ optional($it['nilai'])->ulangan_harian ?? 'null' }},
            uts: {{ optional($it['nilai'])->uts ?? 'null' }},
            uas: {{ optional($it['nilai'])->uas ?? 'null' }},
        },
        @endforeach
    ]">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
        <input type="hidden" name="mapel_id" value="{{ $selectedMapel }}">
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left">No</th>
                        <th class="px-3 py-2 text-left">NIS</th>
                        <th class="px-3 py-2 text-left">Nama Siswa</th>
                        <th class="px-3 py-2 text-left">Tugas</th>
                        <th class="px-3 py-2 text-left">UH</th>
                        <th class="px-3 py-2 text-left">UTS</th>
                        <th class="px-3 py-2 text-left">UAS</th>
                        <th class="px-3 py-2 text-left">Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(row, idx) in items" :key="row.siswa_id">
                        <tr class="border-t">
                            <td class="px-3 py-2" x-text="idx+1"></td>
                            <td class="px-3 py-2" x-text="row.nis"></td>
                            <td class="px-3 py-2" x-text="row.nama"></td>
                            <td class="px-3 py-2">
                                <input type="number" min="0" max="100" x-model="row.tugas" :name="'items['+idx+'][tugas]'" class="border rounded px-2 py-1 w-20">
                            </td>
                            <td class="px-3 py-2">
                                <input type="number" min="0" max="100" x-model="row.ulangan_harian" :name="'items['+idx+'][ulangan_harian]'" class="border rounded px-2 py-1 w-20">
                            </td>
                            <td class="px-3 py-2">
                                <input type="number" min="0" max="100" x-model="row.uts" :name="'items['+idx+'][uts]'" class="border rounded px-2 py-1 w-20">
                            </td>
                            <td class="px-3 py-2">
                                <input type="number" min="0" max="100" x-model="row.uas" :name="'items['+idx+'][uas]'" class="border rounded px-2 py-1 w-20">
                            </td>
                            <td class="px-3 py-2 font-semibold text-green-700">
                                <input type="hidden" :name="'items['+idx+'][siswa_id]'" :value="row.siswa_id">
                                <span x-text="(((+row.tugas||0)*0.2)+((+row.ulangan_harian||0)*0.3)+((+row.uts||0)*0.2)+((+row.uas||0)*0.3)).toFixed(2)"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan Semua Nilai</button>
        </div>
    </form>
    @endif
</div>
@endsection

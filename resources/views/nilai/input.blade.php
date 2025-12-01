@extends('layouts.app')

@section('title','Input Nilai')

@section('content')
<div x-data="{ kelasId:'{{ $selectedKelas }}', mapelId:'{{ $selectedMapel }}', search:'' }" class="space-y-4" @keydown.escape.window="search=''">
    <div class="bg-white rounded-lg shadow-sm p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="text-sm text-gray-600">Pilih Kelas</label>
            <div class="relative mt-1">
                <select x-model="kelasId" @change="window.location='{{ route('nilai.input') }}?kelas_id='+kelasId+'&mapel_id='+mapelId" class="border rounded w-full pl-9 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" @selected($selectedKelas==$k->id)>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v3.75h3.75a.75.75 0 010 1.5H12.75v3.75a.75.75 0 01-1.5 0V8.25H7.5a.75.75 0 010-1.5h3.75V3a.75.75 0 01.75-.75z" clip-rule="evenodd"/></svg>
            </div>
        </div>
        <div>
            <label class="text-sm text-gray-600">Pilih Mata Pelajaran</label>
            <div class="relative mt-1">
                <select x-model="mapelId" @change="window.location='{{ route('nilai.input') }}?kelas_id='+kelasId+'&mapel_id='+mapelId" class="border rounded w-full pl-9 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">-- Pilih Mapel --</option>
                    @foreach($mapelList as $m)
                    <option value="{{ $m->id }}" @selected($selectedMapel==$m->id)>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400"><path fill-rule="evenodd" d="M4.5 6.75A2.25 2.25 0 016.75 4.5h10.5A2.25 2.25 0 0119.5 6.75v10.5A2.25 2.25 0 0117.25 19.5H6.75A2.25 2.25 0 014.5 17.25V6.75z" clip-rule="evenodd"/></svg>
            </div>
        </div>
        <div>
            <label class="text-sm text-gray-600">Cari Siswa</label>
            <div class="relative mt-1">
                <input x-model="search" type="text" placeholder="Ketik NIS atau nama..." class="border rounded w-full pl-9 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"/>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400"><path fill-rule="evenodd" d="M10.5 3a7.5 7.5 0 015.916 12.221l3.181 3.182a.75.75 0 11-1.06 1.06l-3.182-3.181A7.5 7.5 0 1110.5 3zm0 1.5a6 6 0 100 12 6 6 0 000-12z" clip-rule="evenodd"/></svg>
            </div>
        </div>
    </div>

    @if($selectedKelas && $selectedMapel)
    <form method="POST" action="{{ route('nilai.save') }}" x-data="{ items: [], orig: [] }" x-init="items = [
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
    ]; orig = JSON.parse(JSON.stringify(items))">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
        <input type="hidden" name="mapel_id" value="{{ $selectedMapel }}">
        <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr class="text-sm text-gray-600">
                        <th class="px-4 py-2 text-left whitespace-nowrap">No</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">NIS</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">Nama Siswa</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">Tugas</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">UH</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">UTS</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">UAS</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(row, idx) in items" :key="row.siswa_id">
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-green-50" x-show="!$root.search || ((row.nis + ' ' + row.nama).toLowerCase().includes($root.search.toLowerCase()))">
                            <td class="px-4 py-2 whitespace-nowrap" x-text="idx+1"></td>
                            <td class="px-4 py-2" x-text="row.nis"></td>
                            <td class="px-4 py-2" x-text="row.nama"></td>
                            <td class="px-4 py-2">
                                <input type="number" min="0" max="100" step="0.01" x-model="row.tugas" :name="'items['+idx+'][tugas]'" class="border rounded px-2 py-1 w-24 text-center focus:outline-none focus:ring-2 focus:ring-green-500">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" min="0" max="100" step="0.01" x-model="row.ulangan_harian" :name="'items['+idx+'][ulangan_harian]'" class="border rounded px-2 py-1 w-24 text-center focus:outline-none focus:ring-2 focus:ring-green-500">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" min="0" max="100" step="0.01" x-model="row.uts" :name="'items['+idx+'][uts]'" class="border rounded px-2 py-1 w-24 text-center focus:outline-none focus:ring-2 focus:ring-green-500">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" min="0" max="100" step="0.01" x-model="row.uas" :name="'items['+idx+'][uas]'" class="border rounded px-2 py-1 w-24 text-center focus:outline-none focus:ring-2 focus:ring-green-500">
                            </td>
                            <td class="px-4 py-2 font-semibold">
                                <input type="hidden" :name="'items['+idx+'][siswa_id]'" :value="row.siswa_id">
                                <span
                                    :class="{
                                        'text-green-700': (((+row.tugas||0)*0.2)+((+row.ulangan_harian||0)*0.3)+((+row.uts||0)*0.2)+((+row.uas||0)*0.3)) >= 85,
                                        'text-amber-600': (((+row.tugas||0)*0.2)+((+row.ulangan_harian||0)*0.3)+((+row.uts||0)*0.2)+((+row.uas||0)*0.3)) >= 75 && (((+row.tugas||0)*0.2)+((+row.ulangan_harian||0)*0.3)+((+row.uts||0)*0.2)+((+row.uas||0)*0.3)) < 85,
                                        'text-red-700': (((+row.tugas||0)*0.2)+((+row.ulangan_harian||0)*0.3)+((+row.uts||0)*0.2)+((+row.uas||0)*0.3)) < 75
                                    }"
                                    x-text="(((+row.tugas||0)*0.2)+((+row.ulangan_harian||0)*0.3)+((+row.uts||0)*0.2)+((+row.uas||0)*0.3)).toFixed(2)"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex items-center justify-between">
            <div class="text-sm text-gray-600">
                <span x-text="items.filter((row,i)=> (row.tugas ?? null) !== (orig[i]?.tugas ?? null) || (row.ulangan_harian ?? null) !== (orig[i]?.ulangan_harian ?? null) || (row.uts ?? null) !== (orig[i]?.uts ?? null) || (row.uas ?? null) !== (orig[i]?.uas ?? null)).length"></span> baris diubah
            </div>
            <button
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="!items.some((row,i)=> (row.tugas ?? null) !== (orig[i]?.tugas ?? null) || (row.ulangan_harian ?? null) !== (orig[i]?.ulangan_harian ?? null) || (row.uts ?? null) !== (orig[i]?.uts ?? null) || (row.uas ?? null) !== (orig[i]?.uas ?? null))">
                Simpan Semua Nilai
            </button>
        </div>
    </form>
    @endif
</div>
@endsection

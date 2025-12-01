@extends('layouts.guest')

@section('content')
<section class="bg-white py-10">
    <div class="max-w-5xl mx-auto px-4">
        <form action="{{ route('cek-nilai') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 mb-6">
            <div class="relative w-full max-w-md">
                <input name="q" value="{{ $q }}" aria-label="NIS atau Nama Siswa" placeholder="NIS atau Nama Siswa" class="border rounded w-full pl-10 pr-3 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400"><path fill-rule="evenodd" d="M10.5 3a7.5 7.5 0 015.916 12.221l3.181 3.182a.75.75 0 11-1.06 1.06l-3.182-3.181A7.5 7.5 0 1110.5 3zm0 1.5a6 6 0 100 12 6 6 0 000-12z" clip-rule="evenodd"/></svg>
            </div>
            <button class="w-full sm:w-auto px-4 py-3 bg-green-600 text-white rounded hover:bg-green-700">Cari Nilai</button>
        </form>

        @if($siswa)
        <div class="grid md:grid-cols-3 gap-4 sm:gap-6">
            <div class="md:col-span-1">
                <div class="bg-white border border-green-200 rounded p-4 shadow-sm">
                    <div class="font-semibold text-lg mb-2">Profil Siswa</div>
                    <div class="text-sm text-gray-600">NIS</div>
                    <div class="font-semibold">{{ $siswa->nis }}</div>
                    <div class="mt-2 text-sm text-gray-600">Nama</div>
                    <div class="font-semibold">{{ $siswa->nama_lengkap }}</div>
                    <div class="mt-2 text-sm text-gray-600">Kelas</div>
                    <div class="font-semibold">{{ $siswa->kelas->nama_kelas }}</div>
                    <form action="{{ route('transkrip.pdf') }}" method="GET" class="mt-4">
                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                        <button class="w-full px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Cetak Transkrip (PDF)</button>
                    </form>
                </div>
            </div>
            <div class="md:col-span-2">
                <form action="{{ route('cek-nilai') }}" method="GET" class="flex items-center gap-2 mb-4">
                    <input type="hidden" name="q" value="{{ $q }}">
                    <select name="mapel_id" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" @selected($selectedMapel==$m->id)>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <button class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Tampilkan</button>
                </form>

                @if($nilai)
                <div class="rounded-lg shadow-sm overflow-hidden">
                    <div class="bg-green-600 text-white px-4 py-2 font-semibold flex items-center justify-between">
                        <span>{{ $nilai->mataPelajaran->nama_mapel }}</span>
                        <span class="text-sm opacity-90">Semester Aktif</span>
                    </div>
                    <div class="bg-white p-4 space-y-3">
                        <div class="flex justify-between"><span>Tugas</span><span>{{ $nilai->tugas ?? '-' }}</span></div>
                        <div class="flex justify-between"><span>Ulangan Harian</span><span>{{ $nilai->ulangan_harian ?? '-' }}</span></div>
                        <div class="flex justify-between"><span>UTS</span><span>{{ $nilai->uts ?? '-' }}</span></div>
                        <div class="flex justify-between"><span>UAS</span><span>{{ $nilai->uas ?? '-' }}</span></div>
                        <div class="pt-2 border-t">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Nilai Akhir</span>
                                <span class="text-xl font-bold text-green-700">{{ number_format($nilai->nilai_akhir,2) }}</span>
                            </div>
                            @php
                                $na = (float)($nilai->nilai_akhir ?? 0);
                                $grade = $na >= 85 ? 'A' : ($na >= 70 ? 'B' : ($na >= 55 ? 'C' : 'D'));
                                $badge = match($grade){
                                    'A' => 'bg-green-700',
                                    'B' => 'bg-green-500',
                                    'C' => 'bg-yellow-400',
                                    default => 'bg-red-600'
                                };
                                $naPercent = max(0, min(100, $na));
                            @endphp
                            <div class="mt-2 h-2 bg-gray-100 rounded">
                                <div class="h-2 rounded {{ $na >= 85 ? 'bg-green-600' : ($na >= 70 ? 'bg-green-500' : ($na >= 55 ? 'bg-yellow-400' : 'bg-red-600')) }}" style="width: {{ $naPercent }}%"></div>
                            </div>
                            <div class="mt-2"><span class="px-3 py-1 rounded text-white {{ $badge }}">Grade {{ $grade }}</span></div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

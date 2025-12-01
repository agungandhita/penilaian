@extends('layouts.guest')

@section('content')
<section class="bg-white py-10">
    <div class="max-w-5xl mx-auto">
        <form action="{{ route('cek-nilai') }}" method="GET" class="flex items-center gap-2 mb-6">
            <input name="q" value="{{ $q }}" placeholder="NIS atau Nama Siswa" class="border rounded px-4 py-3 w-96">
            <button class="px-4 py-3 bg-green-600 text-white rounded hover:bg-green-700">Cari Nilai</button>
        </form>

        @if($siswa)
        <div class="grid md:grid-cols-3 gap-6">
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
                    <select name="mapel_id" class="border rounded px-3 py-2">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" @selected($selectedMapel==$m->id)>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <button class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Tampilkan</button>
                </form>

                @if($nilai)
                <div class="rounded shadow overflow-hidden">
                    <div class="bg-green-600 text-white px-4 py-2 font-semibold">{{ $nilai->mataPelajaran->nama_mapel }}</div>
                    <div class="bg-white p-4 space-y-2">
                        <div class="flex justify-between"><span>Tugas</span><span>{{ $nilai->tugas ?? '-' }}</span></div>
                        <div class="flex justify-between"><span>Ulangan Harian</span><span>{{ $nilai->ulangan_harian ?? '-' }}</span></div>
                        <div class="flex justify-between"><span>UTS</span><span>{{ $nilai->uts ?? '-' }}</span></div>
                        <div class="flex justify-between"><span>UAS</span><span>{{ $nilai->uas ?? '-' }}</span></div>
                        <div class="flex justify-between text-xl font-bold text-green-700"><span>Nilai Akhir</span><span>{{ number_format($nilai->nilai_akhir,2) }}</span></div>
                        @php
                            $na = (float)($nilai->nilai_akhir ?? 0);
                            $grade = $na >= 85 ? 'A' : ($na >= 70 ? 'B' : ($na >= 55 ? 'C' : 'D'));
                            $badge = match($grade){
                                'A' => 'bg-green-700',
                                'B' => 'bg-green-500',
                                'C' => 'bg-yellow-400',
                                default => 'bg-red-600'
                            };
                        @endphp
                        <div class="mt-2"><span class="px-3 py-1 rounded text-white {{ $badge }}">Grade {{ $grade }}</span></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

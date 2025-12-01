@extends('layouts.guest')

@section('content')
<section class="bg-gradient-to-br from-green-50 to-white py-16">
    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Sistem Cek Nilai Siswa</h1>
        <p class="text-gray-600 mb-8">Masukkan NIS atau Nama Siswa untuk mencari nilai</p>
        <form action="{{ route('cek-nilai') }}" method="GET" class="flex items-center gap-2 justify-center">
            <input name="q" placeholder="NIS atau Nama Siswa" class="border rounded px-4 py-3 w-80">
            <button class="px-4 py-3 bg-green-600 text-white rounded hover:bg-green-700">Cari Nilai</button>
        </form>
    </div>
</section>
@endsection

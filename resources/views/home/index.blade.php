@extends('layouts.guest')

@section('content')
<section class="bg-gradient-to-br from-green-50 to-white py-12 sm:py-16">
    <div class="max-w-3xl mx-auto text-center px-4">
        <h1 class="text-2xl sm:text-4xl font-bold text-gray-800 mb-3">Sistem Cek Nilai Siswa</h1>
        <p class="text-gray-600 mb-8">Masukkan NIS atau Nama Siswa untuk melihat nilai dan cetak transkrip</p>
        <form action="{{ route('cek-nilai') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 sm:gap-2 justify-center w-full">
            <div class="relative w-full max-w-md">
                <input name="q" aria-label="NIS atau Nama Siswa" placeholder="NIS atau Nama Siswa" class="border rounded w-full pl-10 pr-3 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-3 top-3.5 h-5 w-5 text-gray-400"><path fill-rule="evenodd" d="M10.5 3a7.5 7.5 0 015.916 12.221l3.181 3.182a.75.75 0 11-1.06 1.06l-3.182-3.181A7.5 7.5 0 1110.5 3zm0 1.5a6 6 0 100 12 6 6 0 000-12z" clip-rule="evenodd"/></svg>
            </div>
            <button class="w-full sm:w-auto px-4 py-3 bg-green-600 text-white rounded hover:bg-green-700">Cari Nilai</button>
        </form>
        <div class="text-xs text-gray-500 mt-2">Contoh: <span class="font-medium">20231234</span> atau <span class="font-medium">Budi</span></div>
    </div>
</section>

<section class="py-8">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="text-sm text-gray-600">Mudah Digunakan</div>
            <div class="mt-1 text-gray-800">Cari nilai dengan NIS atau nama siswa.</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="text-sm text-gray-600">Transkrip PDF</div>
            <div class="mt-1 text-gray-800">Cetak transkrip resmi untuk arsip.</div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="text-sm text-gray-600">Privasi Terjaga</div>
            <div class="mt-1 text-gray-800">Data siswa aman dan terproteksi.</div>
        </div>
    </div>
</section>
@endsection

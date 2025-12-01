@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4 hover:shadow-md transition">
        <div class="p-3 rounded-lg bg-green-50 text-green-700">👥</div>
        <div>
            <div class="text-sm text-gray-500">Total Siswa</div>
            <div class="text-2xl font-bold">{{ $totalSiswa }}</div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4 hover:shadow-md transition">
        <div class="p-3 rounded-lg bg-green-50 text-green-700">🏫</div>
        <div>
            <div class="text-sm text-gray-500">Total Kelas</div>
            <div class="text-2xl font-bold">{{ $totalKelas }}</div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center gap-4 hover:shadow-md transition">
        <div class="p-3 rounded-lg bg-green-50 text-green-700">📚</div>
        <div>
            <div class="text-sm text-gray-500">Total Mapel</div>
            <div class="text-2xl font-bold">{{ $totalMapel }}</div>
        </div>
    </div>
</div>

<div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <a href="{{ route('nilai.input') }}" class="group bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-1">
            <div class="text-lg font-semibold">Input Nilai</div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-green-600 group-hover:translate-x-1 transition"><path fill-rule="evenodd" d="M13.72 3.97a.75.75 0 011.06 0l6.25 6.25a.75.75 0 010 1.06l-6.25 6.25a.75.75 0 11-1.06-1.06l4.72-4.72H3a.75.75 0 010-1.5h15.44l-4.72-4.72a.75.75 0 010-1.06z" clip-rule="evenodd"/></svg>
        </div>
        <div class="text-gray-600">Masuk ke halaman input nilai.</div>
    </a>
    <a href="{{ route('siswa.index') }}" class="group bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-1">
            <div class="text-lg font-semibold">Kelola Siswa</div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-green-600 group-hover:translate-x-1 transition"><path fill-rule="evenodd" d="M13.72 3.97a.75.75 0 011.06 0l6.25 6.25a.75.75 0 010 1.06l-6.25 6.25a.75.75 0 11-1.06-1.06l4.72-4.72H3a.75.75 0 010-1.5h15.44l-4.72-4.72a.75.75 0 010-1.06z" clip-rule="evenodd"/></svg>
        </div>
        <div class="text-gray-600">Lihat dan kelola data siswa.</div>
    </a>
    <a href="{{ route('kelas.index') }}" class="group bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-1">
            <div class="text-lg font-semibold">Data Kelas</div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-green-600 group-hover:translate-x-1 transition"><path fill-rule="evenodd" d="M13.72 3.97a.75.75 0 011.06 0l6.25 6.25a.75.75 0 010 1.06l-6.25 6.25a.75.75 0 11-1.06-1.06l4.72-4.72H3a.75.75 0 010-1.5h15.44l-4.72-4.72a.75.75 0 010-1.06z" clip-rule="evenodd"/></svg>
        </div>
        <div class="text-gray-600">Kelola daftar kelas.</div>
    </a>
    <a href="{{ route('mapel.index') }}" class="group bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-1">
            <div class="text-lg font-semibold">Data Mapel</div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-green-600 group-hover:translate-x-1 transition"><path fill-rule="evenodd" d="M13.72 3.97a.75.75 0 011.06 0l6.25 6.25a.75.75 0 010 1.06l-6.25 6.25a.75.75 0 11-1.06-1.06l4.72-4.72H3a.75.75 0 010-1.5h15.44l-4.72-4.72a.75.75 0 010-1.06z" clip-rule="evenodd"/></svg>
        </div>
        <div class="text-gray-600">Kelola mata pelajaran.</div>
    </a>
</div>
@endsection

@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded shadow p-4 flex items-center gap-4">
        <div class="p-3 rounded bg-green-100 text-green-700">👥</div>
        <div>
            <div class="text-sm text-gray-500">Total Siswa</div>
            <div class="text-2xl font-bold">{{ $totalSiswa }}</div>
        </div>
    </div>
    <div class="bg-white rounded shadow p-4 flex items-center gap-4">
        <div class="p-3 rounded bg-green-100 text-green-700">🏫</div>
        <div>
            <div class="text-sm text-gray-500">Total Kelas</div>
            <div class="text-2xl font-bold">{{ $totalKelas }}</div>
        </div>
    </div>
    <div class="bg-white rounded shadow p-4 flex items-center gap-4">
        <div class="p-3 rounded bg-green-100 text-green-700">📚</div>
        <div>
            <div class="text-sm text-gray-500">Total Mapel</div>
            <div class="text-2xl font-bold">{{ $totalMapel }}</div>
        </div>
    </div>
</div>

<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
    <a href="{{ route('nilai.input') }}" class="bg-white rounded shadow p-4 hover:shadow-md transition">
        <div class="text-lg font-semibold mb-1">Quick Access</div>
        <div class="text-gray-600">Input Nilai</div>
    </a>
    <a href="{{ route('siswa.index') }}" class="bg-white rounded shadow p-4 hover:shadow-md transition">
        <div class="text-lg font-semibold mb-1">Quick Access</div>
        <div class="text-gray-600">Kelola Siswa</div>
    </a>
</div>
@endsection

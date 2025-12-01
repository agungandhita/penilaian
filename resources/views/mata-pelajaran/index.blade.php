@extends('layouts.app')

@section('title','Data Mata Pelajaran')

@section('content')
<div x-data="{ openCreate:false, editId:null }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Mata Pelajaran</h2>
        <button @click="openCreate=true" class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Tambah Mata Pelajaran</button>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 text-left">No</th>
                    <th class="px-3 py-2 text-left">Kode Mapel</th>
                    <th class="px-3 py-2 text-left">Nama Mapel</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mapel as $i => $row)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $mapel->firstItem() + $i }}</td>
                    <td class="px-3 py-2">{{ $row->kode_mapel }}</td>
                    <td class="px-3 py-2">{{ $row->nama_mapel }}</td>
                    <td class="px-3 py-2 space-x-2">
                        <button @click="editId={{ $row->id }}" class="px-2 py-1 bg-green-100 text-green-700 rounded">✏️</button>
                        <form method="POST" action="{{ route('mapel.destroy',$row) }}" class="inline" onsubmit="return confirm('Hapus mapel?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 bg-red-100 text-red-700 rounded">🗑️</button>
                        </form>
                    </td>
                </tr>
                <tr x-show="editId==={{ $row->id }}" class="bg-gray-50">
                    <td colspan="4" class="px-3 py-2">
                        <form method="POST" action="{{ route('mapel.update',$row) }}" class="grid grid-cols-3 gap-2 items-center">
                            @csrf
                            @method('PUT')
                            <input name="kode_mapel" value="{{ $row->kode_mapel }}" class="border rounded px-3 py-2" required>
                            <input name="nama_mapel" value="{{ $row->nama_mapel }}" class="border rounded px-3 py-2" required>
                            <div class="flex gap-2 justify-end col-span-3">
                                <button class="px-3 py-2 bg-green-600 text-white rounded">Simpan</button>
                                <button type="button" @click="editId=null" class="px-3 py-2 bg-gray-200 rounded">Batal</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">{{ $mapel->links() }}</div>
    </div>

    <div x-show="openCreate" class="fixed inset-0 bg-black/40 flex items-center justify-center">
        <div class="bg-white rounded shadow w-full max-w-md p-4">
            <h3 class="text-lg font-semibold mb-3">Tambah Mata Pelajaran</h3>
            <form method="POST" action="{{ route('mapel.store') }}" class="space-y-3">
                @csrf
                <input name="kode_mapel" placeholder="Kode Mapel" class="border rounded w-full px-3 py-2" required>
                <input name="nama_mapel" placeholder="Nama Mapel" class="border rounded w-full px-3 py-2" required>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openCreate=false" class="px-3 py-2 bg-gray-200 rounded">Batal</button>
                    <button class="px-3 py-2 bg-green-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

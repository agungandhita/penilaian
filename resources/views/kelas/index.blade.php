@extends('layouts.app')

@section('title','Data Kelas')

@section('content')
<div x-data="{ openCreate:false, editId:null }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Kelas</h2>
        <button @click="openCreate=true" class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Tambah Kelas</button>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 text-left">No</th>
                    <th class="px-3 py-2 text-left">Nama Kelas</th>
                    <th class="px-3 py-2 text-left">Jumlah Siswa</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelas as $i => $row)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $kelas->firstItem() + $i }}</td>
                    <td class="px-3 py-2">{{ $row->nama_kelas }}</td>
                    <td class="px-3 py-2">{{ $row->siswa_count }}</td>
                    <td class="px-3 py-2 space-x-2">
                        <button @click="editId={{ $row->id }}" class="px-2 py-1 bg-green-100 text-green-700 rounded">✏️</button>
                        <form method="POST" action="{{ route('kelas.destroy',$row) }}" class="inline" onsubmit="return confirm('Hapus kelas?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 bg-red-100 text-red-700 rounded">🗑️</button>
                        </form>
                    </td>
                </tr>
                <tr x-show="editId==={{ $row->id }}" class="bg-gray-50">
                    <td colspan="4" class="px-3 py-2">
                        <form method="POST" action="{{ route('kelas.update',$row) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <input name="nama_kelas" value="{{ $row->nama_kelas }}" class="border rounded px-3 py-2 w-64" required>
                            <button class="px-3 py-2 bg-green-600 text-white rounded">Simpan</button>
                            <button type="button" @click="editId=null" class="px-3 py-2 bg-gray-200 rounded">Batal</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">{{ $kelas->links() }}</div>
    </div>

    <div x-show="openCreate" class="fixed inset-0 bg-black/40 flex items-center justify-center">
        <div class="bg-white rounded shadow w-full max-w-md p-4">
            <h3 class="text-lg font-semibold mb-3">Tambah Kelas</h3>
            <form method="POST" action="{{ route('kelas.store') }}" class="space-y-3">
                @csrf
                <input name="nama_kelas" placeholder="Nama Kelas" class="border rounded w-full px-3 py-2" required>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openCreate=false" class="px-3 py-2 bg-gray-200 rounded">Batal</button>
                    <button class="px-3 py-2 bg-green-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title','Data Siswa')

@section('content')
<div x-data="{ openCreate:false, editId:null, q:'{{ request('q') }}', kelasId:'{{ request('kelas_id') }}' }">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
        <h2 class="text-xl font-semibold">Daftar Siswa</h2>
        <div class="flex items-center gap-2">
            <input x-model="q" @input.debounce.400ms="window.location='{{ route('siswa.index') }}?q='+q+'&kelas_id='+kelasId" placeholder="Cari NIS/Nama" class="border rounded px-3 py-2 w-64">
            <select x-model="kelasId" @change="window.location='{{ route('siswa.index') }}?q='+q+'&kelas_id='+kelasId" class="border rounded px-3 py-2">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                <option value="{{ $k->id }}" @selected(request('kelas_id')==$k->id)>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <button @click="openCreate=true" class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Tambah Siswa</button>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 text-left">No</th>
                    <th class="px-3 py-2 text-left">NIS</th>
                    <th class="px-3 py-2 text-left">Nama Lengkap</th>
                    <th class="px-3 py-2 text-left">Kelas</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $i => $row)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $siswa->firstItem() + $i }}</td>
                    <td class="px-3 py-2">{{ $row->nis }}</td>
                    <td class="px-3 py-2">{{ $row->nama_lengkap }}</td>
                    <td class="px-3 py-2">{{ $row->kelas->nama_kelas }}</td>
                    <td class="px-3 py-2 space-x-2">
                        <button @click="editId={{ $row->id }}" class="px-2 py-1 bg-green-100 text-green-700 rounded">✏️</button>
                        <form method="POST" action="{{ route('siswa.destroy',$row) }}" class="inline" onsubmit="return confirm('Hapus siswa?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 bg-red-100 text-red-700 rounded">🗑️</button>
                        </form>
                    </td>
                </tr>
                <tr x-show="editId==={{ $row->id }}" class="bg-gray-50">
                    <td colspan="5" class="px-3 py-2">
                        <form method="POST" action="{{ route('siswa.update',$row) }}" class="grid grid-cols-4 gap-2 items-center">
                            @csrf
                            @method('PUT')
                            <input name="nis" value="{{ $row->nis }}" class="border rounded px-3 py-2" required>
                            <input name="nama_lengkap" value="{{ $row->nama_lengkap }}" class="border rounded px-3 py-2" required>
                            <select name="kelas_id" class="border rounded px-3 py-2">
                                @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" @selected($row->kelas_id==$k->id)>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <div class="flex gap-2 justify-end col-span-4">
                                <button class="px-3 py-2 bg-green-600 text-white rounded">Simpan</button>
                                <button type="button" @click="editId=null" class="px-3 py-2 bg-gray-200 rounded">Batal</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">{{ $siswa->links() }}</div>
    </div>

    <div x-show="openCreate" class="fixed inset-0 bg-black/40 flex items-center justify-center">
        <div class="bg-white rounded shadow w-full max-w-md p-4">
            <h3 class="text-lg font-semibold mb-3">Tambah Siswa</h3>
            <form method="POST" action="{{ route('siswa.store') }}" class="space-y-3">
                @csrf
                <input name="nis" placeholder="NIS" class="border rounded w-full px-3 py-2" required>
                <input name="nama_lengkap" placeholder="Nama Lengkap" class="border rounded w-full px-3 py-2" required>
                <select name="kelas_id" class="border rounded w-full px-3 py-2" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openCreate=false" class="px-3 py-2 bg-gray-200 rounded">Batal</button>
                    <button class="px-3 py-2 bg-green-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

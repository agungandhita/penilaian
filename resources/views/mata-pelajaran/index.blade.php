@extends('layouts.app')

@section('title','Data Mata Pelajaran')

@section('content')
<div x-data="{ openCreate:false, editId:null, search:'' }" @keydown.escape.window="openCreate=false; editId=null">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-semibold">Daftar Mata Pelajaran</h2>
            <span class="inline-flex items-center text-sm px-2 py-1 rounded-full bg-green-100 text-green-700">{{ $mapel->total() }} total</span>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:flex-none sm:w-64">
                <input x-model="search" type="text" placeholder="Cari kode atau nama..." class="w-full border rounded px-3 py-2 pl-9 focus:outline-none focus:ring-2 focus:ring-green-500"/>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400">
                    <path fill-rule="evenodd" d="M10.5 3a7.5 7.5 0 015.916 12.221l3.181 3.182a.75.75 0 11-1.06 1.06l-3.182-3.181A7.5 7.5 0 1110.5 3zm0 1.5a6 6 0 100 12 6 6 0 000-12z" clip-rule="evenodd" />
                </svg>
            </div>
            <button @click="openCreate=true" class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700 inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M12 4.5a.75.75 0 01.75.75V11h5.75a.75.75 0 010 1.5H12.75v5.75a.75.75 0 01-1.5 0V12.5H5.5a.75.75 0 010-1.5h5.75V5.25A.75.75 0 0112 4.5z"/></svg>
                <span>Tambah Mata Pelajaran</span>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr class="text-sm text-gray-600">
                        <th class="px-4 py-2 text-left whitespace-nowrap">No</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">Kode Mapel</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">Nama Mapel</th>
                        <th class="px-4 py-2 text-left whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mapel as $i => $row)
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-green-50" x-show="!search || ($el.dataset.search && $el.dataset.search.toLowerCase().includes(search.toLowerCase()))" data-search="{{ $row->kode_mapel }} {{ $row->nama_mapel }}">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $mapel->firstItem() + $i }}</td>
                        <td class="px-4 py-2">{{ $row->kode_mapel }}</td>
                        <td class="px-4 py-2">{{ $row->nama_mapel }}</td>
                        <td class="px-4 py-2">
                            <div class="flex items-center gap-2">
                                <button @click="editId={{ $row->id }}" class="inline-flex items-center gap-1 px-2 py-1 rounded border border-green-200 text-green-700 hover:bg-green-50" title="Edit" aria-label="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M16.862 3.487a2.25 2.25 0 013.182 3.182L8.942 17.77a4.5 4.5 0 01-1.657 1.06l-3.063 1.02a.75.75 0 01-.949-.948l1.02-3.064a4.5 4.5 0 011.06-1.657L16.862 3.487z"/><path d="M19.5 8.25L15.75 4.5"/></svg>
                                </button>
                                <form method="POST" action="{{ route('mapel.destroy',$row) }}" class="inline" onsubmit="return confirm('Hapus mapel?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="inline-flex items-center gap-1 px-2 py-1 rounded border border-red-200 text-red-700 hover:bg-red-50" title="Hapus" aria-label="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M9.75 3a.75.75 0 00-.75.75V4.5H6a.75.75 0 000 1.5h12a.75.75 0 000-1.5h-3V3.75a.75.75 0 00-.75-.75h-4.5z"/><path fill-rule="evenodd" d="M6.75 7.5a.75.75 0 00-.75.75v10.5A2.25 2.25 0 008.25 21h7.5a2.25 2.25 0 002.25-2.25V8.25a.75.75 0 00-.75-.75h-10.5zm3 3a.75.75 0 011.5 0v7.5a.75.75 0 01-1.5 0v-7.5zm5.25 0a.75.75 0 011.5 0v7.5a.75.75 0 01-1.5 0v-7.5z" clip-rule="evenodd"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr x-show="editId==={{ $row->id }}" x-transition class="bg-gray-50">
                        <td colspan="4" class="px-4 py-3">
                            <form method="POST" action="{{ route('mapel.update',$row) }}" class="grid grid-cols-1 sm:grid-cols-3 gap-2 items-center">
                                @csrf
                                @method('PUT')
                                <input name="kode_mapel" value="{{ $row->kode_mapel }}" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                <input name="nama_mapel" value="{{ $row->nama_mapel }}" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                <div class="flex gap-2 justify-end sm:col-span-3">
                                    <button class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
                                    <button type="button" @click="editId=null" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-600">Belum ada data mata pelajaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t">{{ $mapel->links() }}</div>
    </div>

    <div x-show="openCreate" x-transition class="fixed inset-0 z-50 flex items-center justify-center" aria-modal="true" role="dialog">
        <div class="absolute inset-0 bg-black/40" @click.self="openCreate=false"></div>
        <div class="relative bg-white rounded-lg shadow w-full max-w-md p-4">
            <h3 class="text-lg font-semibold mb-3">Tambah Mata Pelajaran</h3>
            <form method="POST" action="{{ route('mapel.store') }}" class="space-y-3">
                @csrf
                <input name="kode_mapel" placeholder="Kode Mapel" class="border rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required autofocus>
                <input name="nama_mapel" placeholder="Nama Mapel" class="border rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openCreate=false" class="px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                    <button class="px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

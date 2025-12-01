<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Guru</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <div x-data="{ open: false }" class="min-h-screen flex">
        <aside :class="open ? 'block' : 'hidden md:block'" class="w-64 bg-gradient-to-b from-green-600 to-green-700 text-white md:flex md:flex-col">
            <div class="px-4 py-4 text-xl font-semibold">Sistem Penilaian</div>
            <nav class="px-2 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-green-800">Dashboard</a>
                <a href="{{ route('kelas.index') }}" class="block px-3 py-2 rounded hover:bg-green-800">Data Kelas</a>
                <a href="{{ route('mapel.index') }}" class="block px-3 py-2 rounded hover:bg-green-800">Data Mata Pelajaran</a>
                <a href="{{ route('siswa.index') }}" class="block px-3 py-2 rounded hover:bg-green-800">Data Siswa</a>
                <a href="{{ route('nilai.input') }}" class="block px-3 py-2 rounded hover:bg-green-800">Input Nilai</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded bg-green-800 hover:bg-green-900">Logout</button>
                </form>
            </nav>
        </aside>
        <div class="flex-1">
            <header class="bg-white shadow flex items-center justify-between px-4 py-3">
                <div class="flex items-center gap-2">
                    <button @click="open = !open" class="md:hidden p-2 rounded bg-green-600 text-white">Menu</button>
                    <div class="text-lg font-semibold">@yield('title')</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-sm">{{ auth()->user()->nama_lengkap ?? '' }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-3 py-1.5 rounded bg-green-600 text-white hover:bg-green-700">Logout</button>
                    </form>
                </div>
            </header>
            <main class="p-4">
                @include('vendor.sweetalert.alert')
                @if(session('success'))
                    <div class="mb-3 px-4 py-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Cek Nilai Siswa</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-white text-gray-800">
    <header class="px-4 py-4 bg-gradient-to-r from-green-600 to-green-500 text-white">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="font-bold text-xl">Sistem Cek Nilai Siswa</div>
            <a href="{{ route('login') }}" class="px-3 py-1.5 bg-white/20 rounded hover:bg-white/30">Login Guru</a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    @include('vendor.sweetalert.alert')
</body>
</html>

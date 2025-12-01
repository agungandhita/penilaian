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
    <header class="px-4 py-3 bg-gradient-to-r from-green-600 to-green-500 text-white">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-8 h-8 sm:w-10 sm:h-10 object-contain" />
                <div class="font-bold text-base sm:text-xl">Sistem Cek Nilai Siswa</div>
            </div>
            <a href="{{ route('login') }}" class="mt-2 sm:mt-0 px-3 py-1.5 text-sm sm:text-base bg-white/20 rounded-md hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50">Login Guru</a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    @include('vendor.sweetalert.alert')
</body>
</html>

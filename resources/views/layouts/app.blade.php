<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Sistem Drainase Pintar') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

{{-- NAVBAR --}}
<nav class="bg-blue-600 text-white">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="font-bold text-lg">
            Sistem Drainase Pintar
        </a>

        <div class="space-x-6 hidden md:flex">
            <a href="/" class="hover:underline">Beranda</a>
            <a href="#fitur" class="hover:underline">Fitur</a>
            <a href="#tentang" class="hover:underline">Tentang</a>
            <a href="#kontak" class="hover:underline">Kontak</a>

            @auth
                <a href="/dashboard" class="bg-white text-blue-600 px-4 py-1 rounded">
                    Dashboard
                </a>
            @else
                <a href="/login" class="bg-white text-blue-600 px-4 py-1 rounded">
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<main class="flex-grow">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-gray-800 text-gray-300">
    <div class="max-w-7xl mx-auto px-6 py-8 grid md:grid-cols-3 gap-6">

        <div>
            <h3 class="font-bold text-white mb-2">Drainase Pintar</h3>
            <p class="text-sm">
                Sistem pelaporan dan pemantauan drainase berbasis web
                untuk membantu pencegahan banjir.
            </p>
        </div>

        <div>
            <h3 class="font-bold text-white mb-2">Menu</h3>
            <ul class="space-y-1 text-sm">
                <li><a href="/" class="hover:underline">Beranda</a></li>
                <li><a href="#fitur" class="hover:underline">Fitur</a></li>
                <li><a href="#tentang" class="hover:underline">Tentang</a></li>
            </ul>
        </div>

        <div id="kontak">
            <h3 class="font-bold text-white mb-2">Kontak</h3>
            <p class="text-sm">Email: drainase@kota.go.id</p>
            <p class="text-sm">Telp: (031) 123456</p>
        </div>

    </div>

    <div class="text-center text-sm text-gray-400 py-4 border-t border-gray-700">
        © {{ date('Y') }} Sistem Drainase Pintar. All rights reserved.
    </div>
</footer>

</body>
</html>

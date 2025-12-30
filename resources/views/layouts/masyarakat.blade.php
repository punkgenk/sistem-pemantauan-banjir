<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Dashboard Masyarakat')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    {{-- Leaflet --}}
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-blue-700 text-white flex flex-col shadow-lg">

        {{-- Logo / Judul --}}
        <div class="p-6 text-xl font-bold border-b border-blue-600">
            <i class="fa-solid fa-water mr-2"></i>
            Sistem Drainase Pintar
            <p class="text-sm font-normal text-blue-200 mt-1">
                Masyarakat
            </p>
        </div>

        {{-- Menu --}}
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('dashboard.masyarakat') }}"
               class="flex items-center gap-3 px-4 py-3 rounded hover:bg-blue-600 transition-colors">
                <i class="fa-solid fa-chart-line w-5"></i>
                Dashboard Utama
            </a>

            <a href="{{ route('water-levels.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded hover:bg-blue-600 transition-colors">
                <i class="fa-solid fa-map-location-dot w-5"></i>
                Pantau Banjir
            </a>

            <a href="{{ route('reports.create') }}"
               class="flex items-center gap-3 px-4 py-3 rounded hover:bg-blue-600 transition-colors">
                <i class="fa-solid fa-file-circle-plus w-5"></i>
                Laporan Saya
            </a>

            <a href="{{ route('chat.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded hover:bg-blue-600 transition-colors">
                <i class="fa-solid fa-envelope w-5"></i>
                Pesan
            </a>
        </nav>

        {{-- Profil & Logout --}}
        <div class="p-4 border-t mt-auto bg-blue-600 rounded-t-lg shadow-inner">
            <div class="flex items-center gap-3">
                <img 
                    src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" 
                    alt="Profile" 
                    class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-md"
                >

                <div class="flex-1">
                    <p class="font-semibold text-white text-lg truncate">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-200 truncate">{{ auth()->user()->email }}</p>

                    <a href="{{ route('profile.edit') }}" 
                       class="text-sm text-blue-200 hover:text-white mt-1 inline-block transition-colors">
                        Edit Profil
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button class="w-full bg-red-600 hover:bg-red-700 py-2 rounded-lg font-semibold flex items-center justify-center gap-2 shadow-md transition-all hover:scale-105">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 p-8 bg-gray-100">
        @yield('content')
    </main>

</div>

@stack('scripts')
</body>
</html>

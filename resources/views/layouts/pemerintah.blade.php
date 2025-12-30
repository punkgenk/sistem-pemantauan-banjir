<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Dashboard Pemerintah')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-emerald-700 text-white flex flex-col shadow-lg">

        {{-- Header --}}
        <div class="p-6 text-xl font-bold border-b border-emerald-600">
            <i class="fa-solid fa-building-columns mr-2"></i>
            Sistem Drainase Pintar
            <p class="text-sm font-normal text-emerald-200 mt-1">Pemerintah</p>
        </div>

        {{-- Menu Navigasi --}}
        <nav class="flex-1 p-4 space-y-1">

            <a href="{{ route('dashboard.pemerintah') }}" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-emerald-600">
                <i class="fa-solid fa-gauge-high w-5"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-emerald-600">
                <i class="fa-solid fa-inbox w-5"></i>
                Laporan Masuk
            </a>

            <a href="{{ route('water-levels.index') }}" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-emerald-600">
                <i class="fa-solid fa-map-location-dot w-5"></i>
                Pantau Banjir
            </a>
{{-- 
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-emerald-600">
                <i class="fa-solid fa-chart-pie w-5"></i>
                Statistik
            </a> --}}

            <a href="{{ route('chat.index') }}" class="flex items-center gap-3 px-4 py-3 rounded hover:bg-emerald-600">
                <i class="fa-solid fa-envelope w-5"></i>
                Pesan
            </a>

        </nav>

{{-- Notifikasi --}}
<div x-data="{ open: false }" class="px-4 py-3 border-t border-emerald-600 relative">

    {{-- BUTTON --}}
    <button
        @click="open = !open"
        class="relative w-full flex items-center justify-between
               bg-emerald-600 hover:bg-emerald-700
               text-white px-4 py-2 rounded-lg transition">

        <span class="flex items-center gap-2">
            <i class="fa-solid fa-bell"></i>
            <span>Pemberitahuan</span>
        </span>

        {{-- Badge --}}
        @if(($notifCount ?? 0) > 0)
            <span
                class="absolute -top-2 -right-2
                       bg-red-600 text-white text-xs font-bold
                       w-6 h-6 rounded-full flex items-center justify-center">
                {{ $notifCount }}
            </span>
        @endif
    </button>

    {{-- DROPDOWN --}}
    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute bottom-full mb-3 left-0 w-80
               bg-white rounded-xl shadow-2xl
               ring-1 ring-black/5
               z-[9999]">

        {{-- Header --}}
        <div class="px-4 py-3 bg-emerald-600 text-white font-semibold flex items-center gap-2">
            <i class="fa-solid fa-bell"></i>
            Notifikasi Terbaru
        </div>

        {{-- LIST (SCROLL DI SINI) --}}
        <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
            @forelse($newReports ?? [] as $report)
                <a href="{{ route('admin.reports.show', $report) }}"
                   class="block px-4 py-3 hover:bg-gray-50 transition">

                    {{-- Nama Pelapor --}}
                    <p class="text-sm font-semibold text-gray-800 truncate">
                        {{ $report->user->name ?? 'Pelapor' }}
                    </p>

                    {{-- Judul --}}
                    <p class="text-sm text-gray-600 truncate">
                        {{ $report->title }}
                    </p>

                    {{-- Status + Waktu --}}
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $report->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                               ($report->status === 'selesai' ? 'bg-green-100 text-green-700' :
                                'bg-red-100 text-red-700') }}">
                            {{ ucfirst($report->status) }}
                        </span>

                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i>
                            {{ $report->created_at->locale('id')->diffForHumans() }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="px-4 py-6 text-center text-sm text-gray-500">
                    <i class="fa-regular fa-bell-slash text-xl mb-2"></i><br>
                    Tidak ada notifikasi
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if(($notifCount ?? 0) > 5)
            <a href="{{ route('admin.reports') }}"
               class="block text-center py-3 text-sm font-semibold
                      text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition">
                Lihat semua notifikasi
            </a>
        @endif
    </div>
</div>

{{-- Profil & Logout --}}
<div class="p-4 border-t mt-auto flex flex-col gap-3 bg-emerald-600 rounded-t-lg shadow-inner">

    {{-- Profil --}}
    <div class="flex items-center gap-3">
        <img src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" 
             alt="Profile" 
             class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-md">

        <div class="flex-1">
            {{-- Nama --}}
            <p class="font-semibold text-white text-lg truncate">{{ auth()->user()->name }}</p>

            {{-- Email --}}
            <p class="text-sm text-gray-200 truncate">{{ auth()->user()->email }}</p>

            {{-- Edit Profil --}}
            <a href="{{ route('profile.edit') }}" 
               class="text-sm text-blue-200 hover:text-white mt-1 inline-block transition-colors">
                Edit Profil
            </a>
        </div>
    </div>

    {{-- Logout --}}
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
    <main class="flex-1 p-8 overflow-x-auto">
        @yield('content')
    </main>

</div>

@stack('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('notifButton');
    const dropdown = document.getElementById('notifDropdown');

    if (btn && dropdown) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function () {
            dropdown.classList.add('hidden');
        });
    }
});
</script>
</body>
</html>

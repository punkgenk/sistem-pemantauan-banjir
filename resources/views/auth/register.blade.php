<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Drainase Pintar</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div x-data="{ open: true, role: null }" class="w-full px-4">

    <!-- Popup Pilih Role -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md text-center transform transition-all">
            {{-- LOGO POPUP --}}
            <img src="{{ asset('logotanya.png') }}" alt="Logo Drainase Pintar" class="mx-auto w-40 h-40 object-contain mb-4">

            <h2 class="text-2xl font-bold mb-3">Daftar Sebagai</h2>
            <p class="text-gray-600 mb-6">Pilih peran akun Anda</p>
            
            <div class="grid grid-cols-2 gap-4">
                <button
                    @click="role='pemerintah'; open=false"
                    class="flex items-center justify-center gap-2 py-4 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                    <i class="fa-solid fa-building-columns"></i> Pemerintah
                </button>
                <button
                    @click="role='masyarakat'; open=false"
                    class="flex items-center justify-center gap-2 py-4 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    <i class="fa-solid fa-users"></i> Masyarakat
                </button>
            </div>
        </div>
    </div>

    <!-- Form Register (container utama) -->
    <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-2xl mx-auto z-10 relative">
        {{-- Logo Register --}}
        <div class="text-center mb-6">
            <img src="{{ asset('Register.png') }}" alt="Logo Register" class="mx-auto w-36 h-36 mb-4">
            <h1 class="text-2xl font-bold text-gray-700">Silahkan melakukan pendaftaran akun</h1>
        </div>

        <!-- Info role terpilih -->
        <p class="text-center text-gray-600 mb-6 text-lg" x-show="role">
            Anda akan mendaftar sebagai 
            <span class="font-semibold capitalize text-blue-600" x-text="role"></span>
        </p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="hidden" name="role" x-model="role">

            <!-- Grid 2 kolom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Kolom Kiri: Nama & Email -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-3 top-3 text-gray-400"></i>
                            <input type="text" name="name" placeholder="Masukkan nama lengkap"
                                   class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Email</label>
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-3 top-3 text-gray-400"></i>
                            <input type="email" name="email" placeholder="Masukkan email"
                                   class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" required>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Password & Konfirmasi -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Password</label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                            <input type="password" name="password" placeholder="Masukkan password"
                                   class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi password"
                                   class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" required>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tombol Daftar -->
            <button :disabled="!role"
                    class="w-full mt-6 py-3 rounded-lg text-white font-semibold
                           bg-gradient-to-r from-blue-500 to-blue-700
                           disabled:opacity-50 disabled:cursor-not-allowed
                           hover:from-blue-600 hover:to-blue-800 transition">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm mt-6 text-gray-500">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Login</a>
        </p>
    </div>

</div>
</body>
</html>

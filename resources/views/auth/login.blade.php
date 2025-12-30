    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Sistem Drainase Pintar</title>

        {{-- Alpine.js --}}
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

        {{-- Tailwind CSS --}}
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full px-4">

        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md mx-auto relative">

            {{-- Logo dan Judul Sistem --}}
            <div class="text-center mb-6">
                <img src="{{ asset('Login.png') }}" 
                    alt="Logo Drainase Pintar" 
                    class="mx-auto w-36 h-36 mb-4">

                <h1 class="text-3xl font-bold text-blue-700">
                    Sistem Drainase Pintar
                </h1>
                <p class="text-gray-500 mt-1">Login ke sistem</p>
            </div>

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4 relative">
                    <i class="fa-solid fa-envelope absolute left-3 top-3 text-gray-400"></i>
                    <input type="email" name="email" placeholder="Masukkan email"
                        class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" required>
                </div>

                {{-- Password --}}
                <div class="mb-4 relative">
                    <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                    <input type="password" name="password" placeholder="Masukkan password"
                        class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition" required>
                </div>

                <button type="submit"
                        class="w-full mt-4 py-3 rounded-lg text-white font-semibold
                            bg-gradient-to-r from-blue-500 to-blue-700
                            hover:from-blue-600 hover:to-blue-800 transition">
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm mt-6 text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                    Daftar
                </a>
            </p>
        </div>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="fixed top-6 right-6 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-white hover:text-gray-200">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('[x-data]').__x.$data.show = false;
            }, 5000);
        </script>
        @endif

    </div>

    </body>
    </html> 

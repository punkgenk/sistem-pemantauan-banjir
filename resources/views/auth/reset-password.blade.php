<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sistem Drainase Pintar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full px-4">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md mx-auto">

        <div class="text-center mb-6">
            <img src="{{ asset('Login.png') }}" alt="Logo" class="mx-auto w-36 h-36 mb-4">
            <h1 class="text-3xl font-bold text-blue-700">Reset Kata Sandi</h1>
            <p class="text-gray-500 mt-1 text-sm">Masukkan kata sandi baru kamu.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email --}}
            <div class="mb-4 relative">
                <i class="fa-solid fa-envelope absolute left-3 top-3 text-gray-400"></i>
                <input type="email" name="email" value="{{ old('email', $request->email) }}"
                       placeholder="Email"
                       class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition"
                       required autofocus>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
            </div>

            {{-- Password Baru --}}
            <div class="mb-4 relative">
                <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                <input type="password" name="password"
                       placeholder="Password baru"
                       class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition"
                       required>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-4 relative">
                <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                <input type="password" name="password_confirmation"
                       placeholder="Konfirmasi password baru"
                       class="w-full border rounded-lg pl-10 pr-3 py-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-500 transition"
                       required>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-600" />
            </div>

            <button type="submit"
                    class="w-full py-3 rounded-lg text-white font-semibold
                           bg-gradient-to-r from-blue-500 to-blue-700
                           hover:from-blue-600 hover:to-blue-800 transition">
                <i class="fa-solid fa-key mr-2"></i>
                Reset Password
            </button>
        </form>

    </div>
</div>

</body>
</html>
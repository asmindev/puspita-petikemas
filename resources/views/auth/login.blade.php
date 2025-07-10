<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-6">
            <!-- Logo and Header -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="relative group">
                        <!-- Logo Container with fallback to SVG if PNG not available -->
                        <div
                            class="w-16 h-16 bg-primary rounded-lg flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300 overflow-hidden">
                            <!-- Try to load PNG logo first -->
                            <img src="{{ asset('images/brand/logo.jpeg') }}" alt="PelindoTrack Logo"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">

                            <!-- Fallback SVG Icon -->
                            <svg class="w-8 h-8 text-white hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div
                            class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center shadow-sm animate-bounce">
                            <span class="text-white text-xs font-bold">✓</span>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-1 tracking-tight">PelindoTrack</h1>
                    <p class="text-lg font-semibold text-primabg-primary uppercase tracking-wide">Sistem Manajemen</p>
                    <p class="text-slate-400 text-sm mt-4">Masuk ke akun Anda untuk melanjutkan</p>
                </div>
            </div>

            <!-- Messages -->
            @if(session('success'))
            <div class="mb-6">
                <div
                    class="bg-gradient-to-r from-emerald-500/20 to-green-500/20 border border-emerald-500/30 text-emerald-300 px-6 py-4 rounded-2xl flex items-center shadow-lg">
                    <svg class="w-6 h-6 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-semibold text-white">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6">
                <div
                    class="bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-2xl shadow-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-3 mt-0.5 flex-shrink-0 text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold text-white mb-2">Login gagal:</p>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Login Form -->
            <div
                class="bg-gradient-to-br from-slate-800/60 to-slate-700/60 backdrop-blur-sm rounded-3xl p-8 border border-slate-600/30 shadow-2xl">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-300 mb-3">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="Masukkan alamat email Anda"
                                class="w-full px-5 py-4 bg-slate-800/50 border-2 border-slate-600 rounded-2xl text-white placeholder-slate-400 focus:outline-none focus:border-primabg-primary focus:ring-4 focus:ring-primabg-primary/20 transition-all duration-200 {{ $errors->has('email') ? '!border-red-500' : '' }}"
                                required autocomplete="email" autofocus>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-5">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-300 mb-3">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda"
                                class="w-full px-5 py-4 bg-slate-800/50 border-2 border-slate-600 rounded-2xl text-white placeholder-slate-400 focus:outline-none focus:border-primabg-primary focus:ring-4 focus:ring-primabg-primary/20 transition-all duration-200 {{ $errors->has('password') ? '!border-red-500' : '' }}"
                                required autocomplete="current-password">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-5">
                                <button type="button" onclick="togglePassword()"
                                    class="text-slate-400 hover:text-white transition-colors duration-200">
                                    <svg id="show-password" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="hide-password" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414L5.636 5.636m14.142 14.142L4.223 4.223" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember"
                                class="w-4 h-4 text-primabg-primary bg-slate-700 border-slate-600 rounded focus:ring-primabg-primary focus:ring-2">
                            <label for="remember" class="ml-3 text-sm text-slate-300">
                                Ingat saya
                            </label>
                        </div>

                        <div>
                            <a href="#"
                                class="text-sm text-primabg-primary hover:text-primabg-primary transition-colors duration-200">
                                Lupa kata sandi?
                            </a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-primabg-primary via-purple-600 to-indigo-600 hover:from-primabg-primary hover:via-purple-700 hover:to-indigo-700 text-white font-bold py-4 px-8 rounded-2xl text-lg transition-all duration-200 transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-primabg-primary/25 focus:outline-none focus:ring-4 focus:ring-primabg-primary/50">
                        <div class="flex items-center justify-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk
                        </div>
                    </button>
                </form>

                <!-- Additional Actions -->
                <div class="mt-8 pt-8 border-t border-slate-600/30">
                    <div class="text-center">
                        <p class="text-slate-400 text-sm mb-4">Akses Cepat</p>
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('containers.track') }}"
                                class="inline-flex items-center px-4 py-2 bg-slate-700/50 hover:bg-slate-600/50 text-slate-300 hover:text-white text-sm font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Lacak Peti Kemas
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demo Info -->
            <div
                class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border border-amber-500/30 rounded-2xl p-4 mt-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-amber-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-amber-300 font-semibold text-sm mb-1">Akun Demo</p>
                        <p class="text-amber-200 text-xs">
                            Email: <span
                                class="font-mono bg-amber-900/30 px-2 py-1 rounded">admin@containerq.com</span><br>
                            Password: <span class="font-mono bg-amber-900/30 px-2 py-1 rounded">password</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="fixed bottom-0 left-0 right-0 bg-slate-800/30 border-t border-slate-700 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="text-center text-slate-400 text-sm">
                <p>&copy; {{ date('Y') }} Sistem Manajemen PetikemasQ. Hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const showIcon = document.getElementById('show-password');
            const hideIcon = document.getElementById('hide-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showIcon.classList.add('hidden');
                hideIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                showIcon.classList.remove('hidden');
                hideIcon.classList.add('hidden');
            }
        }

        // Auto-fill demo credentials on click
        document.addEventListener('DOMContentLoaded', function() {
            const demoInfo = document.querySelector('.bg-gradient-to-r.from-amber-500\\/10');
            if (demoInfo) {
                demoInfo.addEventListener('click', function() {
                    document.getElementById('email').value = 'admin@containerq.com';
                    document.getElementById('password').value = 'password';
                });
            }
        });
    </script>

    <style>
        .animate-bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            53%,
            80%,
            100% {
                animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                transform: translate3d(0, 0, 0);
            }

            40%,
            43% {
                animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
                transform: translate3d(0, -8px, 0);
            }

            70% {
                animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
                transform: translate3d(0, -4px, 0);
            }

            90% {
                transform: translate3d(0, -1px, 0);
            }
        }
    </style>
</body>

</html>

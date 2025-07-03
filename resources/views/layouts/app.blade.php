<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Manajemen Peti Kemas') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-800 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Enhanced Sticky Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-80 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 border-r border-slate-700 flex flex-col">
            <div class="w-full flex flex-col h-full overflow-hidden">

                <!-- Logo Section - Fixed at top -->
                <div
                    class="flex items-center justify-between h-24 px-8 border-b border-slate-700 bg-gradient-to-r from-slate-800/50 to-slate-900/50 backdrop-blur-sm flex-shrink-0">
                    <div class="flex items-center group">
                        <div class="relative">
                            <div
                                class="size-16 bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-600 rounded-3xl flex items-center justify-center shadow-2xl transform group-hover:scale-110 transition-transform duration-300 overflow-hidden">
                                <!-- Try to load PNG logo first -->
                                <img src="{{ asset('images/brand/logo.jpeg') }}" alt="PelindoTrack Logo"
                                    class="w-full h-full object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">

                                <!-- Fallback SVG Icon -->
                                <svg class="w-12 h-12 text-white hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5">
                            <span class="text-2xl font-black text-white block tracking-tight">PelindoTrack</span>
                            <span
                                class="text-xs font-bold text-blue-400 uppercase tracking-widest bg-blue-900/30 px-2 py-1 rounded-full">Manajemen
                                Pro</span>
                        </div>
                    </div>
                    <button id="closeSidebar"
                        class="lg:hidden p-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-700 transition-all duration-200 transform hover:scale-110">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Section - Scrollable with custom scrollbar -->
                <div
                    class="flex-1 overflow-y-auto px-6 py-8 scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-800">
                    <nav>
                        <div class="space-y-3">
                            <a href="{{ route('dashboard') }}"
                                class="group flex items-center px-4 py-4 rounded-2xl text-slate-300 hover:text-white transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/25' : 'hover:bg-slate-800/50' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'bg-slate-700 text-slate-400 group-hover:bg-blue-600 group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <span class="font-bold text-lg">Dasbor</span>
                                        <p class="text-xs text-slate-400 group-hover:text-slate-300">Ikhtisar &
                                            Analitik
                                        </p>
                                    </div>
                                </div>
                                @if(request()->routeIs('dashboard'))
                                <div class="w-1 h-8 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>

                            <a href="{{ route('customers.index') }}"
                                class="group flex items-center px-4 py-4 rounded-2xl text-slate-300 hover:text-white transition-all duration-300 {{ request()->routeIs('customers.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg shadow-emerald-500/25' : 'hover:bg-slate-800/50' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-3 rounded-xl {{ request()->routeIs('customers.*') ? 'bg-white/20 text-white' : 'bg-slate-700 text-slate-400 group-hover:bg-emerald-600 group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <span class="font-bold text-lg">JPT</span>
                                        <p class="text-xs text-slate-400 group-hover:text-slate-300">Kelola Pelanggan
                                        </p>
                                    </div>
                                </div>
                                @if(request()->routeIs('customers.*'))
                                <div class="w-1 h-8 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>

                            <a href="{{ route('containers.index') }}"
                                class="group flex items-center px-4 py-4 rounded-2xl text-slate-300 hover:text-white transition-all duration-300 {{ request()->routeIs('containers.*') && !request()->routeIs('containers.queue') ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/25' : 'hover:bg-slate-800/50' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-3 rounded-xl {{ request()->routeIs('containers.*') && !request()->routeIs('containers.queue') ? 'bg-white/20 text-white' : 'bg-slate-700 text-slate-400 group-hover:bg-purple-600 group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <span class="font-bold text-lg">Peti Kemas</span>
                                        <p class="text-xs text-slate-400 group-hover:text-slate-300">Manajemen
                                            Peti Kemas
                                        </p>
                                    </div>
                                </div>
                                @if(request()->routeIs('containers.*') && !request()->routeIs('containers.queue'))
                                <div class="w-1 h-8 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>

                            <a href="{{ route('containers.queue') }}"
                                class="group flex items-center px-4 py-4 rounded-2xl text-slate-300 hover:text-white transition-all duration-300 {{ request()->routeIs('containers.queue') ? 'bg-gradient-to-r from-orange-600 to-red-600 text-white shadow-lg shadow-orange-500/25' : 'hover:bg-slate-800/50' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-3 rounded-xl {{ request()->routeIs('containers.queue') ? 'bg-white/20 text-white' : 'bg-slate-700 text-slate-400 group-hover:bg-orange-600 group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <span class="font-bold text-lg">Antrian</span>
                                        <p class="text-xs text-slate-400 group-hover:text-slate-300">FCFS + Prioritas
                                        </p>
                                    </div>
                                </div>
                                @if(request()->routeIs('containers.queue'))
                                <div class="w-1 h-8 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>

                            <a href="{{ route('containers.penalty-report') }}"
                                class="group flex items-center px-4 py-4 rounded-2xl text-slate-300 hover:text-white transition-all duration-300 {{ request()->routeIs('containers.penalty-report') ? 'bg-gradient-to-r from-amber-600 to-orange-600 text-white shadow-lg shadow-amber-500/25' : 'hover:bg-slate-800/50' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-3 rounded-xl {{ request()->routeIs('containers.penalty-report') ? 'bg-white/20 text-white' : 'bg-slate-700 text-slate-400 group-hover:bg-amber-600 group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <span class="font-bold text-lg">Laporan Denda</span>
                                        <p class="text-xs text-slate-400 group-hover:text-slate-300">Denda Delivery
                                        </p>
                                    </div>
                                </div>
                                @if(request()->routeIs('containers.penalty-report'))
                                <div class="w-1 h-8 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Enhanced User Profile Section - Fixed at bottom -->
                <div class="px-6 pb-8 flex-shrink-0">
                    <div
                        class="bg-gradient-to-r from-slate-800/60 to-slate-700/60 backdrop-blur-sm rounded-2xl p-6 border border-slate-600/30 shadow-xl">
                        <div class="flex items-center">
                            <div class="relative">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-white text-lg font-bold">A</span>
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-slate-800 animate-pulse">
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-white font-bold text-lg">Pengguna Admin</p>
                                <p class="text-slate-400 text-sm">Administrator Sistem</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse mb-1"></div>
                                <span class="text-xs text-slate-400">Daring</span>
                            </div>
                        </div>

                        <!-- Quick Stats in Sidebar -->
                        <div class="mt-4 pt-4 border-t border-slate-600/30">
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <p class="text-2xl font-bold text-white">{{ $totalContainers ?? 0 }}</p>
                                    <p class="text-xs text-slate-400">Total</p>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-amber-400">{{ $pendingContainers ?? 0 }}</p>
                                    <p class="text-xs text-slate-400">Menunggu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-600 bg-opacity-75 z-40 lg:hidden hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full overflow-hidden">
            <!-- Enhanced Header -->
            <header
                class="py-2 bg-gray-800/80 backdrop-blur-sm shadow-lg border-b border-slate-600/50 sticky top-0 z-30 flex-shrink-0">
                <div class="flex items-center justify-between h-20 px-3 sm:px-4 lg:px-8">
                    <div class="flex items-center">
                        <button id="openSidebar"
                            class="lg:hidden p-2 sm:p-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-700 transition-all duration-200 transform hover:scale-110">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div class="ml-2 sm:ml-4 lg:ml-0">
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-100 tracking-tight">
                                @yield('page-title', 'Dasbor')
                            </h1>
                            <p class="text-slate-500 text-xs sm:text-sm mt-1 hidden sm:block">
                                {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}
                            </p>

                        </div>
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-4 lg:space-x-6">
                        <!-- Notification Bell -->
                        <button
                            class="relative p-2 sm:p-3 bg-slate-600/5 rounded-xl text-slate-400 hover:text-slate-200 hover:bg-slate-700 transition-all duration-200 transform hover:scale-110">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <div
                                class="absolute -top-1 -right-1 w-3 h-3 sm:w-4 sm:h-4 bg-red-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-bold hidden sm:inline">3</span>
                            </div>
                        </button>

                        <!-- User Avatar -->
                        <div class="flex items-center group cursor-pointer relative">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-200">
                                <span class="text-white text-xs sm:text-sm font-bold">U</span>
                            </div>
                            <div class="ml-2 sm:ml-3 hidden sm:block">
                                <p class="text-sm font-semibold text-slate-200">Pengguna Admin</p>
                                <p class="text-xs text-slate-300">Administrator</p>
                            </div>

                            <!-- Dropdown Menu -->
                            <div
                                class="absolute right-0 top-full mt-2 w-48 bg-slate-800 rounded-xl shadow-2xl border border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-slate-300 hover:text-white hover:bg-slate-700 transition-colors duration-200">
                                        Pengaturan Profil
                                    </a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-slate-300 hover:text-white hover:bg-slate-700 transition-colors duration-200">
                                        Preferensi
                                    </a>
                                    <div class="border-t border-slate-700 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-slate-700 transition-colors duration-200">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                </svg>
                                                Keluar
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-800 via-gray-800/30 to-gray-800/20 min-h-0">
                @if(session('success'))
                <div class="mx-3 sm:mx-6 lg:mx-8 mt-6">
                    <div
                        class="bg-gradient-to-r from-emerald-500/20 to-green-500/20 border border-emerald-500/30 text-emerald-300 px-4 sm:px-6 py-4 rounded-2xl flex items-center shadow-lg">
                        <svg class="w-6 h-6 mr-3 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold text-white">{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if($errors->any())

                <div class="mx-3 sm:mx-6 lg:mx-8 mt-6">
                    <div
                        class="bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-500/30 text-red-300 px-4 sm:px-6 py-4 rounded-2xl shadow-lg">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 mr-3 mt-0.5 flex-shrink-0 text-red-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-lg text-white">Silakan perbaiki kesalahan berikut:</p>
                                <ul class="mt-2 list-disc list-inside text-sm space-y-1 text-red-300">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="p-3 sm:p-6 lg:p-8 w-full">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    {{-- End Main Content --}}
    {{-- add for push script --}}
    @stack('scripts')
    <script>
        // Mobile sidebar toggle
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        openSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>

    <style>
        .nav-link {
            @apply flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200;
            @apply text-slate-600 hover: text-slate-900 hover:bg-slate-100;
        }

        .nav-link.active {
            @apply bg-blue-50 text-blue-700 border-r-2 border-blue-600;
        }

        .nav-link.active svg {
            @apply text-blue-600;
        }

        /* Custom scrollbar styles */
        .scrollbar-thin {
            scrollbar-width: thin;
        }

        .scrollbar-thumb-slate-600::-webkit-scrollbar-thumb {
            background-color: rgb(71 85 105);
            border-radius: 0.375rem;
        }

        .scrollbar-track-slate-800::-webkit-scrollbar-track {
            background-color: rgb(30 41 59);
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgb(71 85 105);
            border-radius: 0.375rem;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background-color: rgb(30 41 59);
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background-color: rgb(100 116 139);
        }
    </style>
</body>

</html>

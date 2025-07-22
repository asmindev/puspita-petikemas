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

<body class="bg-white font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Enhanced Sticky Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 border-r border-gray-200 flex flex-col">
            <div class="w-full flex flex-col h-full overflow-hidden">

                <!-- Logo Section - Fixed at top -->
                <div
                    class="flex items-center justify-between h-16 px-6 border-b border-gray-200 bg-white flex-shrink-0">
                    <div class="flex items-center group">
                        <div class="relative">
                            <div
                                class="size-10  rounded-lg flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 overflow-hidden">
                                <!-- Try to load PNG logo first -->
                                <img src="{{ asset('images/brand/pelindo-logo.png') }}" alt="PelindoTrack Logo"
                                    class="w-full h-full object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">

                                <!-- Fallback SVG Icon -->
                                <svg class="w-6 h-6 text-white hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <span class="text-lg font-bold text-gray-900 block tracking-tight">PelindoTrack</span>
                            {{-- <span
                                class="text-xs font-semibold text-primary uppercase tracking-wide bg-blue-50 px-2 py-0.5 rounded">Manajemen
                                Pro</span> --}}
                        </div>
                    </div>
                    <button id="closeSidebar"
                        class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-all duration-200 transform hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Section - Scrollable with custom scrollbar -->
                <div
                    class="flex-1 overflow-y-auto px-4 py-6 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100">
                    <nav>
                        <div class="space-y-2">
                            <a href="{{ route('dashboard') }}"
                                class="group flex items-center px-3 py-3 rounded-lg text-gray-700 hover:text-gray-900 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow-lg' : 'hover:bg-gray-100' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600 group-hover:bg-primary group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <span class="font-semibold text-sm">Beranda</span>
                                        <p class="text-xs text-gray-500 group-hover:text-gray-600">Ikhtisar & Analitik
                                        </p>
                                    </div>
                                </div>
                                @if(request()->routeIs('dashboard'))
                                <div class="w-1 h-6 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>

                            <a href="{{ route('customers.index') }}"
                                class="group flex items-center px-3 py-3 rounded-lg text-gray-700 hover:text-gray-900 transition-all duration-300 {{ request()->routeIs('customers.*') ? 'bg-primary text-white shadow-lg' : 'hover:bg-gray-100' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-2 rounded-lg {{ request()->routeIs('customers.*') ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600 group-hover:bg-primary group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <span class="font-semibold text-sm">JPT</span>
                                        <p class="text-xs text-gray-500 group-hover:text-gray-600">Kelola Pelanggan</p>
                                    </div>
                                </div>
                                @if(request()->routeIs('customers.*'))
                                <div class="w-1 h-6 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>

                            <a href="{{ route('containers.index') }}"
                                class="group flex items-center px-3 py-3 rounded-lg text-gray-700 hover:text-gray-900 transition-all duration-300 {{ request()->routeIs('containers.*') && !request()->routeIs('containers.queue') && !request()->routeIs('containers.penalty-report') ? 'bg-primary text-white shadow-lg' : 'hover:bg-gray-100' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-2 rounded-lg {{ request()->routeIs('containers.*') && !request()->routeIs('containers.queue') && !request()->routeIs('containers.penalty-report') ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600 group-hover:bg-primary group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <span class="font-semibold text-sm">Peti Kemas</span>
                                        <p class="text-xs text-gray-500 group-hover:text-gray-600">Manajemen Peti Kemas
                                        </p>
                                    </div>
                                </div>
                                @if(request()->routeIs('containers.*') && !request()->routeIs('containers.queue') &&
                                !request()->routeIs('containers.penalty-report'))
                                <div class="w-1 h-6 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>

                            <a href="{{ route('containers.queue') }}"
                                class="group flex items-center px-3 py-3 rounded-lg text-gray-700 hover:text-gray-900 transition-all duration-300 {{ request()->routeIs('containers.queue') ? 'bg-primary text-white shadow-lg' : 'hover:bg-gray-100' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-2 rounded-lg {{ request()->routeIs('containers.queue') ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600 group-hover:bg-primary group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <span class="font-semibold text-sm">Antrian</span>
                                        <p class="text-xs text-gray-500 group-hover:text-gray-600">FCFS + Prioritas</p>
                                    </div>
                                </div>
                                @if(request()->routeIs('containers.queue'))
                                <div class="w-1 h-6 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>

                            <a href="{{ route('containers.penalty-report') }}"
                                class="group flex items-center px-3 py-3 rounded-lg text-gray-700 hover:text-gray-900 transition-all duration-300 {{ request()->routeIs('containers.penalty-report') ? 'bg-primary text-white shadow-lg' : 'hover:bg-gray-100' }}">
                                <div class="flex items-center flex-1">
                                    <div
                                        class="p-2 rounded-lg {{ request()->routeIs('containers.penalty-report') ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-600 group-hover:bg-primary group-hover:text-white' }} transition-all duration-300 transform group-hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <span class="font-semibold text-sm">Laporan Denda</span>
                                        <p class="text-xs text-gray-500 group-hover:text-gray-600">Denda Delivery</p>
                                    </div>
                                </div>
                                @if(request()->routeIs('containers.penalty-report'))
                                <div class="w-1 h-6 bg-white rounded-full opacity-75"></div>
                                @endif
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Enhanced User Profile Section - Fixed at bottom -->
                <div class="px-4 pb-4 flex-shrink-0">
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-200 shadow-sm">
                        <div class="flex items-center">
                            <div class="relative">
                                <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center shadow-sm">
                                    <span class="text-white text-xs font-bold">A</span>
                                </div>
                                <div
                                    class="absolute -bottom-0.5 -right-0.5 w-2 h-2 bg-green-400 rounded-full border border-white animate-pulse">
                                </div>
                            </div>
                            <div class="ml-2 flex-1">
                                <p class="text-gray-900 font-semibold text-xs">Pengguna Admin</p>
                                <p class="text-gray-500 text-xs">Administrator Sistem</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-1 h-1 bg-green-400 rounded-full animate-pulse mb-0.5"></div>
                                <span class="text-xs text-gray-500">Daring</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full overflow-hidden">
            <!-- Enhanced Header -->
            <header class="py-2 bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30 flex-shrink-0">
                <div class="flex items-center justify-between h-14 px-3 sm:px-4 lg:px-6">
                    <div class="flex items-center">
                        <button id="openSidebar"
                            class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-all duration-200 transform hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div class="ml-2 sm:ml-4 lg:ml-0">
                            <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">
                                @yield('page-title', 'Beranda')
                            </h1>
                            <p class="text-gray-500 text-xs sm:text-sm mt-0.5 hidden sm:block">
                                {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y') }}
                            </p>

                        </div>
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-3 lg:space-x-4">
                        <!-- Notification Bell -->
                        <button
                            class="relative p-2 bg-gray-50 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-all duration-200 transform hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <div
                                class="absolute -top-1 -right-1 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-red-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-bold hidden sm:inline">3</span>
                            </div>
                        </button>

                        <!-- User Avatar -->
                        <div class="flex items-center group cursor-pointer relative">
                            <div
                                class="w-6 h-6 sm:w-8 sm:h-8 bg-primary rounded-full flex items-center justify-center shadow-sm transform group-hover:scale-110 transition-transform duration-200">
                                <span class="text-white text-xs sm:text-sm font-bold">U</span>
                            </div>
                            <div class="ml-2 hidden sm:block">
                                <p class="text-sm font-semibold text-gray-900">Pengguna Admin</p>
                                <p class="text-xs text-gray-600">Administrator</p>
                            </div>

                            <!-- Dropdown Menu -->
                            <div
                                class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-1">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors duration-200">
                                        Pengaturan Profil
                                    </a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors duration-200">
                                        Preferensi
                                    </a>
                                    <div class="border-t border-gray-200 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-gray-50 transition-colors duration-200">
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
            <main
                class="flex-1 overflow-y-auto bg-gray-5 w-full bg-[url('https://www.pelindo.co.id/uploads/slider/Go2YEqT9UGXPsodhDzN5DSF3ELB2uz7kIeVwjajK.jpg')] bg-cover bg-top min-h-0 relative">
                <!-- Tambahkan overlay hitam semi-transparan -->
                <div class="absolute inset-0 bg-black/50"></div>
                <!-- Konten utama dengan z-index untuk berada di atas overlay -->
                <div class="relative z-10 w-full h-full">
                    @if(session('success'))
                    <div class="mx-3 sm:mx-6 lg:mx-8 mt-4">
                        <div
                            class="bg-green-50 border border-green-200 text-green-800 px-4 sm:px-6 py-3 rounded-lg flex items-center shadow-sm">
                            <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    @if($errors->any())

                    <div class="mx-3 sm:mx-6 lg:mx-8 mt-4">
                        <div
                            class="bg-red-50 border border-red-200 text-red-800 px-4 sm:px-6 py-3 rounded-lg shadow-sm">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-red-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="font-medium">Silakan perbaiki kesalahan berikut:</p>
                                    <ul class="mt-2 list-disc list-inside text-sm space-y-1">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="p-3 sm:p-4 lg:p-6 w-full">
                        @yield('content')
                    </div>
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
            @apply text-gray-600 hover: text-gray-900 hover:bg-gray-100;
        }

        .nav-link.active {
            @apply bg-blue-50 text-blue-700 border-r-2 border-primary;
        }

        .nav-link.active svg {
            @apply text-primary;
        }

        /* Custom scrollbar styles */
        .scrollbar-thin {
            scrollbar-width: thin;
        }

        .scrollbar-thumb-gray-400::-webkit-scrollbar-thumb {
            background-color: rgb(156 163 175);
            border-radius: 0.375rem;
        }

        .scrollbar-track-gray-100::-webkit-scrollbar-track {
            background-color: rgb(243 244 246);
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgb(156 163 175);
            border-radius: 0.375rem;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background-color: rgb(243 244 246);
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background-color: rgb(107 114 128);
        }
    </style>
</body>

</html>

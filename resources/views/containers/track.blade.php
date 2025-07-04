<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pelacakan Peti Kemas - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 font-sans antialiased min-h-screen">
    <!-- Header -->
    <header class="bg-slate-800/50 backdrop-blur-sm border-b border-slate-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <div class="flex items-center group">
                    <div class="relative">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div
                            class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-emerald-400 to-green-500 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white text-xs font-bold">✓</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <span class="text-xl sm:text-2xl font-black text-white block tracking-tight">PelindoTrack</span>
                        <span class="text-xs font-bold text-blue-400 uppercase tracking-widest">Portal Pelacakan</span>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white text-sm font-medium rounded-xl transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white mb-4 tracking-tight">
                Pelacakan <span
                    class="bg-gradient-to-r from-blue-400 via-purple-500 to-indigo-600 bg-clip-text text-transparent">Peti
                    Kemas</span>
            </h1>
            <p class="text-xl text-slate-400 max-w-3xl mx-auto">
                Masukkan nomor peti kemas Anda di bawah ini untuk melacak status, lokasi, dan informasi pemrosesan
                secara real-time.
            </p>
        </div>

        <!-- Search Form -->
        <div class="max-w-2xl mx-auto mb-12">
            <form method="POST" action="{{ route('containers.track.search') }}" class="space-y-6">
                @csrf
                <div class="relative">
                    <label for="container_number" class="block text-sm font-semibold text-slate-300 mb-3">
                        Nomor Peti Kemas
                    </label>
                    <div class="relative">
                        <input type="text" id="container_number" name="container_number"
                            value="{{ old('container_number', request('container_number')) }}"
                            placeholder="Masukkan nomor peti kemas (contoh: CONT001, CONT002)"
                            class="w-full px-6 py-4 bg-slate-800/50 border-2 border-slate-600 rounded-2xl text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 text-lg"
                            required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-6">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 text-white font-bold py-4 px-8 rounded-2xl text-lg transition-all duration-200 transform hover:scale-[1.02] hover:shadow-2xl hover:shadow-blue-500/25 focus:outline-none focus:ring-4 focus:ring-blue-500/50">
                    <div class="flex items-center justify-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        Lacak Peti Kemas
                    </div>
                </button>
            </form>
        </div>

        <!-- Messages -->
        @if(session('success'))
        <div class="max-w-2xl mx-auto mb-8">
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

        @if(session('error'))
        <div class="max-w-2xl mx-auto mb-8">
            <div
                class="bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-2xl flex items-center shadow-lg">
                <svg class="w-6 h-6 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold text-white">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="max-w-2xl mx-auto mb-8">
            <div
                class="bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-500/30 text-red-300 px-6 py-4 rounded-2xl shadow-lg">
                <div class="flex items-start">
                    <svg class="w-6 h-6 mr-3 mt-0.5 flex-shrink-0 text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold text-white mb-2">Harap perbaiki kesalahan berikut:</p>
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

        <!-- Container Information -->
        @if(isset($container))
        <div class="max-w-4xl mx-auto">
            <!-- Container Header -->
            <div
                class="bg-gradient-to-r from-slate-800/60 to-slate-700/60 backdrop-blur-sm rounded-3xl p-8 border border-slate-600/30 shadow-2xl mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-black text-white mb-2">{{ $container->container_number }}</h2>
                        <p class="text-slate-400">Informasi pelacakan peti kemas</p>
                    </div>
                    <div class="text-right">
                        @php
                        $statusColors = [
                        'pending' => 'from-amber-500 to-orange-500',
                        'in_progress' => 'from-blue-500 to-indigo-500',
                        'completed' => 'from-emerald-500 to-green-500',
                        'cancelled' => 'from-red-500 to-pink-500'
                        ];
                        $statusColor = $statusColors[$container->status] ?? 'from-gray-500 to-gray-600';
                        @endphp
                        <span
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r {{ $statusColor }} text-white text-sm font-bold rounded-full shadow-lg">
                            <div class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></div>
                            {{ $container->status === 'pending' ? 'Menunggu' :
                            ($container->status === 'in_progress' ? 'Sedang Diproses' :
                            ($container->status === 'completed' ? 'Selesai' :
                            ($container->status === 'cancelled' ? 'Dibatalkan' : ucfirst(str_replace('_', ' ',
                            $container->status))))) }}
                        </span>
                    </div>
                </div>

                <!-- Progress Bar -->
                @php
                $progress = match($container->status) {
                'pending' => 25,
                'in_progress' => 75,
                'completed' => 100,
                'cancelled' => 0,
                default => 0
                };
                @endphp
                <div class="mb-6">
                    <div class="flex items-center justify-between text-sm text-slate-400 mb-2">
                        <span>Progres Pemrosesan</span>
                        <span>{{ $progress }}%</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-3">
                        <div class="bg-gradient-to-r {{ $statusColor }} h-3 rounded-full transition-all duration-500 ease-out"
                            style="width: {{ $progress }}%"></div>
                    </div>
                </div>

                <!-- Status Steps -->
                <div class="grid grid-cols-4 gap-4">
                    @php
                    $steps = [
                    ['key' => 'received', 'label' => 'Diterima', 'icon' => 'M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0
                    002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['key' => 'pending', 'label' => 'Menunggu', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118
                    0z'],
                    ['key' => 'in_progress', 'label' => 'Diproses', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['key' => 'completed', 'label' => 'Selesai', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118
                    0z']
                    ];
                    @endphp

                    @foreach($steps as $step)
                    @php
                    $isActive = false;
                    $isCompleted = false;

                    if ($container->status === $step['key']) {
                    $isActive = true;
                    } elseif (
                    ($step['key'] === 'received') ||
                    ($step['key'] === 'pending' && in_array($container->status, ['in_progress', 'completed'])) ||
                    ($step['key'] === 'in_progress' && $container->status === 'completed')
                    ) {
                    $isCompleted = true;
                    }
                    @endphp

                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full flex items-center justify-center transition-all duration-300
                            {{ $isActive ? 'bg-gradient-to-r ' . $statusColor . ' text-white shadow-lg' :
                               ($isCompleted ? 'bg-emerald-500 text-white' : 'bg-slate-600 text-slate-400') }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $step['icon'] }}" />
                            </svg>
                        </div>
                        <p
                            class="text-xs font-medium {{ $isActive || $isCompleted ? 'text-white' : 'text-slate-400' }}">
                            {{ $step['label'] }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Container Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Basic Information -->
                <div
                    class="bg-gradient-to-br from-slate-800/40 to-slate-700/40 backdrop-blur-sm rounded-2xl p-6 border border-slate-600/30 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Dasar
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-slate-600/30">
                            <span class="text-slate-400 font-medium">Nomor Peti Kemas</span>
                            <span class="text-white font-semibold">{{ $container->container_number }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-slate-600/30">
                            <span class="text-slate-400 font-medium">Pelanggan</span>
                            <span class="text-white font-semibold">{{ $container->customer->name ?? 'N/A' }}</span>
                        </div>

                        @if($container->type)
                        <div class="flex justify-between items-center py-3 border-b border-slate-600/30">
                            <span class="text-slate-400 font-medium">Type Container</span>
                            <span
                                class="inline-flex items-center px-3 py-1 bg-indigo-500/20 text-indigo-300 text-xs font-bold rounded-full border border-indigo-400/30">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                {{ $container->type }}
                            </span>
                        </div>
                        @endif

                        <div class="flex justify-between items-center py-3">
                            <span class="text-slate-400 font-medium">Prioritas</span>
                            @php
                            $priorityColors = [
                            'high' => 'from-red-500 to-pink-500',
                            'medium' => 'from-amber-500 to-orange-500',
                            'low' => 'from-green-500 to-emerald-500'
                            ];
                            $priorityColor = $priorityColors[$container->priority] ?? 'from-gray-500 to-gray-600';
                            @endphp
                            <span
                                class="inline-flex items-center px-3 py-1 bg-gradient-to-r {{ $priorityColor }} text-white text-xs font-bold rounded-full">
                                {{ $container->priority === 'High' ? 'Tinggi' : ($container->priority === 'Normal' ?
                                'Normal' : ucfirst($container->priority)) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Information -->
                <div
                    class="bg-gradient-to-br from-slate-800/40 to-slate-700/40 backdrop-blur-sm rounded-2xl p-6 border border-slate-600/30 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Timeline
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-slate-600/30">
                            <span class="text-slate-400 font-medium">Tanggal Diterima</span>
                            <span class="text-white font-semibold">
                                {{ $container->entry_date ? $container->entry_date->format('M d, Y H:i') : 'N/A' }}
                            </span>
                        </div>

                        @if($container->process_start_time)
                        <div class="flex justify-between items-center py-3 border-b border-slate-600/30">
                            <span class="text-slate-400 font-medium">Pemrosesan Dimulai</span>
                            <span class="text-white font-semibold">
                                {{ $container->process_start_time->format('M d, Y H:i') }}
                            </span>
                        </div>
                        @endif

                        @if($container->process_end_time)
                        <div class="flex justify-between items-center py-3 border-b border-slate-600/30">
                            <span class="text-slate-400 font-medium">Pemrosesan Selesai</span>
                            <span class="text-white font-semibold">
                                {{ $container->process_end_time->format('M d, Y H:i') }}
                            </span>
                        </div>
                        @endif

                        @if($container->exit_date)
                        <div class="flex justify-between items-center py-3 border-b border-slate-600/30">
                            <span class="text-slate-400 font-medium">Tanggal Keluar</span>
                            <span class="text-white font-semibold">
                                {{ $container->exit_date->format('M d, Y H:i') }}
                            </span>
                        </div>
                        @endif

                        <div class="flex justify-between items-center py-3">
                            <span class="text-slate-400 font-medium">Terakhir Diperbarui</span>
                            <span class="text-white font-semibold">
                                {{ $container->updated_at->format('M d, Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if($container->contents && count($container->contents) > 0)
            <!-- Container Contents -->
            <div class="mt-8">
                <div
                    class="bg-gradient-to-br from-slate-800/40 to-slate-700/40 backdrop-blur-sm rounded-2xl p-6 border border-slate-600/30 shadow-xl">
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Isi Container
                        <span class="ml-2 px-2 py-1 text-xs font-bold bg-purple-500/20 text-purple-300 rounded-full">
                            {{ count($container->contents) }} item
                        </span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($container->contents as $index => $item)
                        <div class="bg-slate-700/50 rounded-xl p-4 border border-slate-600/30">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-sm font-bold text-purple-300">{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-white">{{ $item }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Processing Time Estimate -->

            <!-- Action Buttons -->
            <div class="text-center mt-8">
                <button onclick="window.location.reload()"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 mr-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Segarkan Status
                </button>

                {{-- <button onclick="window.print()"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Detail
                </button> --}}
            </div>
        </div>
        @endif

        <!-- Quick Examples -->
        @if(!isset($container))
        <div class="max-w-4xl mx-auto mt-16">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white mb-4">Butuh bantuan menemukan peti kemas Anda?</h2>
                <p class="text-slate-400">Coba contoh nomor peti kemas berikut untuk melihat cara kerja pelacakan</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @php
                $examples = ['CONT001', 'CONT002', 'CONT003'];
                @endphp
                @foreach($examples as $example)
                <a href="{{ route('containers.track.search') }}?container_number={{ $example }}"
                    class="block p-4 bg-slate-800/50 hover:bg-slate-700/50 border border-slate-600/30 rounded-xl transition-all duration-200 transform hover:scale-105 text-center">
                    <div class="text-lg font-semibold text-white mb-2">{{ $example }}</div>
                    <div class="text-sm text-slate-400">Klik untuk melacak</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-slate-800/30 border-t border-slate-700 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-slate-400">
                <p>&copy; {{ date('Y') }} Sistem Manajemen PetikemasQ. Hak cipta dilindungi.</p>
                <p class="mt-2 text-sm">Solusi pelacakan dan manajemen peti kemas secara real-time.</p>
            </div>
        </div>
    </footer>

    <style>
        @media print {
            body {
                background: white !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</body>

</html>

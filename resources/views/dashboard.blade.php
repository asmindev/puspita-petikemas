@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Enhanced Welcome Header with Animation -->
<div class="mb-10">
    <div
        class="bg-gradient-to-br from-slate-800 via-slate-900 to-gray-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl border border-slate-700">
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div class="max-w-2xl">
                    <div class="flex items-center mb-4">
                        <div class="animate-bounce mr-3">
                            <span class="text-4xl">👋</span>
                        </div>
                        <h1
                            class="text-4xl font-bold bg-gradient-to-r from-white to-blue-300 bg-clip-text text-transparent">
                            Selamat Datang Kembali!
                        </h1>
                    </div>
                    <p class="text-slate-300 text-xl leading-relaxed mb-4">
                        Berikut adalah aktivitas operasi peti kemas hari ini.
                    </p>
                    <div class="flex items-center space-x-6 text-sm">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-2"></div>
                            <span class="text-green-300">Semua Sistem Online</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse mr-2"></div>
                            <span class="text-yellow-300">{{ $pendingContainers }} Menunggu</span>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="relative">
                        <div
                            class="w-36 h-36 bg-gradient-to-br from-white/10 to-white/5 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20 shadow-2xl">
                            <svg class="w-20 h-20 text-white animate-pulse" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <!-- Floating particles -->
                        <div
                            class="absolute -top-4 -right-4 w-8 h-8 bg-yellow-400 rounded-full opacity-60 animate-ping">
                        </div>
                        <div
                            class="absolute -bottom-2 -left-2 w-6 h-6 bg-green-400 rounded-full opacity-60 animate-ping animation-delay-200">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Background Pattern -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 transform translate-x-48 -translate-y-48">
                <div class="w-full h-full bg-gradient-to-br from-blue-500/10 to-transparent rounded-full animate-pulse">
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-64 h-64 transform -translate-x-32 translate-y-32">
                <div
                    class="w-full h-full bg-gradient-to-tr from-purple-500/10 to-transparent rounded-full animate-pulse animation-delay-100">
                </div>
            </div>
            <div class="absolute top-1/2 left-1/2 w-32 h-32 transform -translate-x-16 -translate-y-16">
                <div
                    class="w-full h-full bg-gradient-to-br from-indigo-500/5 to-transparent rounded-full animate-spin-slow">
                </div>
            </div>
        </div>

        <!-- Glassmorphism overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-white/5 to-transparent backdrop-blur-[1px]"></div>
    </div>
</div>

<!-- Ultra-Enhanced Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Customers Card -->
    <div class="group">
        <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-lg hover:shadow-xl border border-slate-700 p-6 transition-all duration-300 hover:-translate-y-1 min-h-[180px]">
            <!-- Header Section -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div
                        class="p-3 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-xl shadow-lg transform group-hover:rotate-6 transition-transform duration-300 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Total Pelanggan</p>
                    </div>
                </div>
                <!-- Background Icon -->
                <div class="text-blue-500 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>
            </div>

            <!-- Content Section -->
            <div class="space-y-3">
                <div class="text-3xl font-black text-white group-hover:text-blue-400 transition-colors">
                    {{ $totalCustomers }}
                </div>
                <div class="flex items-center">
                    <span
                        class="text-xs text-emerald-400 font-medium bg-emerald-500/20 px-2 py-1 rounded-full ring-1 ring-emerald-500/30 inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Containers Card -->
    <div class="group">
        <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-lg hover:shadow-xl border border-slate-700 p-6 transition-all duration-300 hover:-translate-y-1 min-h-[180px]">
            <!-- Header Section -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div
                        class="p-3 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 rounded-xl shadow-lg transform group-hover:rotate-6 transition-transform duration-300 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Total Peti Kemas</p>
                    </div>
                </div>
                <!-- Background Icon -->
                <div class="text-emerald-500 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <!-- Content Section -->
            <div class="space-y-3">
                <div class="text-3xl font-black text-white group-hover:text-emerald-400 transition-colors">
                    {{ $totalContainers }}
                </div>
                <div class="flex items-center">
                    <span
                        class="text-xs text-emerald-400 font-medium bg-emerald-500/20 px-2 py-1 rounded-full ring-1 ring-emerald-500/30 inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        +12% bulan ini
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Containers Card -->
    <div class="group">
        <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-lg hover:shadow-xl border border-slate-700 p-6 transition-all duration-300 hover:-translate-y-1 min-h-[180px]">
            <!-- Header Section -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div
                        class="p-3 bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 rounded-xl shadow-lg transform group-hover:rotate-6 transition-transform duration-300 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Antrian Menunggu</p>
                    </div>
                </div>
                <!-- Background Icon -->
                <div class="text-amber-500 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,6A1.5,1.5 0 0,1 13.5,7.5A1.5,1.5 0 0,1 12,9A1.5,1.5 0 0,1 10.5,7.5A1.5,1.5 0 0,1 12,6M9.5,9.5C9.5,9.22 9.72,9 10,9H14C14.28,9 14.5,9.22 14.5,9.5V10.5C14.5,10.78 14.28,11 14,11H10C9.72,11 9.5,10.78 9.5,10.5V9.5M5,15.25C5,14.01 8.03,13.25 12,13.25C15.97,13.25 19,14.01 19,15.25V17H5V15.25Z" />
                    </svg>
                </div>
            </div>

            <!-- Content Section -->
            <div class="space-y-3">
                <div class="text-3xl font-black text-white group-hover:text-amber-400 transition-colors">
                    {{ $pendingContainers }}
                </div>
                <div class="flex items-center">
                    <span
                        class="text-xs text-amber-400 font-medium bg-amber-500/20 px-2 py-1 rounded-full animate-pulse ring-1 ring-amber-500/30 inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Dalam Antrian
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Containers Card -->
    <div class="group">
        <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-lg hover:shadow-xl border border-slate-700 p-6 transition-all duration-300 hover:-translate-y-1 min-h-[180px]">
            <!-- Header Section -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div
                        class="p-3 bg-gradient-to-br from-green-500 via-green-600 to-emerald-600 rounded-xl shadow-lg transform group-hover:rotate-6 transition-transform duration-300 flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Selesai</p>
                    </div>
                </div>
                <!-- Background Icon -->
                <div class="text-green-500 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z" />
                    </svg>
                </div>
            </div>

            <!-- Content Section -->
            <div class="space-y-3">
                <div class="text-3xl font-black text-white group-hover:text-green-400 transition-colors">
                    {{ $completedContainers }}
                </div>
                <div class="flex items-center">
                    <span
                        class="text-xs text-green-400 font-medium bg-green-500/20 px-2 py-1 rounded-full ring-1 ring-green-500/30 inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        98% Sukses
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Content Section -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Recent Containers - Enhanced -->
    <div class="xl:col-span-2">
        <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-5 border-b border-slate-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white">Aktivitas Peti Kemas Terbaru</h3>
                        <p class="text-sm text-slate-300 mt-1">Operasi dan pembaruan peti kemas terbaru</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-300 ring-1 ring-green-500/30">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                            Pembaruan Langsung
                        </span>
                        <a href="{{ route('containers.index') }}"
                            class="text-blue-400 hover:text-blue-300 text-sm font-medium transition-colors">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if($recentContainers->count() > 0)
                <div class="space-y-4">
                    @foreach($recentContainers as $container)
                    <div
                        class="group bg-gradient-to-r from-slate-700/50 to-slate-800/50 border border-slate-600 rounded-xl p-4 hover:shadow-md transition-all duration-300 hover:border-blue-500/50 hover:from-slate-700/70 hover:to-slate-800/70">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    @if($container->priority === 'High')
                                    <div
                                        class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">!</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <p class="text-lg font-semibold text-white">{{ $container->container_number
                                            }}</p>
                                        @if($container->priority === 'High')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-300 border border-red-500/30">
                                            🔥 PRIORITAS TINGGI
                                        </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-3 mt-1">
                                        <p class="text-sm text-slate-300">
                                            <span class="font-medium">Pelanggan:</span> {{ $container->customer->name ??
                                            'N/A' }}
                                        </p>
                                        <span class="w-1 h-1 bg-slate-500 rounded-full"></span>
                                        <p class="text-xs text-slate-400">{{ $container->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                @if($container->status === 'completed') bg-emerald-500/20 text-emerald-300 border border-emerald-500/30
                                                @elseif($container->status === 'in_progress') bg-amber-500/20 text-amber-300 border border-amber-500/30
                                                @else bg-slate-500/20 text-slate-300 border border-slate-500/30
                                                @endif">
                                        @if($container->status === 'completed')
                                        ✅ Selesai
                                        @elseif($container->status === 'in_progress')
                                        ⏳ Sedang Diproses
                                        @else
                                        📋 Menunggu
                                        @endif
                                    </span>
                                </div>
                                <a href="{{ route('containers.show', $container) }}"
                                    class="text-blue-400 hover:text-blue-300 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">Tidak Ada Aktivitas Terbaru</h3>
                    <p class="text-slate-400 mb-6">Mulai dengan membuat peti kemas pertama untuk melihat aktivitas di
                        sini.</p>
                    <a href="{{ route('containers.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Peti Kemas
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions - Enhanced -->
        <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-700 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4 border-b border-slate-700">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Aksi Cepat
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <a href="{{ route('containers.create') }}"
                    class="group w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Peti Kemas Baru
                </a>
                <a href="{{ route('customers.create') }}"
                    class="group w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Tambah Pelanggan Baru
                </a>
                <a href="{{ route('containers.index') }}"
                    class="group w-full bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Lihat Semua Peti Kemas
                </a>
            </div>
        </div>

        <!-- System Status - Enhanced -->
        <div
            class="bg-gradient-to-br from-emerald-500/10 to-teal-500/10 rounded-2xl p-6 border border-emerald-500/30 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="p-3 bg-slate-800/50 rounded-xl shadow-sm border border-slate-700">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold text-white">Status Sistem</h4>
                        <p class="text-sm text-emerald-400">Semua sistem beroperasi</p>
                    </div>
                </div>
                <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-300">Performa Server</span>
                    <span class="text-green-400 font-semibold">99.9%</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-300">Kesehatan Database</span>
                    <span class="text-green-400 font-semibold">Sangat Baik</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-300">Backup Terakhir</span>
                    <span class="text-slate-400 font-semibold">2 jam lalu</span>
                </div>
            </div>
        </div>

        <!-- Performance Overview -->
        <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-700 p-6">
            <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Ringkasan Hari Ini
            </h4>
            <div class="space-y-4">
                <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-blue-300">Tingkat Pemrosesan</span>
                        <span class="text-lg font-bold text-blue-400">94%</span>
                    </div>
                    <div class="w-full bg-blue-500/20 rounded-full h-2 mt-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 94%"></div>
                    </div>
                </div>
                <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-lg p-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-emerald-300">Skor Efisiensi</span>
                        <span class="text-lg font-bold text-emerald-400">98%</span>
                    </div>
                    <div class="w-full bg-emerald-500/20 rounded-full h-2 mt-2">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 98%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

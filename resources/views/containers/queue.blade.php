@extends('layouts.app')

@section('title', 'Manajemen Antrian Peti Kemas')
@section('page-title', 'Manajemen Antrian')

@section('content')
<div class="w-full mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Manajemen Antrian Peti Kemas</h1>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full animate-pulse"></div>
                    <p class="text-slate-300 text-sm">Algoritma Penjadwalan FCFS + Prioritas</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('containers.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Peti Kemas
                </a>
                @if($nextContainer)
                <form action="{{ route('containers.queue.process-next') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-sm font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg shadow-green-500/25">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                        Proses Peti Kemas Berikutnya
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Queue Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
        <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-400">Total Menunggu</p>
                    <p class="text-2xl font-bold text-white">{{ $statistics['total_pending'] }}</p>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-red-400">Prioritas Tinggi</p>
                    <p class="text-2xl font-bold text-white">{{ $statistics['high_priority_pending'] }}</p>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-400">Prioritas Normal</p>
                    <p class="text-2xl font-bold text-white">{{ $statistics['normal_priority_pending'] }}</p>
                </div>
            </div>
        </div>
        {{-- Average Wait Time --}}
        {{-- <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 bg-gradient-to-r from-purple-500 to-violet-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-400">Rata-rata Waktu Tunggu</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($statistics['average_wait_time_minutes'],
                        1) }}m</p>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Next Container Alert -->
    @if($nextContainer)
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 border border-slate-700 rounded-xl p-6 mb-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="p-3 bg-gradient-to-r from-yellow-500 to-amber-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-6 flex-1">
                <div class="flex items-center mb-2">
                    <h3 class="text-lg font-bold text-yellow-400">Peti Kemas Berikutnya untuk Diproses</h3>
                    <span
                        class="ml-3 px-3 py-1 text-xs font-bold bg-gradient-to-r from-yellow-500 to-amber-600 text-white rounded-full animate-pulse shadow-lg">SIAP</span>
                </div>
                <div class="flex flex-col lg:flex-row gap-4">
                    <!-- Tabel 1 -->
                    <table class="w-full lg:w-1/2 text-sm text-left border-separate border-spacing-y-2">
                        <tbody>
                            <tr>
                                <th class="text-yellow-300 font-medium pr-4">Peti Kemas</th>
                                <td class="font-bold text-white">{{ $nextContainer->container_number }}</td>
                            </tr>
                            <tr>
                                <th class="text-yellow-300 font-medium pr-4">Pelanggan</th>
                                <td class="font-semibold text-white">{{ $nextContainer->customer->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Tabel 2 -->
                    <table class="w-full lg:w-1/2 text-sm text-left border-separate border-spacing-y-2">
                        <tbody>
                            <tr>
                                <th class="text-yellow-300 font-medium pr-4">Prioritas</th>
                                <td>
                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full
                        {{ $nextContainer->priority === 'High' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : 'bg-blue-500/20 text-blue-300 border border-blue-500/30' }}">
                                        {{ $nextContainer->priority === 'High' ? 'Tinggi' : 'Normal' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-yellow-300 font-medium pr-4">Masuk</th>
                                <td class="font-semibold text-white">{{ $nextContainer->entry_date->format('M d, H:i')
                                    }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>



            </div>
        </div>
    </div>
    @endif

    {{-- Filter --}}
    <div class="bg-slate-800/70 backdrop-blur-sm border border-slate-700 rounded-xl p-6 mb-8 shadow-lg">
        <div class="flex items-center mb-4">
            <svg class="w-5 h-5 text-slate-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z">
                </path>
            </svg>
            <h3 class="text-lg font-semibold text-white">Filter Antrian</h3>
        </div>
        <form method="GET" action="{{ route('containers.queue') }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                <div class="lg:col-span-2 xl:col-span-2">
                    <label class="block text-sm font-medium text-slate-300 mb-2">Cari</label>
                    <input type="text" name="search" value="{{ $filters['search'] }}"
                        placeholder="Nomor peti kemas, pelanggan..."
                        class="w-full px-4 py-2.5 bg-slate-700 border border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-white placeholder-slate-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                    <select name="status"
                        class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-white">
                        <option value="all" {{ $filters['status']==='all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending" {{ $filters['status']==='pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="in_progress" {{ $filters['status']==='in_progress' ? 'selected' : '' }}>Sedang
                            Diproses</option>
                        <option value="completed" {{ $filters['status']==='completed' ? 'selected' : '' }}>Selesai
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Prioritas</label>
                    <select name="priority"
                        class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-white">
                        <option value="all" {{ $filters['priority']==='all' ? 'selected' : '' }}>Semua Prioritas
                        </option>
                        <option value="High" {{ $filters['priority']==='High' ? 'selected' : '' }}>Prioritas Tinggi
                        </option>
                        <option value="Normal" {{ $filters['priority']==='Normal' ? 'selected' : '' }}>Prioritas Normal
                        </option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg shadow-blue-500/25">
                        Filter
                    </button>
                    <a href="{{ route('containers.queue') }}"
                        class="px-4 py-2.5 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Queue Table -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-xl shadow-2xl border border-slate-700 overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-slate-700 bg-gradient-to-r from-slate-800 to-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
                        Antrian Peti Kemas (FCFS + Prioritas)
                    </h2>
                    <p class="text-sm text-slate-300 mt-1">Diurutkan berdasarkan Prioritas (Tinggi terlebih dahulu),
                        kemudian berdasarkan Tanggal Masuk (paling awal dulu)</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-slate-400">Total Item</div>
                    <div class="text-2xl font-bold text-white">{{ $containers->total() }}</div>
                </div>
            </div>
        </div>

        @if($containers->count() > 0)
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full">
                <table class="table-auto min-w-full divide-y divide-slate-700">
                    <thead class="bg-gradient-to-r from-slate-800 to-slate-900">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Antrian #
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Peti Kemas</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Pelanggan</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Type</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Isi Container</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Prioritas</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Tanggal Masuk</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Waktu Tunggu</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-slate-800/50 divide-y divide-slate-700">
                        @foreach($containers as $index => $container)
                        <tr
                            class="hover:bg-gradient-to-r hover:from-slate-700/50 hover:to-slate-600/50 transition-all duration-200 {{ $loop->first && $container->status === 'pending' ? 'bg-gradient-to-r from-yellow-500/20 to-amber-500/20 ring-1 ring-yellow-500/30' : '' }}">
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($container->status === 'pending')
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-sm font-bold text-white">{{ ($containers->currentPage() - 1) *
                                            $containers->perPage() + $loop->iteration }}</span>
                                    </div>
                                    @if($loop->first)
                                    <span
                                        class="ml-3 px-3 py-1 text-xs font-bold bg-gradient-to-r from-yellow-400 to-amber-500 text-white rounded-full animate-pulse shadow-lg">BERIKUTNYA</span>
                                    @endif
                                </div>
                                @else
                                <span class="text-slate-500 font-medium">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                                    <div class="text-sm font-bold text-white">{{ $container->container_number }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm font-semibold text-white max-w-[200px] truncate"
                                    title="{{ $container->customer->name }}">
                                    {{ $container->customer->name }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full shadow-sm bg-indigo-500/20 text-indigo-300 ring-1 ring-indigo-500/30">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    {{ $container->type ?? '20ft' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm text-white max-w-[180px]">
                                    @if($container->contents && count($container->contents) > 0)
                                    <div class="space-y-1">
                                        @foreach(array_slice($container->contents, 0, 2) as $item)
                                        <div class="text-xs bg-slate-700/50 px-2 py-1 rounded truncate"
                                            title="{{ $item }}">
                                            {{ Str::limit($item, 20) }}
                                        </div>
                                        @endforeach
                                        @if(count($container->contents) > 2)
                                        <div class="text-xs text-slate-400">+{{ count($container->contents) - 2 }}
                                            lainnya</div>
                                        @endif
                                    </div>
                                    @else
                                    <span class="text-slate-500 text-xs">Kosong</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full shadow-sm
                                    {{ $container->priority === 'High' ? 'bg-red-500/20 text-red-300 ring-1 ring-red-500/30' : 'bg-blue-500/20 text-blue-300 ring-1 ring-blue-500/30' }}">
                                    @if($container->priority === 'High')
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    @endif
                                    {{ $container->priority === 'High' ? 'Tinggi' : 'Normal' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-white font-medium">
                                    {{ $container->entry_date ? $container->entry_date->format('M d, Y') : 'N/A' }}
                                </div>
                                <div class="text-xs text-slate-400">
                                    {{ $container->entry_date ? $container->entry_date->format('H:i') : '' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full shadow-sm
                                    {{ $container->status === 'pending' ? 'bg-yellow-500/20 text-yellow-300 ring-1 ring-yellow-500/30' :
                                       ($container->status === 'in_progress' ? 'bg-blue-500/20 text-blue-300 ring-1 ring-blue-500/30' :
                                       ($container->status === 'completed' ? 'bg-green-500/20 text-green-300 ring-1 ring-green-500/30' : 'bg-slate-500/20 text-slate-300 ring-1 ring-slate-500/30')) }}">
                                    {{ $container->status === 'pending' ? 'Menunggu' :
                                    ($container->status === 'in_progress' ? 'Sedang Diproses' :
                                    ($container->status === 'completed' ? 'Selesai' : ucwords(str_replace('_', ' ',
                                    $container->status)))) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-white">
                                    @if($container->entry_date)
                                    {{ $container->entry_date->diffForHumans() }}
                                    @else
                                    N/A
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('containers.show', $container) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-300 bg-blue-500/20 hover:bg-blue-500/30 rounded-lg transition-all duration-200 hover:scale-105 ring-1 ring-blue-500/30">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        Lihat
                                    </a>

                                    @if($container->status === 'in_progress')
                                    <form action="{{ route('containers.complete-processing', $container) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-300 bg-green-500/20 hover:bg-green-500/30 rounded-lg transition-all duration-200 hover:scale-105 ring-1 ring-green-500/30"
                                            onclick="return confirm('Selesaikan pemrosesan untuk peti kemas ini?')">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Selesai
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800/50">
            {{ $containers->appends(request()->query())->links() }}
        </div>
        @else
        <div class="px-6 py-16 text-center">
            <div
                class="mx-auto w-24 h-24 bg-gradient-to-r from-slate-700 to-slate-800 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-white mb-2">Tidak ada peti kemas ditemukan</h3>
            <p class="text-slate-400 mb-6">Tidak ada peti kemas yang cocok dengan filter Anda saat ini.</p>
            <a href="{{ route('containers.queue') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                Reset Filter
            </a>
        </div>
        @endif
    </div>

    <!-- Queue Simulation Section -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-xl shadow-2xl border border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-700 bg-gradient-to-r from-slate-800 to-slate-900">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-3 animate-pulse"></div>
                        Simulasi Pemrosesan Antrian
                    </h2>
                    <p class="text-sm text-slate-300 mt-1">Analisis prediktif dari timeline pemrosesan antrian</p>
                </div>
                <button id="loadSimulation"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-violet-600 hover:from-purple-600 hover:to-violet-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg shadow-purple-500/25">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Muat Simulasi
                </button>
            </div>
        </div>

        <div id="simulationContent" class="hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div
                        class="bg-gradient-to-br from-blue-500/20 to-indigo-500/20 border border-blue-500/30 rounded-xl p-4 shadow-lg">
                        <div class="flex items-center">
                            <div class="p-2 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-blue-300">Total Peti Kemas</div>
                                <div class="text-xl font-bold text-white" id="simTotalContainers">-</div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 border border-green-500/30 rounded-xl p-4 shadow-lg">
                        <div class="flex items-center">
                            <div class="p-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg shadow">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-green-300">Estimasi Waktu</div>
                                <div class="text-xl font-bold text-white" id="simTotalTime">-</div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-red-500/20 to-pink-500/20 border border-red-500/30 rounded-xl p-4 shadow-lg">
                        <div class="flex items-center">
                            <div class="p-2 bg-gradient-to-r from-red-500 to-pink-600 rounded-lg shadow">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-red-300">Prioritas Tinggi</div>
                                <div class="text-xl font-bold text-white" id="simHighPriority">-</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-lg border border-slate-700">
                    <div class="inline-block min-w-full">
                        <table class="min-w-full divide-y divide-slate-700">
                            <thead class="bg-gradient-to-r from-slate-800 to-slate-900">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                        Posisi</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                        Peti Kemas</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                        Prioritas</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                        Est. Mulai</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                        Est. Selesai</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">
                                        Waktu Tunggu</th>
                                </tr>
                            </thead>
                            <tbody id="simulationTable" class="bg-slate-800/50 divide-y divide-slate-700">
                                <!-- Simulation results will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('loadSimulation').addEventListener('click', function() {
    const button = this;
    const content = document.getElementById('simulationContent');

    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Memuat...
    `;

    fetch('{{ route("containers.queue.simulation") }}?max_containers=10')
        .then(response => response.json())
        .then(data => {
            // Update statistics with animation
            document.getElementById('simTotalContainers').textContent = data.total_containers;
            document.getElementById('simTotalTime').textContent = data.total_estimated_time + ' min';
            document.getElementById('simHighPriority').textContent = data.high_priority_count;

            // Update table
            const tableBody = document.getElementById('simulationTable');
            tableBody.innerHTML = '';

            data.containers.forEach(function(item, index) {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gradient-to-r hover:from-slate-700/50 hover:to-slate-600/50 transition-all duration-200';

                // Add staggered animation
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';

                const priorityClass = item.container.priority === 'High'
                    ? 'bg-red-500/20 text-red-300 ring-1 ring-red-500/30'
                    : 'bg-blue-500/20 text-blue-300 ring-1 ring-blue-500/30';

                const positionBadge = index === 0
                    ? 'bg-gradient-to-r from-yellow-400 to-amber-500 text-white shadow-lg'
                    : 'bg-gradient-to-r from-slate-600 to-slate-700 text-white';

                row.innerHTML = `
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="w-8 h-8 ${positionBadge} rounded-full flex items-center justify-center text-sm font-bold shadow-lg">
                                ${item.position}
                            </span>
                            ${index === 0 ? '<span class="ml-2 px-2 py-1 text-xs font-bold bg-yellow-500/20 text-yellow-300 rounded-full ring-1 ring-yellow-500/30">BERIKUTNYA</span>' : ''}
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                            <span class="text-sm font-bold text-white">${item.container.container_number}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full shadow-sm ${priorityClass}">
                            ${item.container.priority === 'High' ?
                                '<svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>' : ''
                            }
                            ${item.container.priority === 'High' ? 'Tinggi' : 'Normal'}
                        </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-white">
                            ${new Date(item.estimated_start_time).toLocaleDateString()}
                        </div>
                        <div class="text-xs text-slate-400">
                            ${new Date(item.estimated_start_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-white">
                            ${new Date(item.estimated_completion_time).toLocaleDateString()}
                        </div>
                        <div class="text-xs text-slate-400">
                            ${new Date(item.estimated_completion_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-orange-400 rounded-full mr-2"></div>
                            <span class="text-sm font-medium text-white">${item.estimated_wait_time} min</span>
                        </div>
                    </td>
                `;

                tableBody.appendChild(row);

                // Animate row appearance
                setTimeout(() => {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });

            content.classList.remove('hidden');

            // Animate content appearance
            content.style.opacity = '0';
            content.style.transform = 'translateY(20px)';
            setTimeout(() => {
                content.style.transition = 'all 0.5s ease';
                content.style.opacity = '1';
                content.style.transform = 'translateY(0)';
            }, 100);

            button.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Segarkan Simulasi
            `;
        })
        .catch(error => {
            console.error('Error loading simulation:', error);

            // Show error state
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-center py-8';
            errorDiv.innerHTML = `
                <div class="text-red-400 mb-2">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-slate-300">Gagal memuat data simulasi</p>
                <p class="text-sm text-slate-400 mt-1">Silakan coba lagi nanti</p>
            `;

            document.getElementById('simulationTable').appendChild(errorDiv);
            content.classList.remove('hidden');

            button.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Coba Lagi
            `;
        })
        .finally(() => {
            button.disabled = false;
        });
});

// Add refresh functionality for real-time updates
setInterval(function() {
    // Auto-refresh statistics every 30 seconds if page is visible
    if (document.visibilityState === 'visible') {
        // You can add auto-refresh logic here if needed
    }
}, 30000);
</script>
@endpush
@endsection

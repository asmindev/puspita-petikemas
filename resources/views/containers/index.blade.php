@extends('layouts.app')

@section('title', 'Peti Kemas')
@section('page-title', 'Peti Kemas')

@section('content')
<!-- Enhanced Header with Dark Theme -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
    <div
        class="bg-gradient-to-r from-slate-800/50 to-slate-700/50 backdrop-blur-sm rounded-3xl p-8 border border-slate-600/30 shadow-2xl">
        <div class="flex items-center mb-4">
            <div class="p-3 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 rounded-2xl shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-3xl font-black text-white mb-2">Manajemen Peti Kemas</h2>
                <p class="text-slate-300 text-lg">Lacak dan kelola antrian serta pemrosesan peti kemas</p>
            </div>
        </div>
        <div class="flex items-center space-x-6 text-sm">
            <div class="flex items-center text-emerald-300">
                <div class="w-2 h-2 bg-emerald-400 rounded-full mr-2 animate-pulse"></div>
                {{ $containers->total() }} Total Peti Kemas
            </div>
            <div class="flex items-center text-blue-300">
                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></div>
                {{ $containers->where('status', 'pending')->count() }} Menunggu
            </div>
            <div class="flex items-center text-orange-300">
                <div class="w-2 h-2 bg-orange-400 rounded-full mr-2 animate-pulse"></div>
                {{ $containers->where('priority', 'High')->count() }} Prioritas Tinggi
            </div>
        </div>
    </div>
    <div class="mt-6 lg:mt-0">
        <a href="{{ route('containers.create') }}"
            class="group relative bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 hover:from-emerald-700 hover:via-emerald-800 hover:to-teal-800 text-white font-bold py-4 px-8 rounded-3xl transition-all duration-300 flex items-center shadow-xl hover:shadow-2xl hover:shadow-emerald-500/25 transform hover:-translate-y-2 hover:scale-105">
            <div
                class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl blur opacity-50 group-hover:opacity-75 transition-opacity">
            </div>
            <div class="relative flex items-center">
                <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Peti Kemas Baru
            </div>
        </a>
    </div>
</div>

<!-- Search and Filter Controls -->
<div
    class="bg-gradient-to-r from-slate-800/50 to-slate-700/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-600/30 shadow-xl mb-6">
    <form method="GET" action="{{ route('containers.index') }}" class="space-y-4 lg:space-y-0">
        <div class="flex flex-col lg:flex-row lg:items-end lg:space-x-4 space-y-4 lg:space-y-0">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-slate-300 mb-2">Cari Peti Kemas</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nomor peti kemas, pelanggan, status..."
                        class="block w-full pl-10 pr-3 py-3 border border-slate-600/50 rounded-xl bg-slate-800/50 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent backdrop-blur-sm">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-2">
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-medium rounded-xl transition-all duration-200 flex items-center shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>
                <a href="{{ route('containers.index') }}"
                    class="px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-all duration-200 flex items-center shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Enhanced Dark Table -->
<div
    class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-2xl border border-slate-700/50 overflow-hidden backdrop-blur-sm">
    @if($containers->count() > 0)
    <!-- Desktop Table -->
    <div class="hidden lg:block overflow-x-auto max-w-full">
        <div class="min-w-full inline-block align-middle">
            <table class="w-full divide-y divide-slate-700/50">
                <thead class="bg-gradient-to-r from-slate-800 to-slate-700">
                    <tr>
                        <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider w-1/6">
                            <a href="{{ route('containers.index', array_merge(request()->query(), ['sort' => 'container_number', 'direction' => request('sort') == 'container_number' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center space-x-1 hover:text-emerald-300 transition-colors">
                                <span>Peti Kemas</span>
                                @if(request('sort') == 'container_number')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if(request('direction') == 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider w-1/6">
                            JPT
                        </th>
                        <th
                            class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider w-1/12">
                            Type
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider w-1/6">
                            Isi Container
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider w-1/6">
                            <a href="{{ route('containers.index', array_merge(request()->query(), ['sort' => 'status', 'direction' => request('sort') == 'status' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center space-x-1 hover:text-emerald-300 transition-colors">
                                <span>Status</span>
                                @if(request('sort') == 'status')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if(request('direction') == 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider w-1/6">
                            <a href="{{ route('containers.index', array_merge(request()->query(), ['sort' => 'priority', 'direction' => request('sort') == 'priority' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center space-x-1 hover:text-emerald-300 transition-colors">
                                <span>Prioritas</span>
                                @if(request('sort') == 'priority')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if(request('direction') == 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </a>
                        </th>
                        <th
                            class="px-4 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider w-1/12">
                            <a href="{{ route('containers.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center space-x-1 hover:text-emerald-300 transition-colors">
                                <span>Dibuat</span>
                                @if(request('sort') == 'created_at')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if(request('direction') == 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                                @endif
                            </a>
                        </th>
                        <th
                            class="px-4 py-4 text-right text-xs font-bold text-slate-300 uppercase tracking-wider w-1/12">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gradient-to-br from-slate-800/80 to-slate-900/80 divide-y divide-slate-700/30">
                    @foreach($containers as $container)
                    <tr
                        class="hover:bg-gradient-to-r hover:from-slate-700/50 hover:to-slate-600/50 transition-all duration-300 group">
                        <td class="px-4 py-4 whitespace-nowrap w-1/6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div
                                        class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-emerald-400/30 flex items-center justify-center backdrop-blur-sm">
                                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div
                                        class="text-sm font-bold text-white group-hover:text-emerald-300 transition-colors">
                                        {{ $container->container_number }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap w-1/6">
                            <div class="text-sm font-medium text-slate-200 truncate">{{ $container->customer->name ??
                                'N/A' }}
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap w-1/12">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-indigo-500/20 border border-indigo-400/40 text-indigo-300 backdrop-blur-sm">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                {{ $container->type ?? '20ft' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 w-1/6">
                            <div class="text-sm text-slate-200">
                                @if($container->contents && count($container->contents) > 0)
                                <div class="space-y-1">
                                    {{-- show the Total contents --}}
                                    <span class="font-medium">{{ count($container->contents) }} Isi</span>
                                </div>
                                @else
                                <span class="text-slate-500 text-xs">Kosong</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-4 py-4 whitespace-nowrap w-1/6">
                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold border backdrop-blur-sm
                            @if($container->status === 'completed')
                                bg-emerald-500/20 border-emerald-400/40 text-emerald-300
                            @elseif($container->status === 'in_progress')
                                bg-amber-500/20 border-amber-400/40 text-amber-300
                            @elseif($container->status === 'cancelled')
                                bg-red-500/20 border-red-400/40 text-red-300
                            @else
                                bg-slate-500/20 border-slate-400/40 text-slate-300
                            @endif">
                                {{ $container->status === 'pending' ? 'Menunggu' :
                                ($container->status === 'in_progress' ? 'Sedang Diproses' :
                                ($container->status === 'completed' ? 'Selesai' :
                                ($container->status === 'cancelled' ? 'Dibatalkan' : ucfirst(str_replace('_', ' ',
                                $container->status))))) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap w-1/6">
                            @if($container->priority === 'High')
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-red-500/20 border border-red-400/40 text-red-300 backdrop-blur-sm">
                                <div class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1 animate-pulse"></div>
                                Prioritas Tinggi
                            </span>
                            @else
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-blue-500/20 border border-blue-400/40 text-blue-300 backdrop-blur-sm">
                                <div class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1"></div>
                                Prioritas Normal
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-xs text-slate-400 w-1/12">
                            {{ $container->created_at->format('M j') }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-right w-1/12">
                            <div class="flex items-center justify-end space-x-1">
                                <a href="{{ route('containers.show', $container) }}"
                                    class="group p-1.5 bg-blue-500/20 hover:bg-blue-500/30 border border-blue-400/30 hover:border-blue-400/50 text-blue-300 hover:text-blue-200 rounded-lg transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('containers.edit', $container) }}"
                                    class="group p-1.5 bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-400/30 hover:border-emerald-400/50 text-emerald-300 hover:text-emerald-200 rounded-lg transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('containers.destroy', $container) }}"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="group p-1.5 bg-red-500/20 hover:bg-red-500/30 border border-red-400/30 hover:border-red-400/50 text-red-300 hover:text-red-200 rounded-lg transition-all duration-300 backdrop-blur-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus peti kemas ini?')">
                                        <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="lg:hidden divide-y divide-slate-700/30">
        @foreach($containers as $container)
        <div
            class="p-6 hover:bg-gradient-to-r hover:from-slate-700/30 hover:to-slate-600/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12">
                        <div
                            class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-emerald-400/30 flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-base font-bold text-white">{{ $container->container_number }}</div>
                        <div class="text-sm text-slate-400">{{ $container->customer->name ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('containers.show', $container) }}"
                        class="p-2 bg-gradient-to-r from-blue-500/20 to-indigo-500/20 border border-blue-400/30 text-blue-300 rounded-xl transition-all duration-300 backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                    <a href="{{ route('containers.edit', $container) }}"
                        class="p-2 bg-gradient-to-r from-emerald-500/20 to-teal-500/20 border border-emerald-400/30 text-emerald-300 rounded-xl transition-all duration-300 backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3 mb-3">
                <span
                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-bold bg-indigo-500/20 border border-indigo-400/40 text-indigo-300 backdrop-blur-sm">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    {{ $container->type ?? '20ft' }}
                </span>
                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-bold border backdrop-blur-sm
                    @if($container->status === 'completed')
                        bg-emerald-500/20 border-emerald-400/40 text-emerald-300
                    @elseif($container->status === 'in_progress')
                        bg-amber-500/20 border-amber-400/40 text-amber-300
                    @elseif($container->status === 'cancelled')
                        bg-red-500/20 border-red-400/40 text-red-300
                    @else
                        bg-slate-500/20 border-slate-400/40 text-slate-300
                    @endif">
                    {{ $container->status === 'pending' ? 'Menunggu' :
                    ($container->status === 'in_progress' ? 'Sedang Diproses' :
                    ($container->status === 'completed' ? 'Selesai' :
                    ($container->status === 'cancelled' ? 'Dibatalkan' : ucfirst(str_replace('_', ' ',
                    $container->status))))) }}
                </span>
                @if($container->priority === 'High')
                <span
                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-bold bg-red-500/20 border border-red-400/40 text-red-300 backdrop-blur-sm">
                    <div class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></div>
                    Prioritas Tinggi
                </span>
                @else
                <span
                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-bold bg-blue-500/20 border border-blue-400/40 text-blue-300 backdrop-blur-sm">
                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                    Prioritas Normal
                </span>
                @endif
            </div>
            @if($container->contents && count($container->contents) > 0)
            <div class="mb-3">
                <div class="text-xs text-slate-400 mb-2">Isi Container:</div>
                <div class="space-y-1">
                    @foreach(array_slice($container->contents, 0, 3) as $item)
                    <div class="text-xs bg-slate-700/50 px-2 py-1 rounded truncate" title="{{ $item }}">
                        {{ Str::limit($item, 30) }}
                    </div>
                    @endforeach
                    @if(count($container->contents) > 3)
                    <div class="text-xs text-slate-400">+{{ count($container->contents) - 3 }} item lainnya</div>
                    @endif
                </div>
            </div>
            @endif
            <div class="text-sm text-slate-400">
                Dibuat {{ $container->created_at->format('M j, Y') }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($containers->hasPages())
    <div class="px-6 py-4 border-t border-slate-700/30">
        {{ $containers->links() }}
    </div>
    @endif
    @else
    <!-- Enhanced Empty State -->
    <div class="text-center py-20">
        <div class="max-w-md mx-auto">
            <div
                class="mx-auto h-24 w-24 bg-gradient-to-br from-slate-700/50 to-slate-600/50 rounded-3xl flex items-center justify-center mb-6 border border-slate-600/30">
                <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Tidak ada peti kemas ditemukan</h3>
            <p class="text-slate-400 mb-8">Mulai kelola antrian peti kemas dengan membuat entri peti kemas pertama Anda.
            </p>
            <a href="{{ route('containers.create') }}"
                class="group relative bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 hover:from-emerald-700 hover:via-emerald-800 hover:to-teal-800 text-white font-bold py-4 px-8 rounded-3xl transition-all duration-300 inline-flex items-center shadow-xl hover:shadow-2xl hover:shadow-emerald-500/25 transform hover:-translate-y-2 hover:scale-105">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl blur opacity-50 group-hover:opacity-75 transition-opacity">
                </div>
                <div class="relative flex items-center">
                    <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Peti Kemas Pertama
                </div>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

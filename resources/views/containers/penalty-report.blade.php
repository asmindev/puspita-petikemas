@extends('layouts.app')

@section('title', 'Laporan Denda Container')
@section('page-title', 'Laporan Denda Container')

@section('content')
<!-- Enhanced Header with Dark Theme -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
    <div
        class="bg-gradient-to-r from-slate-800/50 to-slate-700/50 backdrop-blur-sm rounded-3xl p-8 border border-slate-600/30 shadow-2xl">
        <div class="flex items-center mb-4">
            <div class="p-3 bg-gradient-to-br from-amber-500 via-orange-600 to-red-600 rounded-2xl shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-3xl font-black text-white mb-2">Laporan Denda Container</h2>
                <p class="text-slate-300 text-lg">Monitor dan kelola denda keterlambatan delivery container</p>
            </div>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
            <div class="flex items-center text-blue-300">
                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></div>
                {{ $stats['total_containers'] }} Total Container
            </div>
            <div class="flex items-center text-red-300">
                <div class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></div>
                {{ $stats['containers_with_penalty'] }} Bermasalah
            </div>
            <div class="flex items-center text-amber-300">
                <div class="w-2 h-2 bg-amber-400 rounded-full mr-2 animate-pulse"></div>
                Rp {{ number_format($stats['total_penalty_amount'], 0, ',', '.') }}
            </div>
            <div class="flex items-center text-emerald-300">
                <div class="w-2 h-2 bg-emerald-400 rounded-full mr-2 animate-pulse"></div>
                {{ $containers->count() }} Ditampilkan
            </div>
        </div>
    </div>
</div>

<!-- Filter Controls -->
<div
    class="bg-gradient-to-r from-slate-800/50 to-slate-700/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-600/30 shadow-xl mb-6">
    <form method="GET" action="{{ route('containers.penalty-report') }}" class="space-y-4 lg:space-y-0">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
            <!-- Container Type Filter -->
            <div>
                <label for="type" class="block text-sm font-medium text-slate-300 mb-2">Jenis Container</label>
                <select name="type" id="type"
                    class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="all" {{ request('type')=='all' ? 'selected' : '' }}>Semua Jenis</option>
                    <option value="20ft" {{ request('type')=='20ft' ? 'selected' : '' }}>20ft</option>
                    <option value="40ft" {{ request('type')=='40ft' ? 'selected' : '' }}>40ft</option>
                </select>
            </div>

            <!-- Penalty Status Filter -->
            <div>
                <label for="penalty_status" class="block text-sm font-medium text-slate-300 mb-2">Status Denda</label>
                <select name="penalty_status" id="penalty_status"
                    class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="" {{ request('penalty_status')=='' ? 'selected' : '' }}>Semua Status</option>
                    <option value="has_penalty" {{ request('penalty_status')=='has_penalty' ? 'selected' : '' }}>Ada
                        Denda</option>
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label for="date_from" class="block text-sm font-medium text-slate-300 mb-2">Tanggal Dari</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                    class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <!-- Date To -->
            <div>
                <label for="date_to" class="block text-sm font-medium text-slate-300 mb-2">Tanggal Sampai</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                    class="w-full px-3 py-2 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end space-x-2">
                <button type="submit"
                    class="px-4 py-2 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium rounded-xl transition-all duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filter
                </button>
                <a href="{{ route('containers.penalty-report') }}"
                    class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-all duration-200">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- 20ft Statistics -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-lg border border-slate-700 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-slate-400">Container 20ft</p>
                <p class="text-2xl font-bold text-white">{{ $stats['by_type']['20ft']['count'] }}</p>
                <p class="text-xs text-slate-400">Rp {{ number_format($stats['by_type']['20ft']['penalty'], 0, ',', '.')
                    }}</p>
            </div>
        </div>
    </div>

    <!-- 40ft Statistics -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-lg border border-slate-700 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-slate-400">Container 40ft</p>
                <p class="text-2xl font-bold text-white">{{ $stats['by_type']['40ft']['count'] }}</p>
                <p class="text-xs text-slate-400">Rp {{ number_format($stats['by_type']['40ft']['penalty'], 0, ',', '.')
                    }}</p>
            </div>
        </div>
    </div>

    <!-- Total Penalty -->
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-lg border border-slate-700 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-slate-400">Total Denda</p>
                <p class="text-2xl font-bold text-red-400">Rp {{ number_format($stats['total_penalty_amount'], 0, ',',
                    '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Penalty Rate -->
    {{-- <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-lg border border-slate-700 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-slate-400">Tingkat Denda</p>
                <p class="text-2xl font-bold text-amber-400">{{ $stats['total_containers'] > 0 ?
                    round(($stats['containers_with_penalty'] / $stats['total_containers']) * 100, 1) : 0 }}%</p>
            </div>
        </div>
    </div> --}}
</div>

<!-- Containers Table -->
<div
    class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-2xl border border-slate-700/50 overflow-hidden backdrop-blur-sm">
    @if($containers->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-slate-700 to-slate-800 border-b border-slate-600">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Container
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Pelanggan
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Tanggal
                        Keluar</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Hari
                        Terlambat</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">Denda</th>
                    {{-- <th class="px-6 py-4 text-left text-xs font-bold text-slate-200 uppercase tracking-wider">
                        Penanggung
                        Jawab</th> --}}
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-200 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-gradient-to-br from-slate-800/80 to-slate-900/80 divide-y divide-slate-700/30">
                @foreach($containers as $container)
                @php
                $penaltyInfo = \App\Services\PenaltyCalculationService::calculateDeliveryPenalty($container);
                $penaltyDays = \App\Services\PenaltyCalculationService::getPenaltyDays($container);
                @endphp
                <tr
                    class="hover:bg-gradient-to-r hover:from-slate-700/50 hover:to-slate-600/50 transition-all duration-300">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-emerald-400/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-bold text-white">{{ $container->container_number }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-slate-200">{{ $container->customer->name ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-indigo-500/20 border border-indigo-400/40 text-indigo-300">
                            {{ $container->type ?? '20ft' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                        {{ $container->exit_date ? $container->exit_date->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($penaltyDays > 0)
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-red-500/20 border border-red-400/40 text-red-300">
                            {{ $penaltyDays }} hari
                        </span>
                        @else
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-green-500/20 border border-green-400/40 text-green-300">
                            Tepat waktu
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($penaltyInfo['total_amount'] > 0)
                        <span class="text-red-400 font-bold">
                            Rp {{ number_format($penaltyInfo['total_amount'], 0, ',', '.') }}
                        </span>
                        @else
                        <span class="text-green-400 font-bold">Rp 0</span>
                        @endif
                    </td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap">
                        @if($penaltyInfo['responsible_party'])
                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold
                                @if(str_contains($penaltyInfo['responsible_party'], 'Pelayaran'))
                                    bg-blue-500/20 border border-blue-400/40 text-blue-300
                                @elseif(str_contains($penaltyInfo['responsible_party'], 'Customer'))
                                    bg-red-500/20 border border-red-400/40 text-red-300
                                @else
                                    bg-amber-500/20 border border-amber-400/40 text-amber-300
                                @endif">
                            {{ $penaltyInfo['responsible_party'] }}
                        </span>
                        @else
                        <span class="text-slate-500">-</span>
                        @endif
                    </td> --}}
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('containers.show', $container) }}"
                                class="p-2 bg-blue-500/20 hover:bg-blue-500/30 border border-blue-400/30 text-blue-300 rounded-lg transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('containers.update-penalty', $container) }}"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="p-2 bg-amber-500/20 hover:bg-amber-500/30 border border-amber-400/30 text-amber-300 rounded-lg transition-all duration-300"
                                    title="Update Denda">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
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

    <!-- Pagination -->
    @if($containers->hasPages())
    <div class="px-6 py-4 border-t border-slate-700/30">
        {{ $containers->links() }}
    </div>
    @endif
    @else
    <!-- Empty State -->
    <div class="text-center py-20">
        <div class="max-w-md mx-auto">
            <div
                class="mx-auto h-24 w-24 bg-gradient-to-br from-slate-700/50 to-slate-600/50 rounded-3xl flex items-center justify-center mb-6 border border-slate-600/30">
                <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Tidak ada container dengan denda</h3>
            <p class="text-slate-400 mb-8">Tidak ada container yang memiliki denda delivery sesuai dengan filter yang
                dipilih.</p>
        </div>
    </div>
    @endif
</div>
@endsection

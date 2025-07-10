@extends('layouts.app')

@section('title', 'Detail Peti Kemas')
@section('page-title', $container->container_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('containers.index') }}"
        class="inline-flex items-center text-sm text-gray-600 hover:text-primary transition-colors duration-200 group">
        <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Peti Kemas
    </a>
</div>

<!-- Container Header -->
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
        <div class="flex items-center mb-4 lg:mb-0">
            <div class="h-12 w-12 rounded-lg bg-primary flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="ml-4">
                <h1 class="text-xl font-bold text-gray-900 mb-1">{{ $container->container_number }}</h1>
                <p class="text-gray-600 text-sm font-medium">{{ $container->customer->name ?? 'Tidak Ada Pelanggan' }}
                </p>
                <div class="flex items-center space-x-2 mt-2">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-bold border
                            @if($container->status === 'completed') bg-green-100 border-green-200 text-green-800
                            @elseif($container->status === 'in_progress') bg-amber-100 border-amber-200 text-amber-800
                            @elseif($container->status === 'cancelled') bg-red-100 border-red-200 text-red-800
                            @else bg-blue-100 border-blue-200 text-blue-800
                            @endif">
                        {{ $container->status === 'pending' ? 'Menunggu' :
                        ($container->status === 'in_progress' ? 'Sedang Diproses' :
                        ($container->status === 'completed' ? 'Selesai' :
                        ($container->status === 'cancelled' ? 'Dibatalkan' : ucfirst(str_replace('_', ' ',
                        $container->status))))) }}
                    </span>
                    @if($container->priority === 'High')
                    <span
                        class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-bold bg-red-100 border border-red-200 text-red-800">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></div>
                        Prioritas Tinggi
                    </span>
                    @else
                    <span
                        class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-bold bg-blue-100 border border-blue-200 text-blue-800">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                        Prioritas Normal
                    </span>
                    @endif
                    @if($container->type)
                    <span
                        class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-bold bg-gray-100 text-gray-800 border border-gray-200">
                        {{ $container->type }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3">
            <a href="{{ route('containers.edit', $container) }}"
                class="group px-6 py-3 text-sm font-bold text-white bg-primary rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-blue-500/25 transform hover:-translate-y-1 hover:scale-105">
                <div class="flex items-center"> <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Peti Kemas
                </div>
            </a>
            <form method="POST" action="{{ route('containers.destroy', $container) }}" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="group px-6 py-3 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-red-500/25 transform hover:-translate-y-1 hover:scale-105"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus peti kemas ini?')">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </div>
                </button>
            </form>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Information -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="p-2 bg-blue-100 rounded-xl mr-3">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Informasi Dasar
                </h3>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Nomor Peti
                            Kemas</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{ $container->container_number }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Pelanggan</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">
                            {{ $container->customer->name ?? 'Tidak Ada Pelanggan' }}
                        </p>
                    </div>
                    @if($container->type)
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Jenis Peti
                            Kemas</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{ $container->type }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Status</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{ $container->status === 'pending' ?
                            'Menunggu' :
                            ($container->status === 'in_progress' ? 'Sedang Diproses' :
                            ($container->status === 'completed' ? 'Selesai' :
                            ($container->status === 'cancelled' ? 'Dibatalkan' : ucfirst(str_replace('_', ' ',
                            $container->status))))) }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Prioritas</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{ $container->priority === 'High' ?
                            'Tinggi' :
                            'Normal' }}</p>
                    </div>
                    @if($container->estimated_time)
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Estimasi Waktu</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{ $container->estimated_time }} menit</p>
                    </div>
                    @endif
                    @if($container->entry_date)
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Tanggal Masuk</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{ $container->entry_date->format('M j, Y
                            g:i
                            A') }}</p>
                    </div>
                    @endif
                    @if($container->exit_date)
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Tanggal Keluar</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{ $container->exit_date->format('M j, Y g:i
                            A') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($container->contents && count($container->contents) > 0)
        <!-- Container Contents -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="p-2 bg-purple-100 rounded-xl mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    Isi Container
                    <span class="ml-2 px-2 py-1 text-xs font-bold bg-purple-100 text-purple-800 rounded-full">
                        {{ count($container->contents) }} item
                    </span>
                </h3>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($container->contents as $index => $item)
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-sm font-bold text-purple-600">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $item }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Process Information -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="p-2 bg-blue-100 rounded-xl mr-3">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Informasi Proses
                </h3>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Waktu Mulai
                            Proses</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{ $container->process_start_time ?
                            $container->process_start_time->format('M j, Y g:i A') : 'Belum dimulai' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Waktu Selesai
                            Proses</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{ $container->process_end_time ?
                            $container->process_end_time->format('M j, Y g:i A') : 'Belum selesai' }}</p>
                    </div>
                    @if($container->process_start_time && $container->process_end_time)
                    <div class="md:col-span-2">
                        <label class="text-sm font-bold text-gray-500 uppercase tracking-wider">Durasi
                            Pemrosesan</label>
                        <p class="text-lg font-semibold text-gray-900 mt-2">{{
                            $container->process_start_time->diffInMinutes($container->process_end_time) }}
                            menit</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Penalty Information -->
        @php
        $penaltyInfo = $container->delivery_penalty;
        $currentPenaltyInfo = $container->current_period_penalty;
        $penaltyDays = $container->delivery_penalty_days;
        @endphp

        @if($container->exit_date)
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="p-2 bg-amber-100 rounded-xl mr-3">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    Informasi Denda Delivery
                    @if($penaltyDays > 0)
                    <span class="ml-2 px-3 py-1 text-xs font-bold bg-red-100 text-red-800 rounded-full animate-pulse">
                        {{ $penaltyDays }} hari terlambat
                    </span>
                    @else
                    <span class="ml-2 px-3 py-1 text-xs font-bold bg-green-100 text-green-800 rounded-full">
                        Tepat waktu
                    </span>
                    @endif
                </h3>
            </div>
            <div class="p-8">
                <div class="gridd grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">Tanggal Keluar Terjadwal:</span>
                                <span class="text-gray-900 font-bold">{{ $container->exit_date->format('d M Y')
                                    }}</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">Hari Terlambat:</span>
                                <span class="text-gray-900 font-bold">
                                    @if($penaltyDays > 0)
                                    <span class="text-red-600">{{ $penaltyDays }} hari</span>
                                    @else
                                    <span class="text-green-600">0 hari</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">Periode Saat Ini:</span>
                                <span class="text-gray-900 font-bold">
                                    @if($currentPenaltyInfo['current_period'])
                                    {{ $currentPenaltyInfo['current_period'] }}
                                    @else
                                    -
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">Total Denda Masa Ini:</span>
                                <span class="text-gray-900 font-bold text-lg">
                                    @if($currentPenaltyInfo['current_amount'] > 0)
                                    <span class="text-red-600">Rp {{
                                        number_format($currentPenaltyInfo['current_amount'],
                                        0, ',',
                                        '.') }}</span>
                                    @else
                                    <span class="text-green-600">Rp 0</span>
                                    @endif
                                </span>
                            </div>
                            @if($currentPenaltyInfo['current_responsible'])
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">Tanggung Jawab:</span>
                                <span class="text-gray-900 font-bold">{{ $currentPenaltyInfo['current_responsible']
                                    }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- @if(!empty($penaltyInfo['breakdown']))
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Rincian Perhitungan (Jika Akumulatif)</h4>
                        <div class="space-y-3">
                            @foreach($penaltyInfo['breakdown'] as $breakdown)
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-medium text-gray-900">{{ $breakdown['period'] }}</span>
                                    <span class="text-sm px-2 py-1 bg-blue-100 text-blue-800 rounded">{{
                                        $breakdown['responsible'] }}</span>
                                </div>
                                <div class="text-sm text-gray-600 space-y-1">
                                    <div class="flex justify-between">
                                        <span>{{ $breakdown['days'] }} hari × Rp {{ number_format($breakdown['rate'], 0,
                                            ',', '.') }}</span>
                                        <span class="font-bold text-gray-900">Rp {{ number_format($breakdown['amount'],
                                            0,
                                            ',', '.') }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $breakdown['note'] }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if($penaltyInfo['total_amount'] > 0)
                        <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900">Total Akumulatif:</span>
                                <span class="text-xl font-bold text-red-600">Rp {{
                                    number_format($penaltyInfo['total_amount'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif --}}
                </div>

                @if($currentPenaltyInfo['description'])
                <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <h5 class="text-sm font-bold text-blue-800 uppercase tracking-wider mb-2">Rincian Denda Masa Saat
                        Ini:</h5>
                    <p class="text-blue-900 mb-2">{{ $currentPenaltyInfo['description'] }}</p>
                    <p class="text-xs text-blue-700 italic">* Ini adalah total denda untuk masa/periode saat ini saja,
                        bukan akumulatif dari semua masa.</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($container->notes)
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-xl mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    Catatan
                </h3>
            </div>
            <div class="p-8">
                <p class="text-gray-700 leading-relaxed">{{ $container->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Timeline -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="p-2 bg-purple-100 rounded-xl mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Timeline
                </h3>
            </div>
            <div class="p-8">
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                @if($container->process_start_time || $container->process_end_time)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-300"
                                    aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span
                                            class="h-8 w-8 rounded-full bg-primary flex items-center justify-center shadow-lg">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Peti Kemas Ditambahkan</p>
                                            <p class="mt-0.5 text-xs text-gray-500">{{
                                                $container->created_at->format('M j, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        @if($container->process_start_time)
                        <li>
                            <div class="relative pb-8">
                                @if($container->process_end_time)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-300"
                                    aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span
                                            class="h-8 w-8 rounded-full bg-amber-500 flex items-center justify-center shadow-lg">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Pemrosesan dimulai</p>
                                            <p class="mt-0.5 text-xs text-gray-500">{{
                                                $container->process_start_time->format('M j, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif

                        @if($container->process_end_time)
                        <li>
                            <div class="relative">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span
                                            class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center shadow-lg">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 pb-5">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Pemrosesan selesai</p>
                                            <p class="mt-0.5 text-xs text-gray-500">{{
                                                $container->process_end_time->format('M j, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="px-8 py-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <div class="p-2 bg-cyan-100 rounded-xl mr-3">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    Aksi Cepat
                </h3>
            </div>
            <div class="p-8 space-y-4">
                {{-- @if($container->status === 'pending')
                <form method="POST" action="{{ route('containers.update', $container) }}" class="w-full">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="in_progress">
                    <input type="hidden" name="process_start_time" value="{{ now()->format('Y-m-d\TH:i') }}">
                    <input type="hidden" name="customer_id" value="{{ $container->customer_id }}">
                    <input type="hidden" name="container_number" value="{{ $container->container_number }}">
                    <input type="hidden" name="type" value="{{ $container->type }}">
                    <input type="hidden" name="priority" value="{{ $container->priority }}">
                    <button type="submit"
                        class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-amber-500/25 transform hover:-translate-y-1 hover:scale-105">
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-5-10v20m5-20v20" />
                            </svg>
                            Mulai Pemrosesan
                        </div>
                    </button>
                </form>
                @endif

                @if($container->status === 'in_progress')
                <form method="POST" action="{{ route('containers.update', $container) }}" class="w-full">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="completed">
                    <input type="hidden" name="process_end_time" value="{{ now()->format('Y-m-d\TH:i') }}">
                    <input type="hidden" name="customer_id" value="{{ $container->customer_id }}">
                    <input type="hidden" name="container_number" value="{{ $container->container_number }}">
                    <input type="hidden" name="type" value="{{ $container->type }}">
                    <input type="hidden" name="priority" value="{{ $container->priority }}">
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-green-500/25 transform hover:-translate-y-1 hover:scale-105">
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Selesaikan
                        </div>
                    </button>
                </form>
                @endif --}}

                <a href="{{ route('containers.edit', $container) }}"
                    class="w-full bg-primary text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-blue-500/25 transform hover:-translate-y-1 hover:scale-105 text-center block">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Detail
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

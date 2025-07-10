@extends('layouts.app')

@section('title', 'Pelanggan')
@section('page-title', 'Pelanggan')

@section('content')
<!-- Enhanced Header with White Theme -->
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
    <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center mb-3">
            <div class="p-2 bg-blue-600 rounded-lg shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="ml-3">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Manajemen Pelanggan</h2>
                <p class="text-gray-600 text-sm">Kelola pelanggan dan hubungan peti kemas mereka</p>
            </div>
        </div>
        <div class="flex items-center space-x-4 text-sm">
            <div class="flex items-center text-blue-600">
                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></div>
                {{ $customers->count() }} Total Pelanggan
            </div>
            <div class="flex items-center text-green-600">
                <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                {{ $customers->sum('containers_count') }} Total Peti Kemas
            </div>
            <div class="flex items-center text-red-600">
                <div class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></div>
                Rp {{ number_format($customers->sum('total_penalty') ?? 0, 0, ',', '.') }} Total Denda
            </div>
        </div>
    </div>
    <div class="mt-4 lg:mt-0">
        <a href="{{ route('customers.create') }}"
            class="group bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center shadow-sm hover:shadow-md transform hover:-translate-y-1">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pelanggan Baru
            </div>
        </a>
    </div>
</div>

<!-- Search and Filter Controls -->
<div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-xl mb-6">
    <form method="GET" action="{{ route('customers.index') }}" class="space-y-4 lg:space-y-0">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
            <!-- Search Input -->
            <div class="lg:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Pelanggan</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama pelanggan..."
                        class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                </div>
            </div>

            <!-- Sort Dropdown -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                <select name="sort" id="sort"
                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="name_asc" {{ request('sort', 'name_asc' )=='name_asc' ? 'selected' : '' }}>Nama A-Z
                    </option>
                    <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="created_desc" {{ request('sort')=='created_desc' ? 'selected' : '' }}>Terbaru
                    </option>
                    <option value="created_asc" {{ request('sort')=='created_asc' ? 'selected' : '' }}>Terlama</option>
                    <option value="containers_desc" {{ request('sort')=='containers_desc' ? 'selected' : '' }}>Container
                        Terbanyak</option>
                </select>
            </div>

            <!-- Items Per Page -->
            <div>
                <label for="per_page" class="block text-sm font-medium text-gray-700 mb-2">Item per Halaman</label>
                <select name="per_page" id="per_page"
                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="5" {{ request('per_page', 5)==5 ? 'selected' : '' }}>5 item</option>
                    <option value="10" {{ request('per_page')==10 ? 'selected' : '' }}>10 item</option>
                    <option value="15" {{ request('per_page')==15 ? 'selected' : '' }}>15 item</option>
                    <option value="25" {{ request('per_page')==25 ? 'selected' : '' }}>25 item</option>
                    <option value="50" {{ request('per_page')==50 ? 'selected' : '' }}>50 item</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end space-x-2">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>
                <a href="{{ route('customers.index') }}"
                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-all duration-200">
                    Reset
                </a>
            </div>
        </div>

        <!-- Advanced Filters (Collapsible) -->
        <div id="advanced-filters" class="hidden mt-4 pt-4 border-t border-gray-300">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <!-- Container Filter -->
                <div>
                    <label for="container_filter" class="block text-sm font-medium text-gray-700 mb-2">Filter
                        Container</label>
                    <select name="container_filter" id="container_filter"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="" {{ request('container_filter')=='' ? 'selected' : '' }}>Semua</option>
                        <option value="has_containers" {{ request('container_filter')=='has_containers' ? 'selected'
                            : '' }}>Ada Container</option>
                        <option value="no_containers" {{ request('container_filter')=='no_containers' ? 'selected' : ''
                            }}>Tanpa Container</option>
                    </select>
                </div>

                <!-- Penalty Filter -->
                <div>
                    <label for="penalty_filter" class="block text-sm font-medium text-gray-700 mb-2">Filter
                        Denda</label>
                    <select name="penalty_filter" id="penalty_filter"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <option value="" {{ request('penalty_filter')=='' ? 'selected' : '' }}>Semua</option>
                        <option value="has_penalty" {{ request('penalty_filter')=='has_penalty' ? 'selected' : '' }}>Ada
                            Denda</option>
                        <option value="no_penalty" {{ request('penalty_filter')=='no_penalty' ? 'selected' : '' }}>Tanpa
                            Denda</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Terdaftar Dari</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Terdaftar Sampai</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
            </div>
        </div>

        <!-- Toggle Advanced Filters Button -->
        <div class="flex justify-center mt-4">
            <button type="button" id="toggle-advanced"
                class="text-sm text-gray-600 hover:text-blue-600 transition-colors flex items-center">
                <span id="toggle-text">Tampilkan Filter Lanjutan</span>
                <svg id="toggle-icon" class="w-4 h-4 ml-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
    </form>
</div>

<!-- Results Info and Pagination Info -->
<div class="mb-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
    @if(request()->filled(['search', 'container_filter', 'penalty_filter', 'date_from', 'date_to']))
    <div class="p-4 bg-white rounded-xl border border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                <span class="font-medium">{{ $customers->total() }}</span> pelanggan ditemukan
                @if(request('search'))
                untuk pencarian "<span class="font-medium text-blue-600">{{ request('search') }}</span>"
                @endif
            </div>
            <a href="{{ route('customers.index') }}" class="text-sm text-red-600 hover:text-red-700 transition-colors">
                Hapus Semua Filter
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Enhanced Table -->
<div class="bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">
    @if($customers->count() > 0)
    <!-- Desktop Table -->
    <div class="hidden lg:block overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg class="size-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informasi Pelanggan
                        </div>
                    </th>
                    <th class="p-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg class="size-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Peti Kemas
                        </div>
                    </th>
                    <th class="p-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg class="size-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            Denda
                        </div>
                    </th>
                    <th class="p-6 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg class="size-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Dibuat
                        </div>
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center justify-end">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                            Aksi
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($customers as $customer)
                <tr class="group hover:bg-gray-50 transition-all duration-300">
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="relative flex-shrink-0 h-12 w-12">
                                <div
                                    class="h-12 w-12 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:shadow-blue-600/25 transform group-hover:mb-1 transition-all duration-300">
                                    <span class="text-white font-bold text-lg">{{ substr($customer->name, 0, 1)
                                        }}</span>
                                </div>
                                <div
                                    class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-2 border-white flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                </div>
                            </div>
                            <div class="ml-4">
                                <div
                                    class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{
                                    $customer->name }}</div>
                                <div class="text-xs text-gray-500 mt-1">ID: #{{ str_pad($customer->id, 4, '0',
                                    STR_PAD_LEFT) }}</div>
                                <div class="flex items-center mt-2">
                                    <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></div>
                                    <span
                                        class="text-xs text-green-600 font-medium bg-green-100 px-2 py-0.5 rounded-full">Aktif</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="flex flex-col">
                                <div class="flex items-center">
                                    <span
                                        class="text-2xl font-black text-gray-900 group-hover:text-blue-600 transition-colors">{{
                                        $customer->containers_count ?? 0 }}</span>
                                    <div class="ml-2 px-2 py-1 bg-blue-50 rounded-lg border border-blue-200">
                                        <span class="text-blue-600 text-xs font-bold">Kontainer</span>
                                    </div>
                                </div>
                                @if($customer->containers_count == 0)
                                <div class="text-xs text-gray-500 mt-1 bg-gray-100 px-2 py-0.5 rounded-full">Kosong
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <div class="flex flex-col">
                                <div class="flex items-center">
                                    @if(($customer->total_penalty ?? 0) > 0)
                                    <span
                                        class="text-lg font-black text-red-600 group-hover:text-red-700 transition-colors"
                                        title="Rp {{ number_format($customer->total_penalty, 0, ',', '.') }}">
                                        @if($customer->total_penalty >= 1000)
                                        Rp {{ number_format($customer->total_penalty / 1000, 1) }}K
                                        @else
                                        Rp {{ number_format($customer->total_penalty, 0) }}
                                        @endif
                                    </span>
                                    <div class="ml-2 px-2 py-1 bg-red-50 rounded-lg border border-red-200">
                                        <span class="text-red-600 text-xs font-bold">Denda</span>
                                    </div>
                                    @else
                                    <span
                                        class="text-lg font-black text-green-600 group-hover:text-green-700 transition-colors">
                                        Rp 0
                                    </span>
                                    <div class="ml-2 px-2 py-1 bg-green-50 rounded-lg border border-green-200">
                                        <span class="text-green-600 text-xs font-bold">Lunas</span>
                                    </div>
                                    @endif
                                </div>
                                @if(($customer->total_penalty ?? 0) > 0)
                                <div class="text-xs text-red-600 mt-1 bg-red-100 px-2 py-0.5 rounded-full">Tunggakan
                                </div>
                                @else
                                <div class="text-xs text-green-600 mt-1 bg-green-100 px-2 py-0.5 rounded-full">Aman
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex flex-col">
                            <div class="text-gray-900 font-medium text-sm">{{ $customer->created_at->format('d M Y') }}
                            </div>
                            <div class="text-xs text-gray-500">{{ $customer->created_at->diffForHumans() }}</div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('customers.show', $customer) }}"
                                class="group/btn relative p-2 bg-blue-50 hover:bg-blue-600 rounded-lg border border-blue-200 hover:border-blue-600 transition-all duration-300 transform hover:mb-1 hover:shadow-lg hover:shadow-blue-600/25">
                                <svg class="w-4 h-4 text-blue-600 group-hover/btn:text-white group-hover/btn:scale-110 transition-all"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('customers.edit', $customer) }}"
                                class="group/btn relative p-2 bg-green-50 hover:bg-green-600 rounded-lg border border-green-200 hover:border-green-600 transition-all duration-300 transform hover:mb-1 hover:shadow-lg hover:shadow-green-600/25">
                                <svg class="w-4 h-4 text-green-600 group-hover/btn:text-white group-hover/btn:scale-110 transition-all"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('customers.destroy', $customer) }}"
                                class="inline-block"
                                onsubmit="return confirm('Apakah Anda yakin? Ini akan menghapus semua peti kemas yang terkait juga.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="group/btn relative p-2 bg-red-50 hover:bg-red-600 rounded-lg border border-red-200 hover:border-red-600 transition-all duration-300 transform hover:mb-1 hover:shadow-lg hover:shadow-red-600/25">
                                    <svg class="w-4 h-4 text-red-600 group-hover/btn:text-white group-hover/btn:scale-110 transition-all"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <!-- Enhanced Mobile Cards -->
    <div class="lg:hidden p-6">
        <div class="space-y-6">
            @foreach($customers as $customer)
            <div
                class="bg-white rounded-3xl p-6 border border-gray-200 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="relative h-14 w-14">
                            <div class="h-14 w-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-lg">{{ substr($customer->name, 0, 1) }}</span>
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 rounded-full border-2 border-white">
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-bold text-gray-900">{{ $customer->name }}</div>
                            <div class="text-sm text-gray-500">ID: #{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-black text-blue-600">{{ $customer->containers_count ?? 0 }}</div>
                        <div class="text-xs text-gray-500">peti kemas</div>
                        @if(($customer->total_penalty ?? 0) > 0)
                        <div class="text-lg font-black text-red-600 mt-1">Rp {{ number_format($customer->total_penalty,
                            0, ',', '.') }}</div>
                        <div class="text-xs text-red-600">denda</div>
                        @else
                        <div class="text-lg font-black text-green-600 mt-1">Rp 0</div>
                        <div class="text-xs text-green-600">denda</div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        <div>{{ $customer->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $customer->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('customers.show', $customer) }}"
                            class="p-3 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-xl transition-all duration-300 transform hover:mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <a href="{{ route('customers.edit', $customer) }}"
                            class="p-3 bg-green-50 hover:bg-green-600 text-green-600 hover:text-white rounded-xl transition-all duration-300 transform hover:mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="inline-block"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">>
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-3 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white rounded-xl transition-all duration-300 transform hover:mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Enhanced Pagination -->
    @if($customers->hasPages())
    <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
        {{ $customers->links() }}
    </div>
    @endif
    @else
    <!-- Enhanced Empty State -->
    <div class="text-center py-16 px-8">
        <div class="max-w-md mx-auto">
            <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Pelanggan</h3>
            <p class="text-gray-600 text-lg mb-8">Mulai dengan membuat pelanggan pertama untuk mengelola peti kemas
                mereka.</p>
            <a href="{{ route('customers.create') }}"
                class="group relative bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 inline-flex items-center shadow-xl hover:shadow-2xl hover:shadow-blue-600/25 transform hover:-translate-y-1">
                <div class="relative flex items-center">
                    <svg class="w-5 h-5 mr-3 group-hover:mb-2 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Pelanggan Pertama
                </div>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggle-advanced');
    const advancedFilters = document.getElementById('advanced-filters');
    const toggleText = document.getElementById('toggle-text');
    const toggleIcon = document.getElementById('toggle-icon');

    if (toggleButton && advancedFilters) {
        // Check if any advanced filter is active to show them by default
        const hasAdvancedFilters = {{
            request()->has('penalty_filter') || request()->has('date_from') || request()->has('date_to') ? 'true' : 'false'
        }};

        if (hasAdvancedFilters) {
            advancedFilters.classList.remove('hidden');
            toggleText.textContent = 'Sembunyikan Filter Lanjutan';
            toggleIcon.style.transform = 'rotate(180deg)';
        }

        toggleButton.addEventListener('click', function() {
            const isHidden = advancedFilters.classList.contains('hidden');

            if (isHidden) {
                advancedFilters.classList.remove('hidden');
                toggleText.textContent = 'Sembunyikan Filter Lanjutan';
                toggleIcon.style.transform = 'rotate(180deg)';
            } else {
                advancedFilters.classList.add('hidden');
                toggleText.textContent = 'Tampilkan Filter Lanjutan';
                toggleIcon.style.transform = 'rotate(0deg)';
            }
        });
    }

    // Auto-submit form when per_page changes
    const perPageSelect = document.getElementById('per_page');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Auto-submit form when filter changes (optional)
    const filterSelects = document.querySelectorAll('#container_filter, #penalty_filter');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Uncomment the line below if you want auto-submit on filter change
            // this.form.submit();
        });
    });
});
</script>
@endpush

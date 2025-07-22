@extends('layouts.app')

@section('title', 'Detail Pelanggan')
@section('page-title', $customer->name)

@section('content')
<div class="mb-8">
    <a href="{{ route('customers.index') }}"
        class="inline-flex items-center text-sm text-gray-600 hover:text-primary transition-all duration-200 group">
        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke daftar
    </a>
</div>

<!-- Customer Info Card -->
<div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8 mb-8">
    <div class="flex items-start justify-between">
        <div class="flex items-center">
            <div class="h-20 w-20 rounded-2xl bg-primary flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-2xl">{{ substr($customer->name, 0, 1) }}</span>
            </div>
            <div class="ml-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $customer->name }}</h1>
                <div class="flex items-center space-x-4 text-sm">
                    <p class="text-gray-600 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span class="font-medium text-primary ml-1">#{{ $customer->id }}</span>
                    </p>
                    <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                    <p class="text-gray-600 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a2 2 0 012-2h6a2 2 0 012 2v4M4 7h16l-1 10a2 2 0 01-2 2H7a2 2 0 01-2-2L4 7z" />
                        </svg>
                        Anggota sejak {{ $customer->created_at->format('M j, Y') }}
                    </p>
                    @if($customer->pin)
                    <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                    <p class="text-gray-600 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="font-medium text-amber-600 ml-1">PIN: {{ $customer->pin }}</span>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('customers.edit', $customer) }}"
                class="group px-6 py-3 text-sm font-medium text-white bg-primary rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center">
                <svg class="w-4 h-4 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Pelanggan
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Containers Card -->
    <div
        class="group bg-white rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center">
            <div class="p-4 bg-primary rounded-xl shadow-lg transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Peti Kemas</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-primary transition-colors">{{
                    $customer->containers->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Pending Containers Card -->
    <div
        class="group bg-white rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center">
            <div class="p-4 bg-amber-500 rounded-xl shadow-lg transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Menunggu</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-amber-500 transition-colors">{{
                    $customer->containers->where('status', 'pending')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Completed Containers Card -->
    <div
        class="group bg-white rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center">
            <div class="p-4 bg-green-500 rounded-xl shadow-lg transition-transform duration-300">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Selesai</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-green-500 transition-colors">{{
                    $customer->containers->where('status', 'completed')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Containers Table -->
<div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-200 flex items-center justify-between bg-gray-50">
        <div>
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Inventori Peti Kemas
            </h3>
            <p class="text-sm text-gray-600 mt-1">Semua peti kemas milik pelanggan ini</p>
        </div>
        <a href="{{ route('containers.create', ['customer_id' => $customer->id]) }}"
            class="group px-6 py-3 text-sm font-medium text-white bg-primary rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center">
            <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Peti Kemas
        </a>
    </div>

    @if($customer->containers->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Peti Kemas</th>
                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status
                    </th>
                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Prioritas
                    </th>
                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Dibuat
                    </th>
                    <th class="px-8 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($customer->containers as $container)
                <tr class="hover:bg-gray-50 transition-all duration-200 group">
                    <td class="px-8 py-6 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="text-sm font-semibold text-gray-900">{{ $container->container_number }}</div>
                        </div>
                    </td>
                    <td class="px-8 py-6 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium rounded-full border
                                        @if($container->status === 'completed') bg-green-100 text-green-800 border-green-200
                                        @elseif($container->status === 'in_progress') bg-amber-100 text-amber-800 border-amber-200
                                        @else bg-gray-100 text-gray-800 border-gray-200
                                        @endif">
                            {{ ucfirst(str_replace('_', ' ', $container->status)) }}
                        </span>
                    </td>
                    <td class="px-8 py-6 whitespace-nowrap">
                        @if($container->priority === 'High')
                        <span
                            class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full border border-red-200 flex items-center w-fit">
                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                            Tinggi
                        </span>
                        @else
                        <span
                            class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full border border-blue-200">Normal</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 whitespace-nowrap text-sm text-gray-600">
                        {{ $container->created_at->format('M j, Y') }}
                    </td>
                    <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('containers.show', $container) }}"
                                class="p-2 text-primary hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('containers.edit', $container) }}"
                                class="p-2 text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-16">
        <div class="relative mb-6">
            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto shadow-lg">
                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <!-- Floating dots -->
            <div class="absolute -top-2 -right-2 w-4 h-4 bg-blue-500 rounded-full opacity-60 animate-ping"></div>
            <div
                class="absolute -bottom-1 -left-1 w-3 h-3 bg-purple-500 rounded-full opacity-60 animate-ping animation-delay-200">
            </div>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada peti kemas</h3>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">Pelanggan ini belum memiliki peti kemas. Mulai dengan menambahkan
            peti kemas pertama mereka untuk memulai pelacakan.</p>
        <div class="mt-8">
            <a href="{{ route('containers.create', ['customer_id' => $customer->id]) }}"
                class="group bg-primary text-white font-medium py-4 px-8 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 inline-flex items-center">
                <svg class="w-5 h-5 mr-3 group-hover:rotate-90 transition-transform duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Peti Kemas Pertama
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

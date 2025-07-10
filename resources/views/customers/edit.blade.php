@extends('layouts.app')

@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')

@section('content')
<div class="w-full">
    <!-- Back Button -->
    <div class="mb-8">
        <a href="{{ route('customers.index') }}"
            class="group inline-flex items-center bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 hover:text-blue-600 py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Pelanggan
        </a>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">
        <!-- Form Header -->
        <div class="px-8 py-6 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="p-3 bg-blue-600 rounded-2xl border border-blue-200">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-black text-gray-900">Edit Pelanggan</h3>
                    <p class="text-gray-600 mt-1">Perbarui informasi pelanggan</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('customers.update', $customer) }}" class="p-8">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <!-- Customer Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-3">Nama Pelanggan</label>
                    <div class="relative">
                        <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}"
                            class="w-full px-4 py-4 bg-white border border-gray-300 rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-600/50 focus:border-blue-600 transition-all duration-300 text-gray-900 placeholder-gray-400 @error('name') border-red-500 focus:ring-red-500/50 focus:border-red-500 @enderror"
                            placeholder="Masukkan nama pelanggan" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                    @error('name')
                    <div class="flex items-center mt-2 text-red-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Statistics Display -->
                <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                    <div class="flex items-center mb-4">
                        <div class="w-1 h-6 bg-blue-600 rounded-full mr-3"></div>
                        <h4 class="text-lg font-bold text-gray-900">Statistik Saat Ini</h4>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="bg-white border border-blue-200 rounded-xl p-4">
                                <p class="text-sm font-medium text-blue-600 mb-2">Jumlah Peti Kemas</p>
                                <p class="text-3xl font-black text-gray-900">{{ $customer->container_count }}</p>
                                <div class="flex items-center justify-center mt-2">
                                    <svg class="w-4 h-4 text-blue-600 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <span class="text-xs text-gray-500">Total peti kemas</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="bg-white border border-green-200 rounded-xl p-4">
                                <p class="text-sm font-medium text-green-600 mb-2">Anggota Sejak</p>
                                <p class="text-xl font-black text-gray-900">{{ $customer->created_at->format('M j, Y')
                                    }}
                                </p>
                                <div class="flex items-center justify-center mt-2">
                                    <svg class="w-4 h-4 text-green-600 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs text-slate-400">Tanggal registrasi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Action Buttons -->
            <div class="mt-12 pt-8 border-t border-slate-700/50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Info Section -->
                    <div
                        class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border border-amber-400/20 rounded-2xl p-4 backdrop-blur-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-amber-400 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-amber-300 mb-1">Penting</p>
                                <p class="text-xs text-slate-400">Mengubah nama pelanggan akan mempengaruhi semua
                                    catatan peti kemas terkait.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('customers.index') }}"
                            class="group px-6 py-4 bg-gradient-to-r from-slate-600/50 to-slate-500/50 hover:from-slate-500/60 hover:to-slate-400/60 border border-slate-500/30 hover:border-slate-400/50 text-slate-300 hover:text-white font-bold rounded-2xl transition-all duration-300 backdrop-blur-sm shadow-lg hover:shadow-xl">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </span>
                        </a>
                        <button type="submit"
                            class="group relative bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-blue-500/25 transform hover:-translate-y-1 hover:scale-105">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur opacity-50 group-hover:opacity-75 transition-opacity">
                            </div>
                            <span class="relative flex items-center">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Perbarui Pelanggan
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

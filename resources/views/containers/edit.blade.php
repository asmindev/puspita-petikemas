@extends('layouts.app')

@section('title', 'Edit Peti Kemas')
@section('page-title', 'Edit Peti Kemas')

@section('content')
<div class="w-full">
    <!-- Enhanced Back Button -->
    <div class="mb-8">
        <a href="{{ route('containers.index') }}"
            class="group inline-flex items-center bg-gradient-to-r from-slate-700/50 to-slate-600/50 hover:from-slate-600/60 hover:to-slate-500/60 backdrop-blur-sm border border-slate-600/30 text-slate-300 hover:text-white py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Peti Kemas
        </a>
    </div>

    <!-- Enhanced Dark Form Container -->
    <div
        class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-2xl border border-slate-700/50 overflow-hidden backdrop-blur-sm">
        <!-- Form Header -->
        <div class="px-8 py-6 border-b border-slate-700/50 bg-gradient-to-r from-slate-800/80 to-slate-700/80">
            <div class="flex items-center">
                <div
                    class="p-3 bg-gradient-to-br from-emerald-500/20 to-teal-500/20 rounded-2xl border border-emerald-400/30">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-black text-white">Edit Peti Kemas</h3>
                    <p class="text-slate-400 mt-1">Perbarui informasi peti kemas</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('containers.update', $container) }}" class="p-8">
            @csrf
            @method('PUT')

            <!-- Hidden field to store the previous URL -->
            <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Section Header -->
                <div class="md:col-span-2 mb-4">
                    <div class="flex items-center">
                        <div class="w-1 h-8 bg-gradient-to-b from-emerald-400 to-teal-400 rounded-full mr-4"></div>
                        <h4 class="text-xl font-bold text-white">Informasi Peti Kemas</h4>
                    </div>
                </div>

                <!-- Customer Selection -->
                <div class="space-y-2">
                    <label for="customer_id" class="block text-sm font-bold text-slate-300 mb-3">Pelanggan</label>
                    <div class="relative">
                        <select name="customer_id" id="customer_id"
                            class="w-full px-4 py-4 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm @error('customer_id') border-red-400/50 focus:ring-red-500/50 focus:border-red-400/50 @enderror"
                            required>
                            <option value="" class="bg-slate-800 text-slate-300">Pilih pelanggan</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" class="bg-slate-800 text-white" {{ old('customer_id',
                                $container->customer_id)==$customer->id ? 'selected' : '' }}>{{ $customer->name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </div>
                    @error('customer_id')
                    <div class="flex items-center mt-2 text-red-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Container Number -->
                <div class="space-y-2">
                    <label for="container_number" class="block text-sm font-bold text-slate-300 mb-3">Nomor
                        Peti Kemas</label>
                    <div class="relative">
                        <input type="text" name="container_number" id="container_number"
                            value="{{ old('container_number', $container->container_number) }}"
                            class="w-full px-4 py-4 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm @error('container_number') border-red-400/50 focus:ring-red-500/50 focus:border-red-400/50 @enderror"
                            placeholder="Masukkan nomor peti kemas" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                    @error('container_number')
                    <div class="flex items-center mt-2 text-red-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Container Type -->
                <div class="space-y-2">
                    <label for="type" class="block text-sm font-bold text-slate-300 mb-3">Tipe Peti Kemas</label>
                    <div class="relative">
                        <select name="type" id="type"
                            class="w-full px-4 py-4 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm @error('type') border-red-400/50 focus:ring-red-500/50 focus:border-red-400/50 @enderror"
                            required>
                            <option value="20ft" class="bg-slate-800 text-white" {{ old('type', $container->type ??
                                '20ft') == '20ft' ? 'selected' : '' }}>20ft</option>
                            <option value="40ft" class="bg-slate-800 text-white" {{ old('type', $container->type) ==
                                '40ft' ? 'selected' : '' }}>40ft</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </div>
                    @error('type')
                    <div class="flex items-center mt-2 text-red-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Container Contents -->
                <div class="space-y-2">
                    <label for="contents" class="block text-sm font-bold text-slate-300 mb-3">Isi Peti Kemas</label>
                    <div class="space-y-3">
                        <div id="contents-container">
                            @php
                            $contents = old('contents', $container->contents ?? []);
                            $contents = is_array($contents) ? $contents : [];
                            @endphp

                            @if(count($contents) > 0)
                            @foreach($contents as $index => $content)
                            <div class="content-item flex items-center space-x-3 mb-3">
                                <div class="flex-1">
                                    <input type="text" name="contents[]" value="{{ $content }}"
                                        class="w-full px-4 py-3 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm"
                                        placeholder="Masukkan nama barang/isi container">
                                </div>
                                <button type="button"
                                    class="remove-content {{ count($contents) <= 1 ? 'hidden' : '' }} px-3 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                            @else
                            <div class="content-item flex items-center space-x-3 mb-3">
                                <div class="flex-1">
                                    <input type="text" name="contents[]"
                                        class="w-full px-4 py-3 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm"
                                        placeholder="Masukkan nama barang/isi container">
                                </div>
                                <button type="button"
                                    class="remove-content hidden px-3 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            @endif
                        </div>
                        <button type="button" id="add-content"
                            class="inline-flex items-center px-4 py-2 bg-blue-500/20 hover:bg-blue-500/30 text-blue-300 font-medium rounded-lg transition-all duration-200 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Item
                        </button>
                    </div>
                    @error('contents')
                    <div class="flex items-center mt-2 text-red-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label for="status" class="block text-sm font-bold text-slate-300 mb-3">Status</label>
                    <div class="relative">
                        <select name="status" id="status"
                            class="w-full px-4 py-4 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm @error('status') border-red-400/50 focus:ring-red-500/50 focus:border-red-400/50 @enderror"
                            required>
                            <option value="pending" class="bg-slate-800 text-white" {{ old('status', $container->
                                status)=='pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="in_progress" class="bg-slate-800 text-white" {{ old('status', $container->
                                status)=='in_progress' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="completed" class="bg-slate-800 text-white" {{ old('status', $container->
                                status)=='completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </div>
                    @error('status')
                    <div class="flex items-center mt-2 text-red-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Priority -->
                <div class="space-y-2">
                    <label for="priority" class="block text-sm font-bold text-slate-300 mb-3">Prioritas</label>
                    <div class="relative">
                        <select name="priority" id="priority"
                            class="w-full px-4 py-4 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm @error('priority') border-red-400/50 focus:ring-red-500/50 focus:border-red-400/50 @enderror"
                            required>
                            <option value="Normal" class="bg-slate-800 text-white" {{ old('priority', $container->
                                priority)=='Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="High" class="bg-slate-800 text-white" {{ old('priority', $container->
                                priority)=='High' ? 'selected' : '' }}>Prioritas Tinggi</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </div>
                    @error('priority')
                    <div class="flex items-center mt-2 text-red-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Additional Notes -->
                <div class="md:col-span-2 space-y-2">
                    <label for="notes" class="block text-sm font-bold text-slate-300 mb-3">Catatan Tambahan</label>
                    <div class="relative">
                        <textarea name="notes" id="notes" rows="4"
                            class="w-full px-4 py-4 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm resize-none @error('notes') border-red-400/50 focus:ring-red-500/50 focus:border-red-400/50 @enderror"
                            placeholder="Masukkan catatan tambahan atau instruksi khusus...">{{ old('notes', $container->notes) }}</textarea>
                        <div class="absolute top-4 right-4 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                    @error('notes')
                    <div class="flex items-center mt-2 text-red-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Exit Date -->
                <div class="space-y-2">
                    <label for="exit_date" class="block text-sm font-bold text-slate-300 mb-3">Tanggal Keluar</label>
                    <div class="relative">
                        <input type="date" name="exit_date" id="exit_date"
                            value="{{ old('exit_date', $container->exit_date ? $container->exit_date->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-4 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm @error('exit_date') border-red-400/50 focus:ring-red-500/50 focus:border-red-400/50 @enderror"
                            placeholder="Masukkan tanggal keluar">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a2 2 0 012-2h6a2 2 0 012 2v4M4 7h16l-1 10a2 2 0 01-2 2H7a2 2 0 01-2-2L4 7z" />
                            </svg>
                        </div>
                    </div>
                    @error('exit_date')
                    <div class="flex items-center mt-2 text-red-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>

            <!-- Enhanced Action Buttons -->
            <div class="mt-12 pt-8 border-t border-slate-700/50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Tips Section -->
                    <div
                        class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 border border-blue-400/20 rounded-2xl p-4 backdrop-blur-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-blue-300 mb-1">Tips Pro</p>
                                <p class="text-xs text-slate-400">Perbarui status dan prioritas saat peti kemas bergerak
                                    melalui antrian pemrosesan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('containers.index') }}"
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
                            class="group relative bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 hover:from-emerald-700 hover:via-emerald-800 hover:to-teal-800 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl hover:shadow-emerald-500/25 transform hover:-translate-y-1 hover:scale-105">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl blur opacity-50 group-hover:opacity-75 transition-opacity">
                            </div>
                            <span class="relative flex items-center">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Perbarui Peti Kemas
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    console.log('Edit Peti Kemas Page Loaded');
    document.addEventListener('DOMContentLoaded', function() {
    const addContentBtn = document.getElementById('add-content');
    const contentsContainer = document.getElementById('contents-container');
    let contentCount = document.querySelectorAll('.content-item').length;

    // Add content item
    addContentBtn.addEventListener('click', function() {
        contentCount++;

        const contentItem = document.createElement('div');
        contentItem.className = 'content-item flex items-center space-x-3 mb-3';
        contentItem.innerHTML = `
            <div class="flex-1">
                <input type="text" name="contents[]"
                    class="w-full px-4 py-3 bg-gradient-to-r from-slate-700/50 to-slate-600/50 border border-slate-600/50 rounded-xl shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400/50 transition-all duration-300 text-white placeholder-slate-400 backdrop-blur-sm"
                    placeholder="Masukkan nama barang/isi container">
            </div>
            <button type="button" class="remove-content px-3 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-lg transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;

        contentsContainer.appendChild(contentItem);
        updateRemoveButtons();

        // Focus on the new input
        const newInput = contentItem.querySelector('input');
        newInput.focus();

        // Add animation
        contentItem.style.opacity = '0';
        contentItem.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            contentItem.style.transition = 'all 0.3s ease';
            contentItem.style.opacity = '1';
            contentItem.style.transform = 'translateY(0)';
        }, 10);
    });

    // Remove content item
    contentsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-content')) {
            const contentItem = e.target.closest('.content-item');
            contentItem.style.transition = 'all 0.3s ease';
            contentItem.style.opacity = '0';
            contentItem.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                contentItem.remove();
                contentCount--;
                updateRemoveButtons();
            }, 300);
        }
    });

    // Update remove buttons visibility
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-content');
        const contentItems = document.querySelectorAll('.content-item');

        removeButtons.forEach(btn => {
            if (contentItems.length > 1) {
                btn.classList.remove('hidden');
            } else {
                btn.classList.add('hidden');
            }
        });
    }

    // Initial update
    updateRemoveButtons();
});
</script>
@endpush
@endsection

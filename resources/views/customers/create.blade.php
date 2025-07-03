@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')

@section('content')
<div class="w-full mx-auto">
    <!-- Enhanced Dark Back Button -->
    <div class="mb-8">
        <a href="{{ route('customers.index') }}"
            class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-slate-700/50 to-slate-800/50 hover:from-slate-600/50 hover:to-slate-700/50 text-slate-300 hover:text-white rounded-2xl border border-slate-600/30 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg backdrop-blur-sm">
            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="font-semibold">Kembali ke Pelanggan</span>
        </a>
    </div>

    <!-- Enhanced Dark Form Container -->
    <div
        class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-2xl border border-slate-700/50 overflow-hidden backdrop-blur-sm">
        <!-- Enhanced Header -->
        <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-8 border-b border-slate-600/50">
            <div class="flex items-center">
                <div class="p-4 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div class="ml-6">
                    <h3 class="text-2xl font-black text-white">Buat Pelanggan Baru</h3>
                    <p class="text-slate-300 text-lg mt-2">Tambahkan pelanggan baru ke sistem manajemen peti kemas Anda
                    </p>
                </div>
            </div>
        </div>

        <!-- Enhanced Form -->
        <form method="POST" action="{{ route('customers.store') }}" class="p-8">
            @csrf

            <div class="space-y-8">
                <!-- Customer Name Field -->
                <div class="group">
                    <label for="name" class="block text-lg font-bold text-white mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Nama Pelanggan *
                        </div>
                    </label>
                    <div class="relative">
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-6 py-4 bg-slate-700/50 border-2 border-slate-600/30 rounded-2xl text-white placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 text-lg font-medium @error('name') border-red-500/50 focus:ring-red-500/20 focus:border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap pelanggan" required>
                        <div
                            class="absolute inset-0 rounded-2xl bg-gradient-to-r from-blue-500/10 to-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                        </div>
                        @if(!$errors->has('name'))
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    @error('name')
                    <div class="mt-3 p-4 bg-red-900/30 border border-red-500/30 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-red-300 font-medium">{{ $message }}</p>
                        </div>
                    </div>
                    @enderror
                    <div class="mt-3 text-sm text-slate-400">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Ini akan menjadi pengenal utama untuk pelanggan dalam sistem
                        </div>
                    </div>
                </div>

                <!-- Additional Info Section -->
                <div class="bg-slate-700/30 rounded-2xl p-6 border border-slate-600/30">
                    <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Apa yang terjadi selanjutnya?
                    </h4>
                    <div class="space-y-3 text-slate-300">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full mr-3"></div>
                            <span>Pelanggan akan dibuat dan diberikan ID unik</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                            <span>Anda dapat mulai menambahkan peti kemas untuk pelanggan ini</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                            <span>Lacak dan kelola semua operasi peti kemas</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-slate-700/50 mt-8">
                <a href="{{ route('customers.index') }}"
                    class="group px-8 py-4 text-lg font-bold text-slate-300 bg-slate-700/50 hover:bg-slate-600/50 border-2 border-slate-600/30 hover:border-slate-500/50 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </div>
                </a>
                <button type="submit"
                    class="group relative px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl hover:shadow-blue-500/25">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur opacity-50 group-hover:opacity-75 transition-opacity">
                    </div>
                    <div class="relative flex items-center">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Pelanggan
                    </div>
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Tips Section -->
    <div
        class="mt-8 bg-gradient-to-r from-slate-800/50 to-slate-700/50 rounded-3xl p-6 border border-slate-600/30 backdrop-blur-sm">
        <h4 class="text-lg font-bold text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
            Pro Tips
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-300">
            <div class="flex items-start">
                <div class="w-2 h-2 bg-amber-400 rounded-full mr-3 mt-2"></div>
                <div>
                    <div class="font-semibold text-white">Use clear names</div>
                    <div>Choose descriptive customer names for easy identification</div>
                </div>
            </div>
            <div class="flex items-start">
                <div class="w-2 h-2 bg-emerald-400 rounded-full mr-3 mt-2"></div>
                <div>
                    <div class="font-semibold text-white">Consistent format</div>
                    <div>Maintain consistent naming conventions across customers</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

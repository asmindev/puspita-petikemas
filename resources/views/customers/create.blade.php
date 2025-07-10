@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')

@section('content')
<div class="w-full mx-auto">
    <!-- Compact Back Button -->
    <div class="mb-8">
        <a href="{{ route('customers.index') }}"
            class="group inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 hover:text-primary rounded-2xl border border-gray-300 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="font-semibold">Kembali ke Pelanggan</span>
        </a>
    </div>

    <!-- Compact Form Container -->
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gray-50 px-8 py-8 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-4 bg-primary rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div class="ml-6">
                    <h3 class="text-2xl font-black text-gray-900">Buat Pelanggan Baru</h3>
                    <p class="text-gray-600 text-lg mt-2">Tambahkan pelanggan baru ke sistem manajemen peti kemas Anda
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('customers.store') }}" class="p-8">
            @csrf

            <div class="space-y-8">
                <!-- Customer Name Field -->
                <div class="group">
                    <label for="name" class="block text-lg font-bold text-gray-900 mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Nama Pelanggan *
                        </div>
                    </label>
                    <div class="relative">
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-6 py-4 bg-white border-2 border-gray-300 rounded-2xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-primary/20 focus:border-primary transition-all duration-300 text-lg font-medium @error('name') border-red-500 focus:ring-red-500/20 focus:border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap pelanggan" required>
                        <div
                            class="absolute inset-0 rounded-2xl bg-primary/10 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                        </div>
                        @if(!$errors->has('name'))
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    @error('name')
                    <div class="mt-3 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-red-600 font-medium">{{ $message }}</p>
                        </div>
                    </div>
                    @enderror
                    <div class="mt-3 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Ini akan menjadi pengenal utama untuk pelanggan dalam sistem
                        </div>
                    </div>
                </div>

                <!-- Additional Info Section -->
                <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                    <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Apa yang terjadi selanjutnya?
                    </h4>
                    <div class="space-y-3 text-gray-700">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            <span>Pelanggan akan dibuat dan diberikan ID unik</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>
                            <span>Anda dapat mulai menambahkan peti kemas untuk pelanggan ini</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-purple-600 rounded-full mr-3"></div>
                            <span>Lacak dan kelola semua operasi peti kemas</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-200 mt-8">
                <a href="{{ route('customers.index') }}"
                    class="group px-8 py-4 text-lg font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 border-2 border-gray-300 hover:border-gray-400 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
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
                    class="group relative px-8 py-4 text-lg font-bold text-white bg-primary hover:bg-blue-700 rounded-2xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl hover:shadow-primary/25">
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
    <div class="mt-8 bg-white rounded-3xl p-6 border border-gray-200">
        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
            Pro Tips
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
            <div class="flex items-start">
                <div class="w-2 h-2 bg-primary rounded-full mr-3 mt-2"></div>
                <div>
                    <div class="font-semibold text-gray-900">Use clear names</div>
                    <div>Choose descriptive customer names for easy identification</div>
                </div>
            </div>
            <div class="flex items-start">
                <div class="w-2 h-2 bg-green-500 rounded-full mr-3 mt-2"></div>
                <div>
                    <div class="font-semibold text-gray-900">Consistent format</div>
                    <div>Maintain consistent naming conventions across customers</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

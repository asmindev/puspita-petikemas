@extends('layouts.app')

@section('title', 'Tambah Peti Kemas')
@section('page-title', 'Tambah Peti Kemas')

@section('content')
<div class="w-full">
    <!-- Compact Back Button -->
    <div class="mb-4">
        <a href="{{ route('containers.index') }}"
            class="group inline-flex items-center bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 hover:text-primary py-2 px-4 rounded-lg transition-all duration-300 shadow-sm hover:shadow-md text-sm">
            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Peti Kemas
        </a>
    </div>

    <!-- Compact Form Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Compact Form Header -->
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <div class="p-2 bg-primtext-primaryrounded-lg border border-primtext-primary">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-bold text-gray-900">Buat Peti Kemas Baru</h3>
                    <p class="text-gray-600 text-sm">Tambahkan peti kemas baru ke antrian pemrosesan</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('containers.store') }}" class="p-4">
            @csrf

            <!-- Hidden field to store the previous URL -->
            <input type="hidden" name="redirect_url" value="{{ url()->previous() }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Compact Section Header -->
                <div class="md:col-span-2 mb-3">
                    <div class="flex items-center">
                        <div class="w-1 h-6 bg-primtext-primary rounded-full mr-3"></div>
                        <h4 class="text-lg font-bold text-gray-900">Informasi Peti Kemas</h4>
                    </div>
                </div>

                <!-- Customer Selection -->
                <div class="space-y-1">
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">JPT</label>
                    <div class="relative">
                        <select name="customer_id" id="customer_id"
                            class="w-full px-5 py-4 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 @error('customer_id') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror text-sm"
                            required>
                            <option value="" class="text-gray-500">Pilih JPT</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id',
                                request('customer_id'))==$customer->id ? 'selected' : '' }}>{{ $customer->name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </div>
                    @error('customer_id')
                    <div class="flex items-center mt-1 text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Container Number -->
                <div class="space-y-1">
                    <label for="container_number" class="block text-sm font-medium text-gray-700">Nomor
                        Peti Kemas</label>
                    <div class="relative">
                        <input type="text" name="container_number" id="container_number"
                            value="{{ old('container_number') }}"
                            class="w-full px-5 py-4 pl-10 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 placeholder-gray-500 @error('container_number') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror text-sm"
                            placeholder="Masukkan nomor peti kemas" required>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                    @error('container_number')
                    <div class="flex items-center mt-1 text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Container Type -->
                <div class="space-y-1">
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Peti Kemas</label>
                    <div class="relative">
                        <select name="type" id="type"
                            class="w-full px-5 py-4 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 @error('type') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror text-sm"
                            required>
                            <option value="20ft" {{ old('type', '20ft' )=='20ft' ? 'selected' : '' }}>20ft</option>
                            <option value="40ft" {{ old('type')=='40ft' ? 'selected' : '' }}>40ft</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </div>
                    @error('type')
                    <div class="flex items-center mt-1 text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Container Contents -->
                <div class="space-y-1">
                    <label for="contents" class="block text-sm font-medium text-gray-700">Isi Peti Kemas</label>
                    <div class="space-y-2">
                        <div id="contents-container">
                            <div class="content-item flex items-center space-x-2">
                                <div class="flex-1">
                                    <input type="text" name="contents[]"
                                        class="w-full px-5 py-4 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 placeholder-gray-500 text-sm"
                                        placeholder="Masukkan nama barang/isi container">
                                </div>
                                <button type="button"
                                    class="remove-content hidden px-2 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="add-content"
                            class="inline-flex items-center px-3 py-2 bg-primtext-primaryhover:bg-primtext-primary text-primary font-medium rounded-lg transition-all duration-200 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Item
                        </button>
                    </div>
                    @error('contents')
                    <div class="flex items-center mt-1 text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="relative">
                        <select name="status" id="status"
                            class="w-full px-5 py-4 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 @error('status') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror text-sm"
                            required>
                            <option value="pending" {{ old('status', 'pending' )=='pending' ? 'selected' : '' }}>
                                Menunggu</option>
                            <option value="in_progress" {{ old('status')=='in_progress' ? 'selected' : '' }}>Sedang
                                Diproses</option>
                            <option value="completed" {{ old('status')=='completed' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </div>
                    @error('status')
                    <div class="flex items-center mt-1 text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Priority -->
                <div class="space-y-1">
                    <label for="priority" class="block text-sm font-medium text-gray-700">Prioritas</label>
                    <div class="relative">
                        <select name="priority" id="priority"
                            class="w-full px-5 py-4 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 @error('priority') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror text-sm"
                            required>
                            <option value="Normal" {{ old('priority', 'Normal' )=='Normal' ? 'selected' : '' }}>Normal
                            </option>
                            <option value="High" {{ old('priority')=='High' ? 'selected' : '' }}>Prioritas Tinggi
                            </option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                    </div>
                    @error('priority')
                    <div class="flex items-center mt-1 text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
                {{-- Entry Date --}}
                <div class="space-y-1">
                    <label for="entry_date" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                    <div class="relative">
                        <input onload="this.value = new Date().toISOString().split('T')[0]" type="date"
                            name="entry_date" id="entry_date" value="{{ old('entry_date') }}"
                            class="w-full px-5 py-4 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 @error('entry_date') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror text-sm"
                            placeholder="Masukkan tanggal masuk" required>
                    </div>
                    @error('entry_date')
                    <div class="flex items-center mt-1 text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label for="exit_date" class="block text-sm font-medium text-gray-700">Tanggal Keluar</label>
                    <div class="relative">
                        <input type="date" name="exit_date" id="exit_date" value="{{ old('exit_date') }}"
                            class="w-full px-5 py-4 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 @error('exit_date') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror text-sm"
                            placeholder="Masukkan tanggal keluar" required>
                    </div>
                    @error('exit_date')
                    <div class="flex items-center mt-1 text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <!-- Additional Notes -->
                <div class="md:col-span-2 space-y-1">
                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Tambahan</label>
                    <div class="relative">
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-5 py-4 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 placeholder-gray-500 resize-none @error('notes') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror text-sm"
                            placeholder="Masukkan catatan tambahan atau instruksi khusus...">{{ old('notes') }}</textarea>
                        <div class="absolute top-2 right-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                    @error('notes')
                    <div class="flex items-center mt-1 text-red-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>

            <!-- Compact Action Buttons -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <!-- Tips Section -->
                    <div class="bg-primary/5 border border-primary/80 rounded-lg p-3">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 text-primary mt-0.5 mr-2 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-primary">Tips</p>
                                <p class="text-xs text-primary">Pilih tingkat prioritas yang sesuai dengan urgensi dan
                                    kebutuhan pemrosesan peti kemas.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('containers.index') }}"
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 hover:text-gray-800 font-medium rounded-lg transition-all duration-200 text-sm">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </span>
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-primary hover:bg-primtext-primary text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md text-sm">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Buat Peti Kemas
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
    document.addEventListener('DOMContentLoaded', function() {
    const addContentBtn = document.getElementById('add-content');
    const contentsContainer = document.getElementById('contents-container');
    let contentCount = 1;

    // Add content item
    addContentBtn.addEventListener('click', function() {
        contentCount++;

        const contentItem = document.createElement('div');
        contentItem.className = 'content-item flex items-center space-x-2 mt-2';
        contentItem.innerHTML = `
            <div class="flex-1">
                <input type="text" name="contents[]"
                    class="w-full px-5 py-4 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primtext-primary focus:border-primtext-primary transition-all duration-200 text-gray-900 placeholder-gray-500 text-sm"
                    placeholder="Masukkan nama barang/isi container">
            </div>
            <button type="button" class="remove-content px-2 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-all duration-200">
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

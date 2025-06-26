<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Search Form -->
        <x-filament::section>
            <x-slot name="heading">
                Cari Kontainer
            </x-slot>

            <form wire:submit.prevent="searchContainer">
                {{ $this->form }}

                <div class="mt-6">
                    <x-filament::button type="submit" icon="heroicon-o-magnifying-glass">
                        Cari Kontainer
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        <!-- Container Details -->
        @if($container)
        <x-filament::section>
            <x-slot name="heading">
                Detail Kontainer: {{ $container->container_number }}
            </x-slot>

            <!-- Status Progress - Moved to Top -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Progress</h3>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <!-- Waiting -->
                        <div class="flex flex-col items-center">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center {{ $container->status !== 'cancelled' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                @if($container->status !== 'cancelled')
                                <x-heroicon-o-check class="w-4 h-4" />
                                @else
                                <x-heroicon-o-x-mark class="w-4 h-4" />
                                @endif
                            </div>
                            <div class="text-xs mt-1">Terdaftar</div>
                        </div>

                        <!-- Line -->
                        <div
                            class="flex-1 h-1 mx-2 {{ in_array($container->status, ['processing', 'completed']) ? 'bg-green-500' : 'bg-gray-300' }}">
                        </div>

                        <!-- Processing -->
                        <div class="flex flex-col items-center">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center {{ in_array($container->status, ['processing', 'completed']) ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                @if(in_array($container->status, ['processing', 'completed']))
                                <x-heroicon-o-check class="w-4 h-4" />
                                @else
                                <div class="w-2 h-2 rounded-full bg-current"></div>
                                @endif
                            </div>
                            <div class="text-xs mt-1">Diproses</div>
                        </div>

                        <!-- Line -->
                        <div
                            class="flex-1 h-1 mx-2 {{ $container->status === 'completed' ? 'bg-green-500' : 'bg-gray-300' }}">
                        </div>

                        <!-- Completed -->
                        <div class="flex flex-col items-center">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center {{ $container->status === 'completed' ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }}">
                                @if($container->status === 'completed')
                                <x-heroicon-o-check class="w-4 h-4" />
                                @else
                                <div class="w-2 h-2 rounded-full bg-current"></div>
                                @endif
                            </div>
                            <div class="text-xs mt-1">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Informasi Dasar</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nomor Kontainer:</span>
                            <span class="font-medium">{{ $container->container_number }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Customer/Pemilik Barang:</span>
                            <span class="font-medium">{{ $container->customer->name }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Prioritas:</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $container->priority === 'Darurat' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $container->priority === 'Tinggi' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $container->priority === 'Normal' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ $container->priority }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Target Keluar:</span>
                            <span
                                class="font-medium {{ $container->tanggal_keluar && $container->status === 'waiting' && now()->startOfDay() > $container->tanggal_keluar->startOfDay() ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $container->tanggal_keluar ? $container->tanggal_keluar->format('d/m/Y') : 'Belum
                                ditentukan' }}
                                @if($container->tanggal_keluar && $container->status === 'waiting' &&
                                now()->startOfDay() > $container->tanggal_keluar->startOfDay())
                                <span class="text-xs text-red-500">(terlambat {{ $container->penalty_days }}
                                    hari)</span>
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Durasi Penumpukan:</span>
                            <span
                                class="font-medium text-{{ $container->actual_storage_duration > 14 ? 'red' : ($container->actual_storage_duration > 7 ? 'yellow' : ($container->actual_storage_duration > 1 ? 'blue' : 'green')) }}-600">
                                {{ $container->storage_duration }} hari
                                @if($container->actual_storage_duration <= 1) <span class="text-xs text-gray-500">
                                    (gratis)</span>
                            @endif
                            </span>
                        </div>

                        @if($container->penalty_days > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Keterlambatan:</span>
                            <span class="font-medium text-red-600">
                                {{ $container->penalty_days }} hari
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Enhanced Timeline -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Timeline Aktivitas</h3>

                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                        <!-- Timeline Items -->
                        <div class="space-y-6">
                            <!-- Masuk -->
                            <div class="relative flex items-start">
                                <div
                                    class="relative z-10 flex items-center justify-center w-8 h-8 bg-green-500 rounded-full ring-4 ring-white">
                                    <x-heroicon-s-truck class="w-4 h-4 text-white" />
                                </div>
                                <div class="ml-4 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900">Kontainer Masuk</div>
                                    <div class="text-sm text-gray-500">{{ $container->tanggal_masuk->format('d/m/Y H:i')
                                        }}</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $container->tanggal_masuk->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                            <!-- Menunggu Antrian -->
                            @if($container->status === 'waiting')
                            <div class="relative flex items-start">
                                <div
                                    class="relative z-10 flex items-center justify-center w-8 h-8 bg-yellow-500 rounded-full ring-4 ring-white animate-pulse">
                                    <x-heroicon-s-clock class="w-4 h-4 text-white" />
                                </div>
                                <div class="ml-4 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900">Menunggu dalam Antrian</div>
                                    <div class="text-sm text-yellow-600">Sedang menunggu giliran proses</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        Waktu tunggu: {{ round($container->waiting_time) }} menit
                                    </div>
                                    @if($container->waktu_estimasi)
                                    <div class="text-xs text-blue-500">
                                        Estimasi proses: {{ $container->waktu_estimasi }} menit
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Mulai Diproses -->
                            @if($container->waktu_mulai_proses)
                            <div class="relative flex items-start">
                                <div
                                    class="relative z-10 flex items-center justify-center w-8 h-8 bg-blue-500 rounded-full ring-4 ring-white {{ $container->status === 'processing' ? 'animate-pulse' : '' }}">
                                    <x-heroicon-s-cog-6-tooth class="w-4 h-4 text-white" />
                                </div>
                                <div class="ml-4 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900">Mulai Diproses</div>
                                    <div class="text-sm text-gray-500">{{ $container->waktu_mulai_proses->format('d/m/Y
                                        H:i') }}</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $container->waktu_mulai_proses->diffForHumans() }}
                                    </div>
                                    @if($container->status === 'processing')
                                    <div class="text-xs text-blue-600 mt-1">
                                        Waktu proses: {{ round($container->processing_time) }} menit
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Selesai Diproses -->
                            @if($container->waktu_selesai_proses)
                            <div class="relative flex items-start">
                                <div
                                    class="relative z-10 flex items-center justify-center w-8 h-8 bg-green-600 rounded-full ring-4 ring-white">
                                    <x-heroicon-s-check class="w-4 h-4 text-white" />
                                </div>
                                <div class="ml-4 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900">Selesai Diproses</div>
                                    <div class="text-sm text-gray-500">{{
                                        $container->waktu_selesai_proses->format('d/m/Y H:i') }}</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $container->waktu_selesai_proses->diffForHumans() }}
                                    </div>
                                    <div class="text-xs text-green-600 mt-1">
                                        Total waktu proses: {{ round($container->processing_time) }} menit
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Keluar -->
                            @if($container->tanggal_keluar)
                            <div class="relative flex items-start">
                                <div
                                    class="relative z-10 flex items-center justify-center w-8 h-8 bg-purple-500 rounded-full ring-4 ring-white">
                                    <x-heroicon-s-arrow-right-on-rectangle class="w-4 h-4 text-white" />
                                </div>
                                <div class="ml-4 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900">Kontainer Keluar</div>
                                    <div class="text-sm text-gray-500">{{ $container->tanggal_keluar->format('d/m/Y
                                        H:i') }}</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {{ $container->tanggal_keluar->diffForHumans() }}
                                    </div>
                                    <div class="text-xs text-purple-600 mt-1">
                                        Total waktu di pelabuhan: {{ round($container->total_time) }} menit
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Cancelled -->
                            @if($container->status === 'cancelled')
                            <div class="relative flex items-start">
                                <div
                                    class="relative z-10 flex items-center justify-center w-8 h-8 bg-red-500 rounded-full ring-4 ring-white">
                                    <x-heroicon-s-x-mark class="w-4 h-4 text-white" />
                                </div>
                                <div class="ml-4 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900">Dibatalkan</div>
                                    <div class="text-sm text-red-600">Proses kontainer dibatalkan</div>
                                    @if($container->keterangan)
                                    <div class="text-xs text-gray-500 mt-1">
                                        Alasan: {{ $container->keterangan }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Future Step Preview (if waiting or processing) -->
                            @if(in_array($container->status, ['waiting', 'processing']))
                            <div class="relative flex items-start opacity-50">
                                <div
                                    class="relative z-10 flex items-center justify-center w-8 h-8 bg-gray-300 rounded-full ring-4 ring-white border-2 border-dashed border-gray-400">
                                    @if($container->status === 'waiting')
                                    <x-heroicon-o-cog-6-tooth class="w-4 h-4 text-gray-600" />
                                    @else
                                    <x-heroicon-o-check class="w-4 h-4 text-gray-600" />
                                    @endif
                                </div>
                                <div class="ml-4 min-w-0 flex-1">
                                    @if($container->status === 'waiting')
                                    <div class="text-sm font-medium text-gray-500">Akan Diproses</div>
                                    <div class="text-xs text-gray-400">Menunggu giliran untuk diproses</div>
                                    @else
                                    <div class="text-sm font-medium text-gray-500">Akan Selesai</div>
                                    <div class="text-xs text-gray-400">Proses akan segera selesai</div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </x-filament::section>

        <!-- Queue Position (only if waiting) -->
        @if($container->status === 'waiting' && $queueInfo)
        <x-filament::section>
            <x-slot name="heading">
                Posisi dalam Antrian
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- FCFS Position -->
                <div class="p-6 bg-blue-50 rounded-lg">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">FCFS (First Come First Serve)</h3>
                        <div class="text-3xl font-bold text-blue-700 mb-2">
                            #{{ $queueInfo['fcfs_position'] ?? 'N/A' }}
                        </div>
                        <div class="text-sm text-blue-600">
                            dari {{ $queueInfo['fcfs_total'] }} kontainer
                        </div>
                        @if($estimatedCompletion && $estimatedCompletion['fcfs'])
                        <div class="text-xs text-blue-500 mt-2">
                            Estimasi selesai: {{ $estimatedCompletion['fcfs']->format('d/m/Y H:i') }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Priority Position -->
                <div class="p-6 bg-orange-50 rounded-lg">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-orange-900 mb-2">Priority Scheduler</h3>
                        <div class="text-3xl font-bold text-orange-700 mb-2">
                            #{{ $queueInfo['priority_position'] ?? 'N/A' }}
                        </div>
                        <div class="text-sm text-orange-600">
                            dari {{ $queueInfo['priority_total'] }} kontainer
                        </div>
                        @if($estimatedCompletion && $estimatedCompletion['priority'])
                        <div class="text-xs text-orange-500 mt-2">
                            Estimasi selesai: {{ $estimatedCompletion['priority']->format('d/m/Y H:i') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </x-filament::section>
        @endif
        <!-- Penalty Information -->
        @if($container->status_denda)
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-red-500" />
                    Informasi Denda
                </div>
            </x-slot>

            <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-red-800 font-medium">Jumlah Denda:</span>
                    <span class="text-red-900 font-bold text-lg">Rp {{ number_format($container->jumlah_denda, 0, ',',
                        '.') }}</span>
                </div>
                @if($container->keterangan)
                <div class="mt-2 text-sm text-red-700">
                    <strong>Keterangan:</strong> {{ $container->keterangan }}
                </div>
                @endif
            </div>
        </x-filament::section>
        @endif
        @endif
    </div>
</x-filament-panels::page>

<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header with Real-time Updates -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        FCFS + Priority Scheduler
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Algoritma antrian berdasarkan prioritas dengan FCFS dalam setiap level prioritas
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Terakhir diperbarui: {{ now()->format('d M Y H:i:s') }}
                    </p>
                </div>
            </div>

            <!-- Key Metrics Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Antrian</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['waiting'] ?? 0
                                }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sedang Diproses</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['processing'] ??
                                0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rata-rata Proses</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{
                                number_format($statistics['avg_processing_time'] ?? 0, 1) }}m</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Selesai Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{
                                $statistics['completed_today'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Queue List --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Antrian Kontainer</h3>
                    </div>
                    <div class="p-6">
                        @if(isset($queueList) && $queueList->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($queueList->take(10) as $index => $container)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg
                                              {{ $index === 0 ? 'ring-2 ring-green-500 bg-green-50 dark:bg-green-900' : '' }}">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full
                                                           {{ $index === 0 ? 'bg-green-500 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300' }}
                                                           text-sm font-medium">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $container->container_number }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Customer: {{ $container->customer->name ?? 'Unknown' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <div class="flex items-center space-x-2">
                                        @if($container->priority === 'Darurat')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Darurat
                                        </span>
                                        @elseif($container->priority === 'Tinggi')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Tinggi
                                        </span>
                                        @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                            Normal
                                        </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Menunggu: {{ $container->tanggal_masuk ?
                                        $container->tanggal_masuk->diffForHumans() : 'Unknown' }}
                                    </p>
                                    @if($container->jumlah_denda > 0)
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">
                                        Denda: Rp {{ number_format($container->jumlah_denda, 0, ',', '.') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach

                            @if($queueList->count() > 10)
                            <div class="text-center pt-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Dan {{ $queueList->count() - 10 }} kontainer lainnya...
                                </p>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-5v9">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada antrian</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Semua kontainer telah diproses atau
                                belum ada yang masuk antrian.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar with Next Container and Processing --}}
            <div class="space-y-6">
                {{-- Next Container --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Kontainer Selanjutnya</h3>
                    </div>
                    <div class="p-6">
                        @if($nextContainer)
                        <div class="text-center">
                            <div
                                class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900">
                                <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4-8-4m16 0v10l-8 4-8-4V7"></path>
                                </svg>
                            </div>
                            <h4 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">
                                {{ $nextContainer->container_number }}
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $nextContainer->customer->name ?? 'Unknown Customer' }}
                            </p>
                            <div class="mt-3">
                                @if($nextContainer->priority === 'Darurat')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Darurat
                                </span>
                                @elseif($nextContainer->priority === 'Tinggi')
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    Tinggi
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                    Normal
                                </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Menunggu sejak: {{ $nextContainer->tanggal_masuk ?
                                $nextContainer->tanggal_masuk->format('d M Y H:i') : 'Unknown' }}
                            </p>
                            @if($nextContainer->jumlah_denda > 0)
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1">
                                Denda Saat Ini: Rp {{ number_format($nextContainer->jumlah_denda, 0, ',', '.') }}
                            </p>
                            @endif
                        </div>
                        @else
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada kontainer</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Semua kontainer telah diproses</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Currently Processing --}}
                @if(isset($processingContainers) && $processingContainers->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Sedang Diproses</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($processingContainers as $container)
                            <div class="p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $container->container_number }}
                                        </h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $container->customer->name ?? 'Unknown' }}
                                        </p>
                                    </div>
                                    <button wire:click="completeProcessing({{ $container->id }})"
                                        class="px-3 py-1 bg-green-500 text-white text-xs rounded-md hover:bg-green-600">
                                        Selesai
                                    </button>
                                </div>
                                @if($container->waktu_mulai_proses)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    Mulai: {{ $container->waktu_mulai_proses->format('H:i') }}
                                    ({{ $container->waktu_mulai_proses->diffForHumans() }})
                                </p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>

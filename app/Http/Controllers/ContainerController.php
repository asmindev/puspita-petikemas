<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\Customer;
use App\Services\ContainerQueueService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class ContainerController extends Controller
{
    protected $queueService;

    public function __construct(ContainerQueueService $queueService)
    {
        $this->queueService = $queueService;
    }

    public function index(Request $request)
    {
        $query = Container::with('customer');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('container_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('priority', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        // Priority filter
        if ($request->filled('priority') && $request->input('priority') !== 'all') {
            $query->where('priority', $request->input('priority'));
        }

        // Sorting functionality
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        // Validate sort field
        $allowedSortFields = ['created_at', 'container_number', 'status', 'priority'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'created_at';
        }

        // Validate direction
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        // Paginate with query parameters preserved
        $containers = $query->paginate(5)->appends($request->query());

        return view('containers.index', compact('containers'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('containers.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'container_number' => 'required|string|max:255|unique:containers',
            'type' => 'required|in:20ft,40ft',
            'contents' => 'nullable|array',
            'contents.*' => 'nullable|string|max:255',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|in:Normal,High',
            'estimated_time' => 'nullable|integer|min:1',
            'entry_date' => 'required|date',
            'exit_date' => 'nullable|date|after_or_equal:entry_date',
            'process_start_time' => 'nullable|date',
            'process_end_time' => 'nullable|date|after:process_start_time',
            'penalty_amount' => 'nullable|numeric|min:0',
            'penalty_reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);




        // Filter out empty content items
        $data = $request->all();
        if (isset($data['contents'])) {
            $data['contents'] = array_filter($data['contents'], function ($content) {
                return !empty(trim($content));
            });
            $data['contents'] = array_values($data['contents']); // Re-index array
        }

        $container = Container::create($data);

        // Update entry_date with hour and minute from created_at
        if ($container->entry_date && $container->created_at) {
            $entryDate = Carbon::parse($container->entry_date);
            $createdAt = Carbon::parse($container->created_at);

            // Set entry_date dengan tanggal asli tapi jam/menit dari created_at
            $updatedEntryDate = $entryDate->setTime(
                $createdAt->hour,
                $createdAt->minute,
                $createdAt->second
            );

            $container->update(['entry_date' => $updatedEntryDate]);
        }

        // Update customer container count
        $container->customer->updateContainerCount();

        // Check if there's a specific redirect URL or use back() as fallback
        $redirectUrl = $request->input('redirect_url', url()->previous());

        // Validate the redirect URL to prevent open redirect attacks
        if (
            filter_var($redirectUrl, FILTER_VALIDATE_URL) &&
            str_contains($redirectUrl, request()->getHost())
        ) {
            return redirect($redirectUrl)->with('success', 'Peti kemas berhasil dibuat.');
        }

        // Fallback to containers index if redirect URL is not valid
        return redirect()->route('containers.index')
            ->with('success', 'Peti kemas berhasil dibuat.');
    }

    public function show(Container $container)
    {
        $container->load('customer');
        return view('containers.show', compact('container'));
    }

    public function edit(Container $container)
    {
        $customers = Customer::orderBy('name')->get();
        return view('containers.edit', compact('container', 'customers'));
    }

    public function update(Request $request, Container $container)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'container_number' => 'required|string|max:255|unique:containers,container_number,' . $container->id,
            'type' => 'required|in:20ft,40ft',
            'contents' => 'nullable|array',
            'contents.*' => 'nullable|string|max:255',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|in:Normal,High',
            'estimated_time' => 'nullable|integer|min:1',
            'exit_date' => 'nullable|date',
            'process_start_time' => 'nullable|date',
            'process_end_time' => 'nullable|date|after:process_start_time',
            'penalty_amount' => 'nullable|numeric|min:0',
            'penalty_reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Filter out empty content items
        $data = $request->all();
        if (isset($data['contents'])) {
            $data['contents'] = array_filter($data['contents'], function ($content) {
                return !empty(trim($content));
            });
            $data['contents'] = array_values($data['contents']); // Re-index array
        }

        $oldCustomerId = $container->customer_id;
        $container->update($data);

        // Update entry_date with hour and minute from updated_at if entry_date was changed
        if ($container->wasChanged('entry_date') && $container->entry_date) {
            $entryDate = Carbon::parse($container->entry_date);
            $updatedAt = Carbon::parse($container->updated_at);

            // Set entry_date dengan tanggal asli tapi jam/menit dari updated_at
            $updatedEntryDate = $entryDate->setTime(
                $updatedAt->hour,
                $updatedAt->minute,
                $updatedAt->second
            );

            $container->update(['entry_date' => $updatedEntryDate]);
        }

        // Update container counts for both old and new customers
        if ($oldCustomerId != $container->customer_id) {
            Customer::find($oldCustomerId)->updateContainerCount();
        }
        $container->customer->updateContainerCount();

        // Check if there's a specific redirect URL or use back() as fallback
        $redirectUrl = $request->input('redirect_url', url()->previous());

        // Validate the redirect URL to prevent open redirect attacks
        if (
            filter_var($redirectUrl, FILTER_VALIDATE_URL) &&
            str_contains($redirectUrl, request()->getHost())
        ) {
            return redirect($redirectUrl)->with('success', 'Peti kemas berhasil diperbarui.');
        }

        // Fallback to containers index if redirect URL is not valid
        return redirect()->route('containers.index')
            ->with('success', 'Peti kemas berhasil diperbarui.');
    }

    public function destroy(Container $container)
    {
        $customer = $container->customer;
        $container->delete();

        return redirect()->route('containers.index')
            ->with('success', 'Container deleted successfully!');
    }

    /**
     * Display the queue management page
     */
    public function queue(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status', 'pending'),
            'priority' => $request->input('priority'),
            'entry_date_from' => $request->input('entry_date_from'),
            'entry_date_to' => $request->input('entry_date_to'),
        ];

        $containers = $this->queueService->getQueuedContainers($filters, 20);
        $statistics = $this->queueService->getQueueStatistics();
        $detailedQueue = $this->queueService->getDetailedQueueInfo();
        $nextContainer = $this->queueService->getNextContainer();

        return view('containers.queue', compact(
            'containers',
            'statistics',
            'detailedQueue',
            'nextContainer',
            'filters'
        ));
    }

    /**
     * Process the next container in queue
     */
    public function processNext()
    {
        $nextContainer = $this->queueService->getNextContainer();

        if (!$nextContainer) {
            return redirect()->route('containers.queue')
                ->with('error', 'No containers in queue to process.');
        }

        $nextContainer->update([
            'status' => 'in_progress',
            'process_start_time' => now(),
        ]);

        return redirect()->route('containers.queue')
            ->with('success', "Container {$nextContainer->container_number} is now being processed.");
    }

    /**
     * Complete processing of a container
     */
    public function completeProcessing(Container $container)
    {
        if ($container->status !== 'in_progress') {
            return redirect()->back()
                ->with('error', 'Container is not currently being processed.');
        }

        $container->update([
            'status' => 'completed',
            'process_end_time' => now(),
            'exit_date' => now(),
        ]);

        return redirect()->route('containers.queue')
            ->with('success', "Container {$container->container_number} processing completed.");
    }

    /**
     * Get queue simulation data as JSON
     */
    public function queueSimulation(Request $request)
    {
        $maxContainers = $request->input('max_containers', 10);
        $simulation = $this->queueService->simulateQueueProcessing($maxContainers);

        return response()->json($simulation);
    }

    /**
     * Show container tracking page
     */
    public function track(Request $request)
    {
        // Handle GET request with container_number parameter
        if ($request->filled('container_number')) {
            $containerNumber = $request->input('container_number');

            $container = Container::with('customer')
                ->where('container_number', $containerNumber)
                ->first();

            if ($container) {
                $queueData = $this->calculateQueueData($container);
                return view('containers.track', compact('container', 'queueData'));
            } else {
                return view('containers.track')
                    ->with('error', 'Container not found with number: ' . $containerNumber);
            }
        }

        return view('containers.track');
    }

    /**
     * Search for container by number
     */
    public function trackSearch(Request $request)
    {
        $request->validate([
            'container_number' => 'required|string|max:255',
        ]);

        $containerNumber = $request->input('container_number');

        $container = Container::with('customer')
            ->where('container_number', $containerNumber)
            ->first();

        if (!$container) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Container not found with number: ' . $containerNumber);
        }

        // Calculate queue position and estimated time based on real data
        $queueData = $this->calculateQueueData($container);

        return view('containers.track', compact('container', 'queueData'));
    }

    /**
     * Calculate queue position and estimated processing time
     */
    private function calculateQueueData(Container $container)
    {
        $queueData = [
            'position' => null,
            'estimated_hours' => null,
            'ahead_count' => 0
        ];

        if ($container->status === 'pending') {
            // Get containers ahead in queue (same or higher priority, earlier entry date)
            $aheadCount = Container::where('status', 'pending')
                ->where(function ($query) use ($container) {
                    $query->where('priority', 'High')
                        ->orWhere(function ($q) use ($container) {
                            $q->where('priority', $container->priority)
                                ->where('entry_date', '<=', $container->entry_date)
                                ->where('id', '<', $container->id);
                        });
                })
                ->count();

            $queueData['position'] = $aheadCount + 1;
            $queueData['ahead_count'] = $aheadCount;

            // Estimate processing time based on queue position and average processing time
            $avgProcessingHours = $container->estimated_time ?? 4; // Default 4 hours if not set
            $queueData['estimated_hours'] = $avgProcessingHours + ($aheadCount * 0.5); // Add 30 min per container ahead
        } elseif ($container->status === 'in_progress') {
            $queueData['position'] = 'Active';

            // Calculate remaining time if process_start_time exists
            if ($container->process_start_time) {
                $processStart = Carbon::parse($container->process_start_time);
                $hoursInProgress = $processStart->diffInHours(Carbon::now());
                $estimatedTotal = $container->estimated_time ?? 4;
                $remainingHours = max(0, $estimatedTotal - $hoursInProgress);
                $queueData['estimated_hours'] = $remainingHours;
            }
        }

        return $queueData;
    }

    /**
     * Display penalty report page
     */
    public function penaltyReport(Request $request)
    {
        $query = Container::with('customer')
            ->whereNotNull('exit_date');

        // Filter by container type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('exit_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('exit_date', '<=', $request->date_to);
        }

        $allContainers = $query->orderBy('exit_date', 'desc')->get();

        // Filter containers berdasarkan penalty status
        if ($request->filled('penalty_status') && $request->penalty_status === 'has_penalty') {
            // Filter containers yang hanya memiliki penalty
            $containersWithPenalty = $allContainers->filter(function ($container) {
                $penaltyInfo = \App\Services\PenaltyCalculationService::calculateCurrentPeriodPenalty($container);
                return $penaltyInfo['current_amount'] > 0;
            });
        } else {
            // Tampilkan semua containers (dengan dan tanpa penalty)
            $containersWithPenalty = $allContainers;
        }

        // Manual pagination untuk filtered results
        $perPage = 20;
        $currentPage = $request->input('page', 1);
        $total = $containersWithPenalty->count();
        $offset = ($currentPage - 1) * $perPage;
        $currentPageItems = $containersWithPenalty->slice($offset, $perPage)->values();

        $containers = new LengthAwarePaginator(
            $currentPageItems,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'pageName' => 'page',
                'query' => $request->query()
            ]
        );

        // Calculate penalty statistics - hitung berdasarkan semua container dengan penalty
        $allContainersWithPenalty = $allContainers->filter(function ($container) {
            $penaltyInfo = \App\Services\PenaltyCalculationService::calculateCurrentPeriodPenalty($container);
            return $penaltyInfo['current_amount'] > 0;
        });

        $stats = [
            'total_containers' => $allContainers->count(),
            'containers_with_penalty' => $allContainersWithPenalty->count(),
            'total_penalty_amount' => 0,
            'by_type' => [
                '20ft' => ['count' => 0, 'penalty' => 0],
                '40ft' => ['count' => 0, 'penalty' => 0],
            ]
        ];

        foreach ($allContainersWithPenalty as $container) {
            $penaltyInfo = \App\Services\PenaltyCalculationService::calculateCurrentPeriodPenalty($container);

            $stats['total_penalty_amount'] += $penaltyInfo['current_amount'];
            $stats['by_type'][$container->type ?? '20ft']['count']++;
            $stats['by_type'][$container->type ?? '20ft']['penalty'] += $penaltyInfo['current_amount'];
        }

        return view('containers.penalty-report', compact('containers', 'stats'));
    }

    /**
     * Update penalty for a specific container
     */
    public function updatePenalty(Container $container)
    {
        $penaltyInfo = \App\Services\PenaltyCalculationService::updateContainerPenalty($container);

        return redirect()->back()->with(
            'success',
            'Denda berhasil diperbarui. Denda periode saat ini: Rp ' . number_format($penaltyInfo['current_amount'], 0, ',', '.')
        );
    }
}

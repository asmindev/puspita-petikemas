<?php

namespace App\Console\Commands;

use App\Services\QueueService;
use Illuminate\Console\Command;

class RunQueueSimulation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:simulate
                            {--containers=10 : Number of containers to generate}
                            {--algorithm=hybrid : Algorithm to use (fcfs, priority, hybrid)}
                            {--dry-run : Run simulation without saving to database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run queue management simulation with different algorithms';

    public function __construct(private QueueService $queueService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $containerCount = $this->option('containers');
        $algorithm = $this->option('algorithm');
        $dryRun = $this->option('dry-run');

        $this->info("Starting queue simulation...");
        $this->line("Containers: {$containerCount}");
        $this->line("Algorithm: {$algorithm}");
        $this->line("Mode: " . ($dryRun ? 'Dry Run' : 'Live'));

        if (!$dryRun) {
            // Generate sample containers
            $this->info("Generating sample containers...");
            $this->generateSampleContainers($containerCount);
        }

        // Run simulation based on algorithm
        $this->info("Running {$algorithm} algorithm simulation...");

        switch ($algorithm) {
            case 'fcfs':
                $result = $this->simulateFcfs();
                break;
            case 'priority':
                $result = $this->simulatePriority();
                break;
            case 'hybrid':
                $result = $this->simulateHybrid();
                break;
            default:
                $this->error("Unknown algorithm: {$algorithm}");
                return Command::FAILURE;
        }

        $this->displayResults($result, $algorithm);

        if (!$dryRun) {
            $this->info("Processing some containers to show real-time updates...");
            $this->processContainers(min(5, $containerCount));
        }

        $this->info("Simulation completed successfully!");
        return Command::SUCCESS;
    }

    private function generateSampleContainers(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->queueService->addToQueue([
                'nomor_container' => 'SIM' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'customer' => fake()->company(),
                'jenis_petikemas' => fake()->randomElement(['20 Feet', '40 Feet', '45 Feet']),
                'priority' => fake()->randomElement(['High', 'Normal']),
                'tanggal_masuk' => now()->subDays(rand(0, 30)),
                'estimasi_selesai' => now()->addDays(rand(1, 7))
            ]);
        }
    }

    private function simulateFcfs(): array
    {
        $queue = $this->queueService->getFcfsQueue();
        return [
            'algorithm' => 'First Come First Served',
            'queue_length' => $queue->count(),
            'avg_waiting_time' => round($queue->avg('waiting_time') ?? 0, 2),
            'total_containers' => $queue->count()
        ];
    }

    private function simulatePriority(): array
    {
        $queue = $this->queueService->getPriorityQueue();
        return [
            'algorithm' => 'Priority Scheduler',
            'queue_length' => $queue->count(),
            'avg_waiting_time' => round($queue->avg('waiting_time') ?? 0, 2),
            'high_priority_count' => $queue->where('priority', 'High')->count(),
            'normal_priority_count' => $queue->where('priority', 'Normal')->count()
        ];
    }

    private function simulateHybrid(): array
    {
        $queue = $this->queueService->getHybridQueue();
        $comparison = $this->queueService->compareAllAlgorithms();

        return [
            'algorithm' => 'Hybrid (Priority + FCFS)',
            'queue_length' => $queue->count(),
            'avg_waiting_time' => round($queue->avg('waiting_time') ?? 0, 2),
            'efficiency_score' => $comparison['hybrid']['efficiency_score'],
            'balance_score' => $this->queueService->getDetailedHybridAnalysis()['algorithm_efficiency']['hybrid_balance_score']
        ];
    }

    private function processContainers(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $processed = $this->queueService->processNextContainer();
            if ($processed) {
                $this->line("✓ Processed container: {$processed->nomor_container}");
            } else {
                break;
            }
        }
    }

    private function displayResults(array $result, string $algorithm): void
    {
        $this->newLine();
        $this->info("=== Simulation Results ===");

        foreach ($result as $key => $value) {
            if (is_numeric($value)) {
                $this->line(ucfirst(str_replace('_', ' ', $key)) . ": " . $value);
            } else {
                $this->line(ucfirst(str_replace('_', ' ', $key)) . ": " . $value);
            }
        }

        // Show comparison if hybrid
        if ($algorithm === 'hybrid') {
            $this->newLine();
            $this->info("=== Algorithm Comparison ===");
            $comparison = $this->queueService->compareAllAlgorithms();

            $headers = ['Algorithm', 'Queue Length', 'Avg Wait Time', 'Efficiency Score'];
            $rows = [];

            foreach ($comparison as $algo => $data) {
                $rows[] = [
                    $data['name'],
                    $data['queue_length'],
                    $data['avg_waiting_time'] . ' min',
                    $data['efficiency_score'] . '%'
                ];
            }

            $this->table($headers, $rows);
        }
    }
}

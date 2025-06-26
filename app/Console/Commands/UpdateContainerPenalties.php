<?php

namespace App\Console\Commands;

use App\Services\QueueService;
use Illuminate\Console\Command;

class UpdateContainerPenalties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'container:update-penalties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update container penalties based on storage duration';

    public function __construct(private QueueService $queueService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating container penalties...');

        $result = $this->queueService->updateContainerPenalties();

        $this->info("Penalties updated successfully!");
        $this->line("Containers checked: {$result['containers_checked']}");
        $this->line("Containers updated: {$result['containers_updated']}");

        return Command::SUCCESS;
    }
}

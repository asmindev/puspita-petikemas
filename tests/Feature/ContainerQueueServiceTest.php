<?php

namespace Tests\Feature;

use App\Models\Container;
use App\Models\Customer;
use App\Services\ContainerQueueService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class ContainerQueueServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ContainerQueueService $queueService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->queueService = new ContainerQueueService();
    }

    public function test_queue_orders_by_priority_then_fcfs()
    {
        // Create a customer
        $customer = Customer::factory()->create();

        // Create containers with different priorities and entry dates
        $containers = [
            // High priority, older entry date
            Container::factory()->create([
                'customer_id' => $customer->id,
                'priority' => 'High',
                'status' => 'pending',
                'entry_date' => Carbon::now()->subHours(2),
                'container_number' => 'HIGH-001'
            ]),
            // Normal priority, oldest entry date
            Container::factory()->create([
                'customer_id' => $customer->id,
                'priority' => 'Normal',
                'status' => 'pending',
                'entry_date' => Carbon::now()->subHours(3),
                'container_number' => 'NORM-001'
            ]),
            // High priority, newer entry date
            Container::factory()->create([
                'customer_id' => $customer->id,
                'priority' => 'High',
                'status' => 'pending',
                'entry_date' => Carbon::now()->subHours(1),
                'container_number' => 'HIGH-002'
            ]),
            // Normal priority, newer entry date
            Container::factory()->create([
                'customer_id' => $customer->id,
                'priority' => 'Normal',
                'status' => 'pending',
                'entry_date' => Carbon::now()->subMinutes(30),
                'container_number' => 'NORM-002'
            ]),
        ];

        // Get queued containers
        $queuedContainers = $this->queueService->getQueuedContainers(['status' => 'pending']);

        // Expected order: HIGH-001, HIGH-002, NORM-001, NORM-002
        $expectedOrder = ['HIGH-001', 'HIGH-002', 'NORM-001', 'NORM-002'];
        $actualOrder = $queuedContainers->pluck('container_number')->toArray();

        $this->assertEquals($expectedOrder, $actualOrder);
    }

    public function test_get_next_container_returns_highest_priority_oldest()
    {
        $customer = Customer::factory()->create();

        // Create containers
        Container::factory()->create([
            'customer_id' => $customer->id,
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subHours(5),
            'container_number' => 'SHOULD-NOT-BE-NEXT'
        ]);

        $expectedNext = Container::factory()->create([
            'customer_id' => $customer->id,
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subHours(1),
            'container_number' => 'SHOULD-BE-NEXT'
        ]);

        $nextContainer = $this->queueService->getNextContainer();

        $this->assertNotNull($nextContainer);
        $this->assertEquals('SHOULD-BE-NEXT', $nextContainer->container_number);
        $this->assertEquals('High', $nextContainer->priority);
    }

    public function test_get_queue_position_returns_correct_position()
    {
        $customer = Customer::factory()->create();

        // Create containers in specific order
        $firstContainer = Container::factory()->create([
            'customer_id' => $customer->id,
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subHours(2),
        ]);

        $secondContainer = Container::factory()->create([
            'customer_id' => $customer->id,
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subHours(1),
        ]);

        $thirdContainer = Container::factory()->create([
            'customer_id' => $customer->id,
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subHours(3),
        ]);

        // Test positions
        $this->assertEquals(1, $this->queueService->getQueuePosition($firstContainer));
        $this->assertEquals(2, $this->queueService->getQueuePosition($secondContainer));
        $this->assertEquals(3, $this->queueService->getQueuePosition($thirdContainer));
    }

    public function test_queue_statistics_returns_correct_data()
    {
        $customer = Customer::factory()->create();

        // Create containers with different statuses and priorities
        Container::factory()->count(3)->create([
            'customer_id' => $customer->id,
            'priority' => 'High',
            'status' => 'pending',
        ]);

        Container::factory()->count(5)->create([
            'customer_id' => $customer->id,
            'priority' => 'Normal',
            'status' => 'pending',
        ]);

        Container::factory()->count(2)->create([
            'customer_id' => $customer->id,
            'status' => 'completed',
        ]);

        $statistics = $this->queueService->getQueueStatistics();

        $this->assertEquals(8, $statistics['total_pending']);
        $this->assertEquals(3, $statistics['high_priority_pending']);
        $this->assertEquals(5, $statistics['normal_priority_pending']);
        $this->assertIsFloat($statistics['average_wait_time_minutes']);
        $this->assertIsInt($statistics['estimated_total_process_time_minutes']);
    }

    public function test_queue_simulation_returns_correct_format()
    {
        $customer = Customer::factory()->create();

        Container::factory()->count(5)->create([
            'customer_id' => $customer->id,
            'status' => 'pending',
            'entry_date' => Carbon::now()->subHours(1),
        ]);

        $simulation = $this->queueService->simulateQueueProcessing(3);

        $this->assertIsArray($simulation);
        $this->assertArrayHasKey('total_containers', $simulation);
        $this->assertArrayHasKey('total_estimated_time', $simulation);
        $this->assertArrayHasKey('high_priority_count', $simulation);
        $this->assertArrayHasKey('normal_priority_count', $simulation);
        $this->assertArrayHasKey('containers', $simulation);

        $this->assertEquals(3, $simulation['total_containers']);
        $this->assertCount(3, $simulation['containers']);

        // Check container structure
        $containerData = $simulation['containers'][0];
        $this->assertArrayHasKey('position', $containerData);
        $this->assertArrayHasKey('container', $containerData);
        $this->assertArrayHasKey('estimated_start_time', $containerData);
        $this->assertArrayHasKey('estimated_completion_time', $containerData);
        $this->assertArrayHasKey('estimated_wait_time', $containerData);
        $this->assertArrayHasKey('estimated_process_time', $containerData);
    }

    public function test_queue_position_returns_zero_for_non_pending_container()
    {
        $customer = Customer::factory()->create();

        $completedContainer = Container::factory()->create([
            'customer_id' => $customer->id,
            'status' => 'completed',
        ]);

        $position = $this->queueService->getQueuePosition($completedContainer);

        $this->assertEquals(0, $position);
    }

    public function test_get_next_container_returns_null_when_no_pending()
    {
        $customer = Customer::factory()->create();

        // Create only completed containers
        Container::factory()->count(3)->create([
            'customer_id' => $customer->id,
            'status' => 'completed',
        ]);

        $nextContainer = $this->queueService->getNextContainer();

        $this->assertNull($nextContainer);
    }
}

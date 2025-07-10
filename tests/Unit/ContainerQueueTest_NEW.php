<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Container;
use App\Models\Customer;
use App\Services\ContainerQueueService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ContainerQueueTest extends TestCase
{
    use RefreshDatabase;

    protected $containerQueueService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->containerQueueService = new ContainerQueueService();
    }

    /**
     * Menguji Algoritma FCFS + Prioritas dengan 10 container berbeda
     */
    public function test_fcfs_priority_queue_algorithm()
    {
        // Buat pelanggan untuk pengujian
        $customer1 = Customer::create([
            'name' => 'Pelanggan A',
            'email' => 'pelanggan.a@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta'
        ]);

        $customer2 = Customer::create([
            'name' => 'Pelanggan B',
            'email' => 'pelanggan.b@example.com',
            'phone' => '081234567891',
            'address' => 'Surabaya'
        ]);

        $customer3 = Customer::create([
            'name' => 'Pelanggan C',
            'email' => 'pelanggan.c@example.com',
            'phone' => '081234567892',
            'address' => 'Bandung'
        ]);

        // Buat 10 container dengan prioritas dan waktu yang berbeda
        $containers = [];

        // Container 1: Prioritas Normal - Pertama
        $containers[] = Container::create([
            'container_number' => 'CONT001',
            'customer_id' => $customer1->id,
            'type' => '20ft',
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(100),
            'exit_date' => Carbon::now()->addDays(5),
            'created_at' => Carbon::now()->subMinutes(100),
        ]);

        // Container 2: Prioritas Tinggi - Kedua (harus diprioritaskan)
        $containers[] = Container::create([
            'container_number' => 'CONT002',
            'customer_id' => $customer2->id,
            'type' => '40ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(90),
            'exit_date' => Carbon::now()->addDays(3),
            'created_at' => Carbon::now()->subMinutes(90),
        ]);

        // Container 3: Prioritas Normal - Ketiga
        $containers[] = Container::create([
            'container_number' => 'CONT003',
            'customer_id' => $customer3->id,
            'type' => '20ft',
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(80),
            'exit_date' => Carbon::now()->addDays(7),
            'created_at' => Carbon::now()->subMinutes(80),
        ]);

        // Container 4: Prioritas Tinggi - Keempat (harus diprioritaskan)
        $containers[] = Container::create([
            'container_number' => 'CONT004',
            'customer_id' => $customer1->id,
            'type' => '40ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(70),
            'exit_date' => Carbon::now()->addDays(4),
            'created_at' => Carbon::now()->subMinutes(70),
        ]);

        // Container 5: Prioritas Normal - Kelima
        $containers[] = Container::create([
            'container_number' => 'CONT005',
            'customer_id' => $customer2->id,
            'type' => '20ft',
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(60),
            'exit_date' => Carbon::now()->addDays(6),
            'created_at' => Carbon::now()->subMinutes(60),
        ]);

        // Container 6: Prioritas Tinggi - Keenam (harus diprioritaskan)
        $containers[] = Container::create([
            'container_number' => 'CONT006',
            'customer_id' => $customer3->id,
            'type' => '40ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(50),
            'exit_date' => Carbon::now()->addDays(2),
            'created_at' => Carbon::now()->subMinutes(50),
        ]);

        // Container 7: Prioritas Normal - Ketujuh
        $containers[] = Container::create([
            'container_number' => 'CONT007',
            'customer_id' => $customer1->id,
            'type' => '20ft',
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(40),
            'exit_date' => Carbon::now()->addDays(8),
            'created_at' => Carbon::now()->subMinutes(40),
        ]);

        // Container 8: Prioritas Tinggi - Kedelapan (harus diprioritaskan)
        $containers[] = Container::create([
            'container_number' => 'CONT008',
            'customer_id' => $customer2->id,
            'type' => '40ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(30),
            'exit_date' => Carbon::now()->addDays(1),
            'created_at' => Carbon::now()->subMinutes(30),
        ]);

        // Container 9: Prioritas Normal - Kesembilan
        $containers[] = Container::create([
            'container_number' => 'CONT009',
            'customer_id' => $customer3->id,
            'type' => '20ft',
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(20),
            'exit_date' => Carbon::now()->addDays(9),
            'created_at' => Carbon::now()->subMinutes(20),
        ]);

        // Container 10: Prioritas Tinggi - Kesepuluh (harus diprioritaskan)
        $containers[] = Container::create([
            'container_number' => 'CONT010',
            'customer_id' => $customer1->id,
            'type' => '40ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(10),
            'exit_date' => Carbon::now()->addDays(5),
            'created_at' => Carbon::now()->subMinutes(10),
        ]);

        // Uji algoritma FCFS + Prioritas
        $queuedContainers = $this->containerQueueService->getPendingQueue(100)->getCollection();

        // Verifikasi jumlah container dalam antrian
        $this->assertEquals(10, $queuedContainers->count(), 'Jumlah container dalam antrian harus 10');

        // Uji urutan prioritas: Prioritas Tinggi harus didahulukan
        $highPriorityContainers = $queuedContainers->where('priority', 'High');
        $normalPriorityContainers = $queuedContainers->where('priority', 'Normal');

        $this->assertEquals(5, $highPriorityContainers->count(), 'Harus ada 5 container Prioritas Tinggi');
        $this->assertEquals(5, $normalPriorityContainers->count(), 'Harus ada 5 container Prioritas Normal');

        // Uji urutan berdasarkan algoritma FCFS + Prioritas
        $expectedOrder = [
            'CONT002', // Prioritas Tinggi - Dibuat pertama di antara prioritas tinggi
            'CONT004', // Prioritas Tinggi - Dibuat kedua di antara prioritas tinggi
            'CONT006', // Prioritas Tinggi - Dibuat ketiga di antara prioritas tinggi
            'CONT008', // Prioritas Tinggi - Dibuat keempat di antara prioritas tinggi
            'CONT010', // Prioritas Tinggi - Dibuat kelima di antara prioritas tinggi
            'CONT001', // Prioritas Normal - Dibuat pertama di antara prioritas normal
            'CONT003', // Prioritas Normal - Dibuat kedua di antara prioritas normal
            'CONT005', // Prioritas Normal - Dibuat ketiga di antara prioritas normal
            'CONT007', // Prioritas Normal - Dibuat keempat di antara prioritas normal
            'CONT009', // Prioritas Normal - Dibuat kelima di antara prioritas normal
        ];

        $actualOrder = $queuedContainers->pluck('container_number')->toArray();

        $this->assertEquals($expectedOrder, $actualOrder, 'Urutan container harus sesuai dengan algoritma FCFS + Prioritas');

        // Uji detail untuk container Prioritas Tinggi
        $highPriorityQueue = $queuedContainers->where('priority', 'High')->values();

        // Verifikasi urutan Prioritas Tinggi berdasarkan FCFS (entry_date)
        $this->assertEquals('CONT002', $highPriorityQueue[0]->container_number);
        $this->assertEquals('CONT004', $highPriorityQueue[1]->container_number);
        $this->assertEquals('CONT006', $highPriorityQueue[2]->container_number);
        $this->assertEquals('CONT008', $highPriorityQueue[3]->container_number);
        $this->assertEquals('CONT010', $highPriorityQueue[4]->container_number);

        // Uji detail untuk container Prioritas Normal
        $normalPriorityQueue = $queuedContainers->where('priority', 'Normal')->values();

        // Verifikasi urutan Prioritas Normal berdasarkan FCFS (entry_date)
        $this->assertEquals('CONT001', $normalPriorityQueue[0]->container_number);
        $this->assertEquals('CONT003', $normalPriorityQueue[1]->container_number);
        $this->assertEquals('CONT005', $normalPriorityQueue[2]->container_number);
        $this->assertEquals('CONT007', $normalPriorityQueue[3]->container_number);
        $this->assertEquals('CONT009', $normalPriorityQueue[4]->container_number);
    }

    /**
     * Menguji estimasi waktu proses untuk antrian
     */
    public function test_queue_processing_time_estimation()
    {
        // Buat pelanggan untuk pengujian
        $customer = Customer::create([
            'name' => 'Pelanggan Uji',
            'email' => 'pelanggan@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta'
        ]);

        // Buat beberapa container
        Container::create([
            'container_number' => 'CONT001',
            'customer_id' => $customer->id,
            'type' => '20ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(60),
            'exit_date' => Carbon::now()->addDays(5),
            'created_at' => Carbon::now()->subMinutes(60),
        ]);

        Container::create([
            'container_number' => 'CONT002',
            'customer_id' => $customer->id,
            'type' => '40ft',
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(50),
            'exit_date' => Carbon::now()->addDays(3),
            'created_at' => Carbon::now()->subMinutes(50),
        ]);

        Container::create([
            'container_number' => 'CONT003',
            'customer_id' => $customer->id,
            'type' => '20ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(40),
            'exit_date' => Carbon::now()->addDays(7),
            'created_at' => Carbon::now()->subMinutes(40),
        ]);

        $queuedContainers = $this->containerQueueService->getPendingQueue(100)->getCollection();

        // Uji jumlah container dalam antrian
        $this->assertEquals(3, $queuedContainers->count(), 'Harus ada 3 container dalam antrian');

        // Uji urutan berdasarkan prioritas (Prioritas tinggi duluan)
        $expectedOrder = ['CONT001', 'CONT003', 'CONT002']; // Prioritas tinggi dulu, kemudian normal
        $actualOrder = $queuedContainers->pluck('container_number')->toArray();

        $this->assertEquals($expectedOrder, $actualOrder, 'Urutan harus Prioritas tinggi dulu');

        // Uji simulasi waktu proses
        $simulation = $this->containerQueueService->simulateQueueProcessing(3);

        $this->assertEquals(3, $simulation['total_containers'], 'Simulasi harus mencakup 3 container');
        $this->assertEquals(2, $simulation['high_priority_count'], 'Harus ada 2 container Prioritas tinggi');
        $this->assertEquals(1, $simulation['normal_priority_count'], 'Harus ada 1 container Prioritas normal');

        // Verifikasi urutan dalam simulasi
        $this->assertEquals('CONT001', $simulation['containers'][0]['container']->container_number);
        $this->assertEquals(0, $simulation['containers'][0]['estimated_wait_time'], 'Container pertama tidak ada waktu tunggu');

        $this->assertEquals('CONT003', $simulation['containers'][1]['container']->container_number);
        $this->assertEquals(30, $simulation['containers'][1]['estimated_wait_time'], 'Container kedua tunggu 30 menit (waktu proses default)');

        $this->assertEquals('CONT002', $simulation['containers'][2]['container']->container_number);
        $this->assertEquals(60, $simulation['containers'][2]['estimated_wait_time'], 'Container ketiga tunggu 60 menit');
    }

    /**
     * Menguji prioritas container dengan waktu masuk yang sama
     */
    public function test_priority_with_same_entry_time()
    {
        $customer = Customer::create([
            'name' => 'Pelanggan Uji',
            'email' => 'pelanggan@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta'
        ]);

        $sameTime = Carbon::now()->subMinutes(30);

        // Buat container dengan waktu masuk yang sama tapi prioritas berbeda
        Container::create([
            'container_number' => 'CONT_NORMAL',
            'customer_id' => $customer->id,
            'type' => '20ft',
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => $sameTime,
            'exit_date' => Carbon::now()->addDays(5),
            'created_at' => $sameTime,
        ]);

        Container::create([
            'container_number' => 'CONT_HIGH',
            'customer_id' => $customer->id,
            'type' => '40ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => $sameTime,
            'exit_date' => Carbon::now()->addDays(3),
            'created_at' => $sameTime,
        ]);

        $queuedContainers = $this->containerQueueService->getPendingQueue(100)->getCollection();

        // Prioritas Tinggi harus didahulukan meskipun waktu masuk sama
        $this->assertEquals('CONT_HIGH', $queuedContainers->first()->container_number);
        $this->assertEquals('CONT_NORMAL', $queuedContainers->last()->container_number);
    }

    /**
     * Menguji bahwa container dengan status selain 'pending' tidak masuk antrian
     */
    public function test_only_pending_containers_in_queue()
    {
        $customer = Customer::create([
            'name' => 'Pelanggan Uji',
            'email' => 'pelanggan@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta'
        ]);

        // Buat container dengan status berbeda
        Container::create([
            'container_number' => 'CONT_PENDING',
            'customer_id' => $customer->id,
            'type' => '20ft',
            'priority' => 'Normal',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(60),
            'exit_date' => Carbon::now()->addDays(5),
        ]);

        Container::create([
            'container_number' => 'CONT_PROGRESS',
            'customer_id' => $customer->id,
            'type' => '40ft',
            'priority' => 'High',
            'status' => 'in_progress',
            'entry_date' => Carbon::now()->subMinutes(50),
            'exit_date' => Carbon::now()->addDays(3),
        ]);

        Container::create([
            'container_number' => 'CONT_COMPLETED',
            'customer_id' => $customer->id,
            'type' => '20ft',
            'priority' => 'High',
            'status' => 'completed',
            'entry_date' => Carbon::now()->subMinutes(40),
            'exit_date' => Carbon::now()->addDays(7),
        ]);

        $queuedContainers = $this->containerQueueService->getPendingQueue(100)->getCollection();

        // Hanya container dengan status 'pending' yang masuk antrian
        $this->assertEquals(1, $queuedContainers->count());
        $this->assertEquals('CONT_PENDING', $queuedContainers->first()->container_number);
    }

    /**
     * Menguji urutan FCFS dalam kelompok prioritas yang sama
     */
    public function test_fcfs_within_same_priority_group()
    {
        $customer = Customer::create([
            'name' => 'Pelanggan Uji',
            'email' => 'pelanggan@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta'
        ]);

        // Buat 3 container dengan prioritas Tinggi dan waktu berbeda
        Container::create([
            'container_number' => 'HIGH_KETIGA',
            'customer_id' => $customer->id,
            'type' => '20ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(30),
            'exit_date' => Carbon::now()->addDays(5),
            'created_at' => Carbon::now()->subMinutes(30),
        ]);

        Container::create([
            'container_number' => 'HIGH_PERTAMA',
            'customer_id' => $customer->id,
            'type' => '40ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(50),
            'exit_date' => Carbon::now()->addDays(3),
            'created_at' => Carbon::now()->subMinutes(50),
        ]);

        Container::create([
            'container_number' => 'HIGH_KEDUA',
            'customer_id' => $customer->id,
            'type' => '20ft',
            'priority' => 'High',
            'status' => 'pending',
            'entry_date' => Carbon::now()->subMinutes(40),
            'exit_date' => Carbon::now()->addDays(7),
            'created_at' => Carbon::now()->subMinutes(40),
        ]);

        $queuedContainers = $this->containerQueueService->getPendingQueue(100)->getCollection();

        // Urutan harus berdasarkan FCFS (entry_date) dalam kelompok prioritas yang sama
        $expectedOrder = ['HIGH_PERTAMA', 'HIGH_KEDUA', 'HIGH_KETIGA'];
        $actualOrder = $queuedContainers->pluck('container_number')->toArray();

        $this->assertEquals($expectedOrder, $actualOrder);
    }
}

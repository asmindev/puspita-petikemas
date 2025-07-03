<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Container;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => Hash::make('123'),
        ]);

        // Create operators
        User::create([
            'name' => 'Operator A',
            'email' => 'operator.a@test.com',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'name' => 'Operator B',
            'email' => 'operator.b@test.com',
            'password' => Hash::make('123'),
        ]);

        // Create customers
        $customers = [
            ['name' => 'PT. Pelayaran Nasional Indonesia'],
            ['name' => 'PT. Samudera Indonesia'],
            ['name' => 'PT. Meratus Line'],
            ['name' => 'PT. TEMAS Tbk'],
            ['name' => 'PT. Indofood Sukses Makmur'],
            ['name' => 'PT. Pan Brothers Tbk'],
            ['name' => 'PT. Samsung Electronics Indonesia'],
            ['name' => 'PT. Unilever Indonesia'],
        ];

        $customerModels = [];
        foreach ($customers as $customerData) {
            $customerModels[] = Customer::create($customerData);
        }

        // Create containers
        $containers = [
            [
                'container_number' => 'EVGU1234567',
                'entry_date' => now()->subHours(2),
                'priority' => 'High',
                'status' => 'pending',
                'notes' => 'Ship departing in 4 hours - high priority',
            ],
            [
                'container_number' => 'MSCU9876543',
                'entry_date' => now()->subHours(1.5),
                'priority' => 'High',
                'status' => 'pending',
                'notes' => 'Textile export to Europe',
            ],
            [
                'container_number' => 'OOLU5678901',
                'entry_date' => now()->subHours(3),
                'priority' => 'Normal',
                'status' => 'pending',
                'notes' => 'Electronics import from China',
            ],
            [
                'container_number' => 'MAEU3456789',
                'entry_date' => now()->subMinutes(45),
                'priority' => 'High',
                'status' => 'pending',
                'penalty_status' => true,
                'penalty_amount' => 750000,
                'notes' => 'Late unloading penalty - Frozen food import',
            ],
            [
                'container_number' => 'TEMU7890123',
                'entry_date' => now()->subHours(4),
                'process_start_time' => now()->subMinutes(20),
                'priority' => 'High',
                'status' => 'in_progress',
                'notes' => 'Transshipment to Surabaya',
            ],
            [
                'container_number' => 'JICT2345678',
                'entry_date' => now()->subHours(2.5),
                'priority' => 'Normal',
                'status' => 'pending',
                'notes' => 'Transshipment to Malaysia',
            ],
            [
                'container_number' => 'PELNI456789',
                'entry_date' => now()->subHours(1),
                'priority' => 'Normal',
                'status' => 'pending',
                'notes' => 'Domestic distribution to Kalimantan',
            ],
            [
                'container_number' => 'SMDR8901234',
                'entry_date' => now()->subMinutes(30),
                'priority' => 'High',
                'status' => 'pending',
                'notes' => 'Emergency medicines for Sulawesi',
            ],
            [
                'container_number' => 'BLTU1357924',
                'entry_date' => now()->subHours(8),
                'process_start_time' => now()->subHours(6),
                'process_end_time' => now()->subHours(5),
                'exit_date' => now()->subHours(5),
                'priority' => 'Normal',
                'status' => 'completed',
                'notes' => 'Coffee export to America',
            ],
            [
                'container_number' => 'MERU2468135',
                'entry_date' => now()->subHours(12),
                'process_start_time' => now()->subHours(10),
                'process_end_time' => now()->subHours(9),
                'exit_date' => now()->subHours(8),
                'priority' => 'Normal',
                'status' => 'completed',
                'notes' => 'Vehicle spare parts import',
            ],
        ];

        foreach ($containers as $containerData) {
            $randomCustomer = $customerModels[array_rand($customerModels)];
            Container::create(array_merge($containerData, [
                'customer_id' => $randomCustomer->id,
            ]));
        }

        // Update container counts for customers
        foreach ($customerModels as $customer) {
            $customer->updateContainerCount();
        }
    }
}

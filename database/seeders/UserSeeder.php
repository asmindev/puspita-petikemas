<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Container;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrator Pelabuhan',
            'email' => 'admin@containerq.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create secondary admin user for testing
        $testAdmin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);

        // Create operator users (also admins)
        $operators = [
            [
                'name' => 'Operator Crane A',
                'email' => 'crane.a@pelabuhan-tanjungpriok.co.id',
                'password' => Hash::make('operator123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Operator Crane B',
                'email' => 'crane.b@pelabuhan-tanjungpriok.co.id',
                'password' => Hash::make('operator123'),
                'role' => 'admin',
            ],
        ];

        foreach ($operators as $operatorData) {
            User::create($operatorData);
        }

        // Create customer users (shipping lines & logistics companies)
        $users = [
            [
                'name' => 'User PT. PELNI',
                'email' => 'operations@pelni.co.id',
                'password' => Hash::make('pelni2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'User PT. Samudera Indonesia',
                'email' => 'container@samudera.id',
                'password' => Hash::make('samudera2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'User PT. Meratus Line',
                'email' => 'logistics@meratusline.com',
                'password' => Hash::make('meratus2025'),
                'role' => 'customer',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create customer companies (separate from users)
        $customers = [
            [
                'name' => 'PT. Pelayaran Nasional Indonesia (PELNI)',
                'email' => 'corporate@pelni.co.id',
                'phone' => '+62-21-385-2000',
                'address' => 'Jl. Gajah Mada No. 14, Jakarta Pusat',
                'contact_person' => 'Budi Santoso',
                'type' => 'shipping_line',
                'is_active' => true,
            ],
            [
                'name' => 'PT. Samudera Indonesia',
                'email' => 'info@samudera.id',
                'phone' => '+62-21-2985-2100',
                'address' => 'Samudera Indonesia Building, Jakarta',
                'contact_person' => 'Sari Dewi',
                'type' => 'shipping_line',
                'is_active' => true,
            ],
            [
                'name' => 'PT. Meratus Line',
                'email' => 'info@meratusline.com',
                'phone' => '+62-511-3360-888',
                'address' => 'Banjarmasin, Kalimantan Selatan',
                'contact_person' => 'Ahmad Rahman',
                'type' => 'logistics',
                'is_active' => true,
            ],
            [
                'name' => 'PT. TEMAS Tbk',
                'email' => 'corporate@temas.co.id',
                'phone' => '+62-21-4585-1234',
                'address' => 'Terminal Petikemas Surabaya',
                'contact_person' => 'Lisa Hartono',
                'type' => 'logistics',
                'is_active' => true,
            ],
            [
                'name' => 'PT. Indofood Sukses Makmur',
                'email' => 'logistics@indofood.co.id',
                'phone' => '+62-21-2650-2000',
                'address' => 'Sudirman Plaza, Jakarta',
                'contact_person' => 'Rudi Wijaya',
                'type' => 'manufacturer',
                'is_active' => true,
            ],
            [
                'name' => 'PT. Pan Brothers Tbk',
                'email' => 'export@panbrothers.com',
                'phone' => '+62-22-6034-9999',
                'address' => 'Bandung, Jawa Barat',
                'contact_person' => 'Maya Sari',
                'type' => 'manufacturer',
                'is_active' => true,
            ],
            [
                'name' => 'PT. Samsung Electronics Indonesia',
                'email' => 'logistics@samsung.co.id',
                'phone' => '+62-21-5299-3333',
                'address' => 'Cikarang, Jawa Barat',
                'contact_person' => 'Kim Jong-Su',
                'type' => 'manufacturer',
                'is_active' => true,
            ],
            [
                'name' => 'PT. Unilever Indonesia',
                'email' => 'supply@unilever.co.id',
                'phone' => '+62-21-2995-1000',
                'address' => 'BSD City, Tangerang',
                'contact_person' => 'Diana Putri',
                'type' => 'manufacturer',
                'is_active' => true,
            ],
        ];

        $customerEntities = [];
        foreach ($customers as $customerData) {
            $customerEntities[] = Customer::create($customerData);
        }

        // Create sample containers with realistic data and assign to customers
        $this->createSampleContainers($customerEntities);
    }

    private function createSampleContainers($customerEntities): void
    {
        // Container data with realistic scenarios
        $containers = [
            // High priority export containers (ready for departure)
            [
                'container_number' => 'EVGU1234567',
                'priority' => 'Darurat',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(2),
                'waktu_estimasi' => 20,
                'keterangan' => 'Kapal berangkat dalam 4 jam - prioritas tinggi',
            ],
            [
                'container_number' => 'MSCU9876543',
                'priority' => 'Tinggi',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(1.5),
                'waktu_estimasi' => 25,
                'keterangan' => 'Ekspor tekstil untuk Eropa',
            ],

            // Import containers waiting for processing
            [
                'container_number' => 'OOLU5678901',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(3),
                'waktu_estimasi' => 35,
                'keterangan' => 'Import elektronik dari China',
            ],
            [
                'container_number' => 'MAEU3456789',
                'priority' => 'Tinggi',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subMinutes(45),
                'waktu_estimasi' => 30,
                'status_denda' => true,
                'jumlah_denda' => 750000,
                'keterangan' => 'Denda keterlambatan bongkar muatan - Import makanan beku',
            ],

            // Transshipment containers
            [
                'container_number' => 'TEMU7890123',
                'priority' => 'Tinggi',
                'status' => 'processing',
                'tanggal_masuk' => now()->subHours(4),
                'waktu_mulai_proses' => now()->subMinutes(20),
                'waktu_estimasi' => 40,
                'keterangan' => 'Transshipment ke Surabaya',
            ],
            [
                'container_number' => 'JICT2345678',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(2.5),
                'waktu_estimasi' => 45,
                'keterangan' => 'Transshipment ke Malaysia',
            ],

            // Domestic containers
            [
                'container_number' => 'PELNI456789',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(1),
                'waktu_estimasi' => 25,
                'keterangan' => 'Distribusi domestik ke Kalimantan',
            ],
            [
                'container_number' => 'SMDR8901234',
                'priority' => 'Darurat',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subMinutes(30),
                'waktu_estimasi' => 15,
                'keterangan' => 'Obat-obatan darurat untuk Sulawesi',
            ],

            // Completed containers
            [
                'container_number' => 'BLTU1357924',
                'priority' => 'Normal',
                'status' => 'completed',
                'tanggal_masuk' => now()->subHours(8),
                'waktu_mulai_proses' => now()->subHours(6),
                'waktu_selesai_proses' => now()->subHours(5),
                'tanggal_keluar' => now()->subHours(5),
                'waktu_estimasi' => 35,
                'keterangan' => 'Ekspor kopi ke Amerika',
            ],
            [
                'container_number' => 'MERU2468135',
                'priority' => 'Normal',
                'status' => 'completed',
                'tanggal_masuk' => now()->subHours(12),
                'waktu_mulai_proses' => now()->subHours(10),
                'waktu_selesai_proses' => now()->subHours(9),
                'tanggal_keluar' => now()->subHours(8),
                'waktu_estimasi' => 40,
                'keterangan' => 'Import spare part kendaraan',
            ],

            // Cancelled container
            [
                'container_number' => 'CANC9999999',
                'priority' => 'Normal',
                'status' => 'cancelled',
                'tanggal_masuk' => now()->subHours(6),
                'waktu_estimasi' => 30,
                'keterangan' => 'Dibatalkan karena masalah dokumen ekspor',
            ],

            // Containers with penalties
            [
                'container_number' => 'FINE1111111',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(4),
                'waktu_estimasi' => 50,
                'status_denda' => true,
                'jumlah_denda' => 1500000,
                'keterangan' => 'Denda overtime storage - Barang berbahaya',
            ],
            [
                'container_number' => 'LATE2222222',
                'priority' => 'Normal',
                'status' => 'processing',
                'tanggal_masuk' => now()->subHours(5),
                'waktu_mulai_proses' => now()->subMinutes(10),
                'waktu_estimasi' => 60,
                'status_denda' => true,
                'jumlah_denda' => 500000,
                'keterangan' => 'Denda keterlambatan pickup - Distribusi pupuk',
            ],

            // More waiting containers for queue testing
            [
                'container_number' => 'WAIT3333333',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(7),
                'waktu_estimasi' => 35,
                'keterangan' => 'Ekspor furniture ke Jepang',
            ],
            [
                'container_number' => 'WAIT4444444',
                'priority' => 'Tinggi',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(1.8),
                'waktu_estimasi' => 28,
                'keterangan' => 'Import material konstruksi',
            ],
            [
                'container_number' => 'WAIT5555555',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(3.2),
                'waktu_estimasi' => 42,
                'keterangan' => 'Transshipment ke Singapura',
            ],
        ];

        foreach ($containers as $index => $containerData) {
            // Assign each container to a random customer entity
            $randomCustomer = $customerEntities[array_rand($customerEntities)];

            Container::create(array_merge($containerData, [
                'customer_id' => $randomCustomer->id,
                'queue_position' => null, // Will be calculated by service
            ]));
        }
    }
}

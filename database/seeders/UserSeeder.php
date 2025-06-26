<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Container;
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
        $customers = [
            [
                'name' => 'PT. Pelayaran Nasional Indonesia (PELNI)',
                'email' => 'operations@pelni.co.id',
                'password' => Hash::make('pelni2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'PT. Samudera Indonesia',
                'email' => 'container@samudera.id',
                'password' => Hash::make('samudera2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'PT. Meratus Line',
                'email' => 'logistics@meratusline.com',
                'password' => Hash::make('meratus2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'PT. TEMAS Tbk',
                'email' => 'operations@temas.co.id',
                'password' => Hash::make('temas2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'PT. Berlian Laju Tanker',
                'email' => 'container@blt.co.id',
                'password' => Hash::make('blt2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'PT. Tanto Intim Line',
                'email' => 'shipping@tantointim.com',
                'password' => Hash::make('tantointim2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'Evergreen Marine Corporation',
                'email' => 'jakarta@evergreen-marine.com',
                'password' => Hash::make('evergreen2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'OOCL Indonesia',
                'email' => 'operations@oocl.co.id',
                'password' => Hash::make('oocl2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'Maersk Indonesia',
                'email' => 'container@maersk.co.id',
                'password' => Hash::make('maersk2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'MSC Indonesia',
                'email' => 'operations@msc.co.id',
                'password' => Hash::make('msc2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'PT. IPC Terminal Operator',
                'email' => 'terminal@ipc.co.id',
                'password' => Hash::make('ipc2025'),
                'role' => 'customer',
            ],
            [
                'name' => 'PT. Jakarta International Container Terminal',
                'email' => 'operations@jict.co.id',
                'password' => Hash::make('jict2025'),
                'role' => 'customer',
            ],
        ];

        $customerUsers = [];
        foreach ($customers as $customerData) {
            $customerUsers[] = User::create($customerData);
        }

        // Create sample containers with realistic data and assign to customers
        $this->createSampleContainers($customerUsers);
    }

    private function createSampleContainers($customerUsers): void
    {
        // Container data with realistic scenarios
        $containers = [
            // High priority export containers (ready for departure)
            [
                'container_number' => 'EVGU1234567',
                'customer' => 'PT. Indofood Sukses Makmur',
                'priority' => 'Darurat',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(2),
                'waktu_estimasi' => 20,
                'keterangan' => 'Kapal berangkat dalam 4 jam - prioritas tinggi',
            ],
            [
                'container_number' => 'MSCU9876543',
                'customer' => 'PT. Pan Brothers Tbk',
                'priority' => 'Tinggi',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(1.5),
                'waktu_estimasi' => 25,
                'keterangan' => 'Ekspor tekstil untuk Eropa',
            ],

            // Import containers waiting for processing
            [
                'container_number' => 'OOLU5678901',
                'customer' => 'PT. Samsung Electronics Indonesia',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(3),
                'waktu_estimasi' => 35,
                'keterangan' => 'Import elektronik dari China',
            ],
            [
                'container_number' => 'MAEU3456789',
                'customer' => 'PT. Japfa Comfeed Indonesia',
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
                'customer' => 'PT. Astra International',
                'priority' => 'Tinggi',
                'status' => 'processing',
                'tanggal_masuk' => now()->subHours(4),
                'waktu_mulai_proses' => now()->subMinutes(20),
                'waktu_estimasi' => 40,
                'keterangan' => 'Transshipment ke Surabaya',
            ],
            [
                'container_number' => 'JICT2345678',
                'customer' => 'PT. Unilever Indonesia',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(2.5),
                'waktu_estimasi' => 45,
                'keterangan' => 'Transshipment ke Malaysia',
            ],

            // Domestic containers
            [
                'container_number' => 'PELNI456789',
                'customer' => 'PT. Pertamina Tbk',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(1),
                'waktu_estimasi' => 25,
                'keterangan' => 'Distribusi domestik ke Kalimantan',
            ],
            [
                'container_number' => 'SMDR8901234',
                'customer' => 'PT. Kimia Farma Tbk',
                'priority' => 'Darurat',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subMinutes(30),
                'waktu_estimasi' => 15,
                'keterangan' => 'Obat-obatan darurat untuk Sulawesi',
            ],

            // Completed containers
            [
                'container_number' => 'BLTU1357924',
                'customer' => 'PT. Mayora Indah Tbk',
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
                'customer' => 'PT. Toyota Motor Manufacturing Indonesia',
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
                'customer' => 'PT. Adaro Energy Tbk',
                'priority' => 'Normal',
                'status' => 'cancelled',
                'tanggal_masuk' => now()->subHours(6),
                'waktu_estimasi' => 30,
                'keterangan' => 'Dibatalkan karena masalah dokumen ekspor',
            ],

            // Containers with penalties
            [
                'container_number' => 'FINE1111111',
                'customer' => 'PT. Chandra Asri Petrochemical',
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
                'customer' => 'PT. Pupuk Kaltim Tbk',
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
                'customer' => 'PT. Tzu Chi Indonesia',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(7),
                'waktu_estimasi' => 35,
                'keterangan' => 'Ekspor furniture ke Jepang',
            ],
            [
                'container_number' => 'WAIT4444444',
                'customer' => 'PT. Wijaya Karya Tbk',
                'priority' => 'Tinggi',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(1.8),
                'waktu_estimasi' => 28,
                'keterangan' => 'Import material konstruksi',
            ],
            [
                'container_number' => 'WAIT5555555',
                'customer' => 'PT. Gudang Garam Tbk',
                'priority' => 'Normal',
                'status' => 'waiting',
                'tanggal_masuk' => now()->subHours(3.2),
                'waktu_estimasi' => 42,
                'keterangan' => 'Transshipment ke Singapura',
            ],
        ];

        foreach ($containers as $index => $containerData) {
            // Assign each container to a random customer user
            $randomCustomer = $customerUsers[array_rand($customerUsers)];

            Container::create(array_merge($containerData, [
                'customer_id' => $randomCustomer->id,
                'queue_position' => null, // Will be calculated by service
            ]));
        }
    }
}

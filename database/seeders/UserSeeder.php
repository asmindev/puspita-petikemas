<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Container;
use App\Models\Customer;
use Carbon\Carbon;

class ContainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, find or create the customers mentioned in the CSV
        $customers = [
            'PT FITRAH TRANS SULTRA' => Customer::firstOrCreate([
                'name' => 'PT FITRAH TRANS SULTRA',
                'email' => 'fitrah.trans@example.com',
                'phone' => '+6281234567890',
                'address' => 'Sultra, Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),

            'PT PRATAMA REJEKI ABADI' => Customer::firstOrCreate([
                'name' => 'PT PRATAMA REJEKI ABADI',
                'email' => 'pratama.rejeki@example.com',
                'phone' => '+6281234567891',
                'address' => 'Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),

            'PT KHARISMA TIRTA PRIMA' => Customer::firstOrCreate([
                'name' => 'PT KHARISMA TIRTA PRIMA',
                'email' => 'kharisma.tirta@example.com',
                'phone' => '+6281234567892',
                'address' => 'Indonesia',
                'type' => 'shipping_line',
                'is_active' => true,
            ]),

            'PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES' => Customer::firstOrCreate([
                'name' => 'PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES',
                'email' => 'salam.pacific@example.com',
                'phone' => '+6281234567893',
                'address' => 'Kantor Pusat, Indonesia',
                'type' => 'shipping_line',
                'is_active' => true,
            ]),

            'PT CAHAYA ANUGRAH TRANS' => Customer::firstOrCreate([
                'name' => 'PT CAHAYA ANUGRAH TRANS',
                'email' => 'cahaya.anugrah@example.com',
                'phone' => '+6281234567894',
                'address' => 'Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),

            'PT NGUPOYO UPO TRANS' => Customer::firstOrCreate([
                'name' => 'PT NGUPOYO UPO TRANS',
                'email' => 'ngupoyo.upo@example.com',
                'phone' => '+6281234567895',
                'address' => 'Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),

            'PT EMKL BAHARI KURNIA KENDARI' => Customer::firstOrCreate([
                'name' => 'PT EMKL BAHARI KURNIA KENDARI',
                'email' => 'bahari.kurnia@example.com',
                'phone' => '+6281234567896',
                'address' => 'Kendari, Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),

            'PT SAKURA INDAH TRANSPOR' => Customer::firstOrCreate([
                'name' => 'PT SAKURA INDAH TRANSPOR',
                'email' => 'sakura.indah@example.com',
                'phone' => '+6281234567897',
                'address' => 'Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),

            'PT SARANABHAKTI TIMUR' => Customer::firstOrCreate([
                'name' => 'PT SARANABHAKTI TIMUR,',
                'email' => 'saranabhakti@example.com',
                'phone' => '+6281234567898',
                'address' => 'Indonesia',
                'type' => 'manufacturer',
                'is_active' => true,
            ]),

            'PT CAHAYA KARUNIA LOGISTIK' => Customer::firstOrCreate([
                'name' => 'PT CAHAYA KARUNIA LOGISTIK',
                'email' => 'cahaya.karunia@example.com',
                'phone' => '+6281234567899',
                'address' => 'Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),

            'PT CIPTA TRANS LOGISTIC' => Customer::firstOrCreate([
                'name' => 'PT CIPTA TRANS LOGISTIC',
                'email' => 'cipta.trans@example.com',
                'phone' => '+6281234567800',
                'address' => 'Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),

            'PT SRIWIJAYA LINTAS NUSANTARA' => Customer::firstOrCreate([
                'name' => 'PT SRIWIJAYA LINTAS NUSANTARA',
                'email' => 'sriwijaya.lintas@example.com',
                'phone' => '+6281234567801',
                'address' => 'Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),

            'PT UNTUNG ANAUGI' => Customer::firstOrCreate([
                'name' => 'PT UNTUNG ANAUGI',
                'email' => 'untung.anaugi@example.com',
                'phone' => '+6281234567802',
                'address' => 'Indonesia',
                'type' => 'logistics',
                'is_active' => true,
            ]),
        ];

        // Container data from the CSV
        $containers = [
            [
                'container_number' => 'SPNU2001393',
                'customer_id' => $customers['PT FITRAH TRANS SULTRA']->id,
                'entry_date' => Carbon::create(2025, 6, 14, 8, 34, 0),
                'isi' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2001428',
                'customer_id' => $customers['PT FITRAH TRANS SULTRA']->id,
                'entry_date' => Carbon::create(2025, 6, 15, 8, 34, 0),
                'isi' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2101263',
                'customer_id' => $customers['PT PRATAMA REJEKI ABADI']->id,
                'entry_date' => Carbon::create(2025, 6, 16, 8, 34, 0),
                'isi' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2689218',
                'customer_id' => $customers['PT PRATAMA REJEKI ABADI']->id,
                'entry_date' => Carbon::create(2025, 6, 17, 8, 34, 0),
                'isi' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2694214',
                'customer_id' => $customers['PT KHARISMA TIRTA PRIMA']->id,
                'entry_date' => Carbon::create(2025, 6, 18, 8, 34, 0),
                'isi' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2717618',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 19, 8, 34, 0),
                'isi' => json_encode(['BESI DAN SEJENISNYA']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2719333',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 20, 8, 34, 0),
                'isi' => json_encode(['BESI TUA']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2720550',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 21, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2721285',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 22, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2727302',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 23, 8, 34, 0),
                'isi' => json_encode(['KABEL']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2727909',
                'customer_id' => $customers['PT CAHAYA ANUGRAH TRANS']->id,
                'entry_date' => Carbon::create(2025, 6, 24, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2731262',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 25, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2738354',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 26, 8, 34, 0),
                'isi' => json_encode(['BESI DAN SEJENISNYA']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2745970',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 27, 8, 34, 0),
                'isi' => json_encode(['KABEL']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2759491',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 28, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2759697',
                'customer_id' => $customers['PT NGUPOYO UPO TRANS']->id,
                'entry_date' => Carbon::create(2025, 6, 29, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2777983',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 30, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2797315',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 31, 8, 34, 0),
                'isi' => json_encode(['KABEL']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2797737',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 1, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2815511',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 2, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2826265',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 3, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2856228',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 4, 8, 34, 0),
                'isi' => json_encode(['KARTON']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2881318',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 5, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2890623',
                'customer_id' => $customers['PT KHARISMA TIRTA PRIMA']->id,
                'entry_date' => Carbon::create(2025, 7, 6, 8, 34, 0),
                'isi' => json_encode(['PLASTIK DAN SEJENISNYA']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2897309',
                'customer_id' => $customers['PT CAHAYA ANUGRAH TRANS']->id,
                'entry_date' => Carbon::create(2025, 7, 7, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2915167',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 8, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2927851',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 9, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2929710',
                'customer_id' => $customers['PT EMKL BAHARI KURNIA KENDARI']->id,
                'entry_date' => Carbon::create(2025, 7, 10, 8, 34, 0),
                'isi' => json_encode(['KOPRA']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2930984',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 11, 8, 34, 0),
                'isi' => json_encode(['DEDAK']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2943209',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 12, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2946595',
                'customer_id' => $customers['PT SAKURA INDAH TRANSPOR']->id,
                'entry_date' => Carbon::create(2025, 7, 13, 8, 34, 0),
                'isi' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2953742',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 14, 8, 34, 0),
                'isi' => json_encode(['KAYU']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2965044',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 15, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2965065',
                'customer_id' => $customers['PT CAHAYA ANUGRAH TRANS']->id,
                'entry_date' => Carbon::create(2025, 7, 16, 8, 34, 0),
                'isi' => json_encode(['LIMBAH PABRIK']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2973420',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 17, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2976054',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 18, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2980780',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 19, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2981770',
                'customer_id' => $customers['PT SARANABHAKTI TIMUR']->id,
                'entry_date' => Carbon::create(2025, 7, 20, 8, 34, 0),
                'isi' => json_encode(['BERAS']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2983731',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 21, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2985415',
                'customer_id' => $customers['PT CAHAYA KARUNIA LOGISTIK']->id,
                'entry_date' => Carbon::create(2025, 7, 22, 8, 34, 0),
                'isi' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2988380',
                'customer_id' => $customers['PT EMKL BAHARI KURNIA KENDARI']->id,
                'entry_date' => Carbon::create(2025, 7, 23, 8, 34, 0),
                'isi' => json_encode(['KOPRA']),
                'type' => '20ft',
            ],
            // 40ft containers start here
            [
                'container_number' => 'SPNU2989067',
                'customer_id' => $customers['PT CIPTA TRANS LOGISTIC']->id,
                'entry_date' => Carbon::create(2025, 7, 24, 8, 34, 0),
                'isi' => json_encode(['LIMBAH PABRIK']),
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU2989766',
                'customer_id' => $customers['PT SARANABHAKTI TIMUR']->id,
                'entry_date' => Carbon::create(2025, 7, 25, 8, 34, 0),
                'isi' => json_encode(['BERAS']),
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU2993745',
                'customer_id' => $customers['PT SARANABHAKTI TIMUR']->id,
                'entry_date' => Carbon::create(2025, 7, 26, 8, 34, 0),
                'isi' => json_encode(['KELAPA']),
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU2999553',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 27, 8, 34, 0),
                'isi' => json_encode(['BIJI SAWIT']),
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3016443',
                'customer_id' => $customers['PT SRIWIJAYA LINTAS NUSANTARA']->id,
                'entry_date' => Carbon::create(2025, 7, 28, 8, 34, 0),
                'isi' => null,
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3033435',
                'customer_id' => $customers['PT UNTUNG ANAUGI']->id,
                'entry_date' => Carbon::create(2025, 7, 29, 8, 34, 0),
                'isi' => null,
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3037683',
                'customer_id' => $customers['PT PRATAMA REJEKI ABADI']->id,
                'entry_date' => Carbon::create(2025, 7, 30, 8, 34, 0),
                'isi' => null,
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3046047',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 31, 8, 34, 0),
                'isi' => json_encode(['BERAS']),
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3048311',
                'customer_id' => $customers['PT PRATAMA REJEKI ABADI']->id,
                'entry_date' => Carbon::create(2025, 8, 1, 8, 34, 0),
                'isi' => null,
                'type' => '40ft',
            ],
        ];

        foreach ($containers as $container) {
            Container::create([
                'container_number' => $container['container_number'],
                'customer_id' => $container['customer_id'],
                'entry_date' => $container['entry_date'],
                'isi' => $container['isi'],
                'type' => $container['type'],
                'status' => 'waiting', // Default status
                'priority' => 'Normal', // Default priority
                'tanggal_masuk' => $container['entry_date'],
                'waktu_estimasi' => $container['type'] === '20ft' ? 20 : 40,
            ]);
        }
        // users seeder
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);
    }
}

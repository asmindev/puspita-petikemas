<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Seeder;
use App\Models\Container;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
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

            ]),

            'PT PRATAMA REJEKI ABADI' => Customer::firstOrCreate([
                'name' => 'PT PRATAMA REJEKI ABADI',

            ]),

            'PT KHARISMA TIRTA PRIMA' => Customer::firstOrCreate([
                'name' => 'PT KHARISMA TIRTA PRIMA',

            ]),

            'PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES' => Customer::firstOrCreate([
                'name' => 'PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES',

            ]),

            'PT CAHAYA ANUGRAH TRANS' => Customer::firstOrCreate([
                'name' => 'PT CAHAYA ANUGRAH TRANS',

            ]),

            'PT NGUPOYO UPO TRANS' => Customer::firstOrCreate([
                'name' => 'PT NGUPOYO UPO TRANS',

            ]),

            'PT EMKL BAHARI KURNIA KENDARI' => Customer::firstOrCreate([
                'name' => 'PT EMKL BAHARI KURNIA KENDARI',

            ]),

            'PT SAKURA INDAH TRANSPOR' => Customer::firstOrCreate([
                'name' => 'PT SAKURA INDAH TRANSPOR',

            ]),

            'PT SARANABHAKTI TIMUR' => Customer::firstOrCreate([
                'name' => 'PT SARANABHAKTI TIMUR,',

            ]),

            'PT CAHAYA KARUNIA LOGISTIK' => Customer::firstOrCreate([
                'name' => 'PT CAHAYA KARUNIA LOGISTIK',

            ]),

            'PT CIPTA TRANS LOGISTIC' => Customer::firstOrCreate([
                'name' => 'PT CIPTA TRANS LOGISTIC',

            ]),

            'PT SRIWIJAYA LINTAS NUSANTARA' => Customer::firstOrCreate([
                'name' => 'PT SRIWIJAYA LINTAS NUSANTARA',

            ]),

            'PT UNTUNG ANAUGI' => Customer::firstOrCreate([
                'name' => 'PT UNTUNG ANAUGI',

            ]),
        ];

        // CONTOH DATA PETI KEMAS, 50 DATA
        // semua peti kemas status 'pending'
        // 25 peti kemas dengan type 20ft dan 25 peti kemas dengan type 40ft
        // 10 peti kemas dengan priority HIGH dan 10 peti kemas dengan priority NORMAL
        // 2 peti kemas dengan type 20ft dengan keterlambatan 7 hari (total keterlambatan dihitung dari exit_date sampai tanggal ini)
        // 2 peti kemas dengan type 40ft dengan keterlambatan 7 hari (total keterlambatan dihitung dari exit_date sampai tanggal ini)
        // 4 peti kemas pada dengan entry_date tanggal 2025-05-14
        $containers = [
            [
                'container_number' => 'SPNU2001393',
                'customer_id' => $customers['PT FITRAH TRANS SULTRA']->id,
                'entry_date' => Carbon::create(2025, 5, 14, 8, 34, 0),
                'exit_date' => Carbon::create(2025, 6, 14, 8, 34, 0),
                'contents' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2001428',
                'customer_id' => $customers['PT FITRAH TRANS SULTRA']->id,
                'entry_date' => Carbon::create(2025, 6, 15, 8, 34, 0),
                'exit_date' => Carbon::create(2025, 7, 20, 10, 0, 0), // 35 hari terlambat
                'contents' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2101263',
                'customer_id' => $customers['PT PRATAMA REJEKI ABADI']->id,
                'entry_date' => Carbon::create(2025, 6, 16, 8, 34, 0),
                'exit_date' => Carbon::create(2025, 6, 18, 14, 0, 0),
                'contents' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2689218',
                'customer_id' => $customers['PT PRATAMA REJEKI ABADI']->id,
                'entry_date' => Carbon::create(2025, 6, 17, 8, 34, 0),
                'contents' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2694214',
                'customer_id' => $customers['PT KHARISMA TIRTA PRIMA']->id,
                'entry_date' => Carbon::create(2025, 6, 18, 8, 34, 0),
                'contents' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2717618',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 19, 8, 34, 0),
                'exit_date' => Carbon::create(2025, 6, 25, 9, 30, 0), // 36 hari terlambat
                'contents' => ['BESI DAN SEJENISNYA'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2719333',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 20, 8, 34, 0),
                'contents' => ['BESI TUA'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2720550',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 21, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2721285',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 22, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2727302',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 23, 8, 34, 0),
                'contents' => ['KABEL'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2727909',
                'customer_id' => $customers['PT CAHAYA ANUGRAH TRANS']->id,
                'entry_date' => Carbon::create(2025, 6, 24, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2731262',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 25, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2738354',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 26, 8, 34, 0),
                'contents' => ['BESI DAN SEJENISNYA'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2745970',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 27, 8, 34, 0),
                'contents' => ['KABEL'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2759491',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 28, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2759697',
                'customer_id' => $customers['PT NGUPOYO UPO TRANS']->id,
                'entry_date' => Carbon::create(2025, 6, 29, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2777983',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 30, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2797315',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 6, 31, 8, 34, 0),
                'contents' => ['KABEL'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2797737',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 1, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2815511',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 2, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2826265',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 3, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2856228',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 4, 8, 34, 0),
                'contents' => ['KARTON'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2881318',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 5, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2890623',
                'customer_id' => $customers['PT KHARISMA TIRTA PRIMA']->id,
                'entry_date' => Carbon::create(2025, 7, 6, 8, 34, 0),
                'contents' => ['PLASTIK DAN SEJENISNYA'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2897309',
                'customer_id' => $customers['PT CAHAYA ANUGRAH TRANS']->id,
                'entry_date' => Carbon::create(2025, 7, 7, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2915167',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 8, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2927851',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 9, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2929710',
                'customer_id' => $customers['PT EMKL BAHARI KURNIA KENDARI']->id,
                'entry_date' => Carbon::create(2025, 7, 10, 8, 34, 0),
                'contents' => ['KOPRA'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2930984',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 11, 8, 34, 0),
                'contents' => ['DEDAK'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2943209',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 12, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2946595',
                'customer_id' => $customers['PT SAKURA INDAH TRANSPOR']->id,
                'entry_date' => Carbon::create(2025, 7, 13, 8, 34, 0),
                'contents' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2953742',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 14, 8, 34, 0),
                'contents' => ['KAYU'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2965044',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 15, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2965065',
                'customer_id' => $customers['PT CAHAYA ANUGRAH TRANS']->id,
                'entry_date' => Carbon::create(2025, 7, 16, 8, 34, 0),
                'contents' => ['LIMBAH PABRIK'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2973420',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 17, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2976054',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 18, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2980780',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 19, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2981770',
                'customer_id' => $customers['PT SARANABHAKTI TIMUR']->id,
                'entry_date' => Carbon::create(2025, 7, 20, 8, 34, 0),
                'contents' => ['BERAS'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2983731',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 21, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2985415',
                'customer_id' => $customers['PT CAHAYA KARUNIA LOGISTIK']->id,
                'entry_date' => Carbon::create(2025, 7, 22, 8, 34, 0),
                'contents' => null,
                'type' => '20ft',
            ],
            [
                'container_number' => 'SPNU2988380',
                'customer_id' => $customers['PT EMKL BAHARI KURNIA KENDARI']->id,
                'entry_date' => Carbon::create(2025, 7, 23, 8, 34, 0),
                'contents' => ['KOPRA'],
                'type' => '20ft',
            ],
            // 40ft containers start here
            [
                'container_number' => 'SPNU2989067',
                'customer_id' => $customers['PT CIPTA TRANS LOGISTIC']->id,
                'entry_date' => Carbon::create(2025, 7, 24, 8, 34, 0),
                'contents' => ['LIMBAH PABRIK'],
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU2989766',
                'customer_id' => $customers['PT SARANABHAKTI TIMUR']->id,
                'entry_date' => Carbon::create(2025, 7, 25, 8, 34, 0),
                'contents' => ['BERAS'],
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU2993745',
                'customer_id' => $customers['PT SARANABHAKTI TIMUR']->id,
                'entry_date' => Carbon::create(2025, 7, 26, 8, 34, 0),
                'contents' => ['KELAPA'],
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU2999553',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 27, 8, 34, 0),
                'contents' => ['BIJI SAWIT'],
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3016443',
                'customer_id' => $customers['PT SRIWIJAYA LINTAS NUSANTARA']->id,
                'entry_date' => Carbon::create(2025, 7, 28, 8, 34, 0),
                'contents' => null,
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3033435',
                'customer_id' => $customers['PT UNTUNG ANAUGI']->id,
                'entry_date' => Carbon::create(2025, 7, 29, 8, 34, 0),
                'contents' => null,
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3037683',
                'customer_id' => $customers['PT PRATAMA REJEKI ABADI']->id,
                'entry_date' => Carbon::create(2025, 7, 30, 8, 34, 0),
                'contents' => null,
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3046047',
                'customer_id' => $customers['PT KANTOR PUSAT SALAM PACIFIC INDONESIA LINES']->id,
                'entry_date' => Carbon::create(2025, 7, 31, 8, 34, 0),
                'contents' => ['BERAS'],
                'type' => '40ft',
            ],
            [
                'container_number' => 'SPNU3048311',
                'customer_id' => $customers['PT PRATAMA REJEKI ABADI']->id,
                'entry_date' => Carbon::create(2025, 8, 1, 8, 34, 0),
                'contents' => null,
                'type' => '40ft',
            ],
        ];

        foreach ($containers as $container) {
            Container::create([
                'container_number' => $container['container_number'],
                'customer_id' => $container['customer_id'],
                'entry_date' => $container['entry_date'],
                'exit_date' => $container['exit_date'] ?? Carbon::now(), // Default to now if exit_date is not set
                'contents' => $container['contents'],
                'type' => $container['type'],
                'status' => 'pending', // Default status
                'priority' => 'Normal', // Default priority

            ]);
        }
        // users seeder
        $testAdmin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('123'),
        ]);
    }
}

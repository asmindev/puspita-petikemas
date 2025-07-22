<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerPinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing customers with PIN
        $customers = Customer::all();

        foreach ($customers as $customer) {
            // Generate a simple 6-digit PIN for each customer
            $pin = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $customer->update([
                'pin' => $pin
            ]);

            // Log the generated PINs for reference
            $this->command->info("Customer: {$customer->name}, PIN: {$pin}");
        }

        // If no customers exist, create at least one test customer
        if ($customers->count() === 0) {
            Customer::create([
                'name' => 'Demo Customer',
                'pin' => '123456',
                'container_count' => 0
            ]);
            $this->command->info("Created Demo Customer with PIN: 123456");
        }
    }
}

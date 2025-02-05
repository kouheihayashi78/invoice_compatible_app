<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'A商店',
            ],
            [
                'name' => 'B商店',
            ],
            [
                'name' => 'C商店',
            ],
        ];

        foreach($customers as $customer) {
            DB::table('customers')->insert([
                'customer_name' => $customer['name']
            ]);
        }
    }
}

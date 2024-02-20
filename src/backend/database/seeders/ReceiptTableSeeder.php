<?php

namespace Database\Seeders;

use App\Models\Receipt;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReceiptTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Receipt::factory(1)->create([
            'customer_id' => 1,
            'total_payment' => 110.00,
        ]);
    }
}

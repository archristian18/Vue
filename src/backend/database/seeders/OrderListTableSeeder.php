<?php

namespace Database\Seeders;

use App\Models\OrderList;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderList::factory(2)->create([
            'quantity' => 1,
            'total_price' => 110.00,
            'customer_id' => 1,
            'menu_id' => 1,
        ]);
    }
}

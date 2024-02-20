<?php

namespace Database\Seeders;

use App\Models\CustomerOrder;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerOrder::factory(3)->create([
            'name' => 'Burger',
            'status' => 'DineIn',
        ]);
    }
}

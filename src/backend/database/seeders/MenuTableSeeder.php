<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('menus')->insert([
            [
                'name' => 'Classic Burger',
                'price' => 110.00,
                'description' => 'Quarter pound, cheese, sauce, tomato & with ice tea',
                'image_path' => 'images/classic.jpg',
            ],
            [
                'name' => 'Ham and Cheese',
                'price' => 150.00,
                'description' => 'Quarter pound patty, 2 sliced grilled, ham, cheese, sauce, tomato & with ice tea',
                'image_path' => 'images/hamcheese.png',
            ],
            [
                'name' => 'Northern General',
                'price' => 165.00,
                'description' => 'Quarter pound patty, chese sauce, lettuce, tomato, caramelized onion & with ice tea',
                'image_path' => 'images/northerngeneral.png',
            ],
            [
                'name' => 'Angry Viking',
                'price' => 185.00,
                'description' => 'Quarter pound patty, 2 sliced grilled, ham, cheese, sauce, tomato & with ice tea',
                'image_path' => 'images/angryviking.png',
            ],
            [
                'name' => 'Heart Attack',
                'price' => 199.00,
                'description' => 'Quarter pound patty, loaded with bacon, cheese sauce, lettuce, tomato, house hot sauce & with ice tea',
                'image_path' => 'images/heartattack.png',
            ],
            [
                'name' => 'Hawaiian Burger',
                'price' => 210.00,
                'description' => 'Quarter pound patty, loaded with bacon cheese sauce, lettuce, tomato, caramelized onion & with ice tea',
                'image_path' => 'images/hawaiian.png',
            ],
        ]);
    }
}

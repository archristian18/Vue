<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InquiryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inquiry::factory()->create([
            'fullname' => 'Test Name',
            'email' => 'test@gmail.com',
            'content' => 'TESTING',
        ]);
    }
}

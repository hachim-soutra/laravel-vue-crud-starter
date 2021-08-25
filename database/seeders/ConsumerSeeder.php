<?php

namespace Database\Seeders;

use App\Models\Consumer;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ConsumerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Consumer::factory()->count(30)->create(); 
    }
}

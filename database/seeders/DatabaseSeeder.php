<?php

namespace Database\Seeders;

use App\Models\StatusLivraison;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(PermissionSeeder::class);
        // $this->call(StatusLivraisonSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}

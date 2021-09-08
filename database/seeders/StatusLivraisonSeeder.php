<?php

namespace Database\Seeders;

use App\Models\StatusLivraison;
use Illuminate\Database\Seeder;

class StatusLivraisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['Expédiée','Livrée','Reporter','Pas de réponse','Annuler','Paye','Retour'];
        foreach ($status as $value) {
            StatusLivraison::create([
                'name' => $value
            ]);
        }
    }
}

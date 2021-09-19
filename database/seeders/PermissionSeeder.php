<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [

            'voir pays',
            'ajouter pays',
            'mise a jour pays',

            'voir partner',
            'ajouter partner',
            'mise a jour partner',

            'voir user',
            'ajouter user',
            'mise a jour user',

            'voir produit',
            'ajouter produit',
            'mise a jour produit',

            'voir livreur',
            'ajouter livreur',
            'mise a jour livreur',

            'voir équipe confirmation',
            'ajouter équipe confirmation',
            'mise a jour équipe confirmation',

            'voir command',
            'ramassage command',
            'reportiez command',
            'ajouter command',
            'mise a jour command',


        ];

        // Permission::get()->delete();

        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }
}

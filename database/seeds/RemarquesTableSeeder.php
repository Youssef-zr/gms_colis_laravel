<?php

use App\Models\Remarque;
use Illuminate\Database\Seeder;

class RemarquesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $remarques = [
            ['libelle' => "Appel"],
            ['libelle' => "Sans réponse"],
            ['libelle' => "Hors zone"],
            ['libelle' => "Client indisponible"],
            ['libelle' => "Information incorrect"],
            ['libelle' => "Fonds insuffisant"],
            ['libelle' => "Colis rejeté"],
            ['libelle' => "Injoignable"],
            ['libelle' => "Colis rejeté"],
            ['libelle' => "Colis Endommagé"],
        ];

        foreach ($remarques as $remarque) {
            $new = new Remarque();
            $new->fill($remarque)->save();
        }

    }
}

<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            "WareHouse",
            "En attente",
            "En Ramassage",
            "En cours de livraison",
            "Livré",
            "Annulé",
            "Livré en agence",
            "Retourné",
            "Versé",
        ];

        foreach ($statuses as $key => $value) {
            $new = new Status();
            $new->libelle = $statuses[$key];
            $new->save();
        }
    }
}

<?php

use App\Models\Ville;
use Illuminate\Database\Seeder;

class VilleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path("assets/dist/js/cities.json");
        $cities = json_decode(file_get_contents($path), true);

        foreach ($cities['cities'] as $city) {
            $new = new Ville();
            $new->libelle = $city["city"];
            $new->save();
        }
    }
}

<?php

use App\Models\Colis;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ColisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 500; $i++) {
            $faker = Factory::create();

            $new = new Colis();
            $new->date = now();
            $new->numero_suivi = Str::random(3) . random_int(5512, 9965887);
            $new->numero_commande = Str::random(3) . random_int(5512, 9965887);
            $new->nom_destinataire = $faker->name;
            $new->adresse_destinataire = $faker->address;
            $new->type_expedtion = 1;
            $new->tel = $faker->phoneNumber;
            $new->montant = random_int(140, 1800);
            $new->type_paiement = 0;
            $new->code_destinataire = random_int(100, 256);
            $new->id_expediteur = random_int(1, 25);
            $new->id_livreur = random_int(3, 4);
            $new->id_ville = random_int(1, 162);
            $new->id_statut = 1;
            $new->id_remarques = random_int(1,10);

            $new->save();
        }
    }
}

<?php

use App\Models\Lpaiment;
use App\Models\Payment;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 0; $i < 100; $i++) {
            $faker = Factory::create();
            $newPayment = new Payment();
            $newPayment->date = $faker->date();
            $newPayment->montant = $faker->randomFloat();
            $newPayment->heure = date('H:i');
            $newPayment->id_livreur = random_int(5, 6);
            $newPayment->id_expediteur = random_int(4, 5);
            $newPayment->save();

            $newLpayment = new Lpaiment();
            $newLpayment->id_paiment = $newPayment->id;
            $newLpayment->id_colis = $newPayment->id;
            $newLpayment->save();
        }
    }
}

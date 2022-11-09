<?php

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
        $this->call(PermissionTableSeeder::class);
        $this->call(ExpediteursTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(RemarquesTableSeeder::class);
        $this->call(VilleTableSeeder::class);
        $this->call(StatutTableSeeder::class);
        $this->call(ColisTableSeeder::class);
        // $this->call(PaymentTableSeeder::class);
    }
}

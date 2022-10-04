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
        $this->call(UserTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(BundelTableSeeder::class);
    }
}

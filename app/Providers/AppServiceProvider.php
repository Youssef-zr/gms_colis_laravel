<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (Schema::hasTable('colis')) {
        //     if (!Schema::hasColumn('colis', 'signature') and !Schema::hasColumn('colis', 'signature')) {
        //         Schema::table('colis', function (Blueprint $table) {
        //             DB::statement("ALTER TABLE colis ADD signature longblob");
        //             DB::statement("ALTER TABLE colis ADD recu longblob");
        //         });
        //     }
        // }

        // if (Schema::hasTable('paiment')) {
        //     if (!Schema::hasColumn('paiment', 'recu_paiement')) {
        //         Schema::table('colis', function (Blueprint $table) {
        //             DB::statement("ALTER TABLE paiment ADD signature longblob");
        //         });
        //     }
        // }
    }
}

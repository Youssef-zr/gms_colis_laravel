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
        // DB::statement("CREATE TABLE [dbo].[colis2](
        //     [id] [bigint] IDENTITY(1,1) NOT NULL,
        //     [date] [date] NULL,
        //     [numero_suivi] [nvarchar](255) NOT NULL,
        //     [nom_destinataire] [nvarchar](255) NOT NULL,
        //     [numero_commande] [nvarchar](255) NOT NULL,
        //     [adresse_destinataire] [nvarchar](255) NOT NULL,
        //     [type_expedtion] [nvarchar](255) NULL,
        //     [tel] [nvarchar](255) NOT NULL,
        //     [montant] [int] NOT NULL,
        //     [paye] [int] NULL,
        //     [type_paiement] [nvarchar](255) NOT NULL,
        //     [code_destinataire] [nvarchar](255) NOT NULL,
        //     [centre_id] [nvarchar](255) NULL
        //     )");

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

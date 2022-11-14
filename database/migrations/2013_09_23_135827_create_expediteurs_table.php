<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpediteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('tel')->nullable();
            $table->string('adresse')->nullable();
            $table->string('mail')->nullable();
            // $table->timestamps();
        });

        Schema::create('remarques', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expediteurs');
        Schema::dropIfExists('remarques');
    }
}

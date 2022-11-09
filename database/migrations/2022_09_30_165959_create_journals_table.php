<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_utilisateur')->nullable();
            $table->foreign('id_utilisateur')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('id_colis')->nullable();
            $table->foreign('id_colis')->references('id')->on('colis')->onDelete('set null');
            $table->unsignedBigInteger('id_statut')->nullable();
            $table->foreign('id_statut')->references('id')->on('statut')->onDelete('set null');
            $table->unsignedBigInteger('id_remarques')->nullable();
            $table->foreign('id_remarques')->references('id')->on('remarques')->onDelete('set null');
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
        Schema::dropIfExists('journals');
    }
}

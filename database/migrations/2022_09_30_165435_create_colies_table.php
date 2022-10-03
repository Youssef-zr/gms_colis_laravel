<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colis', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('numero_suivi');
            $table->string('nom_destinataire');
            $table->string('numero_commande');
            $table->string('adresse_destinataire');
            $table->string('type_expedtion')->nullable()->default('0');
            $table->string('tel');
            $table->integer('montant');
            $table->integer('paye')->nullable()->default('0');
            $table->string('type_paiement');
            $table->string('code_destinataire');
            $table->string('centre_id')->nullable()->default('0');

            $table->unsignedBigInteger('id_livreur')->nullable();
            $table->foreign('id_livreur')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('id_expediteur')->nullable();
            $table->foreign('id_expediteur')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('id_ville')->nullable();
            $table->foreign('id_ville')->references('id')->on('villes')->onDelete('set null');
            $table->unsignedBigInteger('id_statut')->nullable();
            $table->foreign('id_statut')->references('id')->on('status')->onDelete('set null');
            $table->unsignedBigInteger('id_remarques')->nullable();
            $table->foreign('id_remarques')->references('id')->on('remarques')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colis');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiments', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->longText('recu_paiment')->nullable()->default('--');
            $table->integer('montant')->nullable()->default(0);
            $table->string("heure");

            $table->unsignedBigInteger('id_livreur')->nullable();
            $table->foreign('id_livreur')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('id_expediteur')->nullable();
            $table->foreign('id_expediteur')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('paiments');
    }
}

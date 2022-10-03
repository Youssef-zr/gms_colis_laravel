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
            $table->string('reference');
            $table->integer('montant')->nullable()->default(0);
            $table->timestamp("heure");

            $table->unsignedBigInteger('id_utilisateur')->nullable();
            $table->foreign('id_utilisateur')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('id_Expediteur')->nullable();
            $table->foreign('id_Expediteur')->references('id')->on('users')->onDelete('set null');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLpaimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpaiments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_paiement')->nullable();
            $table->foreign('id_paiement')->references('id')->on('paiments')->onDelete('set null');
            $table->unsignedBigInteger('id_colis')->nullable();
            $table->foreign('id_colis')->references('id')->on('colis')->onDelete('set null');
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
        Schema::dropIfExists('lpaiments');
    }
}

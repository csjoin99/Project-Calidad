<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloTallasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo_tallas', function (Blueprint $table) {
            $table->id('idArticuloTalla');
            $table->unsignedBigInteger('idArticuloS');
            $table->unsignedBigInteger('idTallaS');
            $table->unique(array('idArticuloS', 'idTallaS'));
            $table->foreign('idArticuloS')->references('idArticulo')->on('articulos');
            $table->foreign('idTallaS')->references('idTalla')->on('tallas');
            $table->integer('stockArticulo')->default(0);
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
        Schema::dropIfExists('articulo_tallas');
    }
}

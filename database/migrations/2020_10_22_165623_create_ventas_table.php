<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('idVenta');
            $table->unsignedBigInteger('idClienteV');
            $table->string('serieComprobanteVenta', 10);
            $table->string('numComprobanteVenta', 45);
            $table->string('customerVenta', 80);
            $table->date('fechaVenta');
            $table->decimal('totalVenta', 10, 2);
            $table->decimal('impuestoVenta', 10, 2);
            $table->string('direccionVenta',100);
            $table->string('distritoVenta',100);
            $table->tinyInteger('estadoVenta')->default(1);
            $table->foreign('idClienteV')->references('id')->on('users');
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
        Schema::dropIfExists('ventas');
    }
}

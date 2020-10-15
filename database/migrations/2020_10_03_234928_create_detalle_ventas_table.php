<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id('idVentaDetalle');
            $table->unsignedBigInteger('idVentaD');
            $table->unsignedBigInteger('idArticuloTallaD');
            $table->unique(array('idVentaD', 'idArticuloTallaD'));
            $table->foreign('idVentaD')->references('idVenta')->on('ventas');
            $table->foreign('idArticuloTallaD')->references('idArticuloTalla')->on('articulo_tallas');
            $table->integer('cantidad');
            $table->decimal('precioVentaD', 10, 2);
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
        Schema::dropIfExists('detalle_ventas');
    }
}

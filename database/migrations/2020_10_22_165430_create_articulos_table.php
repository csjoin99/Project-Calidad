<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id('idArticulo');
            $table->string('codigoArticulo',20)->unique()->nullable();
            $table->string('nombreArticulo',45)->unique();
            $table->string('categoriaArticulo',45);
            $table->decimal('precioArticulo', 10, 2);
            $table->string('photoArticulo',200)->nullable();
            $table->tinyInteger('estadoArticulo')->default(1);
            $table->Integer('generoArticulo');
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
        Schema::dropIfExists('articulos');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TriggerUpdateStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER TriggerUpdateStock
            AFTER INSERT ON detalle_ventas 
            FOR EACH ROW
            UPDATE articulo_tallas 
                SET stockArticulo = stockArticulo - NEW.cantidad
            WHERE idArticuloTalla = NEW.idArticuloTallaD;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TriggerUpdateStock');
    }
}

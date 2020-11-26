<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Vistas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            create view recomendaciones as
            select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
            articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) 
            as cant from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) 
            as b where b.cant !=0 ORDER BY RAND() LIMIT 4
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

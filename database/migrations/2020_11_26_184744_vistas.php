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
            create view vista_recomendaciones as
            select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
            articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) 
            as cant from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) 
            as b where b.cant !=0 ORDER BY RAND() LIMIT 4
        ');
        DB::statement('
            create view vista_articulos_cant_tallas as
            select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
            articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) 
            as cant from articulos where articulos.estadoArticulo!=0 order 
            by articulos.idArticulo ASC) as b
        ');
        DB::statement('
            create view vista_tallas_articulos as
            SELECT `articulo_tallas`.`idArticuloTalla`, `articulo_tallas`.`idArticuloS`, 
            `articulo_tallas`.`idTallaS`, `articulo_tallas`.`stockArticulo`, 
            `tallas`.`nombreTalla` FROM `articulo_tallas` LEFT JOIN `tallas` ON 
            `articulo_tallas`.`idTallaS` = `tallas`.`idTalla` where 
            `articulo_tallas`.`estadoArticuloTalla`!=0
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS vista_recomendaciones');
        DB::statement('DROP VIEW IF EXISTS vista_articulos_cant_tallas');
        DB::statement('DROP VIEW IF EXISTS vista_tallas_articulos');
    }
}

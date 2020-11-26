<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TallaController extends Controller
{
    public function obtenerTallas(Request $request, $id)
    {
        $tallas = DB::select("select * from (select * from (select idTalla, nombreTalla, categoriaTalla from tallas) as a 
        left join (select articulo_tallas.idArticuloS, articulo_tallas.idTallaS, articulo_tallas.estadoArticuloTalla from 
        articulo_tallas WHERE articulo_tallas.idArticuloS=? and articulo_tallas.estadoArticuloTalla!=0) as b on 
        a.idTalla=b.idTallaS) as b where idArticulos IS NULL and categoriaTalla=?", [$id, $request->category]);
        return response()->json(['talla' => $tallas]);
    }
}

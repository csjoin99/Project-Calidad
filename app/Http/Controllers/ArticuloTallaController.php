<?php

namespace App\Http\Controllers;

use App\Models\articulo_talla;
use ArrayObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticuloTallaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $check = DB::table('articulo_tallas')->select('estadoArticuloTalla')
            ->where('idArticuloS', '=', $request->idArticulo)
            ->where('idTallaS', '=', $request->tallaArticulo)->get();
        if (!$check->isEmpty()) {
            if ($check[0]->estadoArticuloTalla == 0) {
                DB::table('articulo_tallas')
                    ->where('idArticuloS', '=', $request->idArticulo)
                    ->where('idTallaS', $request->tallaArticulo)
                    ->update([
                        'stockArticulo' => $request->stockArticulo,
                        'estadoArticuloTalla' => 1
                    ]);
            }
            else{
                return redirect()->route('admin.articulotalla')->withSuccess('Se agrego la talla exitosamente');;
            }
        } else {
            DB::table('articulo_tallas')->insert([
                [
                    'idArticuloS' => $request->idArticulo,
                    'idTallaS' => $request->tallaArticulo,
                    'stockArticulo' => $request->stockArticulo
                ]
            ]);
        }
        return redirect()->route('admin.articulotalla')->withSuccess('Se agrego la talla exitosamente');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\articulo_talla  $articulo_talla
     * @return \Illuminate\Http\Response
     */
    public function show(articulo_talla $articulo_talla)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\articulo_talla  $articulo_talla
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        DB::table('articulo_tallas')
            ->where('idArticuloTalla', $request->idArticulo)
            ->update([
                'stockArticulo' => $request->stockArticulo,
            ]);
        return redirect()->route('admin.articulotalla')->withSuccess('Se editaron los datos exitosamente');;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\articulo_talla  $articulo_talla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, articulo_talla $articulo_talla)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\articulo_talla  $articulo_talla
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('articulo_tallas')
            ->where('idArticuloTalla', $request->idArticulo)
            ->update([
                'estadoArticuloTalla' => 0,
            ]);
        return redirect()->route('admin.articulotalla')->withSuccess('Se elimino la talla exitosamente');;
    }

    public function getTallaArticulo(Request $request, $id)
    {
        $tallas = DB::select("select * from (select * from (select idTalla, nombreTalla, categoriaTalla from tallas) as a 
        left join (select articulo_tallas.idArticuloS, articulo_tallas.idTallaS, articulo_tallas.estadoArticuloTalla from 
        articulo_tallas WHERE articulo_tallas.idArticuloS=? and articulo_tallas.estadoArticuloTalla!=0) as b on 
        a.idTalla=b.idTallaS) as b where idArticulos IS NULL and categoriaTalla=?", [$id, $request->category]);

        return response()->json(['talla' => $tallas, 'id' => $id]);
    }
}

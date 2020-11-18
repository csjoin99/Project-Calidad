<?php

namespace App\Http\Controllers;

use App\Models\articulo_talla;
use ArrayObject;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
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
        try {
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
                } else {
                    return response()->json(['success' => false,'message'=>'No se pudo añadir la talla']);
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
            return response()->json(['success' => true,'message'=>'Se agrego la talla exitosamente']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'message'=>'No se pudo añadir la talla']);
        }
        
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
        try {
            DB::table('articulo_tallas')
            ->where('idArticuloTalla', $request->idArticulo)
            ->update([
                'stockArticulo' => $request->stockArticulo,
            ]);
            return response()->json(['success' => true,'message'=>'Se editaron los datos exitosamente']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'message'=>'No se pudo editar el stock de la talla']);
        }
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
    public function destroy($id)
    {
        try {
            DB::table('articulo_tallas')
            ->where('idArticuloTalla', $id)
            ->update([
                'estadoArticuloTalla' => 0,
            ]);
            return response()->json(['success' => true,'message'=>'Se elimino la talla exitosamente']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'message'=>'No se pudo eliminar la talla']);
        }
    }
    public function articulostallaShow()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');;
        }
        return view('admin.articulotalla');
    }
    public function getTallaArticulo(Request $request, $id)
    {
        $tallas = DB::select("select * from (select * from (select idTalla, nombreTalla, categoriaTalla from tallas) as a 
        left join (select articulo_tallas.idArticuloS, articulo_tallas.idTallaS, articulo_tallas.estadoArticuloTalla from 
        articulo_tallas WHERE articulo_tallas.idArticuloS=? and articulo_tallas.estadoArticuloTalla!=0) as b on 
        a.idTalla=b.idTallaS) as b where idArticulos IS NULL and categoriaTalla=?", [$id, $request->category]);

        return response()->json(['talla' => $tallas]);
    }
    public function articulosTallaGet(Request $request)
    {
        $articulos = DB::select("SELECT articulos.idArticulo, articulos.estadoArticulo, articulos.nombreArticulo, articulos.categoriaArticulo,(select COUNT(*) from articulo_tallas where articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) 
        as cant from articulos where articulos.estadoArticulo!=0  order by articulos.idArticulo ASC");
        $articuloscant = count($articulos);
        $articuloTallas = DB::select("SELECT `articulo_tallas`.`idArticuloTalla`, `articulo_tallas`.`idArticuloS`, `articulo_tallas`.`idTallaS`, `articulo_tallas`.`stockArticulo`, `tallas`.`nombreTalla`
        FROM `articulo_tallas` LEFT JOIN `tallas` ON `articulo_tallas`.`idTallaS` = `tallas`.`idTalla` where 
        `articulo_tallas`.`estadoArticuloTalla`!=0");
        for ($i = 0; $i < $articuloscant; $i++) {
            $arrayTallas = array();
            for ($j = 0; $j < count($articuloTallas); $j++) {
                if($articulos[$i]->idArticulo == $articuloTallas[$j]->idArticuloS){
                    array_push($arrayTallas,(object)$articuloTallas[$j]);
                }
            }
            $articulos[$i]->arrayTalla=$arrayTallas;
        }
        $page = ($request->page)?$request->page:1;
        $perPage = 6; 
        $offset = ($page * $perPage) - $perPage;
        $paginate = new LengthAwarePaginator(
            array_slice($articulos,$offset,$perPage, true),
            $articuloscant,
            $perPage,
            $page
        );
        return ['pagination' => $paginate, 'articuloscant' => $articuloscant];
    }
}

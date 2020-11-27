<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticuloTallaController extends Controller
{
    public function paginaArticuloTalla()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');;
        }
        return view('admin.articulotalla');
    }
    public function listaArticuloTalla(Request $request)
    {
        $articulos = DB::select("SELECT * FROM vista_articulos_cant_tallas");
        $articulos_cant = count($articulos);
        $articulo_tallas = DB::select("SELECT * FROM vista_tallas_articulos");
        for ($i = 0; $i < $articulos_cant; $i++) {
            $array_tallas = array();
            for ($j = 0; $j < count($articulo_tallas); $j++) {
                if($articulos[$i]->idArticulo == $articulo_tallas[$j]->idArticuloS){
                    array_push($array_tallas,(object)$articulo_tallas[$j]);
                }
            }
            $articulos[$i]->arrayTalla=$array_tallas;
        }
        $page = ($request->page)?$request->page:1;
        $per_page = 5; 
        $offset = ($page * $per_page) - $per_page;
        $paginate = new LengthAwarePaginator(
            array_slice($articulos,$offset,$per_page, true),
            $articulos_cant,
            $per_page,
            $page
        );
        return ['pagination' => $paginate, 'articuloscant' => $articulos_cant];
    }
    public function insertArticuloTalla(Request $request)
    {
        try {
            $check_talla = DB::table('articulo_tallas')->select('estadoArticuloTalla')
                ->where('idArticuloS', '=', $request->idArticulo)
                ->where('idTallaS', '=', $request->tallaArticulo)->get();
            if (!$check_talla->isEmpty()) {
                if ($check_talla[0]->estadoArticuloTalla == 0) {
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
    public function editArticuloTalla(Request $request)
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
    public function destroyArticuloTalla($id)
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
}

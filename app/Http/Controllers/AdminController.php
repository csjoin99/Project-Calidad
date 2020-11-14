<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\articulo;
use App\Models\articulo_talla;
use App\Models\detalle_venta;
use App\Models\User;
use App\Models\venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::guard('admin')->check()) {

            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');
        }
        $ventas = venta::count();
        $users = User::count();
        $det_venta = DB::select("SELECT sum(detalle_ventas.cantidad) as cantidad FROM detalle_ventas");
        return view('admin.dashboard')->with([
            'ventas' => $ventas,
            'users' => $users,
            'det_venta' => $det_venta[0]->cantidad
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(admin $admin)
    {
        //
    }

    public function usuariosShow()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');;
        }
        $users = User::all();
        return view('admin.users')->with('users', $users);
    }

    public function articulosShow()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');;
        }
        $articulos = DB::select("SELECT `articulos`.* FROM `articulos` where `articulos`.`estadoArticulo`!=0");
        return view('admin.articulos')->with('articulos', $articulos);;
    }
    public function articulosGet(){
        $articulos = DB::select("SELECT `articulos`.* FROM `articulos` where `articulos`.`estadoArticulo`!=0");
        for ($i = 0; $i < count($articulos); $i++) {
            if ($articulos[$i]->photoArticulo) {
                $articulos[$i]->photoArticulo = asset('store/' . $articulos[$i]->photoArticulo);
            }
        }
        $length = count($articulos);
        return [$articulos,$length];
    }
    public function articulosTallaShow()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');;
        }
        $articulos = DB::select("SELECT articulos.idArticulo, articulos.estadoArticulo, articulos.nombreArticulo, articulos.categoriaArticulo,(select COUNT(*) from articulo_tallas where articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) 
        as cant from articulos where articulos.estadoArticulo!=0  order by articulos.idArticulo ASC");
        $articuloTallas = DB::select("SELECT `articulo_tallas`.`idArticuloTalla`, `articulo_tallas`.`idArticuloS`, `articulo_tallas`.`idTallaS`, `articulo_tallas`.`stockArticulo`, `tallas`.`nombreTalla`
        FROM `articulo_tallas` LEFT JOIN `tallas` ON `articulo_tallas`.`idTallaS` = `tallas`.`idTalla` where 
        `articulo_tallas`.`estadoArticuloTalla`!=0");
        return view('admin.articulotalla')->with([
            'articulos' => $articulos,
            'articuloTallas' => $articuloTallas
        ]);
    }
}

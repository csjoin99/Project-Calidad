<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            if ($previousid = DB::table('articulos')->where('nombreArticulo', $request->nombreArticulo)->first()) {
                if ($archivo = $request->file('fotoArticulo')) {
                    $currentimage = DB::table('articulos')->where('idArticulo', $previousid->idArticulo)->value('photoArticulo');
                    if ($currentimage) {
                        $imgpath = public_path() . '/store/' . $currentimage;
                        if (file_exists($imgpath)) {
                            unlink($imgpath);
                        }
                    }
                    $nombreimage = $request->nombreArticulo . $request->idArticulo . ".jpg";
                    $archivo->move('store', $nombreimage);
                    DB::table('articulos')
                        ->where('idArticulo', $previousid->idArticulo)
                        ->update([
                            'nombreArticulo' => $request->nombreArticulo,
                            'categoriaArticulo' => $request->categoriaArticulo,
                            'precioArticulo' => $request->precioArticulo,
                            'generoArticulo' => $request->generoArticulo,
                            'photoArticulo' => $nombreimage,
                            'estadoArticulo' => 1
                        ]);
                } else {
                    DB::table('articulos')
                        ->where('idArticulo', $previousid->idArticulo)
                        ->update([
                            'nombreArticulo' => $request->nombreArticulo,
                            'categoriaArticulo' => $request->categoriaArticulo,
                            'precioArticulo' => $request->precioArticulo,
                            'generoArticulo' => $request->generoArticulo,
                            'estadoArticulo' => 1
                        ]);
                }
                return redirect()->route('admin.articulos')->with('success_message', 'Se agrego el articulo exitosamente');
            }
            $id = DB::table('articulos')->insertGetId(
                [
                    'nombreArticulo' => $request->nombreArticulo,
                    'categoriaArticulo' => $request->categoriaArticulo,
                    'precioArticulo' => $request->precioArticulo,
                    'generoArticulo' => $request->generoArticulo,
                    'codigoArticulo' => null
                ]
            );
            if ($id < 1000) {
                $codigo = 'PO00' . strval($id);
            } else {
                if ($id < 100) {
                    $codigo = 'PO0' . strval($id);
                } else {
                    $codigo = 'PO' . strval($id);
                }
            }
            if ($archivo = $request->file('fotoArticulo')) {
                $nombreimage = $request->nombreArticulo . $id . ".jpg";
                $archivo->move('store', $nombreimage);
            } else {
                $nombreimage = '';
            }
            DB::table('articulos')
                ->where('idArticulo', $id)
                ->update([
                    'codigoArticulo' => $codigo,
                    'photoArticulo' => $nombreimage
                ]);
            return redirect()->route('admin.articulos')->with('success_message', 'Se agrego el articulo exitosamente');
        } catch (\Throwable $th) {
            return redirect()->route('admin.articulos')->with('failure_message', 'No se pudo registrar el articulo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(articulo $articulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {
            $currentimage = DB::table('articulos')->where('idArticulo', $request->idArticulo)->value('photoArticulo');
            if ($currentimage) {
                $imgpath = public_path() . '/store/' . $currentimage;
                if ($archivo = $request->file('fotoArticulo')) {
                    if (file_exists($imgpath)) {
                        unlink($imgpath);
                    }
                    $nombreimage = $request->nombreArticulo . $request->idArticulo . ".jpg";
                    $archivo->move('store', $nombreimage);
                    DB::table('articulos')
                        ->where('idArticulo', $request->idArticulo)
                        ->update([
                            'nombreArticulo' => $request->nombreArticulo,
                            'categoriaArticulo' => $request->categoriaArticulo,
                            'precioArticulo' => $request->precioArticulo,
                            'generoArticulo' => $request->generoArticulo,
                            'photoArticulo' => $nombreimage
                        ]);
                    return redirect()->route('admin.articulos')->with('success_message', 'Se edito el articulo exitosamente');
                }
            } else {
                if ($archivo = $request->file('fotoArticulo')) {
                    $nombreimage = $request->nombreArticulo . $request->idArticulo . ".jpg";
                    $archivo->move('store', $nombreimage);
                    DB::table('articulos')
                        ->where('idArticulo', $request->idArticulo)
                        ->update([
                            'nombreArticulo' => $request->nombreArticulo,
                            'categoriaArticulo' => $request->categoriaArticulo,
                            'precioArticulo' => $request->precioArticulo,
                            'generoArticulo' => $request->generoArticulo,
                            'photoArticulo' => $nombreimage
                        ]);
                    return redirect()->route('admin.articulos')->with('success_message', 'Se edito el articulo exitosamente');
                }
            }
            DB::table('articulos')
                ->where('idArticulo', $request->idArticulo)
                ->update([
                    'nombreArticulo' => $request->nombreArticulo,
                    'categoriaArticulo' => $request->categoriaArticulo,
                    'precioArticulo' => $request->precioArticulo,
                    'generoArticulo' => $request->generoArticulo
                ]);
            return redirect()->route('admin.articulos')->with('success_message', 'Se edito el articulo exitosamente');
        } catch (\Throwable $th) {
            return redirect()->route('admin.articulos')->with('failure_message', 'No se pudo editar el articulo');;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, articulo $articulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            DB::table('articulos')
                ->where('idArticulo', $request->idArticulo)
                ->update([
                    'estadoArticulo' => 0
                ]);
            return redirect()->route('admin.articulos')->with('success_message', 'Se elimino el articulo exitosamente');
        } catch (\Throwable $th) {
            return redirect()->route('admin.articulos')->with('failure_message', 'No se pudo eliminar el articulo');;
        }
    }

    public function showProductsHombre()
    {
        if (request()->category) {
            $products = DB::select("select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
            articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) as cant 
            from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) as b where b.cant !=0 
            and generoArticulo=1 and b.categoriaArticulo=?", [request()->category]);
            return view('shop.productshombre')->with(['Titulo' => 'Artículos hombres', 'products' => $products, 'genderTitulo' => request()->category]);
        }
        $products = DB::select("select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
        articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0)
        as cant from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) as b where 
        b.cant !=0 and generoArticulo=1");

        return view('shop.productshombre')->with(['Titulo' => 'Artículos hombres', 'products' => $products, 'genderTitulo' => 'Todos']);
    }

    public function showProductsMujer()
    {
        if (request()->category) {
            $products = DB::select("select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
            articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) as cant 
            from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) as b where b.cant !=0 
            and generoArticulo=2 and b.categoriaArticulo=?", [request()->category]);
            return view('shop.productsmujer')->with(['Titulo' => 'Artículos mujeres', 'products' => $products, 'genderTitulo' => request()->category]);
        }
        $products = DB::select("select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
        articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0)
        as cant from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) as b where 
        b.cant !=0 and generoArticulo=2");

        return view('shop.productsmujer')->with(['Titulo' => 'Artículos mujeres', 'products' => $products, 'genderTitulo' => 'Todos']);
    }

    public function showProduct($nombreproducto)
    {
        $product = DB::table('articulos')->where('nombreArticulo', '=', $nombreproducto)->get();
        $tallas = DB::select("SELECT `articulo_tallas`.`idArticuloTalla`, `articulo_tallas`.`idArticuloS`, `articulo_tallas`.`idTallaS`, `articulo_tallas`.`stockArticulo`, `tallas`.`nombreTalla`
        FROM `articulo_tallas` 
            LEFT JOIN `tallas` ON `articulo_tallas`.`idTallaS` = `tallas`.`idTalla`
        WHERE articulo_tallas.estadoArticuloTalla!=0 and `articulo_tallas`.`idArticuloS`=?", [$product[0]->idArticulo]);
        $moreproducts = articulo::where('nombreArticulo', '!=', $nombreproducto)->inRandomOrder()->take(4)->get();
        foreach ($tallas as $item) {
            if ($item->stockArticulo > 0) {
                return view('shop.product')->with([
                    'Titulo' => 'Artículos',
                    'product' => $product,
                    'tallas' => $tallas,
                    'moreproducts' => $moreproducts
                ]);
            }
        }
        return view('shop.product')->with([
            'Titulo' => 'Artículos',
            'product' => $product,
            'tallas' => $tallas,
            'moreproducts' => $moreproducts,
            'empty' => 'El articulo seleccionado no cuenta con stock'
        ]);
    }
}

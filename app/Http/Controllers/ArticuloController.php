<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
    public function articulosShow()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');;
        }
        return view('admin.articulos');
    }
    public function articulosGet(Request $request){ 
        $articulos = articulo::where('estadoArticulo','!=',0)->get();
        for ($i = 0; $i < count($articulos); $i++) {
            if ($articulos[$i]->photoArticulo) {
                $articulos[$i]->photoArticulo = asset('store/' . $articulos[$i]->photoArticulo);
            }
        }
        $length = count($articulos);
        $page = ($request->page)?$request->page:1;
        $perPage = 6; 
        $offset = ($page * $perPage) - $perPage;
        $paginate = new LengthAwarePaginator(
            array_slice($articulos->toArray(),$offset,$perPage, true),
            $length,
            $perPage,
            $page
        );
        return [
            'pagination'=>$paginate,
            'length'=>$length,];
    }
    public function store(Request $request)
    {
        try {
            if ($previousarticulo = DB::table('articulos')
            ->where(['nombreArticulo' => $request->nombreArticulo,'estadoArticulo'=>0])->first()) {
                $id = $previousarticulo->idArticulo;
                DB::table('articulos')
                    ->where('idArticulo', $id)
                    ->update([
                        'nombreArticulo' => $request->nombreArticulo,
                        'categoriaArticulo' => $request->categoriaArticulo,
                        'precioArticulo' => $request->precioArticulo,
                        'generoArticulo' => $request->generoArticulo,
                        'estadoArticulo' => 1
                    ]);
            } else {
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
                DB::table('articulos')
                    ->where('idArticulo', $id)
                    ->update([
                        'codigoArticulo' => $codigo
                    ]);
            }
            if ($request->photoArticulo) {
                $currentimage = DB::table('articulos')->where('idArticulo', $id)->value('photoArticulo');
                if ($currentimage) {
                    $imgpath = public_path() . '/store/' . $currentimage;
                    if (file_exists($imgpath)) {
                        unlink($imgpath);
                    }
                }
                $exploded = explode(',', $request->photoArticulo);
                $decoded = base64_decode($exploded[1]);
                $fileName = $request->nombreArticulo . $id . '.jpg';
                $path = public_path() . '/store/' . $fileName;
                file_put_contents($path, $decoded);
                DB::table('articulos')
                    ->where('idArticulo', $id)
                    ->update([
                        'photoArticulo' => $fileName
                    ]);
            }
            return ['success' => true, 'message' => 'Se agrego el articulo exitosamente'];
        } catch (\Throwable $th) {
            return ['success' => false, 'message' => 'No se pudo agregar el articulo'];
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
    public function edit($id, Request $request)
    {
        try {
            if ($request->photoArticulo) {
                $currentimage = DB::table('articulos')->where('idArticulo', $id)->value('photoArticulo');
                if ($currentimage) {
                    $imgpath = public_path() . '/store/' . $currentimage;
                    if (file_exists($imgpath)) {
                        unlink($imgpath);
                    }
                }
                $exploded = explode(',', $request->photoArticulo);
                $decoded = base64_decode($exploded[1]);
                $fileName = $request->nombreArticulo . $id . '.jpg';
                $path = public_path() . '/store/' . $fileName;
                file_put_contents($path, $decoded);
                DB::table('articulos')
                    ->where('idArticulo', $id)
                    ->update([
                        'nombreArticulo' => $request->nombreArticulo,
                        'categoriaArticulo' => $request->categoriaArticulo,
                        'precioArticulo' => $request->precioArticulo,
                        'generoArticulo' => $request->generoArticulo,
                        'photoArticulo' => $fileName
                    ]);
            } else {
                DB::table('articulos')
                    ->where('idArticulo', $id)
                    ->update([
                        'nombreArticulo' => $request->nombreArticulo,
                        'categoriaArticulo' => $request->categoriaArticulo,
                        'precioArticulo' => $request->precioArticulo,
                        'generoArticulo' => $request->generoArticulo
                    ]);
            }
            return ['success' => true, 'message' => 'Se edito el articulo exitosamente'];
        } catch (\Throwable $th) {
            return ['success' => false, 'message' => 'No se pudo editar el articulo'];
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
    public function destroy($id)
    {
        try {
            $currentimage = DB::table('articulos')->where('idArticulo', $id)->value('photoArticulo');
            if ($currentimage) {
                $imgpath = public_path() . '/store/' . $currentimage;
                if (file_exists($imgpath)) {
                    unlink($imgpath);
                }
            }
            DB::table('articulos')
                ->where('idArticulo', $id)
                ->update([
                    'estadoArticulo' => 0,
                    'photoArticulo' => null
                ]);
            return ['success' => true, 'message' => 'Se elimino el articulo exitosamente'];
        } catch (\Throwable $th) {
            return ['success' => false, 'message' => 'No se pudo eliminar el articulo'];
        }
    }
    public function showProducts($genero)
    {
        return view('shop.productsmujer')->with(['Titulo' => 'Artículos ' . $genero, 'genderTitulo' => 'Todos', 'genero' => $genero]);
    }

    public function showProductsFilter($genero, Request $request)
    {
        if ($genero == 'mujeres') {
            $generoArticulo = 2;
        } else {
            if ($genero == 'hombres') {
                $generoArticulo = 1;
            } else {
                return redirect()->route('main');
            }
        }
        if ($request->categoria) {
            $products = DB::select("select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
            articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) as cant 
            from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) as b where b.cant !=0 
            and generoArticulo=? and categoriaArticulo=?", [$generoArticulo, $request->categoria]);
        } else {
            $products = DB::select("select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
            articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) as cant 
            from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) as b where b.cant !=0 
            and generoArticulo=?", [$generoArticulo]);
        }
        for ($i = 0; $i < count($products); $i++) {
            if ($products[$i]->photoArticulo) {
                $products[$i]->photoArticulo = asset('store/' . $products[$i]->photoArticulo);
            }
        }
        $lenght = count($products);
        return [$products, $lenght];
    }
    public function showProduct($nombreproducto)
    {
        $product = DB::table('articulos')->where('nombreArticulo', '=', $nombreproducto)->get();
        $tallas = DB::select("SELECT `articulo_tallas`.`idArticuloTalla`, `articulo_tallas`.`idArticuloS`, 
        `articulo_tallas`.`idTallaS`, `articulo_tallas`.`stockArticulo`, `tallas`.`nombreTalla`
        FROM `articulo_tallas` LEFT JOIN `tallas` ON `articulo_tallas`.`idTallaS` = `tallas`.`idTalla`
        WHERE articulo_tallas.estadoArticuloTalla!=0 and `articulo_tallas`.`idArticuloS`=?", [$product[0]->idArticulo]);
        $moreproducts = DB::select('select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
        articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) 
        as cant from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) 
        as b where b.cant !=0 ORDER BY RAND() LIMIT 4');
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

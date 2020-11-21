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
    public function articulosShow()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');;
        }
        return view('admin.articulos');
    }
    public function articulosGet(Request $request)
    {
        $articulos = articulo::where('estadoArticulo', '!=', 0)->get();
        for ($i = 0; $i < count($articulos); $i++) {
            if ($articulos[$i]->photoArticulo) {
                $articulos[$i]->photoArticulo = asset('store/' . $articulos[$i]->photoArticulo);
            }
        }
        $cantidad_articulos = count($articulos);
        $page = ($request->page) ? $request->page : 1;
        $per_page = 5;
        $offset = ($page * $per_page) - $per_page;
        $paginate = new LengthAwarePaginator(
            array_slice($articulos->toArray(), $offset, $per_page, true),
            $cantidad_articulos,
            $per_page,
            $page
        );
        return [
            'pagination' => $paginate,
            'length' => $cantidad_articulos,
        ];
    }
    public function store(Request $request)
    {
        try {
            /* Verificar si hay otro articulo con ese nombre y si este tiene el estado eliminado */
            if ($check_previous_articulo = DB::table('articulos')
                ->where(['nombreArticulo' => $request->nombreArticulo, 'estadoArticulo' => 0])->first()
            ) {
                $id = $check_previous_articulo->idArticulo;
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
                $this->destroyPhoto($id);
                $photo_name = $this->uploadPhoto($id, $request->photoArticulo);
                DB::table('articulos')
                    ->where('idArticulo', $id)
                    ->update([
                        'photoArticulo' => $photo_name
                    ]);
            }
            return ['success' => true, 'message' => 'Se agrego el articulo exitosamente'];
        } catch (\Throwable $th) {
            return ['success' => false, 'message' => 'No se pudo agregar el articulo'];
        }
    }
    public function edit($id, Request $request)
    {
        try {
            if ($request->photoArticulo) {
                $this->destroyPhoto($id);
                $photo_name = $this->uploadPhoto($id, $request->photoArticulo);
                DB::table('articulos')
                    ->where('idArticulo', $id)
                    ->update([
                        'nombreArticulo' => $request->nombreArticulo,
                        'categoriaArticulo' => $request->categoriaArticulo,
                        'precioArticulo' => $request->precioArticulo,
                        'generoArticulo' => $request->generoArticulo,
                        'photoArticulo' => $photo_name
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
            return ['success' => false, 'message' => 'No se pudo editar el articulo' . $th->getMessage()];
        }
    }
    public function destroy($id)
    {
        try {
            $this->destroyPhoto($id);
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
        return view('shop.products')->with(['Titulo' => 'Artículos ' . $genero, 'genderTitulo' => 'Todos', 'genero' => $genero]);
    }

    public function showProductsFilter($genero, Request $request)
    {
        if ($genero == 'mujeres' || $genero == 'hombres') {
            $generoArticulo = $genero == 'mujeres' ? 2 : 1;
            if ($request->categoria) {
                $articulos = DB::select("select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
                articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) as cant 
                from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) as b where b.cant !=0 
                and generoArticulo=? and categoriaArticulo=?", [$generoArticulo, $request->categoria]);
            } else {
                $articulos = DB::select("select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
                articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) as cant 
                from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) as b where b.cant !=0 
                and generoArticulo=?", [$generoArticulo]);
            }
            for ($i = 0; $i < count($articulos); $i++) {
                $articulos[$i]->photoArticulo = $articulos[$i]->photoArticulo ? asset('store/' . $articulos[$i]->photoArticulo) : $articulos[$i]->photoArticulo;
            }
            $cantidad_articulos = count($articulos);
            return [$articulos, $cantidad_articulos];
        }
        return redirect()->route('main');
    }
    public function showProduct($nombreproducto)
    {
        $product = DB::table('articulos')->where('nombreArticulo', '=', $nombreproducto)->get();
        $tallas_producto = DB::select("SELECT `articulo_tallas`.`idArticuloTalla`, `articulo_tallas`.`idArticuloS`, 
        `articulo_tallas`.`idTallaS`, `articulo_tallas`.`stockArticulo`, `tallas`.`nombreTalla`
        FROM `articulo_tallas` LEFT JOIN `tallas` ON `articulo_tallas`.`idTallaS` = `tallas`.`idTalla`
        WHERE articulo_tallas.estadoArticuloTalla!=0 and `articulo_tallas`.`idArticuloS`=?", [$product[0]->idArticulo]);
        $recomendaciones = DB::select('select * from (SELECT *,(select COUNT(*) from articulo_tallas where 
        articulo_tallas.idArticuloS=articulos.idArticulo and articulo_tallas.estadoArticuloTalla!=0) 
        as cant from articulos where articulos.estadoArticulo!=0 order by articulos.idArticulo ASC) 
        as b where b.cant !=0 ORDER BY RAND() LIMIT 4');
        $message_stock = 'El articulo seleccionado no cuenta con stock';
        foreach ($tallas_producto as $item) {
            if ($item->stockArticulo > 0) {
                $message_stock = '';
                break;
            }
        }
        return view('shop.product')->with([
            'Titulo' => 'Artículos',
            'product' => $product,
            'tallas' => $tallas_producto,
            'moreproducts' => $recomendaciones,
            'empty' => $message_stock
        ]);
    }
    private function uploadPhoto($id, $photo)
    {
        $exploded = explode(',', $photo);
        $decoded = base64_decode($exploded[1]);
        $nombre_photo = md5(openssl_random_pseudo_bytes(20)) . $id . '.jpg';
        $path = public_path() . '/store/' . $nombre_photo;
        file_put_contents($path, $decoded);
        return $nombre_photo;
    }
    private function destroyPhoto($id)
    {
        if ($check_photo_articulo = DB::table('articulos')->where('idArticulo', $id)->value('photoArticulo')) {
            $imgpath = public_path() . '/store/' . $check_photo_articulo;
            if (file_exists($imgpath)) {
                unlink($imgpath);
            }
        }
    }
}

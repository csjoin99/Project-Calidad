<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopStoreController extends Controller
{
    public function showListProducts($genero)
    {
        return view('shop.products')->with(['Titulo' => 'Artículos ' . $genero, 'genderTitulo' => 'Todos', 'genero' => $genero]);
    }

    public function FiltroProducts($genero, Request $request)
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
    public function showInfoProduct($nombreproducto)
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
}

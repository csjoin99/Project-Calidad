<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopStoreController extends Controller
{
    public function paginaPrincipal()
    {
        return view('shop.main')->with('Titulo', 'Bienvenido a Clothing and More');
    }

    public function paginaProductos($genero)
    {
        return view('shop.products')->with(['Titulo' => 'Artículos ' . $genero, 'genderTitulo' => 'Todos', 'genero' => $genero]);
    }

    public function filtroProductos($genero, Request $request)
    {
        if ($genero == 'mujeres' || $genero == 'hombres') {
            $generoArticulo = $genero == 'mujeres' ? 2 : 1;
            if ($request->categoria) {
                $articulos = DB::select("SELECT * FROM `vista_articulos_cant_tallas` WHERE cant!=0 
                and generoArticulo=? and categoriaArticulo=?", [$generoArticulo, $request->categoria]);
            } else {
                $articulos = DB::select("SELECT * FROM `vista_articulos_cant_tallas` WHERE cant!=0 
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
    public function informacionProducto($nombreproducto)
    {
        $product = DB::table('articulos')->where('nombreArticulo', '=', $nombreproducto)->get();
        $tallas_producto = DB::select("SELECT * FROM vista_tallas_articulos WHERE idArticuloS=?", [$product[0]->idArticulo]);
        $recomendaciones = DB::select('SELECT * FROM vista_recomendaciones');
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

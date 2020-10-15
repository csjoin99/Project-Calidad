<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use App\Models\talla;
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
        //
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
    public function edit(articulo $articulo)
    {
        //
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
    public function destroy(articulo $articulo)
    {
        //
    }

    public function showstore()
    {
        $products = articulo::all();
        return view('shop.products')->with(['Titulo' => 'Artículos', 'products' => $products]);
    }

    public function showproduct($nombreproducto)
    {

        $product = DB::table('articulos')->where('nombreArticulo', '=', $nombreproducto)->get();
        $tallas = DB::select("SELECT `articulo_tallas`.`idArticuloTalla`, `articulo_tallas`.`idArticuloS`, `articulo_tallas`.`idTallaS`, `articulo_tallas`.`stockArticulo`, `tallas`.`nombreTalla`
        FROM `articulo_tallas` 
            LEFT JOIN `tallas` ON `articulo_tallas`.`idTallaS` = `tallas`.`idTalla`
        WHERE `articulo_tallas`.`idArticuloS`=?", [$product[0]->idArticulo]);
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
            'empty'=> 'El articulo seleccionado no cuenta con stock'
        ]);
    }
}

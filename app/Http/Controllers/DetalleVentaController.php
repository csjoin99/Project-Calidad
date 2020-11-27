<?php

namespace App\Http\Controllers;

use App\Models\detalle_venta;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleVentaController extends Controller
{
    public function insertDetalleVentas($ventaid)
    {
        foreach (Cart::content() as $item) {
            DB::table('detalle_ventas')->insert(
                [
                    'idVentaD' => $ventaid,
                    'idArticuloTallaD' => $item->id,
                    'cantidad' => $item->qty,
                    'precioVentaD' => $item->price
                ]
            );
        }
    }
}

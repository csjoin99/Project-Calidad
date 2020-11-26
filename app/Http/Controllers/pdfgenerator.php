<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PDFgenerator extends Controller
{
    public function index($clienteid, $ventaid)
    {
        $cliente = DB::table('users')->where('id', $clienteid)->get();
        $venta = DB::table('ventas')->where('idVenta', $ventaid)->get();
        $nombre_cliente = $venta[0]->customerVenta;
        $email_cliente = $cliente[0]->email;
        $nro_factura = $venta[0]->serieComprobanteVenta." ".$venta[0]->numComprobanteVenta ;
        $fecha_factura = $venta[0]->fechaVenta;
        $direccion_venta = $venta[0]->direccionVenta;
        $distrito_venta = $venta[0]->distritoVenta;
        $igv = number_format((Cart::Total()/1.18*0.18), 2);
        $subtotal = number_format((Cart::Total()/1.18), 2);
        $pdf = App::make('dompdf.wrapper');
        $output =
            "
        <!doctype html>
            <html>
                <head>
                    <meta charset='utf-8'>
                    <title>A simple, clean, and responsive HTML invoice template</title>
                    <style>
                        .invoice-box {
                            max-width: 800px;
                            margin: auto;
                            padding: 30px;
                            border: 1px solid #eee;
                            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
                            font-size: 16px;
                            line-height: 24px;
                            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                            color: #555;
                        }
                
                        .invoice-box table {
                            width: 100%;
                            line-height: inherit;
                            text-align: left;
                        }
                        
                        .invoice-box table td {
                            padding: 5px;
                            vertical-align: top;
                        }
                        
                        .invoice-box table tr td:nth-child(2) {
                            text-align: right;
                        }
                        .temp-right{
                            text-align: right;
                        }
                        .invoice-box table tr.top table td {
                            padding-bottom: 20px;
                        }
                        
                        .invoice-box table tr.top table td.title {
                            font-size: 45px;
                            line-height: 45px;
                            color: #333;
                        }
                        
                        .invoice-box table tr.information table td {
                            padding-bottom: 40px;
                        }
                        
                        .invoice-box table tr.heading td {
                            background: #eee;
                            border-bottom: 1px solid #ddd;
                            font-weight: bold;
                        }
                        
                        .invoice-box table tr.details td {
                            padding-bottom: 20px;
                        }
                        
                        .invoice-box table tr.item td{
                            border-bottom: 1px solid #eee;
                        }
                        
                        .invoice-box table tr.item.last td {
                            border-bottom: none;
                        }
                        
                        .invoice-box table tr.total td:nth-child(2) {
                            border-top: 2px solid #eee;
                            font-weight: bold;
                        }
                        
                        @media only screen and (max-width: 600px) {
                            .invoice-box table tr.top table td {
                                width: 100%;
                                display: block;
                                text-align: center;
                            }
                            
                            .invoice-box table tr.information table td {
                                width: 100%;
                                display: block;
                                text-align: center;
                            }
                        }
                    
                        /** RTL **/
                        .rtl {
                            direction: rtl;
                            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                        }
                        
                        .rtl table {
                            text-align: right;
                        }
                        
                        .rtl table tr td:nth-child(2) {
                            text-align: left;
                        }
                    </style>
                </head>
        <body>
            <div class='invoice-box'>
                <table cellpadding='0' cellspacing='0'>
                    <tr class='top'>
                        <td colspan='4'>
                            <table>
                                <tr>
                                    <td class='title'>
                                        <h5 style='color: #565757'>Clothing and More</h5>
                                </td>  
                                <td>
                                    Factura: $nro_factura<br>
                                    Creado: $fecha_factura<br>
                                </td>
                    </tr>
                </table>
                        </td>
                    </tr>
                    <tr class='information'>
                        <td colspan='4'>
                            <table>
                                <tr>
                                    <td>
                                        Av Milagros de Jesus <br>
                                        3ra zn de Collique<br>
                                    </td>
                                    <td>
                                        $direccion_venta $distrito_venta<br>
                                        $nombre_cliente<br>
                                        $email_cliente
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
            
           
                    <tr class='heading'>
                        <td>
                            Articulo
                        </td>
                        <td>
                            Cantidad
                        </td>
                        <td class='temp-right'>
                            Precio
                        </td>
                        <td class='temp-right'>
                            Importe
                        </td>
                    </tr>
                    ";
                    foreach (Cart::content() as $item) {
                    $importe=$item->qty*$item->price;
                    $output .=
                    "
                            <tr class='item'>
                                <td>
                                $item->name
                                </td>
                                <td>
                                $item->qty
                                </td>
                                <td class='temp-right'>
                                $item->price
                                </td>
                                <td class='temp-right'>
                                $importe
                                </td>
                            </tr>";
                    }
                    $totalCarro = Cart::total();
                    $output .=
            "
                    <tr class='item'>
                        <td></td>
                        <td></td>
                        <td class='temp-right'>Subtotal: S/. </td>
                        <td class='temp-right'>
                            $subtotal
                        </td>
                    </tr>
                    <tr class='item'>
                        <td></td>
                        <td></td>
                        <td class='temp-right'>Impuesto: S/. </td>
                        <td class='temp-right'>
                            $igv
                        </td>
                    </tr>
                    <tr class='item'>
                        <td></td>
                        <td></td>
                        <td class='temp-right'>Total: S/. </td>
                        <td class='temp-right'>
                            $totalCarro
                        </td>
                    </tr>
                </table>
            </div>
        </body>
    </html>";
    $pdfdoc = $pdf->loadHTML($output);
    return $pdfdoc;
    }
}


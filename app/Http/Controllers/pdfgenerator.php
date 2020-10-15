<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class pdfgenerator extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($clienteid, $ventaid)
    {
        $cliente = DB::table('users')->where('id', $clienteid)->get();
        $venta = DB::table('ventas')->where('idVenta', $ventaid)->get();

        $nombreCliente = $venta[0]->customerVenta;
        $emailCliente = $cliente[0]->email;

        $nroFactura = $venta[0]->serieComprobanteVenta." ".$venta[0]->numComprobanteVenta ;
        $fechaFactura = $venta[0]->fechaVenta;
        $direccionVenta = $venta[0]->direccionVenta;
        $distritoVenta = $venta[0]->distritoVenta;

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
                        <td colspan='2'>
                <table>
                    <tr>
                        <td class='title'>
                            <h5 style='color: #565757'>Clothing and More</h5>
                        </td>
                            
                        <td>
                            Factura: $nroFactura<br>
                            Creado: $fechaFactura<br>
                        </td>
                    </tr>
                </table>
                        </td>
                    </tr>
            
                    <tr class='information'>
                        <td colspan='2'>
                            <table>
                                <tr>
                                    <td>
                                        Av Milagros de Jesus <br>
                                        3ra zn de Collique<br>
                                    </td>
                            
                                    <td>
                                        $direccionVenta $distritoVenta<br>
                                        $nombreCliente<br>
                                        $emailCliente
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
            
           
                    <tr class='heading'>
                        <td>
                            Item
                        </td>
                
                        <td>
                            Price
                        </td>
                    </tr>
                    ";
                    foreach (Cart::content() as $item) {
            $output .=
                    "
                            <tr class='item'>
                                <td>
                                $item->name
                                </td>
                                
                                <td>
                                $item->price
                                </td>
                            </tr>";
                    }
                    $totalCarro = Cart::total();
                    $taxCarro = Cart::tax();
            $output .=
            "
                    <tr class='total'>
                        <td></td>
                        <td>
                            Impuesto: S/. $taxCarro
                        </td>
                    </tr>
                    <tr class='total'>
                        <td></td>
                        <td>
                            Total: S/. $totalCarro
                        </td>
                    </tr>
                </table>
            </div>
        </body>
    </html>";

    $pdfdoc = $pdf->loadHTML($output);

    return $pdfdoc;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

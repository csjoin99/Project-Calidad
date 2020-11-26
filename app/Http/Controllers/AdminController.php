<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboardAdmin()
    {
        if (!Auth::guard('admin')->check()) {

            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');
        }
        $ventas = venta::count();
        $users = User::count();
        $productos_vendidos = DB::select("SELECT sum(detalle_ventas.cantidad) as cantidad FROM detalle_ventas");
        return view('admin.dashboard')->with([
            'ventas' => $ventas,
            'users' => $users,
            'det_venta' => $productos_vendidos[0]->cantidad
        ]);
    }
    public function listaUsuarios()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');;
        }
        $users = User::all();
        return view('admin.users')->with('users', $users);
    }
}

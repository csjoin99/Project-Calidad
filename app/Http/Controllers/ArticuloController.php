<?php

namespace App\Http\Controllers;

use App\Models\articulo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{
    public function vistaArticulos()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login.admin')->withErrors('Debes iniciar sesión para acceder');;
        }
        return view('admin.articulos');
    }
    public function listaArticulos(Request $request)
    {
        $articulos = articulo::where('estadoArticulo', '!=', 0)->get();
        for ($i = 0; $i < count($articulos); $i++) {
            if ($articulos[$i]->photoArticulo) {
                $articulos[$i]->photoArticulo = asset('store/' . $articulos[$i]->photoArticulo);
            }
        }
        $cantidad_articulos = count($articulos);
        $per_page = 5;
        $page = ($request->page) ? $request->page : 1;
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
            'test' => $paginate->currentPage()
        ];
    }
    public function insertArticulos(Request $request)
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
                $this->deletePhoto($id);
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
    public function editArticulos($id, Request $request)
    {
        try {
            if ($request->photoArticulo) {
                $this->deletePhoto($id);
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
    public function destroyArticulos($id)
    {
        try {
            $this->deletePhoto($id);
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
    private function uploadPhoto($id, $photo)
    {
        $exploded = explode(',', $photo);
        $decoded = base64_decode($exploded[1]);
        $nombre_photo = md5(openssl_random_pseudo_bytes(20)) . $id . '.jpg';
        $path = public_path() . '/store/' . $nombre_photo;
        file_put_contents($path, $decoded);
        return $nombre_photo;
    }
    private function deletePhoto($id)
    {
        if ($check_photo_articulo = DB::table('articulos')->where('idArticulo', $id)->value('photoArticulo')) {
            $imgpath = public_path() . '/store/' . $check_photo_articulo;
            if (file_exists($imgpath)) {
                unlink($imgpath);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\articulo_talla;
use Illuminate\Database\Seeder;

class seedArticuloTalla extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        articulo_talla::create([
            'idArticuloS' => 1,
            'idTallaS' => 1,
            'stockArticulo' => 10,
        ]);
        articulo_talla::create([
            'idArticuloS' => 1,
            'idTallaS' => 2,
            'stockArticulo' => 10,
        ]);
        articulo_talla::create([
            'idArticuloS' => 1,
            'idTallaS' => 3,
            'stockArticulo' => 10,
        ]);
        articulo_talla::create([
            'idArticuloS' => 1,
            'idTallaS' => 4,
        ]);
        articulo_talla::create([
            'idArticuloS' => 2,
            'idTallaS' => 1,
            'stockArticulo' => 10,
        ]);
        articulo_talla::create([
            'idArticuloS' => 2,
            'idTallaS' => 3,
            'stockArticulo' => 10,
        ]);
        articulo_talla::create([
            'idArticuloS' => 2,
            'idTallaS' => 4,
        ]);
        articulo_talla::create([
            'idArticuloS' => 3,
            'idTallaS' => 2,
        ]);
        articulo_talla::create([
            'idArticuloS' => 3,
            'idTallaS' => 5,
            'stockArticulo' => 10,
        ]);
        articulo_talla::create([
            'idArticuloS' => 3,
            'idTallaS' => 6,
            'stockArticulo' => 10,
        ]);
        articulo_talla::create([
            'idArticuloS' => 3,
            'idTallaS' => 7,
        ]);
        articulo_talla::create([
            'idArticuloS' => 4,
            'idTallaS' => 5,
            'stockArticulo' => 10,
        ]);
        articulo_talla::create([
            'idArticuloS' => 4,
            'idTallaS' => 6,
            'stockArticulo' => 10,
        ]);
    }
}

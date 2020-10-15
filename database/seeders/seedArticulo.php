<?php

namespace Database\Seeders;

use App\Models\articulo;
use Illuminate\Database\Seeder;

class seedArticulo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        articulo::create([
            'codigoArticulo'=>'PO001',
            'nombreArticulo'=>'Vaqueros azules',
            'categoriaArticulo'=>'Jean',
            'precioArticulo'=>20.00,
            'generoArticulo'=>1
        ]);
        articulo::create([
            'codigoArticulo'=>'PO002',
            'nombreArticulo'=>'Pantalon Jean',
            'categoriaArticulo'=>'Jean',
            'precioArticulo'=>25.00,
            'generoArticulo'=>1
        ]);
        articulo::create([
            'codigoArticulo'=>'PO003',
            'nombreArticulo'=>'Pantalon Jean Slim Azul',
            'categoriaArticulo'=>'Jean',
            'precioArticulo'=>30.00,
            'generoArticulo'=>2
        ]);
        articulo::create([
            'codigoArticulo'=>'PO004',
            'nombreArticulo'=>'Pantalon Nozomi',
            'categoriaArticulo'=>'Short',
            'precioArticulo'=>45.00,
            'generoArticulo'=>2
        ]);
    }
}

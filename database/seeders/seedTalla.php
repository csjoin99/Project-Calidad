<?php

namespace Database\Seeders;

use App\Models\talla as ModelsTalla;
use Illuminate\Database\Seeder;
use Talla;

class seedTalla extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsTalla::create([
            'nombreTalla' => '26'
        ]);
        ModelsTalla::create([
            'nombreTalla' => '28'
        ]);
        ModelsTalla::create([
            'nombreTalla' => '30'
        ]);
        ModelsTalla::create([
            'nombreTalla' => '32'
        ]);
        ModelsTalla::create([
            'nombreTalla' => '34'
        ]);
        ModelsTalla::create([
            'nombreTalla' => '36'
        ]);
        ModelsTalla::create([
            'nombreTalla' => '38'
        ]);
    }
}

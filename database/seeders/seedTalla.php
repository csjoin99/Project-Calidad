<?php

namespace Database\Seeders;

use App\Models\talla;
use Illuminate\Database\Seeder;

class seedTalla extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        talla::create([
            'nombreTalla' => '26',
            'categoriaTalla' => 'Jean'
        ]);
        talla::create([
            'nombreTalla' => '28',
            'categoriaTalla' => 'Jean'
        ]);
        talla::create([
            'nombreTalla' => '30',
            'categoriaTalla' => 'Jean'
        ]);
        talla::create([
            'nombreTalla' => '32',
            'categoriaTalla' => 'Jean'
        ]);
        talla::create([
            'nombreTalla' => '34',
            'categoriaTalla' => 'Jean'
        ]);
        talla::create([
            'nombreTalla' => '36',
            'categoriaTalla' => 'Jean'
        ]);
        talla::create([
            'nombreTalla' => '38',
            'categoriaTalla' => 'Jean'
        ]);
        talla::create([
            'nombreTalla' => 'XS',
            'categoriaTalla' => 'Casaca'
        ]);
        talla::create([
            'nombreTalla' => 'S',
            'categoriaTalla' => 'Casaca'
        ]);
        talla::create([
            'nombreTalla' => 'M',
            'categoriaTalla' => 'Casaca'
        ]);
        talla::create([
            'nombreTalla' => 'L',
            'categoriaTalla' => 'Casaca'
        ]);
        talla::create([
            'nombreTalla' => 'XL',
            'categoriaTalla' => 'Casaca'
        ]);
    }
}

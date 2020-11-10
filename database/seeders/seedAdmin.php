<?php

namespace Database\Seeders;

use App\Models\admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class seedAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        admin::create([
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'telefono' => '123456789',
            'email' => 'admin@admin.com',
            'password' => Hash::make('curo_99_1')
        ]);
    }
}

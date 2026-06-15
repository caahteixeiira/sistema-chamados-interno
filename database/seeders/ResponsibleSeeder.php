<?php

namespace Database\Seeders;

use App\Models\Responsible;
use Illuminate\Database\Seeder;

class ResponsibleSeeder extends Seeder
{
    public function run(): void
    {
        Responsible::create([
            'name' => 'Ana Suporte',
            'email' => 'ana@empresa.com',
        ]);

        Responsible::create([
            'name' => 'Bruno TI',
            'email' => 'bruno@empresa.com',
        ]);

        Responsible::create([
            'name' => 'Carla Administrativo',
            'email' => 'carla@empresa.com',
        ]);
    }
}
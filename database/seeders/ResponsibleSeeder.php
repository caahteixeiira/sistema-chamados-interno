<?php

namespace Database\Seeders;

use App\Models\Responsible;
use Illuminate\Database\Seeder;

class ResponsibleSeeder extends Seeder
{
    public function run(): void
    {
        Responsible::updateOrCreate(
            ['name' => 'Ana Suporte'],
            ['email' => 'ana@empresa.com']
            
        );

        Responsible::updateOrCreate(
            ['name' => 'Bruno TI'],
            ['email' => 'bruno@empresa.com']
            
        );

        Responsible::updateOrCreate(
            ['name' => 'Carla Administrativo'],   
            ['email' => 'carla@empresa.com']
            
        );

    /* //Descomente para criar um responsável aleatório usando a factory
        Responsible::updateOrCreate(
            ['name' => 'Novo Responsável'],
            ['email' => 'novo@empresa.com']
            
        );
        */
    }
}
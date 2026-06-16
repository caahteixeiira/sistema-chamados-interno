<?php

namespace Database\Seeders;

use Database\Seeders\ResponsibleSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $this->call(ResponsibleSeeder::class);
    }
}
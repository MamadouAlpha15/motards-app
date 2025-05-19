<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Commune;

class CommuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //use App\Models\Commune;

$communes = [
    ['nom' => 'Dubreka', 'slug' => 'dubreka'],
    ['nom' => 'Coyah', 'slug' => 'coyah'],
    ['nom' => 'Kaloum', 'slug' => 'kaloum'],
    ['nom' => 'Boké', 'slug' => 'boke'],
    ['nom' => 'Labé', 'slug' => 'labe'],
    ['nom' => 'Mamou', 'slug' => 'mamou'],
    ['nom' => 'Kankan', 'slug' => 'kankan'],
    ['nom' => 'Siguiri', 'slug' => 'siguiri'],
    ['nom' => 'Kissidougou', 'slug' => 'kissidougou'],
    ['nom' => 'Nzérékoré', 'slug' => 'nzerekore'],
    ['nom' => 'Faranah', 'slug' => 'faranah'],
    ['nom' => 'Koubia', 'slug' => 'koubia'],
    ['nom' => 'Gaoual', 'slug' => 'gaoual'],
    ['nom' => 'Pita', 'slug' => 'pita'],
];

foreach ($communes as $commune) {
    Commune::create($commune);
}

    }
}

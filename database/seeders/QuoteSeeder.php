<?php

namespace Database\Seeders;

use App\Models\Quote;
//use App\Models\User;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quote::factory()->create([
            'content_text' => 'hada hada hada',
            'source' => 'ktab jdid',
            'user_id' => 1,
            'nombre_mots'=>3,
            'nombre_vues'=>0,
            'auteur'=>'ilyass',
        ]);

        Quote::factory()->create([
            'content_text' => 'ktab ktab kjjh',
            'source' => 'ktab 9dim',
            'user_id' => 2,
            'nombre_mots'=>3,
            'nombre_vues'=>0,
            'auteur'=>'ayman',
        ]);
    }
}

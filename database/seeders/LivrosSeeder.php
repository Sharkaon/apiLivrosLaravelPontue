<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LivrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insere livros e enciclopédias aleatórios
        DB::table('livros')->insert([
            'titulo' => Str::random(15),
            'autor' => Str::random(10),
            'editora' => Str::random(10),
            'data_publi' => '2020-02-02'
        ]);

        DB::table('enciclopedias')->insert([
            'edicao' => Str::random(15),
            'editora' => Str::random(10),
            'data_publi' => '2020-01-01'
        ]);
    }
}

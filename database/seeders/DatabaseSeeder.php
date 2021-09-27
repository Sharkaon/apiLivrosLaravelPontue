<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enciclopedia;
use App\Models\Livro;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Chamar 9 vezes o Seeder do projeto para popular o banco pra testes
        for($i=0; $i<9; $i++){
            $this->call([
                LivrosSeeder::class
            ]);
        }
        $this->call([
            UserSeeder::class
        ]);
    }
}

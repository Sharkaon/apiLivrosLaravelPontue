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

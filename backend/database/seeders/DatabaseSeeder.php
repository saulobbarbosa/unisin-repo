<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UsuarioSeeder::class,
        ]);

        $this->call([
            EscolasSeeder::class,
        ]);

        $this->call([
        AlunosSeeder::class,
        ]);

        $this->call([
        ProfessorSeeder::class,
        ]);

        $this->call([
        NiveisEnsinoSeeder::class,
        ]);

        $this->call([
        ModulosEnsinoSeeder::class,
        ]);

        $this->call([
        AlunosHasModulosEnsinoSeeder::class,
        ]);

        $this->call([
        AmigosSeeder::class,
        ]);

        $this->call([
        ConteudosSeeder::class,
        ]);

        $this->call([
        AlunosHasConteudosSeeder::class,
        ]);

        $this->call([
        AtividadesSeeder::class,
        ]);

        $this->call([
        ConquistasSeeder::class,
        ]);

        $this->call([
        AlunosHasConquistasSeeder::class,
        ]);

        $this->call([
        ItensLojaSeeder::class,
        ]);

        $this->call([
        AlunosHasItensLojaSeeder::class,
        ]);





        

    }
}

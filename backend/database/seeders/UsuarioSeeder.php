<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::create([
            'nome' => 'Alice Silva',
            'dt_nasc' => '1990-05-15',
            'email' => 'alice@exemplo.com',
            'senha' => Hash::make('senha123'),
        ]);

        Usuario::create([
            'nome' => 'Bruno Costa',
            'dt_nasc' => '1988-11-23',
            'email' => 'bruno@exemplo.com',
            'senha' => Hash::make('outrasenha'),
        ]);
    }
}

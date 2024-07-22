<?php

namespace Database\Seeders;

use App\Models\Endereco;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Endereco::where('name', 'casa')->first()) {
            Endereco::create([
                'id' => 1,
                'user_id' => 1,
                'name' => 'Home',
                'cep' => 89900000,
                'rua' => 'Avenida Getulio Vargas',
                'numero' => 400,
                'complemento' => 'Complemento'
            ]);
        }
    }
}

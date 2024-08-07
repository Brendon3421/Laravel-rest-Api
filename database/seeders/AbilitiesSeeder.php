<?php

namespace Database\Seeders;

use App\Models\Abilities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Abilities::where('name', 'criar_user')->first()) {
            Abilities::create([
                'id' => 1,
                'name' => "criar_user"
            ]);
        }
        if (!Abilities::where('name', 'editar_user')->first()) {
            Abilities::create([
                'id' => 2,
                'name' => "editar_user"
            ]);
        }
        if (!Abilities::where('name', 'listar_user')->first()) {
            Abilities::create([
                'id' => 3,
                'name' => "listar_user"
            ]);
        }
        if (!Abilities::where('name', 'listar_user_id')->first()) {
            Abilities::create([
                'id' => 4,
                'name' => "listar_user_id"
            ]);
        }
        if (!Abilities::where('name', 'delete_post')->first()) {
            Abilities::create([
                'id' => 5,
                'name' => "delete_post"
            ]);
        }
    }
}

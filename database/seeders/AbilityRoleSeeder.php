<?php

namespace Database\Seeders;

use App\Models\AbilityRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbilityRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!AbilityRole::where("role_id", 2)->where('ability_id', 1)->first()) {
            AbilityRole::create([
                "id" => 1,
                "role_id" => 2,
                "ability_id" => 1,
            ]);
        }
        if (!AbilityRole::where("role_id", 2)->where('ability_id', 2)->first()) {
            AbilityRole::create([
                "id" => 2,
                "role_id" => 2,
                "ability_id" => 2,
            ]);
        }
        if (!AbilityRole::where("role_id", 2)->where('ability_id', 3)->first()) {
            AbilityRole::create([
                "id" => 3,
                "role_id" => 2,
                "ability_id" => 3,
            ]);
            if (!AbilityRole::where("role_id", 2)->where('ability_id', 4)->first()) {
                AbilityRole::create([
                    "id" => 4,
                    "role_id" => 2,
                    "ability_id" => 4,
                ]);
                if (!AbilityRole::where("role_id", 2)->where('ability_id', 5)->first()) {
                    AbilityRole::create([
                        "id" => 5,
                        "role_id" => 2,
                        "ability_id" => 5,
                    ]);
                }
            }
        }
    }
}

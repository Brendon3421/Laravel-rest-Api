<?php

namespace Database\Seeders;

use App\Models\AbilityUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbilityUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!AbilityUser::where('user_id', 1)->where('ability_id', 1)) {
            AbilityUser::create([
                'id' => 1,
                'user_id' => 1,
                'ability_id' => 1,
            ]);
        }
        if (!AbilityUser::where('user_id', 1)->where('ability_id', 2)) {
            AbilityUser::create([
                'id' => 1,
                'user_id' => 1,
                'ability_id' => 2,
            ]);
        }
        if (!AbilityUser::where('user_id', 1)->where('ability_id', 3)) {
            AbilityUser::create([
                'id' => 1,
                'user_id' => 1,
                'ability_id' => 3,
            ]);
        }
        if (!AbilityUser::where('user_id', 1)->where('ability_id', 4)) {
            AbilityUser::create([
                'id' => 1,
                'user_id' => 1,
                'ability_id' => 4,
            ]);
        }
        if (!AbilityUser::where('user_id', 1)->where('ability_id', 5)) {
            AbilityUser::create([
                'id' => 1,
                'user_id' => 1,
                'ability_id' => 5,
            ]);
        }
    }
}

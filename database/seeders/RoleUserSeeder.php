<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!RoleUser::create('role_id',1)->where('user_id',1)){
            RoleUser::create([
                'id' => 1,
                'role_id' => 1,
                'user_id' => 1
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      if(!User::where('email', 'brendon@cooperoestesc.com.br')->first()){
        User::create([
            'name' => 'Brendon',
            'email' => 'brendon@cooperostesc.com.br',
            'password'  => Hash::make('terra02', ['rounds'=> 12]),
            'genero_id' => 2
        ]);
      }
    }
}

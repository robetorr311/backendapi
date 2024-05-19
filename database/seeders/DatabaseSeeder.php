<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comun.users')->insert(['nombre' => 'Robert','login' => 'robetorr99','email' => 'robetorr9962@gmail.com','password' => Hash::make('rt988311')]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DifficultiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('difficulties')->truncate();

        DB::table( 'difficulties')->insert([
            'name' => 'facile',
            'level' => '1'
        ]);

        DB::table('difficulties')->insert([
            'name' => 'normal',
            'level' => '2'
        ]);

        DB::table('difficulties')->insert([
            'name' => 'moyen',
            'level' => '3'
        ]);

        DB::table('difficulties')->insert([
            'name' => 'difficile',
            'level' => '4'
        ]);

        DB::table('difficulties')->insert([
            'name' => 'élite',
            'level' => '5'
        ]);
    }
}

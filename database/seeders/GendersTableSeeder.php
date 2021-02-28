<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->truncate();

        DB::table('genders')->insert([
            'shortname' => 'f',
            'name' => 'Femme'
        ]);

        DB::table('genders')->insert([
            'shortname' => 'h',
            'name' => 'Homme'
        ]);
    }
}

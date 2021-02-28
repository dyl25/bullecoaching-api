<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events_type')->truncate();

        DB::table('events_type')->insert([
            'name' => 'Compétition'
        ]);

        DB::table('events_type')->insert([
            'name' => 'Entraînement'
        ]);
    }
}

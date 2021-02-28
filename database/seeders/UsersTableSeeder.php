<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'role_id' => 3,
            'gender_id' => 2,
            "name" => "Vansteenacker",
            'firstname' => "Dylan",
            "email" => "dylan-vst@hotmail.com",
            "password" => Hash::make("AqsPml2012"),
            'birthdate' => new \DateTime('1995-12-22'),
            "created_at" => new \DateTime(),
            "active" => 1
        ]);

        DB::table('users')->insert([
            'role_id' => 2,
            'gender_id' => 2,
            "name" => "Pieters",
            'firstname' => "Julien",
            "email" => "julien.pts@bullecoaching.be",
            "password" => Hash::make("AqsPml2012"),
            'birthdate' => new \DateTime('1999-07-07'),
            "created_at" => new \DateTime(),
            "active" => 1
        ]);
    }
}

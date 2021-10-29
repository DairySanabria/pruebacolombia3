<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'name' => 'admin',
            'lastname' => 'admin',
            'national_identity_document' => '1234567',
            'email' => 'admin@app.com',
            'country' => 'Lima',
            'address' => 'Avenida Mateo Pumacahua',
            'mobile' => 981777670,
            'password' => Hash::make('123456789'),

            'category_id' => 3
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('staff')->insert([
            'nama' => 'Leonardo Wijaya',
            'email' => 'admin001@admin.com',
            'jobDesc' => 'Admin',
            'password' => Hash::make('admin001'),
            'gender' => 'L',
            'phone' => '081330229959'
        ]);

        DB::table('staff')->insert([
            'nama' => 'Ian Putra Ismaya',
            'email' => 'admin002@admin.com',
            'jobDesc' => 'Admin',
            'password' => Hash::make('admin002'),
            'gender' => 'L',
        ]);

        DB::table('staff')->insert([
            'nama' => 'Ian Putra Ismaya',
            'email' => 'admin003@admin.com',
            'jobDesc' => 'Admin',
            'password' => Hash::make('admin003'),
            'gender' => 'L',
        ]);
    }
}

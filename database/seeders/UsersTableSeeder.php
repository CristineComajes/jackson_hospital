<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Juan Dela Cruz',
                'email' => 'admin@example.com',
                'username' => 'adminuser',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Maria Santos',
                'email' => 'doctor@example.com',
                'username' => 'doctoruser',
                'password' => Hash::make('password123'),
                'role' => 'doctor',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pedro Reyes',
                'email' => 'patient@example.com',
                'username' => 'patientuser',
                'password' => Hash::make('password123'),
                'role' => 'patient',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Anna Cruz',
                'email' => 'pharmacist@example.com',
                'username' => 'pharmacistuser',
                'password' => Hash::make('password123'),
                'role' => 'pharmacist',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Luis Garcia',
                'email' => 'frontdesk@example.com',
                'username' => 'frontdeskuser',
                'password' => Hash::make('password123'),
                'role' => 'frontdesk',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

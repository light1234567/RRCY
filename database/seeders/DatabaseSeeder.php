<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'fname' => 'Michael ',
            'lname' => 'Entero',
            'middlename' => 'Estorgio',
            'email' => 'raborden02372@usep.edu.ph',
            'role' => 'admin',
            'status' => 'v',
            'password' => Hash::make('12345678'),

        ]);
    }
}

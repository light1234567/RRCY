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
            'email' => 'michaelentero123@gmail.com',
            'role' => 'admin',
            'status' => 'v',
            'password' => Hash::make('kel12345'),

        ]);
    }
}

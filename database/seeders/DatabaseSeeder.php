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
            'fname' => 'Rowel ',
            'lname' => 'Borden',
            'middlename' => 'Antonio',
            'email' => 'jasperellaga12345@gmail.com',
            'role' => 'admin',
            'status' => 'verified',
            'password' => Hash::make('12345678'),

        ]);
    }
}

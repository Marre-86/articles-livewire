<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $admin = User::create([
            'name' => 'Robb Jones',
            'email' => 'a@a',
            'password' => Hash::make('a'),
            'password_not_hashed' => 'a',
        ]);

        $admin->assignRole('Admin');

        $user = User::create([
            'name' => 'John Persimonn',
            'email' => 's@s',
            'password' => Hash::make('s'),
            'password_not_hashed' => 's',
        ]);

        $user->assignRole('User');
    }
}
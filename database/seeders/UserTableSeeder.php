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

        User::create([
            'name' => 'Robb Jones',
            'email' => 'a@a',
            'password' => Hash::make('a'),
            'password_not_hashed' => 'a',
        ]);

        User::create([
            'name' => 'John Persimonn',
            'email' => 's@s',
            'password' => Hash::make('s'),
            'password_not_hashed' => 's',
        ]);

        $admin = User::where('name', 'Robb Jones')->first();
        $admin->assignRole('Admin');

        $user = User::where('name', 'John Persimonn')->first();
        $user->assignRole('User');
    }
}
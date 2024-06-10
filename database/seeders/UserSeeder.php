<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'photo' => '',
            'name' => 'Dev',
            'username' => 'dev',
            'email' => 'dev@email.com',
            'phone' => '081234567890',
            'address' => 'Jl. Developer',
            'password' => Hash::make('1'),
        ])->assignRole('developer');

        User::create([
            'photo' => '',
            'name' => 'Super Admin',
            'username' => 'sa',
            'email' => 'super@email.com',
            'phone' => '081234567891',
            'address' => 'Jl. Super Admin',
            'password' => Hash::make('1'),
        ])->assignRole('super-admin');

        // User::create([
        //     'photo' => '',
        //     'name' => 'Admin',
        //     'username' => 'admin',
        //     'email' => 'admin@email.com',
        //     'phone' => '081234567892',
        //     'address' => 'Jl. Admin',
        //     'password' => Hash::make('1'),
        //     'store_id' => 1,
        // ])->assignRole('admin');
    }
}

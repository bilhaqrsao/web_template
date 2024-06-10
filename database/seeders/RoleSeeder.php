<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::withoutEvents(fn () => Role::create(['name' => 'developer']));
        Role::withoutEvents(fn () => Role::create(['name' => 'super-admin']));
        Role::withoutEvents(fn () => Role::create(['name' => 'admin']));
        Role::withoutEvents(fn () => Role::create(['name' => 'user']));
    }
}

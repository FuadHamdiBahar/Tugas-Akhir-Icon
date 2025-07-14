<?php

namespace Database\Seeders;

use App\Models\RoleMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleMenu::create([
            'role' => 'superadmin',
            'mid' => 1
        ]);
        RoleMenu::create([
            'role' => 'superadmin',
            'mid' => 2
        ]);
        RoleMenu::create([
            'role' => 'superadmin',
            'mid' => 3
        ]);
        RoleMenu::create([
            'role' => 'superadmin',
            'mid' => 4
        ]);
        RoleMenu::create([
            'role' => 'superadmin',
            'mid' => 5
        ]);
    }
}

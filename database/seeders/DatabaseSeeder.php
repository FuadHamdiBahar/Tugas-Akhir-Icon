<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\pssarpen;
use App\Models\RoleMenu;
use App\Models\Submenu;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Menu::create([
            'mid' => 5,
            'nama_menu' => 'improvement',
            'submenu' => 1
        ]);

        Submenu::create([
            'sid' => 24,
            'mid' => 5,
            'nama_submenu' => 'pssarpen'
        ]);

        RoleMenu::create([
            'id' => 8,
            'role' => 'admin',
            'mid' => 5
        ]);
    }
}

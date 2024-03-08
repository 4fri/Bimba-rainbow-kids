<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Menu;
use App\Models\MenuParent;
use App\Models\Route;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $superadmin = Role::create([
            'name' => 'super admin',
        ]);
        $admin = Role::create([
            'name' => 'admin',
        ]);
        $pendaftar = Role::create([
            'name' => 'student guardian',
        ]);

        $user_superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@bimba.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty11'),
        ]);
        $user_admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@bimba.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty11'),
        ]);

        $user_superadmin->assignRole($superadmin->name);
        $user_admin->assignRole($admin->name);

        $menus = Menu::create([
            'category_name' => 'Menu & Access',
            'menu_name' => 'Management',
            'menu_icon' => 'portfolio-grid-1'
        ]);

        // Create Menu Sidebar
        $create_menu = MenuParent::create([
            'route_name' => 'menus.index',
            'menu_name' => 'Menus',
            'menu_id' => $menus->id,
        ]);
        $create_menu_parent = MenuParent::create([
            'route_name' => 'menu-parents.index',
            'menu_name' => 'Menu Parents',
            'menu_id' => $menus->id,
        ]);
    }
}

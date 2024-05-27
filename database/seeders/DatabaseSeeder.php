<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuParent;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat atau mendapatkan peran yang sudah ada
        $superadmin = Role::firstOrCreate(['name' => 'super admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $pendaftar = Role::firstOrCreate(['name' => 'student guardian']);

        // Membuat pengguna super admin
        $user_superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@bimba.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty11'),
        ]);

        // Membuat pengguna admin
        $user_admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@bimba.com',
            'email_verified_at' => now(),
            'password' => Hash::make('qwerty11'),
        ]);

        // Menugaskan peran kepada pengguna
        $user_superadmin->assignRole($superadmin->name);
        $user_admin->assignRole($admin->name);

        // Daftar izin (permissions)
        $permissions = [
            'menus-index',
            'menus-store',
            'menus-edit',
            'menus-update',
            'menus-destroy',
            'menu-parents-index',
            'menu-parents-store',
            'menu-parents-edit',
            'menu-parents-update',
            'menu-parents-destroy',
        ];

        // Membuat izin jika belum ada dan menugaskannya ke peran
        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);

            // Menugaskan izin ke peran superadmin dan admin
            $superadmin->givePermissionTo($permission);
            $admin->givePermissionTo($permission);
        }

        // Membuat menu
        $menus = Menu::create([
            'category_name' => 'Menu & Access',
            'menu_name' => 'Management',
            'menu_icon' => 'portfolio-grid-1'
        ]);

        // Membuat Menu Sidebar
        MenuParent::create([
            'route_name' => 'menus.index',
            'menu_name' => 'Menus',
            'menu_id' => $menus->id,
        ]);

        MenuParent::create([
            'route_name' => 'menu-parents.index',
            'menu_name' => 'Menu Parents',
            'menu_id' => $menus->id,
        ]);
    }
}

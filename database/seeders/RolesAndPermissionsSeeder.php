<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Barang permissions
            'view_any_barang',
            'view_barang',
            'create_barang',
            'update_barang',
            'delete_barang',
            'delete_any_barang',
            'restore_barang',
            'restore_any_barang',
            'force_delete_barang',
            'force_delete_any_barang',
            'replicate_barang',
            'reorder_barang',

            // MutasiBarang permissions
            'view_any_mutasi::barang',
            'view_mutasi::barang',
            'create_mutasi::barang',
            'update_mutasi::barang',
            'delete_mutasi::barang',
            'delete_any_mutasi::barang',
            'restore_mutasi::barang',
            'restore_any_mutasi::barang',
            'force_delete_mutasi::barang',
            'force_delete_any_mutasi::barang',
            'replicate_mutasi::barang',
            'reorder_mutasi::barang',

            // User permissions
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
            'restore_user',
            'restore_any_user',
            'force_delete_user',
            'force_delete_any_user',
            'replicate_user',
            'reorder_user',

            // Role permissions
            'view_any_shield::role',
            'view_shield::role',
            'create_shield::role',
            'update_shield::role',
            'delete_shield::role',
            'delete_any_shield::role',

            // Page permissions
            'page_Dashboard',

            // Widget Permission
            'widget_RecentMutasiBarangWidget',
            'widget_MutasiBarangStatsWidget'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        // Super Admin role
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin role - now has full mutasi::barang permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            // Barang permissions
            'view_any_barang',
            'view_barang',
            'create_barang',
            'update_barang',
            'delete_barang',
            'restore_barang',
            'replicate_barang',
            'reorder_barang',

            // MutasiBarang permissions - now complete
            'view_any_mutasi::barang',
            'view_mutasi::barang',
            'create_mutasi::barang',
            'update_mutasi::barang',
            'delete_mutasi::barang',
            'restore_mutasi::barang',
            'replicate_mutasi::barang',
            'reorder_mutasi::barang',

            // Dashboard access
            'page_Dashboard',

            // Widget Permission
            'widget_RecentMutasiBarangWidget',
            'widget_MutasiBarangStatsWidget'
        ]);

        // Owner role - now has basic mutasi::barang permissions
        $ownerRole = Role::create(['name' => 'owner']);
        $ownerRole->givePermissionTo([
            // Barang permissions (view only)
            'view_any_barang',
            'view_barang',

            // MutasiBarang permissions - basic operations
            'view_any_mutasi::barang',
            'view_mutasi::barang',
            'create_mutasi::barang',
            'update_mutasi::barang',

            // Dashboard access
            'page_Dashboard',

            // Widget Permission
            'widget_RecentMutasiBarangWidget',
            'widget_MutasiBarangStatsWidget'
        ]);

        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole($superAdminRole);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);

        // Create owner user
        $owner = User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $owner->assignRole($ownerRole);
    }
}

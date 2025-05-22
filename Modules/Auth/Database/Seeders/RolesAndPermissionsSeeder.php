<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\Permission;
use Modules\Auth\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {

        // Define permissions
        // $permissions = [
        //     'manage all properties',
        //     'manage own properties',
        //     'view all bookings',
        //     'view own bookings',
        //     'manage users',
        // ];

        $manage_all_properties = Permission::create([
            'name' => 'manage-all-properties',
            'display_name' => 'Manage All Properties', // optional
            'description' => 'Manage All Adminstrators Properties', // optional
        ]);

        $manage_own_properties = Permission::create([
            'name' => 'manage-own-properties',
            'display_name' => 'Manage All Properties', // optional
            'description' => 'Manage All Adminstrators Properties', // optional
        ]);

        $view_all_bookings = Permission::create([
            'name' => 'view-all-bookings',
            'display_name' => 'View All Bookings', // optional
            'description' => 'View All Adminstrators And Users Bookings', // optional
        ]);

        $view_own_bookings = Permission::create([
            'name' => 'view-own-bookings',
            'display_name' => 'View All Bookings', // optional
            'description' => 'View Only Properties Bookings', // optional
        ]);

        $manage_users = Permission::create([
            'name' => 'manage-users',
            'display_name' => 'Manage Users', // optional
            'description' => 'Manage Users', // optional
        ]);

        // foreach ($permissions as $permission) {
        //     Permission::firstOrCreate(['name' => $permission]);
        // }

        // Superadmin (has all permissions)
        $super_admin = Role::create([
            'name' => 'super_admin',
            'display_name' => 'User Super Administrator', // optional
            'description' => 'User is allowed to All Permissions', // optional
        ]);
        $super_admin->givePermissions([
            $manage_all_properties,
            $manage_own_properties,
            $view_all_bookings,
            $view_own_bookings,
            $manage_users,
        ]);

        // Admin (can manage their own properties and view own bookings)
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'User Administrator', // optional
            'description' => 'User is allowed to manage and edit other users', // optional
        ]);
        $admin->givePermissions([
            $view_own_bookings,
            $manage_own_properties,
        ]);

        // User (minimal access or booking-related only)
        $user = Role::create([
            'name' => 'user',
            'display_name' => 'User', // optional
            'description' => 'User is allowed to view own bookings', // optional
        ]);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Modules\Property\Database\Seeders\PropertyTypeSeeder::class,
            \Modules\Auth\Database\Seeders\RolesAndPermissionsSeeder::class,
            \Modules\Auth\Database\Seeders\SuperAdminSeeder::class,
            // \Modules\Auth\Database\Seeders\LaratrustSeeder::class,
            // LaratrustSeeder::class
            // Add more module seeders here
        ]);
    }
}

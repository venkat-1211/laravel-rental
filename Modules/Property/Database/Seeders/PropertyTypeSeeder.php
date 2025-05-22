<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Property\Models\PropertyType;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyType::insert([
            ['name' => 'Room',      'slug' => 'room'],
            ['name' => 'Villa',     'slug' => 'villa'],
            ['name' => 'Apartment', 'slug' => 'apartment'],
            ['name' => 'Resort',    'slug' => 'resort'],
            ['name' => 'Cottage',    'slug' => 'cottage'],
        ]);
    }
}

<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\Profile;
use Modules\Auth\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345678'),
        ];

        $user = User::create($user);

        $user->addRole('super_admin');

        $profile = [
            'user_id' => $user->id,
            'phone' => '6379102578',
            'profile_image' => 'user-3296.png',
            'address' => [
                'flat' => '123',
                'street' => 'Main Street',
                'city' => 'City',
                'state' => 'State',
                'pincode' => '12345',
            ],
            'aadhaar' => [
                'name_as_in_aadhaar' => 'Superadmin',
                'aadhaar_number' => '123456789012',
                'aadhaar_front_image' => '',
                'aadhaar_back_image' => '',
            ],
            'pan' => [
                'name_as_in_pan' => 'Superadmin',
                'pan_number' => 'ABCDE1234F',
                'pan_front_image' => 'pan_image.jpg',
                'pan_back_image' => 'pan_image.jpg',
            ],
            'gst_number' => '1234567890',
            'bank' => [
                'bank_name' => 'HDFC Bank',
                'account_number' => '1234567890',
                'ifsc' => 'HDFC000000',
            ],
            'upi' => [
                'upi_id' => 'superadmin@upi',
                'upi_name' => 'Superadmin',
                'upi_phone' => '1234567890',
            ],
        ];

        Profile::create($profile);
    }
}

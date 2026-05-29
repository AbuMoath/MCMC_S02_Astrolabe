<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class McmcUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Public user
        DB::table('public_users')->updateOrInsert(
            ['UserEmail' => 'khaled11khaled221@gmail.com'],
            [
                'UserName' => 'pupbic',
                'UserEmail' => 'khaled11khaled221@gmail.com',
                'UserPassword' => bcrypt('password123'),
                'UserPhoneNum' => null,
                'UserProfilePicture' => null,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Admin
        DB::table('administrators')->updateOrInsert(
            ['AdminEmail' => 'khsledqmhan@gmail.com'],
            [
                'AdminName' => 'Admin',
                'AdminEmail' => 'khsledqmhan@gmail.com',
                'AdminRole' => 'Super Admin',
                'AdminPhoneNum' => '0000000000',
                'AdminAddress' => '',
                'AdminUserName' => 'admin',
                'AdminPassword' => bcrypt('password123'),
                'AdminProfilePicture' => null,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Agency
        DB::table('agencies')->updateOrInsert(
            ['AgencyEmail' => 'mohammedalghtane@gmail.com'],
            [
                'AgencyName' => 'Agency',
                'AgencyEmail' => 'mohammedalghtane@gmail.com',
                'AgencyPhoneNum' => '0000000000',
                'AgencyType' => 'Default',
                'AgencyUserName' => 'agency',
                'AgencyPassword' => bcrypt('password123'),
                'AgencyProfilePicture' => null,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        echo "MCMC users seeded/updated.\n";
    }
}

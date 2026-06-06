<?php

namespace Database\Seeders;

use App\Models\PublicUser;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\PublicUser::updateOrCreate(
            ['UserEmail' => 'publicuser@gmail.com'],
            [
                'UserName' => 'public',
                'UserPassword' => \Illuminate\Support\Facades\Hash::make('password123'),
                'UserPhoneNum' => '1234567890',
            ]
        );

        \App\Models\Admin::updateOrCreate(
            ['AdminEmail' => 'khsledqmhan@gmail.com'],
            [
                'AdminName' => 'admin',
                'AdminUserName' => 'admin',
                'AdminPassword' => \Illuminate\Support\Facades\Hash::make('password123'),
                'AdminRole' => 'Super Admin',
                'AdminPhoneNum' => '1234567890',
                'AdminAddress' => 'Default Address',
            ]
        );
        

        \App\Models\Admin::updateOrCreate(
            ['AdminEmail' => 'abu.hd3@gmail.com'],
            [
                'AdminName' => 'admin2',
                'AdminUserName' => 'admin2',
                'AdminPassword' => \Illuminate\Support\Facades\Hash::make('password123'),
                'AdminRole' => 'Super Admin',
                'AdminPhoneNum' => '1234567890',
                'AdminAddress' => 'Default Address',
            ]
        );
        
        \App\Models\Agency::updateOrCreate(
            ['AgencyEmail' => 'agency@gmail.com'],
            [
                'AgencyName' => 'agency',
                'AgencyUserName' => 'agency',
                'AgencyPassword' => \Illuminate\Support\Facades\Hash::make('password123'),
                'AgencyType' => 'General',
                'AgencyPhoneNum' => '1234567890',
            ]
        );
    }
}

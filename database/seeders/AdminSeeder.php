<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin1 = 'user_avatar/avatar1.jpg';
        $admin2 = 'user_avatar/avatar2.jpg';
        $users = 'user_avatar/avatar.jpg';

        // Admin users
        User::create([
            'role' => 'Admin',
            'avatar' => $admin1,
            'name' => 'E-Mart',
            'email' => 'e.mart@admin.me',
            'phone' => 639638753244,
            'fb_link' => 'https://www.facebook.com/',
            'address' => 'Rizal Street, Sogod, Southern, Leyte',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'role' => 'Admin',
            'avatar' => $admin2,
            'name' => 'Melchard Lina',
            'email' => 'e.mart@eridiano.admin',
            'phone' => 639232423,
            'fb_link' => 'https://www.facebook.com/',
            'address' => 'Kagwapo Street, Kapogian, Southern Gwapo',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Customer user
        User::create([
            'role' => 'Customer',
            'avatar' => $users,
            'name' => 'Elessa Fermano',
            'email' => 'esang@ungo.com',
            'phone' => 639232423,
            'fb_link' => 'https://www.facebook.com/',
            'address' => 'Kagwapo Street, Kagwapahan, Southern Gwapa',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Courier users
        User::create([
            'role' => 'Courier',
            'avatar' => $users,
            'name' => 'Antonette Lozares',
            'email' => 'tonette@ungo.com',
            'phone' => 639232423,
            'fb_link' => 'https://www.facebook.com/',
            'address' => 'Kagwapo Street, Kagwapahan, Southern Gwapa',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'role' => 'Courier',
            'avatar' => $users,
            'name' => 'Janine Rosales',
            'email' => 'anine@ungo.com',
            'phone' => 639232423,
            'fb_link' => 'https://www.facebook.com/',
            'address' => 'Kagwapo Street, Kagwapahan, Southern Gwapa',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

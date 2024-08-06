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
        $admin1 = 'user_avatar/admin.jpg';
        $admin2 = 'user_avatar/admin.jpg';
        $users = 'user_avatar/avatar.jpg';
        $superadmin = 'user_avatar/superadmin.jpg';

        User::create([
            'role' => 'SuperAdmin',
            'avatar' => $superadmin,
            'name' => 'Jerry Molar Parrocha',
            'email' => 'j.parrocha@superadmin.me',
            'phone' =>  639638753244,
            'fb_link' => 'https://www.facebook.com/jerryparrocha1234/',
            'address' => 'Hilongos, Leyte',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'role' => 'SuperAdmin',
            'avatar' => $superadmin,
            'name' => 'Melchard Lina',
            'email' => 'm.lina@superadmin.me',
            'phone' =>  639307696919,
            'fb_link' => 'https://www.facebook.com/melchard.lina',
            'address' => 'Hilongos, Leyte',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
            'name' => 'E-Marty',
            'email' => 'e.marty@admin.me',
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
            'email' => 'esang@customer.me',
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
            'email' => 'tonette@courier.me',
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
            'email' => 'janine@courier.me',
            'phone' => 639232423,
            'fb_link' => 'https://www.facebook.com/',
            'address' => 'Kagwapo Street, Kagwapahan, Southern Gwapa',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::updateOrInsert(
            ['setting_key' => 'opening_time'],
            ['setting_value' => '08:00:00'],
        );

        Settings::updateOrInsert(
            ['setting_key' => 'closing_time'],
            ['setting_value' => '17:00:00'],
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $img1 = 'products/1.png';
        $img2 = 'products/2.jpg';

        Category::create([
            'category_img' => $img1,
            'category_name' => 'Dairy',
            'description' => 'AMBOT LAMI BANI',
        ]);

        Category::create([
            'category_img' => $img2,
            'category_name' => 'Meat',
            'description' => 'AMBOT LAMI BANI',
        ]);
    }
}

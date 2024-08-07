<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Inventory;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            [
                'category_img' => 'products/logo/category1.jpg',
                'category_name' => 'Fresh Produce',
                'description' => 'Description for Fresh Produce'
            ],
            [
                'category_img' => 'products/logo/category2.jpg',
                'category_name' => 'Dairy and Eggs',
                'description' => 'Description for Dairy and Eggs'
            ],
            [
                'category_img' => 'products/logo/category3.png',
                'category_name' => 'Meat and Seafood',
                'description' => 'Description for Meat and Seafood'
            ],
            [
                'category_img' => 'products/logo/category4.jpg',
                'category_name' => 'Pantry Staples',
                'description' => 'Description for Pantry Staples'
            ],
            [
                'category_img' => 'products/logo/category5.png',
                'category_name' => 'Bakery and Snacks',
                'description' => 'Description for Bakery and Snacks'
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $category1 = Category::where('category_name', 'Fresh Produce')->first();
        $category2 = Category::where('category_name', 'Dairy and Eggs')->first();
        $category3 = Category::where('category_name', 'Meat and Seafood')->first();
        $category4 = Category::where('category_name', 'Pantry Staples')->first();
        $category5 = Category::where('category_name', 'Bakery and Snacks')->first();

        $inventoryItems = [
            [
                'category_id' => $category1->id,
                'product_img' => 'product_name/product1-1.jpg',
                'product_name' => "Mangoes",
                'variant' => 'Carabao',
                'price' => rand(10, 20),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category1->id,
                'product_img' => 'product_name/product1-2.jpg',
                'product_name' => "Malunggay Leaves",
                'variant' => null,
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category1->id,
                'product_img' => 'product_name/product1-3.jpg',
                'product_name' => "Banana",
                'variant' => 'Saba',
                'price' => rand(20, 40),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category1->id,
                'product_img' => 'product_name/product1-4.jpg',
                'product_name' => "Calamansi",
                'variant' => null,
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'product_name/product2-5.jpg',
                'product_name' => "Magnolia Fresh Milk",
                'variant' => '1 Liter',
                'price' => rand(50, 100),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'product_name/product2-6.jpg',
                'product_name' => "Eden Cheese",
                'variant' => null,
                'price' => rand(30, 50),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'product_name/product2-7.jpg',
                'product_name' => "NestFresh Eggs",
                'variant' => null,
                'price' => rand(80, 120),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'product_name/product2-8.jpg',
                'product_name' => "Carabao's Milk",
                'variant' => null,
                'price' => rand(40, 60),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'product_name/product3-9.jpg',
                'product_name' => "Century Tuna",
                'variant' => null,
                'price' => rand(20, 30),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'product_name/product3-10.jpg',
                'product_name' => "Purefoods Tender Juicy Hotdog",
                'variant' => null,
                'price' => rand(20, 30),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'product_name/product3-11.jpg',
                'product_name' => "Magnolia Chicken",
                'variant' => 'Whole Chicken',
                'price' => rand(180, 200),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'product_name/product3-12.jpg',
                'product_name' => "555 Canned Tuna",
                'variant' => null,
                'price' => rand(20, 30),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'product_name/product4-13.jpg',
                'product_name' => "Datu Puti Vinegar",
                'variant' => 'Sulit Pack',
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'product_name/product4-14.jpg',
                'product_name' => "Silver Swan Soy Sauce",
                'variant' => 'Sulit Pack',
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'product_name/product4-15.jpg',
                'product_name' => "Argentina Corned Beef",
                'variant' => '200ml',
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'product_name/product4-16.jpg',
                'product_name' => "Knorr Sinigang Mix",
                'variant' => null,
                'price' => rand(20, 25),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'product_name/product5-17.jpg',
                'product_name' => "Gardenia Classic",
                'variant' => 'White Bread',
                'price' => rand(40, 50),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'product_name/product5-18.jpg',
                'product_name' => "SkyFlakes Crackers",
                'variant' => null,
                'price' => rand(150, 170),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'product_name/product5-19.jpg',
                'product_name' => "Jack 'n Jill Piattos",
                'variant' => null,
                'price' => rand(20, 25),
                'quantity' => rand(15, 50),
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'product_name/product5-20.jpg',
                'product_name' => "Oishi Pillows",
                'variant' => null,
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
            ],
        ];

        foreach ($inventoryItems as $inventoryData) {
            Inventory::create($inventoryData);
        }
    }
}

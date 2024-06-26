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
                'description' => 'Description for Fresh Produce category',
            ],
            [
                'category_img' => 'products/logo/category2.jpg',
                'category_name' => 'Dairy and Eggs',
                'description' => 'Description for Dairy and Eggs category',
            ],
            [
                'category_img' => 'products/logo/category3.png',
                'category_name' => 'Meat and Seafood',
                'description' => 'Description for Meat and Seafood category',
            ],
            [
                'category_img' => 'products/logo/category4.jpg',
                'category_name' => 'Pantry Staples',
                'description' => 'Description for Pantry Staples category',
            ],
            [
                'category_img' => 'products/logo/category5.png',
                'category_name' => 'Bakery and Snacks',
                'description' => 'Description for Bakery and Snacks category',
            ],
            // [
            //     'category_img' => 'products/2.jpg',
            //     'category_name' => 'Beverages',
            //     'description' => 'Description for Meat category',
            // ],
            // [
            //     'category_img' => 'products/1.png',
            //     'category_name' => 'Frozen Foods',
            //     'description' => 'Description for Dairy category',
            // ],
            // [
            //     'category_img' => 'products/2.jpg',
            //     'category_name' => 'Household Essentials',
            //     'description' => 'Description for Meat category',
            // ],
            // [
            //     'category_img' => 'products/2.jpg',
            //     'category_name' => 'Health and Wellness',
            //     'description' => 'Description for Meat category',
            // ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        $category1 = Category::where('category_name', 'Fresh Produce')->first();
        $category2 = Category::where('category_name', 'Dairy and Eggs')->first();
        $category3 = Category::where('category_name', 'Meat and Seafood')->first();
        $category4 = Category::where('category_name', 'Pantry Staples')->first();
        $category5 = Category::where('category_name', 'Bakery and Snacks')->first();
        // $category6 = Category::where('category_name', 'Beverages')->first();
        // $category7 = Category::where('category_name', 'Frozen Foods')->first();
        // $category8 = Category::where('category_name', 'Household Essentials')->first();
        // $category9 = Category::where('category_name', 'Health and Wellness')->first();


        $inventoryItems = [
            [
                'category_id' => $category1->id,
                'product_img' => 'product_name/product1-1.jpg',
                'product_name' => "Carabao Mangoes",
                'price' => rand(10, 20),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category1->id,
                'product_img' => 'product_name/product1-2.jpg',
                'product_name' => "Malunggay leaves",
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category1->id,
                'product_img' => 'product_name/product1-3.jpg',
                'product_name' => "Saba bananas",
                'price' => rand(20, 40),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category1->id,
                'product_img' => 'product_name/product1-4.jpg',
                'product_name' => "Calamansi",
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'product_name/product2-5.jpg',
                'product_name' => "Magnolia Fresh Milk",
                'price' => rand(50, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'product_name/product2-6.jpg',
                'product_name' => "Eden Cheese",
                'price' => rand(30, 50),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'product_name/product2-7.jpg',
                'product_name' => "NestFresh Eggs",
                'price' => rand(80, 120),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'product_name/product2-8.jpg',
                'product_name' => "Carabao's Milk",
                'price' => rand(40, 60),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'product_name/product3-9.jpg',
                'product_name' => "Century Tuna",
                'price' => rand(20, 30),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'product_name/product3-10.jpg',
                'product_name' => "Purefoods Tender Juicy Hotdog",
                'price' => rand(20, 30),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'product_name/product3-11.jpg',
                'product_name' => "Magnolia Chicken (Whole Chicken)",
                'price' => rand(180, 200),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'product_name/product3-12.jpg',
                'product_name' => "555 Canned Tuna",
                'price' => rand(20, 30),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'product_name/product4-13.jpg',
                'product_name' => "Datu Puti Vinegar",
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'product_name/product4-14.jpg',
                'product_name' => "Silver Swan Soy Sauce",
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'product_name/product4-15.jpg',
                'product_name' => "Argentina Corned Beef",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'product_name/product4-16.jpg',
                'product_name' => "Knorr Sinigang Mix",
                'price' => rand(20, 25),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'product_name/product5-17.jpg',
                'product_name' => "Gardenia Classic White Bread",
                'price' => rand(40, 50),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'product_name/product5-18.jpg',
                'product_name' => "SkyFlakes Crackers (1 box pack)",
                'price' => rand(150, 170),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'product_name/product5-19.jpg',
                'product_name' => "Jack 'n Jill Piattos",
                'price' => rand(20, 25),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'product_name/product5-20.jpg',
                'product_name' => "Oishi Pillows",
                'price' => rand(10, 15),
                'quantity' => rand(15, 50),
                'information' => 'Information for Products',
                'description' => 'Description for Products',
            ],
            // [
            //     'category_id' => $category6->id,
            //     'product_img' => 'product_name/product3-9.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category6->id,
            //     'product_img' => 'product_name/product3-9.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category6->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category6->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category7->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category7->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category7->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category7->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category8->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category8->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category8->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // [
            //     'category_id' => $category8->id,
            //     'product_img' => 'products/2.jpg',
            //     'product_name' => "Melchard's Juicy Meat",
            //     'price' => rand(10, 100),
            //     'quantity' => rand(15, 50),
            //     'information' => 'Information for Juicy Meat',
            //     'description' => 'Description for Juicy Meat',
            // ],
            // Add more inventory items as needed
        ];

        foreach ($inventoryItems as $inventoryData) {
            Inventory::create($inventoryData);
        }
    }
}

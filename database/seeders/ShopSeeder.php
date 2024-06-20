<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Inventory;

class CombinedSeeder extends Seeder
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
                'description' => 'Description for Dairy category',
            ],
            [
                'category_img' => 'products/logo/category2.jpg',
                'category_name' => 'Dairy and Eggs',
                'description' => 'Description for Meat category',
            ],
            [
                'category_img' => 'products/logo/category3.jpg',
                'category_name' => 'Meat and Seafood',
                'description' => 'Description for Dairy category',
            ],
            [
                'category_img' => 'products/logo/category4.jpg',
                'category_name' => 'Pantry Staples',
                'description' => 'Description for Meat category',
            ],
            [
                'category_img' => 'products/logo/category5.jpg',
                'category_name' => 'Bakery and Snacks',
                'description' => 'Description for Dairy category',
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
                'product_img' => 'products/products/product1-1.jpg',
                'product_name' => "Juicy Philippine Mangoes",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Milky Dicky',
                'description' => 'Description for Milky Dicky',
            ],
            [
                'category_id' => $category1->id,
                'product_img' => 'products/products/product1-2.webp',
                'product_name' => "Crisp Pechay Tagalog",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category1->id,
                'product_img' => 'products/products/product1-3.jpg',
                'product_name' => "Ripe Cavendish Bananas",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category1->id,
                'product_img' => 'products/products/product1-4.jpg',
                'product_name' => "Fresh Pandan Leaves",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'products/products/product2-5.jpg',
                'product_name' => "Carabao's Milk",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'products/products/product2-6.jpg',
                'product_name' => "Kesong Puti (White Cheese)",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'products/products/product2-7.webp',
                'product_name' => "Filipino-style Yogurt",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category2->id,
                'product_img' => 'products/products/product2-8.jpg',
                'product_name' => "Free-Range Itlog ng Pugo (Quail Eggs)",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Tender Beef Tapa",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Adobong Manok (Chicken Adobo Cut)",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Fresh Bangus (Milkfish)",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category3->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Seasoned Pork BBQ Skewers",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Premium Sinandomeng Rice",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Whole Wheat Bihon (Rice Noodles)",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Organic Mongo Beans",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category4->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Extra Virgin Coconut Oil",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Pan de Sal",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Decadent Ube Ensaymada",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Sweet Banana Chips",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
            [
                'category_id' => $category5->id,
                'product_img' => 'products/2.jpg',
                'product_name' => "Nutritious Taho (Soy Pudding)",
                'price' => rand(10, 100),
                'quantity' => rand(15, 50),
                'information' => 'Information for Juicy Meat',
                'description' => 'Description for Juicy Meat',
            ],
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

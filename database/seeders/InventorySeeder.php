<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;
use SebastianBergmann\FileIterator\Factory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $img1 = 'products/1.png';
        $img2 = 'products/2.jpg';

        // Inventory::factory(5)->create();

        Inventory::create([
            'category_id' => 1,
            'product_img' => $img1,
            'product_name' => "Melchard's Milky Dicky",
            'price' => 1000,
            'quantity' => 10000,
            'information' => 'lami ni labaw nag tag iya lami pud',
            'description' => 'lami ni labaw nag tag iya lami pud',
        ]);

        Inventory::create([
            'category_id' => 2,
            'product_img' => $img2,
            'product_name' => "Melchard's Juicy Meat",
            'price' => 1000,
            'quantity' => 10000,
            'information' => 'lami ni kaajo murag sa tag iya',
            'description' => 'lami ni labaw nag tag iya lami pud',
        ]);
    }
}

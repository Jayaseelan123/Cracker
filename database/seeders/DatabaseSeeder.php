<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Admin
        User::firstOrCreate(
            ['email' => 'admin@crackerstore.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'is_admin' => 1,
            ]
        );

        // 2. Categories
        $cats = ['Sparklers', 'Flower Pots', 'Ground Chakkars', 'Atom Bombs'];
        
        foreach($cats as $c) {
            $cat = Category::create(['name' => $c]);
            
            // 3. Products for each category
            Product::create([
                'category_id' => $cat->id,
                'name' => 'Standard ' . $c . ' (10 Pcs)',
                'mrp' => 150.00,
                'price' => 75.00,
                'image_path' => 'demo.jpg',
                'pack_size' => '1 Box'
            ]);
            Product::create([
                'category_id' => $cat->id,
                'name' => 'Giant ' . $c . ' (Special)',
                'mrp' => 300.00,
                'price' => 150.00,
                'image_path' => 'demo.jpg',
                'pack_size' => '1 Box'
            ]);
        }
    }
}
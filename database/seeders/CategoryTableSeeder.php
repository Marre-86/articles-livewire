<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::truncate();

        $category = Category::create([
            'name' => 'Technology',
            'order' => Category::getNextOrderValue(),
        ]);

        $category = Category::create([
            'name' => 'Mystery',
            'status' => 'Inactive',
            'order' => Category::getNextOrderValue(),
        ]);

        $category = Category::create([
            'name' => 'Fantasy',
            'status' => 'Active',
            'order' => Category::getNextOrderValue(),
        ]);

        $category = Category::create([
            'name' => 'Romance',
            'status' => 'Active',
            'order' => Category::getNextOrderValue(),
        ]);

        $category = Category::create([
            'name' => 'Comedy',
            'status' => 'Active',
            'order' => Category::getNextOrderValue(),
        ]);

        
        $category = Category::create([
            'name' => 'Thriller',
            'status' => 'Active',
            'order' => Category::getNextOrderValue(),
        ]);

        
        $category = Category::create([
            'name' => 'History',
            'status' => 'Active',
            'order' => Category::getNextOrderValue(),
        ]);

        
        $category = Category::create([
            'name' => 'Horror',
            'status' => 'Inactive',
            'order' => Category::getNextOrderValue(),
        ]);
    }
}
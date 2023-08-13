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
            'name' => 'clothes',
            'order' => Category::getNextOrderValue(),
        ]);

        $category = Category::create([
            'name' => 'shoes',
            'status' => 'Inactive',
            'order' => Category::getNextOrderValue(),
        ]);

        $category = Category::create([
            'name' => 'trousers',
            'status' => 'Active',
            'order' => Category::getNextOrderValue(),
        ]);

        $category = Category::create([
            'name' => 'hats',
            'status' => 'Active',
            'order' => Category::getNextOrderValue(),
        ]);

        $category = Category::create([
            'name' => 'accessories',
            'status' => 'Active',
            'order' => Category::getNextOrderValue(),
        ]);
    }
}
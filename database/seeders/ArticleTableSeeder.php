<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;

class ArticleTableSeeder extends Seeder
{
    public function run()
    {
        Article::truncate();

        $faker = \Faker\Factory::create();

        $categoriesCount = Category::count();

        $images = [
            'nice-looking-lake.jpg',
            'clouds.jpg',
            'airplanes.jpg',
            'bridge-at-night.jpg',
            'castle.jpg',
            'city-from-above.jpg',
            'leaves.jpg',
            'pencils.jpg',
        ];

        for ($i = 0; $i < 8; $i++) {
            Article::create([
                'name' => $faker->sentence(3),
                'category_id' => rand(1, $categoriesCount),
                'content' => $faker->paragraph,
                'status' => ['Active', 'Inactive'][rand(0, 1)],
                'order' => Article::getNextOrderValue(),
                'image' => $images[$i],
            ]);
        }
    }
}
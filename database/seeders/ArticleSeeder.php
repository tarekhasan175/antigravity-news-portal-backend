<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $authors = Author::all();
        
        if ($categories->isEmpty() || $authors->isEmpty()) {
            return;
        }
        
        for ($i = 0; $i < 20; $i++) {
            $title = "Sample News Article " . ($i + 1);
            Article::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . Str::random(5),
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'featured_image' => 'https://picsum.photos/seed/' . ($i + 1) . '/800/600',
                'category_id' => $categories->random()->id,
                'author_id' => $authors->random()->id,
                'is_featured' => rand(0, 1),
                'status' => 'published',
                'published_at' => now(),
            ]);
        }
    }
}

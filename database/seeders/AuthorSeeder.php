<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'John Doe',
            'bio' => 'Senior Editor',
            'avatar' => 'https://i.pravatar.cc/150?u=john',
        ]);
        
        Author::create([
            'name' => 'Jane Smith',
            'bio' => 'Tech Reporter',
            'avatar' => 'https://i.pravatar.cc/150?u=jane',
        ]);
    }
}

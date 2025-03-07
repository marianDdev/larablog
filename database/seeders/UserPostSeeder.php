<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->withRole()
            ->count(100)
            ->has(
                Post::factory()
                ->count(rand(0,10))
            )
            ->create();
    }
}

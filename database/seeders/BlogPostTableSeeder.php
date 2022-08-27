<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postsCount = (int) $this->command->ask('How many BlogPost Do you want', 5);

        $users = User::all();
        BlogPost::factory($postsCount)->make()->each(function($post) use($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}

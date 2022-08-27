<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class CommenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commentsCount = (int) $this->command->ask('How many Comments Do you want', 5);

        $posts = BlogPost::all();
        Comment::factory($commentsCount)->make()->each(function($comment) use($posts) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}

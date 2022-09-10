<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\BlogPost;
use App\Models\User;
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
        $users  = User::all();
        Comment::factory($commentsCount)->make()->each(function($comment) use($posts, $users) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });
    }
}

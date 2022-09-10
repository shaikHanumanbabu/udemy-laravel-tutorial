<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();
        $blogposts = BlogPost::whereIn('id',[
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
        ]);
        $blogposts->each(function($post) use($tags) {
            
            $post->tags()->sync($tags->random(2));
            
        });
    }
}

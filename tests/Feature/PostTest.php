<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Database\Factories\CommentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No Posts Found');
    }

    public function createDemoPost($userId = null)
    {
        // $this->setUpFaker();
        // $post = new BlogPost();
        // $post->title = $this->faker->text($maxNbChars = 50);
        // $post->content = $this->faker->text;
        // $post->user_id = $this->getTestUser()->id;
        // $post->save();

        $post = BlogPost::factory()->create(['user_id' => $userId ?? $this->getTestUser()->id]);
        return $post;
    }

    public function testStoreValid()
    {
        $this->actingAs($this->getTestUser());
        $this->setUpFaker();
        $params = [
            'title' => $this->faker->text($maxNbChars = 50),
            'content' => $this->faker->sentence($nbWords = 10, $variableNbWords = true)
        ];
        
        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');
        
        $this->assertEquals(session('status'), 'BlogPost was created');
    }

    public function testStoreFail()
    {
        $this->setUpFaker();
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];
        
        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');
        
        $message = session('errors');
        $this->assertNotEmpty($message->getMessages()) ;
    }

    public function testUpdateValid()
    {
        $this->setUpFaker();
        $params = [
            'title' => $this->faker->text($maxNbChars = 50),
            'content' => $this->faker->sentence($nbWords = 10, $variableNbWords = true)
        ];

        $post = BlogPost::findOrFail(2);
        $this->put("posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'BlogPost was updated!');

        $this->assertDatabaseHas('blog_posts', ['id' => $post->id]);
    }

    public function testDeletePost()
    {
        
        $user = $this->getTestUser();
        $this->actingAs($user);

        $post = $this->createDemoPost($user->id);
        // dd($post->id);
        // dd($post->toArray());
        $this->delete("posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'BlogPost was deleted!');

        // $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    public function testBlogPostWithCommentWithHelpOfFactory()
    {
        
        $post = $this->createDemoPost();
        Comment::factory()->create(['blog_post_id' => $post->id]);
        
        $this->assertDatabaseHas('comments', [
            'blog_post_id' => $post->id
        ]);
        // $this->assertEquals(session('status'), 'BlogPost was created');
    }

    


}

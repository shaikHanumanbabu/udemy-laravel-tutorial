<?php

namespace Tests\Feature;

use App\Models\BlogPost;
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

    public function testsee1BlogPostWhenThereIs1()
    {
        $post = new BlogPost();
        $post->title = 'Sample test';
        $post->content = 'Sample content';
        $post->save();

        $response = $this->get('/posts');

        $response->assertSeeText($post->title);
    }

    public function testStoreValid()
    {
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
        

        $post = BlogPost::findOrFail(2);
        $this->delete("posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'BlogPost was deleted!');

        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    


}

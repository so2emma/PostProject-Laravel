<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase;


    public function testNoBlogPostsWhenNothingInDatabase()
    {
       $response = $this->get('/posts');
       $response->assertSeeText('No posts Found');
    }

    public function testSee1BlogPostWhenThereIs1WithNoComment()
    {
        //Arange
        $post = $this->createDummyBlogPost();

        //Act
        $response = $this->get('/posts');

        //Assert
       $response->assertSeeText('New Title');
        $response->assertSeeText('No comments yet!');
       $this->assertDatabaseHas('blog_posts',[
           'title' => 'New Title'
       ]);
    }
    public function testSee1BlogPostWithComment(){
        $post = $this->createDummyBlogPost();
        $comment = Comment::factory()->count(4)->create([
            'blog_post_id' => $post->id
        ]);
        // factory(Comment::class, 4)->create([
        //     'blog_post_id' => $post->id
        // ]);
        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');



    }

    public function testStoreValid()
    {


        $params = [
            'title' => 'valid title',
            'content' => 'At least 10 characters',
        ];
        $this->actingAs($this->user())
        ->post('/posts',$params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'The Blog post was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'va',
            'content' => 'At',
        ];

        $this->actingAs($this->user())
        ->post('/posts',$params)
        ->assertStatus(302)
        ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');
    }
    public function testUpdateValid()
    {
        $post = $this->createDummyBlogPost();


        $array = [
            'title' => $post['title'],
            'content' => $post['content'],
        ];


        $this->assertDatabaseHas("blog_posts",$array);

        $params = [
            'title' => 'A very new title',
            'content' => 'this is the story of a brother',
        ];

        $this->actingAs($this->user())
        ->put("/posts/{$post->id}",$params)
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'BlogPost Was Updated!');
        $this->assertDatabaseMissing("blog_posts",$array);
        $this->assertDatabaseHas("blog_posts",[
            'title' => 'A very new title',
            'content' => 'this is the story of a brother',
        ]);
    }

    public function testDelete(){
        $post = $this->createDummyBlogPost();
        $array = [
            'title' => $post['title'],
            'content' => $post['content'],
        ];
        $this->assertDatabaseHas("blog_posts",$array);

        $this->actingAs($this->user())
        ->delete("/posts/{$post->id}")
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'),'Blog post was Deleted!');
        // $this->assertDatabaseMissing("blog_posts",$array);
        // $this->assertSoftDeleted("blog_posts",$array);
    }


    private function createDummyBlogPost(): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'New Content';
        // $post->save();

        return BlogPost::factory()->suspended()->create();

        // return $post;
    }
}

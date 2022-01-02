<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;

class PostsTest extends TestCase
{
    /** @test */
    public function aut_user_can_create_post()
    {
        $post = $this->createPost();
        $post->assertStatus(200)->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'slug',
                'description',
            ]
        ])
            ->assertJsonFragment([
                'title' => 'Test Post',
                'user_id' => $this->user->id
            ]);
    }

    /** @test */
    public function auth_user_can_get_list_of_users()
    {
        //Create additionally 3 new posts
        Post::factory(3)->create();
        $data = $this->getJson(self::POSTS_ENDPOINT);
        $this->assertCount(3, $data->decodeResponseJson()->json()['data']);

        $data
            ->assertStatus(200)
            ->assertSee('data')
            ->assertJsonFragment(['type' => 'posts'])
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'type',
                        'attributes' => [
                            'slug', 'title', 'description', 'user_id', 'created_at', 'updated_at'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function aut_user_can_see_specific_post()
    {
        $post = $this->createPost();
        $postResponse = $this->getJson(
            sprintf('%s/%s', self::POSTS_ENDPOINT, $post->getOriginalContent()['data']->id)
        );

        $postResponse->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'description',
                ]
            ]);

        $this->assertEquals($postResponse->getOriginalContent()->user_id, $this->user->id);
        $this->assertEquals($postResponse->getOriginalContent()->title, 'Test Post');
    }

    /** @test */
    public function auth_user_can_delete_specific_post()
    {
        $post = $this->createPost();
        $postResponse = $this->getJson(sprintf('%s/%s', self::POSTS_ENDPOINT, $post->getOriginalContent()['data']->id));

        $postResponse->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'description'
                ]
            ]);
        $this->assertEquals($postResponse->getOriginalContent()->user_id, $this->user->id);
        $this->assertEquals($postResponse->getOriginalContent()->title, 'Test Post');

        $this->deleteJson(sprintf('%s/%s', self::POSTS_ENDPOINT, $post->getOriginalContent()['data']->id))
            ->assertStatus(200)
            ->assertJsonFragment(
                ['message' => sprintf('Post with ID %s was deleted', $post->getOriginalContent()['data']->id)]
            );

        $this
            ->getJson(sprintf('%s/%s', self::POSTS_ENDPOINT, $post->getOriginalContent()['data']->id))
            ->assertNotFound();
    }
}

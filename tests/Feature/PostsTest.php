<?php

namespace Tests\Feature;

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
    public function aut_user_can_see_specific_post()
    {
        $post = $this->createPost();

        $postResponse =  $this->getJson(sprintf('%s/%s', self::POSTS_ENDPOINT, $post->getOriginalContent()['data']->id));


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
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /** @test */
    public function can_get_created_user()
    {
        $user = User::where('email', self::TEST_USER_EMAIL)->first();
        $this->assertEquals($user->email, self::TEST_USER_EMAIL);
    }

    /** @test */
    public function auth_user_can_get_list_of_users()
    {
        //Create additionally +3 new user
        User::factory(3)->create();
        $data = $this->getJson(self::USERS_ENDPOINT);
        $this->assertCount(4, $data->decodeResponseJson()->json()['data']);

        $data
            ->assertStatus(200)
            ->assertSee('data')
            ->assertJsonFragment(['type' => 'users'])
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'type',
                        'attributes' => [
                            'name', 'email', 'created_at', 'updated_at'
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function auth_user_can_see_specific_user()
    {
        $user = User::where('email', self::TEST_USER_EMAIL)->first();
        $this->getJson(sprintf('%s/%s', self::USERS_ENDPOINT, $user->id))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id', 'email'
                ]
            ])
            ->assertJsonFragment(['email' => self::TEST_USER_EMAIL]);
    }
}

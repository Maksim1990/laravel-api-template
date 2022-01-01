<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected User $user;

    protected const TEST_USER_EMAIL = 'test@test.com';
    protected const USERS_ENDPOINT = '/api/v1/users';
    protected const POSTS_ENDPOINT = '/api/v1/posts';

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['email' => self::TEST_USER_EMAIL]);
        $this->withDisabledTokenAutentication()->actingAs($this->user);
    }

    protected function withEnabledTokenAutentication()
    {
        config(['system.disable_test_auth_via_token' => false]);
        return $this;
    }

    protected function withDisabledTokenAutentication()
    {
        config(['system.disable_test_auth_via_token' => true]);
        return $this;
    }

    protected function createPost($data = null): TestResponse
    {
        return $this->postJson(self::POSTS_ENDPOINT, $data ?? [
                'title' => 'Test Post',
                'slug' => 'test-post',
                'description' => 'Test Post Description',
                'user_id' => $this->user->id
            ]);
    }
}

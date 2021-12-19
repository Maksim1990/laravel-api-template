<?php

namespace Database\Factories;

use App\Models\User;
use App\Utils\ModelUtil;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'slug' => Str::snake($this->faker->regexify('[a-z]{5,10}-[a-z]{5,10}')),
            'description' => $this->faker->realText(300),
            'user_id' => ModelUtil::getRandomModelId(User::class),
        ];
    }
}

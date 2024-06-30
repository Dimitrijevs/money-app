<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Comment;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'post_id' => $this->faker->numberBetween(-10000, 10000),
            'user_id' => $this->faker->numberBetween(-10000, 10000),
            'content' => $this->faker->paragraphs(3, true),
            'published' => $this->faker->boolean(),
            'published_at' => $this->faker->word(),
            'parent_id' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}

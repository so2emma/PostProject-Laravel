<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;


class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'content'=> $this->faker->sentence(10),
            'created_at' => $this->faker->dateTimeBetween('-3 months')
            // 'blog_post_id'=>13,

        ];
    }
}

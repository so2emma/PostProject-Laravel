<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;
use App\Models\Profile;


class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function configure()
    {
        return $this
        ->afterMaking(function (Author $author) {
            //
        })
        ->afterCreating(function (Author $author) {
            //
            $author->profile()->save(Profile::factory()->make());
        });
    }
}

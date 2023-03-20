<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::all()->count();

        if (0 === $tagCount){
            $this->command->info("No tags found, Skipping tags to Blog Post");
            return;
        }

        $howManyMIn = (int)$this->command->ask('Minimum Tags on a blog Post ', 0);
        $howManyMax = min((int)$this->command->ask("Maximum tags on blog post?", $tagCount), $tagCount);

        BlogPost::all()->each(function (BlogPost $post) use($howManyMIn, $howManyMax) {
            $take = random_int($howManyMIn, $howManyMax);
            $tags = Tag::inRandomOrder()->take($take)->get()->pluck("id");
            $post->tags()->sync($tags);
        });

    }
}

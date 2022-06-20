<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        if($this->command->confirm('Do you want to refresh the database? '))
        {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }
       $this->call([
           UsersTableSeeder::class,
           BlogPostsTableSeeder::class,
           CommentsTableSeeder::class]);
    }
}

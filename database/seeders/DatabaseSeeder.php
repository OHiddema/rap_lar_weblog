<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Users and tags already created manually

        // Create 100 articles and 3 comments for each article 
        \App\Models\Article::factory()
            ->times(100)
            ->hasComments(3)
            ->create();

        // Give each article one random tag and one random like
        $articles = \App\Models\Article::all();
        foreach ($articles as $article) {
            DB::table('article_tag')->insert([
                'article_id' => $article->id,
                'tag_id' => \App\Models\Tag::inRandomOrder()->first()->id
            ]);
            DB::table('likes')->insert([
                'article_id' => $article->id,
                'user_id' => \App\Models\User::inRandomOrder()->first()->id
            ]);
        }
    }
}

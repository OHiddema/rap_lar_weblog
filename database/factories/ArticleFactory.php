<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            // 'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence(6,true),
            'excerpt' => $this->faker->sentences(3,true),
            'body' => $this->faker->paragraphs(3,true)
        ];
    }
}

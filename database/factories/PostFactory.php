<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    // protected $model = Post::class;
    protected $model = \App\Models\Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $number = [1,2,3,4,5];
        return [
            'title' => $this-> faker->text(50),
            'post_text' => $this->faker->text(500),
            'category_id' => $number[rand(0,4)],
        ];
    }
}
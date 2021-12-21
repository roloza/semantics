<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected string $model = Post::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image_id' => $this->faker->numberBetween(1,4),
            'description' => $this->faker->text(200),
            'content' => $this->faker->realTextBetween(350, 850),
            'keywords' => $this->faker->word() . ',' . $this->faker->word() . ', ' . $this->faker->word(),
            'author' => $this->faker->firstName(),
            'parent_id' => null,
            'category_id' => $this->faker->numberBetween(1,4),
            'published' => 1,
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),


        ];
    }
}

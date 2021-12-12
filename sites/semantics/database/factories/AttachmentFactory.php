<?php

namespace Database\Factories;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttachmentFactory extends Factory
{
    protected string $model = Attachment::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name() . '.jpg',
            'attachable_id' => $this->faker->randomDigitNotNull,
            'attachable_type' => $this->faker->name()
        ];
    }
}

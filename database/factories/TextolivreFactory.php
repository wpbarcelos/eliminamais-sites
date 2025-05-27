<?php

namespace Database\Factories;

use App\Models\Textolivre;
use Illuminate\Database\Eloquent\Factories\Factory;

class TextolivreFactory extends Factory
{
    protected $model = Textolivre::class;

    public function definition()
    {
        return [
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}

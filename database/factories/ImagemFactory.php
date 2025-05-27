<?php

namespace Database\Factories;

use App\Models\Imagem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImagemFactory extends Factory
{
    protected $model = Imagem::class;

    public function definition()
    {
        return [
            'url' => $this->faker->imageUrl,
            'caption' => $this->faker->optional()->sentence,
        ];
    }
}

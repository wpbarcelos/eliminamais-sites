<?php

namespace Database\Factories;

use App\Models\Component;
use App\Models\Page;
use App\Models\Video;
use App\Models\Textolivre;
use App\Models\Imagem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComponentFactory extends Factory
{
    protected $model = Component::class;

    public function definition()
    {
        $componentableType = $this->faker->randomElement(['Video', 'Textolivre', 'Imagem']);
        $componentable = null;

        switch ($componentableType) {
            case 'Video':
                $componentable = Video::factory()->create();
                break;
            case 'Textolivre':
                $componentable = Textolivre::factory()->create();
                break;
            case 'Imagem':
                $componentable = Imagem::factory()->create();
                break;
        }

        return [
            'page_id' => Page::factory(),
            'type' => strtolower($componentableType),
            'order' => $this->faker->numberBetween(1, 10),
            'componentable_id' => $componentable->id,
            'componentable_type' => 'App\Models\\' . $componentableType,
        ];
    }
}

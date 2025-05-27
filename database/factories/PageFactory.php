<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\Subdomain;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        return [
            'subdomain_id' => Subdomain::factory(),
            'title' => $this->faker->sentence,
            'slug' => $this->faker->unique()->slug,
        ];
    }
}

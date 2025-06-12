<?php

namespace Database\Factories;

use App\Models\Subdomain;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubdomainFactory extends Factory
{
    protected $model = Subdomain::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'domain' => $this->faker->unique()->domainName,
            'description'=> $this->faker->sentence,
        ];
    }
}

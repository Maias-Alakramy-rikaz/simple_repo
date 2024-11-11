<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'code' => $this->faker->numberBetween(0, 10000),
            'min_quan' => $this->faker->numberBetween(1, 10000),
            'price' => $this->faker->numberBetween(500, 1000),
            'activated' => $this->faker->boolean(),
            'group_id' => Group::inRandomOrder()->first(),
        ];
    }
}

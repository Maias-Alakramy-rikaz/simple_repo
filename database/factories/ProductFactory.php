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
        $code = 'P'.$this->faker->numberBetween(10000, 99999);

        return [
            'name' => $this->faker->word(),
            'code' => $code,
            'min_quan' => $this->faker->numberBetween(1, 50),
            'price' => $this->faker->numberBetween(500, 1000),
            'activated' => $this->faker->boolean(),
            'group_id' => Group::inRandomOrder()->first(),
        ];
    }
}

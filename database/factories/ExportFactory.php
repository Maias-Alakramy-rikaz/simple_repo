<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Export;
use App\Models\Exporter;
use App\Models\Product;

class ExportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Export::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'exp_date' => $this->faker->date(),
            'exporter_id' => Exporter::inRandomOrder()->first(),
        ];
    }
}

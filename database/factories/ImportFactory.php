<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Import;
use App\Models\Importer;
use App\Models\Product;

class ImportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Import::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first(),
            'quantity' => $this->faker->numberBetween(20, 100),
            'imp_date' => $this->faker->date(),
            'importer_id' => Importer::inRandomOrder()->first(),
        ];
    }
}

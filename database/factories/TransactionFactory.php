<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Transaction;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(-10000, 10000),
            'category_id' => $this->faker->numberBetween(-10000, 10000),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'type' => $this->faker->word(),
            'recurring' => $this->faker->boolean(),
            'recurring_interval' => $this->faker->word(),
            'price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'place' => $this->faker->word(),
            'date' => $this->faker->word(),
        ];
    }
}

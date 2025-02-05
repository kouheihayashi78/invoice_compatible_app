<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_customer_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'order_product_id1' => $this->faker->numberBetween($min = 1, $max = 10),
            'order_num1' => $this->faker->numberBetween($min = 1, $max = 20),
            'order_product_id2' => $this->faker->numberBetween($min = 1, $max = 10),
            'order_num2' => $this->faker->numberBetween($min = 1, $max = 20),
            'order_product_id3' => $this->faker->numberBetween($min = 1, $max = 10),
            'order_num3' => $this->faker->numberBetween($min = 1, $max = 20),
            'order_day' => date('Y-m-d H:i:s'),
        ];
    }
}

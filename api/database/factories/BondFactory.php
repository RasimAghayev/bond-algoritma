<?php

namespace Database\Factories;

use App\Models\Bond;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bond>
 */
class BondFactory extends Factory
{
    // protected $model = Bond::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'emisia_date' => $this->faker->date('Y-m-d'), //Y-m-d
            'turnover_date' => $this->faker->date('Y-m-d'),//Y-m-d
            'nominal_price' => $this->faker->randomFloat(2),//digit
            'frequency_payment_coupons' => $this->faker->randomElement(['1', '2', '4', '12']),//1, 2, 4, 12
            'period_for_calculating_interest' =>$this->faker->randomElement(['360', '364', '365']),//360, 364, 365
            'coupon_interest' => $this->faker->numberBetween(0, 100),//0-100
          ];
    }
}

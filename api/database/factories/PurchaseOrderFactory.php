<?php

namespace Database\Factories;


use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    
    // protected $model = PurchaseOrder::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_date' => $this->faker->date('Y-m-d'),//Y-m-d
            'number_bonds_received' => $this->faker->randomFloat(2),//digit
        ];
    }
}

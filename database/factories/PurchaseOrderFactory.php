<?php

namespace Database\Factories;


use App\Models\Bond;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseOrder::class;
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

    public function configure()
    {
        return $this->for(
            static::factoryForModel($this->purchaseorder()),
            'bonds',
        );
    }

    public function purchaseorder()
    {
        return $this->faker->randomElement([
            Bond::class,
        ]);
    }
}

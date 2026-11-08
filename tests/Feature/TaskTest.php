<?php

namespace Tests\Feature;

use App\Models\Bond;
use App\Models\PurchaseOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1.Bond Interest Maturity Dates
     *
     * @return void
     */
    public function testBondInterestMaturityDates()
    {
        $bond = Bond::create([
            'emisia_date' => '2021-11-08',
            'turnover_date' => '2022-11-08',
            'nominal_price' => 100.00,
            'frequency_payment_coupons' => '4',
            'period_for_calculating_interest' => '360',
            'coupon_interest' => 10,
        ]);

        $response = $this->json('GET', sprintf('api/bonds/%d/payouts', $bond->id));

        $response->assertStatus(200);
    }

    /**
     * 2.Creating a Bond Purchase Order.
     *
     * @return void
     */
    public function testCreatingaBondPurchaseOrder()
    {
        $bond = Bond::create([
            'emisia_date' => '2021-11-08',
            'turnover_date' => '2022-11-08',
            'nominal_price' => 100.00,
            'frequency_payment_coupons' => '4',
            'period_for_calculating_interest' => '360',
            'coupon_interest' => 10,
        ]);

        $response = $this->json('POST', sprintf('api/bonds/%d/order', $bond->id), [
            'order_date' => '2021-11-23',
            'number_bonds_received' => 30,
        ]);

        $response->assertStatus(200);
    }

    /**
     * 3. Interest Payments on the Bond Order.
     *
     * @return void
     */
    public function testInterestPaymentsontheBondOrder()
    {
        $bond = Bond::create([
            'emisia_date' => '2021-11-08',
            'turnover_date' => '2022-11-08',
            'nominal_price' => 100.00,
            'frequency_payment_coupons' => '4',
            'period_for_calculating_interest' => '360',
            'coupon_interest' => 10,
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'bond_id' => $bond->id,
            'order_date' => '2021-11-23',
            'number_bonds_received' => 30,
        ]);

        $response = $this->json('GET', sprintf('api/bond/order/%d', $purchaseOrder->id));

        $response->assertStatus(200);
    }
}

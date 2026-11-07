<?php

namespace Tests\Feature;

use App\Models\Bond;
use App\Models\PurchaseOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseOrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreatePurchaseOrderForBond(): void
    {
        $bond = Bond::create([
            'emisia_date' => '2021-11-08',
            'turnover_date' => '2022-11-08',
            'nominal_price' => 100.00,
            'frequency_payment_coupons' => '4',
            'period_for_calculating_interest' => '360',
            'coupon_interest' => 10,
        ]);

        $response = $this->postJson("/api/bonds/{$bond->id}/order", [
            'order_date' => '2021-12-01',
            'number_bonds_received' => '30.00',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('purchase_orders', [
            'bond_id' => $bond->id,
            'number_bonds_received' => 30.00,
        ]);
    }

    public function testRejectsOrderDateBeforeEmissionDate(): void
    {
        $bond = Bond::create([
            'emisia_date' => '2021-11-08',
            'turnover_date' => '2022-11-08',
            'nominal_price' => 100.00,
            'frequency_payment_coupons' => '4',
            'period_for_calculating_interest' => '360',
            'coupon_interest' => 10,
        ]);

        $response = $this->postJson("/api/bonds/{$bond->id}/order", [
            'order_date' => '2021-10-01',
            'number_bonds_received' => '30.00',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['error' => 'Alış tarixi “Emissiya tarixi”-dən az ola bilməz.']);
    }

    public function testCanGetOrderPayouts(): void
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
            'order_date' => '2021-12-01',
            'number_bonds_received' => 30.00,
        ]);

        $response = $this->getJson("/api/bond/order/{$purchaseOrder->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure(['payouts' => [['date', 'amount']]]);
    }
}

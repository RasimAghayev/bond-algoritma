<?php

use App\Models\Bond;
use App\Models\PurchaseOrder;

$bondPayload = [
    'emisia_date' => '2021-11-08',
    'turnover_date' => '2022-11-08',
    'nominal_price' => '100.00',
    'frequency_payment_coupons' => '4',
    'period_for_calculating_interest' => '360',
    'coupon_interest' => 10,
];

it('creates a bond and lists it via the API', function () use ($bondPayload) {
    $response = $this->postJson('/api/bonds', $bondPayload);

    $response->assertOk();
    $response->assertJsonPath('bond.nominal_price', 100);
    $this->assertDatabaseHas('bonds', ['nominal_price' => 100.00]);

    $this->getJson('/api/bonds')
        ->assertOk()
        ->assertJsonStructure(['bonds' => [['id', 'emisia_date', 'nominal_price']]]);
});

it('rejects invalid bond payloads', function () use ($bondPayload) {
    $this->postJson('/api/bonds', [...$bondPayload, 'emisia_date' => 'not-a-date'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['emisia_date']);
});

it('returns payout dates for a bond', function () use ($bondPayload) {
    $bond = Bond::query()->create($bondPayload);

    $this->getJson("/api/bonds/{$bond->id}/payouts")
        ->assertOk()
        ->assertJsonStructure(['dates' => [['date']]]);
});

it('creates a purchase order and returns interest payments', function () use ($bondPayload) {
    $bond = Bond::query()->create($bondPayload);

    $orderResponse = $this->postJson("/api/bonds/{$bond->id}/order", [
        'order_date' => '2021-11-23',
        'number_bonds_received' => '30.00',
    ]);

    $orderResponse->assertOk();
    $orderResponse->assertJsonStructure(['purchase_order' => ['id'], 'message']);

    $purchaseOrder = PurchaseOrder::query()->latest('id')->firstOrFail();

    $this->getJson("/api/bond/order/{$purchaseOrder->id}")
        ->assertOk()
        ->assertJsonStructure(['payouts' => [['date', 'amount']]]);
});

it('rejects purchase orders outside the bond circulation period', function () use ($bondPayload) {
    $bond = Bond::query()->create($bondPayload);

    $this->postJson("/api/bonds/{$bond->id}/order", [
        'order_date' => '2020-01-01',
        'number_bonds_received' => '1.00',
    ])->assertStatus(422);
});
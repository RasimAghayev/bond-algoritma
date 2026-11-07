<?php

namespace Tests\Feature;

use App\Models\Bond;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BondApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateAndListBonds(): void
    {
        $response = $this->postJson('/api/bonds', [
            'emisia_date' => '2021-11-08',
            'turnover_date' => '2022-11-08',
            'nominal_price' => '100.00',
            'frequency_payment_coupons' => '4',
            'period_for_calculating_interest' => '360',
            'coupon_interest' => 10,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('bonds', ['nominal_price' => 100.00]);

        $list = $this->getJson('/api/bonds');
        $list->assertStatus(200);
        $list->assertJsonStructure(['bonds' => [*]]);
    }

    public function testCanGetPayoutDates(): void
    {
        $bond = Bond::create([
            'emisia_date' => '2021-11-08',
            'turnover_date' => '2022-11-08',
            'nominal_price' => 100.00,
            'frequency_payment_coupons' => '4',
            'period_for_calculating_interest' => '360',
            'coupon_interest' => 10,
        ]);

        $response = $this->getJson("/api/bonds/{$bond->id}/payouts");
        $response->assertStatus(200);
        $response->assertJsonStructure(['dates' => [['date']]]);
    }

    public function testValidationRejectsInvalidDates(): void
    {
        $response = $this->postJson('/api/bonds', [
            'emisia_date' => 'not-a-date',
            'turnover_date' => '2022-11-08',
            'nominal_price' => '100.00',
            'frequency_payment_coupons' => '4',
            'period_for_calculating_interest' => '360',
            'coupon_interest' => 10,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['emisia_date']);
    }
}

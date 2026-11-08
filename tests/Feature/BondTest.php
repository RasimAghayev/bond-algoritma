<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BondTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_bonds()
    {
        $response = $this->json('GET', 'api/bonds');

        $response->assertStatus(200);
    }

    public function test_create_bonds()
    {
        $response = $this->json('POST', 'api/bonds', [
            'emisia_date' => '2021-11-08',
            'turnover_date' => '2022-11-03',
            'nominal_price' => 999,
            'frequency_payment_coupons' => '12',
            'period_for_calculating_interest' => '365',
            'coupon_interest' => 12,
        ]);

        $response->assertStatus(200);
    }
}

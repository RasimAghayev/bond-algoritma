<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BondResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'emisia_date' => $this->emisia_date,
            'turnover_date' => $this->turnover_date,
            'nominal_price' => (float) $this->nominal_price,
            'frequency_payment_coupons' => $this->frequency_payment_coupons,
            'period_for_calculating_interest' => $this->period_for_calculating_interest,
            'coupon_interest' => $this->coupon_interest,
            'purchase_orders_count' => $this->whenCounted('purchaseOrders'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

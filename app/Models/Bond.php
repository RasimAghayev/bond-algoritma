<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bond extends Model
{
    //public $incrementing = false;
    //public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'emisia_date', //Y-m-d
        'turnover_date',//Y-m-d
        'nominal_price',//digit
        'frequency_payment_coupons',//1, 2, 4, 12
        'period_for_calculating_interest',//360, 364, 365
        'coupon_interest',//0-100
      ];
    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}

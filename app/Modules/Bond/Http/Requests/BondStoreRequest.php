<?php

namespace App\Modules\Bond\Http\Requests;

use App\Enums\FrequencyPaymentCoupons;
use App\Enums\PeriodForCalculatingInterest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BondStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'emisia_date' => ['required', 'date_format:Y-m-d'],
            'turnover_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:emisia_date'],
            'nominal_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'frequency_payment_coupons' => ['required', Rule::in(FrequencyPaymentCoupons::cases())],
            'period_for_calculating_interest' => ['required', Rule::in(PeriodForCalculatingInterest::cases())],
            'coupon_interest' => ['required', 'integer', 'between:0,100'],
        ];
    }
}

<?php

namespace App\Modules\Bond\Entities;

use App\Modules\Bond\ValueObjects\DateRange;
use App\Modules\Bond\ValueObjects\Money;

class BondTerms
{
    public DateRange $period;
    public Money $nominalPrice;
    public int $frequencyPaymentCoupons;
    public int $periodForCalculatingInterest;
    public int $couponInterest;

    public function __construct(
        DateRange $period,
        Money $nominalPrice,
        int $frequencyPaymentCoupons,
        int $periodForCalculatingInterest,
        int $couponInterest
    ) {
        $this->period = $period;
        $this->nominalPrice = $nominalPrice;
        $this->frequencyPaymentCoupons = $frequencyPaymentCoupons;
        $this->periodForCalculatingInterest = $periodForCalculatingInterest;
        $this->couponInterest = $couponInterest;
    }

    public static function fromBond(\App\Models\Bond $bond): self
    {
        return new self(
            new DateRange(
                new \DateTime($bond->emisia_date),
                new \DateTime($bond->turnover_date)
            ),
            new Money((float) $bond->nominal_price),
            (int) $bond->frequency_payment_coupons,
            (int) $bond->period_for_calculating_interest,
            (int) $bond->coupon_interest
        );
    }

    public function interestAccrualPeriod(): float
    {
        return match ($this->periodForCalculatingInterest) {
            360 => (12 / $this->frequencyPaymentCoupons) * 30,
            364 => 364 / $this->frequencyPaymentCoupons,
            365 => 12 / $this->frequencyPaymentCoupons,
            default => throw new \InvalidArgumentException("Unsupported period: {$this->periodForCalculatingInterest}"),
        };
    }

    public function accrualUnit(): string
    {
        return match ($this->periodForCalculatingInterest) {
            360, 364 => 'day',
            365 => 'month',
            default => throw new \InvalidArgumentException("Unsupported period: {$this->periodForCalculatingInterest}"),
        };
    }
}

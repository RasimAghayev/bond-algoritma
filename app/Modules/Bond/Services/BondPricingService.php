<?php

namespace App\Modules\Bond\Services;

use App\Models\Bond;
use App\Models\PurchaseOrder;
use App\Modules\Bond\Entities\BondTerms;

class BondPricingService
{
    public function calculatePayoutDates(Bond $bond): array
    {
        $terms = BondTerms::fromBond($bond);
        $period = $terms->period;
        $accrualPeriod = $terms->interestAccrualPeriod();
        $unit = $terms->accrualUnit();
        $countPeriod = $unit === 'day' ? $period->totalDays() : $period->totalMonths();

        $dates = [];
        for ($i = $accrualPeriod; $i <= $countPeriod; $i += $accrualPeriod) {
            $paidDate = (clone $period->start())->modify("+{$i} {$unit}");
            $paidDate = $this->shiftToNextMondayIfWeekend($paidDate);
            $dates[] = ['date' => $paidDate->format('Y-m-d')];
        }

        return $dates;
    }

    public function calculateOrderPayouts(int $purchaseOrderId): array
    {
        $purchaseOrder = PurchaseOrder::findOrFail($purchaseOrderId);
        $bond = $purchaseOrder->bond;

        $terms = BondTerms::fromBond($bond);
        $dates = $this->calculatePayoutDates($bond);

        $orderPayment = [];
        $dateOld = null;
        $period = $terms->period;
        $frequency = $terms->frequencyPaymentCoupons;
        $nominalPrice = $terms->nominalPrice->amount();
        $couponInterest = $terms->couponInterest;
        $numberBondsReceived = (int) $purchaseOrder->number_bonds_received;

        foreach ($dates as $dateEntry) {
            $paidDate = new \DateTime($dateEntry['date']);
            $turnoverDate = $dateOld ? (clone $dateOld)->modify('-1 day') : $period->start();
            $interval = $paidDate->diff($turnoverDate);
            $pastDays = (int) $interval->format('%a');
            $accumulatedInterest = ($nominalPrice / 100 * $couponInterest) / $frequency * $pastDays * $numberBondsReceived;
            $dateOld = $paidDate;
            $orderPayment[] = ['date' => $paidDate->format('Y-m-d'), 'amount' => $accumulatedInterest];
        }

        return $orderPayment;
    }

    private function shiftToNextMondayIfWeekend(\DateTime $date): \DateTime
    {
        $weekNum = (int) $date->format('w');
        if ($weekNum === 6 || $weekNum === 0) {
            $nextMonday = ($weekNum === 6) ? 2 : 1;
            $date->modify("+{$nextMonday} day");
        }
        return $date;
    }
}

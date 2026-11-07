<?php

namespace Tests\Unit;

use App\Modules\Bond\Entities\BondTerms;
use App\Modules\Bond\ValueObjects\DateRange;
use App\Modules\Bond\ValueObjects\Money;
use DateTime;
use PHPUnit\Framework\TestCase;

class BondTermsTest extends TestCase
{
    public function testInterestAccrualPeriod360ReturnsDays(): void
    {
        $terms = new BondTerms(
            new DateRange(new DateTime('2021-01-01'), new DateTime('2021-12-31')),
            new Money(1000),
            4,
            360,
            10
        );
        $this->assertSame(90.0, $terms->interestAccrualPeriod());
        $this->assertSame('day', $terms->accrualUnit());
    }

    public function testInterestAccrualPeriod365ReturnsMonths(): void
    {
        $terms = new BondTerms(
            new DateRange(new DateTime('2021-01-01'), new DateTime('2021-12-31')),
            new Money(1000),
            4,
            365,
            10
        );
        $this->assertSame(3.0, $terms->interestAccrualPeriod());
        $this->assertSame('month', $terms->accrualUnit());
    }

    public function testMoneyOperations(): void
    {
        $money = new Money(100, 'AZN');
        $this->assertSame(200.0, $money->multiply(2)->amount());
        $this->assertSame(50.0, $money->divide(2)->amount());
        $this->assertSame(150.0, $money->add(new Money(50))->amount());
        $this->assertSame('AZN', $money->currency());
    }

    public function testDateRangeCalculatesDaysAndMonths(): void
    {
        $range = new DateRange(new DateTime('2021-01-01'), new DateTime('2021-01-10'));
        $this->assertSame(9, $range->totalDays());
        $this->assertSame(0, $range->totalMonths());
    }

    public function testDateRangeRejectsStartAfterEnd(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new DateRange(new DateTime('2021-12-31'), new DateTime('2021-01-01'));
    }
}

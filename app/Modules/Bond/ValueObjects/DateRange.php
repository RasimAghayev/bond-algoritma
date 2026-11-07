<?php

namespace App\Modules\Bond\ValueObjects;

use DateTime;

class DateRange
{
    private DateTime $start;
    private DateTime $end;

    public function __construct(DateTime $start, DateTime $end)
    {
        if ($start > $end) {
            throw new \InvalidArgumentException('Start date must be before or equal to end date.');
        }
        $this->start = $start;
        $this->end = $end;
    }

    public function start(): DateTime
    {
        return $this->start;
    }

    public function end(): DateTime
    {
        return $this->end;
    }

    public function totalDays(): int
    {
        return (int) $this->start->diff($this->end)->format('%a');
    }

    public function totalMonths(): int
    {
        $diff = $this->start->diff($this->end);
        return (int) $diff->format('%r%y') * 12 + (int) $diff->format('%r%m');
    }
}

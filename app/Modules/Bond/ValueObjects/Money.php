<?php

namespace App\Modules\Bond\ValueObjects;

class Money
{
    private float $amount;
    private string $currency;

    public function __construct(float $amount, string $currency = 'AZN')
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function multiply(float $factor): self
    {
        return new self($this->amount * $factor, $this->currency);
    }

    public function divide(float $divisor): self
    {
        return new self($this->amount / $divisor, $this->currency);
    }

    public function add(self $money): self
    {
        return new self($this->amount + $money->amount, $this->currency);
    }

    public function __toString(): string
    {
        return number_format($this->amount, 2, ',', '.') . ' ' . $this->currency;
    }
}

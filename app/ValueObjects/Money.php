<?php

namespace App\ValueObjects;

final class Money
{
    public function __construct(public readonly int $cents) {}

    public static function fromRinggit(float|int|string $ringgit): self
    {
        return new self((int) round(((float) $ringgit) * 100));
    }

    public function ringgit(): float
    {
        return $this->cents / 100;
    }

    public function format(string $currency = 'RM'): string
    {
        return $currency.' '.number_format($this->ringgit(), 2);
    }

    public function add(Money $other): self
    {
        return new self($this->cents + $other->cents);
    }

    public function subtract(Money $other): self
    {
        return new self($this->cents - $other->cents);
    }

    public function __toString(): string
    {
        return $this->format();
    }
}

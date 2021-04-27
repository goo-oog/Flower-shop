<?php
declare(strict_types=1);

namespace Flowershop;

class Female implements Customer
{
    private const DISCOUNT = 0.2;
    private const DISCOUNT_MESSAGE = ' (-20% feminine discount applied)';

    public function discount(): float
    {
        return self::DISCOUNT;
    }

    public function discountMessage(): string
    {
        return self::DISCOUNT_MESSAGE;
    }
}
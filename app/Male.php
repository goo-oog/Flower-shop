<?php
declare(strict_types=1);

namespace Flowershop;

class Male implements Customer
{
    private const DISCOUNT = 0;
    private const DISCOUNT_MESSAGE = '';

    public function discount(): float
    {
        return self::DISCOUNT;
    }

    public function discountMessage(): string
    {
        return self::DISCOUNT_MESSAGE;
    }
}
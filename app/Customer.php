<?php
declare(strict_types=1);

namespace Flowershop;

interface Customer
{
    public function discount(): float;

    public function discountMessage(): string;
}
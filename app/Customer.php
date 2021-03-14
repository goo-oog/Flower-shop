<?php
declare(strict_types=1);

namespace Flowershop;

interface Customer
{
    public function bill(float $amount): string;
}
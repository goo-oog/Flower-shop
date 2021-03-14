<?php
declare(strict_types=1);

namespace Flowershop;

interface Customer
{
    public function gender():string;
    public function bill(float $amount): string;
}
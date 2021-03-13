<?php
declare(strict_types=1);

namespace Flowers;

interface Customer
{
    public function bill(float $amount): string;
}
<?php
declare(strict_types=1);

namespace Flowers;

class Male implements Customer
{

    public function bill(float $amount): string
    {
        return sprintf("%0.2f €\n\n", $amount);
    }
}
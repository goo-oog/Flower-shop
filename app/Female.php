<?php
declare(strict_types=1);

namespace Flowershop;

class Female implements Customer
{
    public function bill(float $amount): string
    {
        return sprintf("%0.2f €     (-20%% feminine discount applied)\n\n", $amount * 0.8);
    }
}
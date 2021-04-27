<?php
declare(strict_types=1);

namespace Flowershop;

interface Warehouse
{
    /**@return Flower[] */
    public function inventory(): array;

}
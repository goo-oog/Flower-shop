<?php
declare(strict_types=1);

namespace Flowers;

interface Warehouse
{
    /**@return Flower[] */
    public function inventory(): array;

    public function addFlowers(array $flowers): void;
}
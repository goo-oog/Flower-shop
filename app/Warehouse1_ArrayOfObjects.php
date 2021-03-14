<?php
declare(strict_types=1);

namespace Flowershop;

class Warehouse1_ArrayOfObjects implements Warehouse
{
    /**@var Flower[] */
    private array $inventory = [];

    /**@return Flower[] */
    public function inventory(): array
    {
        return $this->inventory;
    }

    public function addFlowers(array $flowers): void
    {
        foreach ($flowers as $name => $amount) {
            $this->inventory[] = new Flower($name, $amount);
        }
    }
}
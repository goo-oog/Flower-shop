<?php
declare(strict_types=1);

namespace Flowers;

class Warehouse2_AssociativeArray implements Warehouse
{
    /**@var array[string]string */
    private array $inventory = [];

    /**@return Flower[] */
    public function inventory(): array
    {
        $flowers = [];
        foreach ($this->inventory as $name => $amount) {
            $flowers[] = new Flower($name, $amount);
        }
        return $flowers;
    }

    public function addFlowers(array $flowers): void
    {
        $this->inventory = $flowers;
    }
}
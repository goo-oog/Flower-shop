<?php
declare(strict_types=1);

namespace Flowershop;

class Warehouse3_CommaSeparatedString implements Warehouse
{
    /**@var string */
    private string $inventory = '';

    /**@return Flower[] */
    public function inventory(): array
    {
        /** @var string[] $flowers */
        $flowers = explode(',', $this->inventory);
        array_pop($flowers);

        /** @var Flower[] $output */
        $output = [];

        for ($i = 0, $iMax = count($flowers); $i < $iMax; $i += 2) {
            $output[] = new Flower($flowers[$i], (int)$flowers[$i + 1]);
        }
        return $output;
    }

    public function addFlowers(array $flowers): void
    {
        foreach ($flowers as $name => $amount) {
            $this->inventory .= $name . ',' . $amount . ',';
        }
    }
}
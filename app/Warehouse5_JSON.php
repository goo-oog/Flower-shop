<?php
declare(strict_types=1);

namespace Flowershop;

class Warehouse5_JSON implements Warehouse
{
    /**@var Flower[] */
    private array $inventory = [];

    public function __construct()
    {
        $json = json_decode(file_get_contents('storage/warehouse5.json'));
        foreach ($json as $flower) {
            $this->inventory[] = new Flower($flower->name, $flower->amount);
        }
    }

    /**@return Flower[] */
    public function inventory(): array
    {
        return $this->inventory;
    }
}
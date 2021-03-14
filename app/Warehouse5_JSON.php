<?php
declare(strict_types=1);

namespace Flowershop;

class Warehouse5_JSON implements Warehouse
{
    /**@var Flower[] */
    private array $inventory = [];

    public function __construct(){
        $json=json_decode(file_get_contents('storage/warehouse5.json'), true);
        foreach ($json as $flower=>$amount){
            $this->inventory[] = new Flower($flower, (int)$amount);
        }
    }

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
<?php
declare(strict_types=1);

namespace Flowershop;

use League\Csv\Reader;

class Warehouse4_CSV implements Warehouse
{
    /**@var Flower[] */
    private array $inventory = [];

    public function __construct()
    {
        $csv = Reader::createFromPath('storage/warehouse4.csv');
        $csv->setHeaderOffset(0);
        $csvRecords = $csv->getRecords();
        foreach ($csvRecords as $record) {
            $this->inventory[] = new Flower($record['flower'], (int)$record['amount']);
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
<?php
declare(strict_types=1);

namespace Flowershop;

class Shop
{
    /**@var Flower[] */
    private array $inventory = [];
    private array $priceList = [];
    /**@var Flower[] */
    private array $basket = [];

    public function __construct()
    {
        $warehouse4 = new Warehouse4_CSV();
        $warehouse5 = new Warehouse5_JSON();
        $warehouse6 = new Warehouse6_SQL();
        $this->addWarehouse($warehouse4);
        $this->addWarehouse($warehouse5);
        $this->addWarehouse($warehouse6);
        $this->setPriceList([
            'Tulip' => 0.75,
            'Rose' => 2.70,
            'Lily' => 3.50,
            'Hyacinth' => 1.20,
            'Orchid' => 2.00,
            'Daffodil' => 0.50
        ]);
    }

    public function addWarehouse(Warehouse $warehouse): void
    {
        foreach ($warehouse->inventory() as $flower) {
            if (in_array($flower->name(), array_column($this->inventory, 'name'), true)) {
                $this->searchInventory($flower->name())->addToAmount($flower->amount());
            } else {
                $this->inventory[] = $flower;
            }
        }
        sort($this->inventory);
    }

    private function searchInventory(string $name): ?Flower
    {
        foreach ($this->inventory as $i => $flower) {
            if ($flower->name() === $name) {
                return $this->inventory[$i];
            }
        }
        return null;
    }

    private function searchBasket(string $name): ?Flower
    {
        foreach ($this->basket as $i => $flower) {
            if ($flower->name() === $name) {
                return $this->basket[$i];
            }
        }
        return null;
    }

    public function inventory(): array
    {
        return $this->inventory;
    }

    public function restoreInventory(array $inventory): void
    {
        $this->inventory = $inventory;
    }

    public function sell(int $flowerIndex, int $amount): void
    {
        $this->inventory[$flowerIndex]->subtractFromAmount($amount);
    }

    public function setPriceList(array $priceList): void
    {
        $this->priceList = $priceList;
    }

    public function price(string $name): float
    {
        if (array_key_exists($name, $this->priceList)) {
            return $this->priceList[$name];
        }
        return 0;
    }

    public function basket(): array
    {
        return $this->basket;
    }

    public function grandTotal(): float
    {
        $total = 0;
        foreach ($this->basket as $flower) {
            $total += $this->price($flower->name()) * $flower->amount();
        }
        return $total;
    }

    public function addToBasket(Flower $flower): void
    {
        if (in_array($flower->name(), array_column($this->basket, 'name'), true)) {
            $this->searchBasket($flower->name())->addToAmount($flower->amount());
        } else {
            $this->basket[] = $flower;
        }
    }

    public function restoreBasket(array $basket): void
    {
        $this->basket = $basket;
    }
}
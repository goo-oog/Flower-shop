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
    public array $exceptions = [];

    public function addWarehouse(Warehouse $warehouse): void
    {
        foreach ($warehouse->inventory() as $flower) {
            if (in_array($flower->name(), array_column($this->inventory, 'name'), true)) {
                try {
                    $this->findFlower($flower->name())->addToAmount($flower->amount());
                } catch (FlowerNotFoundException $exception) {
                    $this->exceptions[] = $exception;
                }
            } else {
                $this->inventory[] = $flower;
            }
        }
        sort($this->inventory);
    }

    /**
     * @param $name
     * @return Flower
     * @throws FlowerNotFoundException
     */
    private function findFlower(string $name): Flower
    {
        foreach ($this->inventory as $i => $flower) {
            if ($flower->name() === $name) {
                return $this->inventory[$i];
            }
        }
        throw new FlowerNotFoundException('Flower not found');
    }

    public function inventory(): array
    {
        return $this->inventory;
    }

    public function setPriceList(array $priceList): void
    {
        $this->priceList = $priceList;
    }

    /**
     * @param $name
     * @return float
     * @throws PriceNotFoundException
     */
    public function price(string $name): float
    {
        if (array_key_exists($name, $this->priceList)) {
            return $this->priceList[$name];
        }
        throw new PriceNotFoundException('Flower do not have price');
    }

    public function addToBasket(Flower $flower): void
    {
        $this->basket[] = $flower;
    }

    /**
     * @param Customer $customer
     * @return string
     * @throws PriceNotFoundException
     */
    public function printBasket(Customer $customer): string
    {
        $output = "\n";
        foreach ($this->basket as $flower) {
            $output .= $flower->name() . '     price: ';
            $output .= sprintf('%0.2f €', $this->price($flower->name()));
            $output .= '    x' . $flower->amount() . '     total: ';
            $output .= $customer->bill($this->price($flower->name()) * $flower->amount());
        }
        return $output;
    }
}
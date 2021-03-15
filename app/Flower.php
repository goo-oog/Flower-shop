<?php
/** @noinspection MagicMethodsValidityInspection */
/** @noinspection PhpVariableVariableInspection */
declare(strict_types=1);

namespace Flowershop;

class Flower
{
    private string $name;
    private int $amount;

    public function __construct(string $name, int $amount)
    {
        $this->name = $name;
        $this->amount = $amount;
    }

    public function __get(string $name): string
    {
        return $this->$name;
    }

    public function __isset(string $name): bool
    {
        return isset($this->$name);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function addToAmount(int $amount): void
    {
        $this->amount += $amount;
    }

    public function subtractFromAmount(int $amount): void
    {
        $this->amount -= $amount;
    }
}
<?php
declare(strict_types=1);


namespace Flowershop\Controllers;


class CheckoutController
{
    public static function index(): void
    {
        require_once __DIR__ . '/../view/_checkout.php';
    }
}
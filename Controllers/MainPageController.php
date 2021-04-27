<?php
declare(strict_types=1);


namespace Flowershop\Controllers;


class MainPageController
{
    public static function index(): void
    {
        require_once __DIR__ . '/../view/_main-page.php';
    }
}
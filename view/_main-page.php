<?php
declare(strict_types=1);

namespace Flowershop;

$shop = new Shop();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['inventory'])) {
    $shop->restoreInventory($_SESSION['inventory']);
    $shop->restoreBasket($_SESSION['basket']);
    if (isset($_POST['number'], $_POST['amount'])
        && $_POST['number'] !== '' && $_POST['amount'] !== '' && $_POST['amount'] !== '0') {
        $itemNumber = $_POST['number'];
        $itemAmount = $_POST['amount'];
        $shop->addToBasket(new Flower($shop->inventory()[$itemNumber]->name(), (int)$itemAmount));
        $shop->sell((int)$itemNumber, (int)$itemAmount);
    }
}
$_SESSION['inventory'] = $shop->inventory();
$_SESSION['basket'] = $shop->basket();

require 'header.php';
require 'inventory.php';
require 'basket.php';
if (!empty($shop->basket())) {
    require 'checkout-button.php';
}
require 'footer.php';
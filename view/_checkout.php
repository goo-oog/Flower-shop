<?php
declare(strict_types=1);

namespace Flowershop;

$shop = new Shop();

$shop->restoreInventory($_SESSION['inventory']);
$shop->restoreBasket($_SESSION['basket']);

require 'header.php';
if (isset($_POST['gender'])) {
    require 'home-button.php';
    /** @var Customer $customer */
    $customer = $_POST['gender'] === 'male' ? new Male() : new Female();
    require 'basket.php';
    $_SESSION['basket'] = [];
} else {
    require 'gender-selector.php';
}
require 'footer.php';

$_SESSION['inventory'] = $shop->inventory();
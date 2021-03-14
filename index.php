<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

use Flowershop\Female;
use Flowershop\Flower;
use Flowershop\Male;
use Flowershop\PriceNotFoundException;
use Flowershop\Shop;
use Flowershop\Warehouse1_ArrayOfObjects;
use Flowershop\Warehouse2_AssociativeArray;
use Flowershop\Warehouse3_CommaSeparatedString;
use Flowershop\Warehouse4_CSV;
use Flowershop\Warehouse5_JSON;

$warehouse1 = new Warehouse1_ArrayOfObjects();
$warehouse2 = new Warehouse2_AssociativeArray();
$warehouse3 = new Warehouse3_CommaSeparatedString();
$warehouse4 = new Warehouse4_CSV();
$warehouse5 = new Warehouse5_JSON();

$warehouse1->addFlowers(['Tulip' => 427, 'Rose' => 93, 'Lily' => 193]);
$warehouse2->addFlowers(['Tulip' => 359, 'Rose' => 85, 'Hyacinth' => 315]);
$warehouse3->addFlowers(['Tulip' => 178, 'Orchid' => 251, 'Daffodil' => 849]);

$shop = new Shop();
$shop->addWarehouse($warehouse1);
$shop->addWarehouse($warehouse2);
$shop->addWarehouse($warehouse3);
$shop->addWarehouse($warehouse4);
$shop->addWarehouse($warehouse5);
$shop->setPriceList([
    'Tulip' => 0.75,
    'Rose' => 2.70,
    'Lily' => 3.50,
    'Hyacinth' => 1.20,
    'Orchid' => 2.00,
    'Daffodil' => 0.50,
    'Xeranthemum' => 4.90,
    'Xylobium' => 5.60,
    'Xylosma' => 3.80,
    'Zenobia' => 8.30,
    'Zephyranthes' => 7.70
]);
if (($_SERVER['REQUEST_METHOD'] === 'POST') && $_POST['amount'] > $shop->inventory()[$_POST['number'] - 1]->amount()) {
    $_POST['amount'] = $shop->inventory()[$_POST['number'] - 1]->amount();
} ?>

<html lang="en">
<head>
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="text/html">
    <title>Flowershop</title>
</head>
<body>
<table id="list">
    <tr>
        <td class='header'>#</td>
        <td class='header'>Flower</td>
        <td class='header'>Amount</td>
        <td class='header'>Price</td>
    </tr>
    <?php
    foreach ($shop->inventory() as $number => $flower): ?>
    <tr>
        <td class='number'><?= ($number + 1) ?></td>
        <td><?= $flower->name() ?></td>
        <td class='amount'><?= $flower->amount() ?></td>
        <?php try {
            printf('<td class="price">%0.2f €</td>', $shop->price($flower->name()));
        } catch (PriceNotFoundException $exception) {
            $shop->exceptions[] = $exception; ?>
            <td class='no-price'>no price</td>
        <?php }
        endforeach; ?>
    </tr>
</table>
<br><br>

<form id="form" method="post">
    <label for="number">Enter flower # : </label>
    <input class="input-box" type="number" id="number" name="number" value="<?= $_POST['number'] ?? '1' ?>"
           min="1" max="<?= count($shop->inventory()) ?>"><br><br>
    <label for="amount">Enter amount : </label>
    <input class="input-box" type="number" id="amount" name="amount" value="<?= $_POST['amount'] ?? '1' ?>"
           min="1"><br>
    <p>What is your gender?</p>
    <input type="radio" id="male" name="gender" value="male"
        <?php if (isset($_POST['gender']) && $_POST['gender'] === 'male'): ?>
           checked="checked"> <?php endif; ?>
    <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="female"
        <?php if (isset($_POST['gender']) && $_POST['gender'] === 'female'): ?>
           checked="checked"><?php endif; ?>
    <label for="female">Female</label><br><br>
    <input type="submit" value="Submit" class="button">
</form>

<?php
if (isset($_POST['gender'], $_POST['number'], $_POST['amount'])):
    $customer = $_POST['gender'] === 'male' ? new Male() : new Female();
    $itemNumber = $_POST['number'];
    $itemAmount = $_POST['amount'];
    $shop->addToBasket(new Flower($shop->inventory()[$itemNumber - 1]->name(), (int)$itemAmount));
    try { ?>
        <span class='basket'><?= $shop->printBasket($customer) ?></span>
        <br>
        <p>Thank you for the purchase!</p>
    <?php } catch (PriceNotFoundException $exception) {
        $shop->exceptions[] = $exception; ?>
        <p>That flower does not have price try once more</p>
    <?php }
endif; ?>

</body>
</html>

<style type="text/css">
    body {
        font-family: sans-serif;
        line-height: 50%;
    }

    table {
        border-style: solid;
        border-width: 5px;
        border-collapse: collapse;
        border-color: black;
    }

    tr:nth-child(odd) {
        background-color: #eeeeee;
    }

    td, header {
        padding: 7px;
        border-style: solid;
        border-width: 2px;
        border-color: black;
    }

    .header {
        background-color: maroon;
        color: white;
        border-right-color: white;
        border-bottom-width: 5px;
        text-align: center;
        font-weight: bold;
    }

    .amount, .number {
        text-align: right;
        padding-right: 20px;
        padding-left: 20px;
    }

    .price, .no-price {
        text-align: center;
    }

    .no-price {
        color: maroon;
        font-size: small;
    }

    .basket {
        white-space: pre;
        font-size: x-large;
    }

    .button {
        background-color: white;
        color: black;
        border: 2px solid maroon;
        width: 100px;
        height: 30px;
    }

    .button:hover {
        background-color: maroon;
        color: white;
    }

    .input-box {
        width: 100px;
    }
</style>
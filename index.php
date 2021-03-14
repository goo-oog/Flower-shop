<?php
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
?>

<html lang="en">
<head>
    <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="text/html">
    <title>Flowershop</title>
</head>
<body>
<table>
    <tr>
        <td class='header'>Flower</td>
        <td class='header'>Amount</td>
        <td class='header'>Price</td>
    </tr>
    <?php
    foreach ($shop->inventory() as $number => $flower) {
        echo "<tr><td>{$flower->name()}</td><td class='amount'>{$flower->amount()}</td>";
        try {
            printf("<td>%0.2f €</td></tr>", $shop->price($flower->name()));
        } catch (PriceNotFoundException $exception) {
            $shop->exceptions[] = $exception;
            echo "<td class='no-price'>no price</td></tr>";
        }
    } ?>
</table>
<br>

<p>Are you male or female?</p>
<form method="post">
    <input type="radio" id="male" name="gender" value="Male">
    <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="Female">
    <label for="female">Female</label>
    <input type="submit" name="submit" value="Set gender">
</form>
<?php
if (isset($_POST['gender'])) {
    $customer = $_POST['gender'] === 'Male' ? new Male() : new Female();
    echo $customer->gender() . '<br><br><br>' . '<p>Which flower do you like?</p>';
    $itemNumber = 4;
    echo '<p>' . $shop->inventory()[$itemNumber - 1]->name() . '<br><br><br></p>';
    echo '<p>Choose amount!</p>';
    $itemAmount = 9;
    echo "<p>Amount: $itemAmount</p><br>";

    $shop->addToBasket(new Flower($shop->inventory()[$itemNumber - 1]->name(), $itemAmount));

    try {
        echo "<span class='basket'>".$shop->printBasket($customer)."</span>";
        echo "<br><br><br>";
        echo "Thank you for the purchase!<br>";
    } catch (PriceNotFoundException $exception) {
        $shop->exceptions[] = $exception;
        echo "<br>That flower does not have price try once more<br>";
    }
}
?>
</body>
</html>

<style type="text/css">
    body {
        font-size: large;
        font-family: sans-serif;
        line-height: 50%;
    }

    table {
        border-style: solid;
        border-width: 5px;
        border-collapse: collapse;
        border-color: black;
        font-size: large;
        font-family: sans-serif;
    }

    tr:nth-child(odd) {
        background-color: #eeeeee;
    }

    td, header {
        font-size: x-large;
        font-family: sans-serif;
        padding: 10px;
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
    }

    .amount {
        text-align: right;
        padding-right: 20px;
    }

    .no-price {
        color: maroon;
        font-size: medium;
        text-align: center;
    }
    .basket {
        white-space: pre;
        font-size: x-large;
    }
</style>
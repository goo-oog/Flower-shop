<html>
<body>
<?php
require_once 'vendor/autoload.php';

use Flowers\Female;
use Flowers\Flower;
use Flowers\Male;
use Flowers\PriceNotFoundException;
use Flowers\Shop;
use Flowers\Warehouse1_ArrayOfObjects;
use Flowers\Warehouse2_AssociativeArray;
use Flowers\Warehouse3_CommaSeparatedString;
use Flowers\Warehouse4_CSV;
use Flowers\Warehouse5_JSON;

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
    'Daffodil' => 0.50
]);
?>

<table>
    <tr>
        <td>Flower</td>
        <td>Amount</td>
        <td>Price</td>
    </tr>
    <?php
    foreach ($shop->inventory() as $number => $flower) {
        echo "<tr><td>{$flower->name()}</td><td>{$flower->amount()}</td>";
        try {
            printf("<td>%0.2f €</td></tr>", $shop->price($flower->name()));
        } catch (PriceNotFoundException $exception) {
            $shop->exceptions[] = $exception;
            echo "<td>?.?? €</td></tr>";
        }
    } ?>
</table>
<br>

<p>Are you male or female?</p>
<p>Female</p>
<?php $customer = new Female(); ?>
<br>

<p>Which flower do you like?</p>
<?php $itemNumber = 4; ?>
<p><?=$shop->inventory()[$itemNumber - 1]->name();?></p>

<br>

<p>Choose amount!</p>
<?php $itemAmount = 9; ?>
<p><?="Amount: $itemAmount";?></p>
<br>

<?php $shop->addToBasket(new Flower($shop->inventory()[$itemNumber - 1]->name(), $itemAmount));

try {
    echo $shop->printBasket($customer);
    echo "<br><br>";
    echo "Thank you for the purchase!<br>";
} catch (PriceNotFoundException $exception) {
    $shop->exceptions[] = $exception;
    echo "<br>That flower does not have price try once more<br>";
}
?>
</body>
</html>
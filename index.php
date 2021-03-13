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

$warehouse1 = new Warehouse1_ArrayOfObjects();
$warehouse2 = new Warehouse2_AssociativeArray();
$warehouse3 = new Warehouse3_CommaSeparatedString();

$warehouse1->addFlowers(['Tulip' => 427, 'Rose' => 93, 'Lily' => 193]);
$warehouse2->addFlowers(['Tulip' => 359, 'Rose' => 85, 'Hyacinth' => 315]);
$warehouse3->addFlowers(['Tulip' => 178, 'Orchid' => 251, 'Daffodil' => 849]);

$shop = new Shop();
$shop->addWarehouse($warehouse1);
$shop->addWarehouse($warehouse2);
$shop->addWarehouse($warehouse3);
$shop->setPriceList([
    'Tulip' => 0.75,
    'Rose' => 2.70,
    'Lily' => 3.50,
    'Hyacinth' => 1.20,
    'Orchid' => 2.00,
    'Daffodil' => 0.50
]);

echo "<br> # |   Flower   | Amount | Price <br>";
echo "---+------------+--------+--------<br>";
foreach ($shop->inventory() as $number => $flower) {
    echo ' ' . ($number + 1) . ' | ';
    echo $flower->name() . str_repeat(' ', 10 - strlen($flower->name())) . ' |  ';
    echo $flower->amount() . '   | ';
    try {
        printf("%0.2f €<br>", $shop->price($flower->name()));
    } catch (PriceNotFoundException $exception) {
        $shop->exceptions[] = $exception;
        echo "?.?? €<br><br>";
    }
}
echo "<br>";

echo 'Are you male(m) or female(f)?';
echo "<br>";
echo "Female";


$customer = new Female();
echo "<br>";

echo 'Which flower do you like? Enter the number: ';
echo "<br>";


    $itemNumber = 4;


    $itemAmount = 9;


$shop->addToBasket(new Flower($shop->inventory()[$itemNumber - 1]->name(), $itemAmount));

try {
    echo $shop->printBasket($customer);
    echo "Thank you for the purchase!<br>";
} catch (PriceNotFoundException $exception) {
    $shop->exceptions[] = $exception;
    echo "\nThat flower does not have price try once more<br>";
}
?>
</body>
</html>
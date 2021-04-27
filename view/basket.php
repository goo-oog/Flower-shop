<?php
declare(strict_types=1);
/** @var Flowershop\Shop $shop */
if (!empty($shop->basket())):?>
    <h4>Basket</h4>
    <table>
        <?php foreach ($shop->basket() as $flower): ?>
            <tr>
                <td class="name"><?= $flower->name() ?></td>
                <td class="price">price: <?= sprintf('%0.2f €', $shop->price($flower->name())) ?></td>
                <td class="amount">x <?= $flower->amount() ?></td>
                <td class="price">
                    total: <?= sprintf('%0.2f €', $shop->price($flower->name()) * $flower->amount()) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (isset($_POST['gender'])): ?>
            <tr>
                <td colspan="4" class="grand-total">
                    <?=
                    /** @var Flowershop\Customer $customer */
                    sprintf('Grand total%s: %0.2f €', $customer->discountMessage(), $shop->grandTotal() * (1 - $customer->discount())) ?>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="4" class="grand-total">
                    <?= sprintf('Grand total: %0.2f €', $shop->grandTotal()); ?>
                </td>
            </tr>
        <?php endif; ?>
    </table>
<?php endif; ?>
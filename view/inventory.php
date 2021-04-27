<table>
    <tr>
        <td class='header'>Flower</td>
        <td class='header'>Amount</td>
        <td class='header'>Price</td>
        <td class='header'></td>
    </tr>
    <?php
    /** @var Flowershop\Shop $shop */
    foreach ($shop->inventory() as $number => $flower): ?>
        <tr>
            <td class="name"><?= $flower->name() ?></td>
            <td class='amount'><?= $flower->amount() ?></td>
            <?php if ($shop->price($flower->name()) != 0): ?>
                <td class="price"><?= sprintf('%0.2f €', $shop->price($flower->name())) ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="number" value="<?= $number ?>"/>
                        <input class="input-box" type="number" id="amount" name="amount" value="0"
                               min="0" max="<?= $flower->amount() ?>"/>
                        <input class="button" type="submit" value="Add to basket">
                    </form>
                </td>
            <?php else: ?>
                <td class='no-price' colspan="2">no price</td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
<br>


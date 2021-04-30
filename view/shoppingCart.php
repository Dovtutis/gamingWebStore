<div class="shopping-cart-container">
        <div class="shopping-cart-info-box">
            <h4>Your basket</h4>
            <div id="error-box"></div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Item</th>
                <th scope="col">Single Item Price</th>
                <th scope="col">Quantity</td>
                <th scope="col">Total Price</th>
            </tr>
            </thead>
            <tbody>
<?php foreach ($shoppingCartItems as $item) :?>
            <tr id="<?php echo $shoppingCartId?>">
                <td scope="row" id="<?php echo $item->itemData->item_id?>">
                    <img src="<?php echo $item->itemData->item_image?>" alt="<?php echo $item->itemData->item_name?>" class="shopping-cart-image">
                    <?php echo $item->itemData->item_name?>
                </td>
                <td>
                    <div class="item-price-box">
                        € <span class="item-price"><?php echo $item->itemData->item_price?></span>
                    </div>
                </td>
                <td>
                    <div class="item-quantity-box">
                        <button class="quantity-button quantity-minus">-</button>
                        <div class="shopping-cart-quantity"><?php echo $item->itemQuantity?></div>
                        <button class="quantity-button quantity-plus">+</button>
                    </div>
                </td>
                <td class="total-price-box">
                    <div class="total-item-price">
                        € <span><?php echo ($item->itemData->item_price * $item->itemQuantity)?></span>
                    </div>
                    <i class="far fa-trash-alt shopping-cart-delete-icon"></i>
                </td>
            </tr>
<?php endforeach;?>
            </tbody>
        </table>
        <div class="shopping-cart-confirm-box">
            <div id="total-sum" class="mt-3"></div>
            <button id="buy-button"><a id="buy-button-anchor">Continue</a></button>
        </div>
</div>


<?php var_dump($shoppingCartItems) ?>
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
            <?php if ($shoppingCartItems) : ?>
                <?php foreach ($shoppingCartItems as $item) : ?>
                    <tr>
                        <td scope="row">
                            <img src="<?php echo $item->itemData->item_image ?>" alt="<?php echo $item->itemData->item_name ?>" class="shopping-cart-image">
                            <?php echo $item->itemData->item_name ?>
                        </td>
                        <td>
                            <div class="item-price-box">
                                € <span class="item-price"><?php echo $item->itemData->item_price ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="item-quantity-box">
                                <button class="quantity-button quantity-minus">-</button>
                                <div class="shopping-cart-quantity"><?php echo $item->itemQuantity ?></div>
                                <button class="quantity-button quantity-plus">+</button>
                            </div>
                        </td>
                        <td class="total-price-box">
                            <div class="total-item-price">
                                € <span class="total-item-price-value"><?php echo ($item->itemData->item_price * $item->itemQuantity) ?></span>
                            </div>
                            <button class="shopping-cart-delete-button">
                                <i class="far fa-trash-alt shopping-cart-delete-icon" id="<?php echo $item->itemData->item_id ?>"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="shopping-cart-confirm-box">
        <div id="total-sum"></div>
        <?php if ($shoppingCartItems) : ?>
            <button id="buy-button"><a id="buy-button-anchor">Continue</a></button>
        <?php endif; ?>
    </div>
</div>

<script>
    let totalSumEl = document.getElementById('total-sum');
    const shoppingCartCounterEl = document.getElementById('shopping-cart-counter');

    const minusSelectors = document.querySelectorAll('.quantity-minus');
    minusSelectors.forEach((element) => {
        element.addEventListener('click', minusQuantity);
    });

    const addSelectors = document.querySelectorAll('.quantity-plus');
    addSelectors.forEach((element) => {
        element.addEventListener('click', addQuantity);
    });

    const deleteButtons = document.querySelectorAll('.shopping-cart-delete-button');
    deleteButtons.forEach((button) => {
        button.addEventListener('click', deleteItem);
    });


    sumTotal();

    function sumTotal() {
        const allTotalSums = document.querySelectorAll('.total-item-price-value');
        let totalSum = 0;

        allTotalSums.forEach(item => {
            let sum = Number(item.innerText);
            totalSum += sum;
        });
        totalSumEl.innerHTML = "Your total sum: € " + totalSum.toFixed(2);
    }

    function minusQuantity(event) {
        if (event.target.parentNode.children[1].innerText > 1) {
            event.target.parentNode.children[1].innerText--;
        }

        recalculatePrices(event);
    }

    function addQuantity(event) {
        event.target.parentNode.children[1].innerText++;

        recalculatePrices(event);
    }

    function deleteItem(event) {
        const shoppingCartId = <?php echo $shoppingCartId ?>;
        const itemId = event.target.id;
        const selectedQuantity = event.target.parentNode.parentNode.parentNode.children[2].children[0].children[1].innerText;
        const userId = <?php echo $userId ?>

        const info = {
            shoppingCartId: shoppingCartId,
            itemId: event.target.id,
            selectedQuantity: selectedQuantity,
            userId: userId
        }

        fetch(`/deleteFromCart`, {
                method: "POST",
                mode: "same-origin",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    info: info
                })
            }).then(resp => resp.json())
            .then(data => {
                console.log(data)
                if (data.response) {
                    handleDeleteSuccess(event);
                }
            }).catch(error => console.error())

    }

    function recalculatePrices(event) {
        const singleItemPrice = event.target.parentNode.parentNode.parentNode.children[1].children[0].children[0].innerText;
        const rowItemSelectedQuantity = event.target.parentNode.children[1].innerText;
        const totalRowPrice = singleItemPrice * rowItemSelectedQuantity;
        event.target.parentNode.parentNode.parentNode.children[3].children[0].children[0].innerHTML = totalRowPrice;

        sumTotal();
    }

    function continueToCheckout() {

    }

    function handleDeleteSuccess(event) {
        let row = event.target.parentNode.parentNode.parentNode;
        console.log(row);
        row.style.display = "none";
        shoppingCartCounterEl.innerText--;
        row.remove();
        sumTotal();
    }
</script>
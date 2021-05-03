<div id="shopping-cart-checkout-container">
    <div id="shopping-cart-container">
        <div class="shopping-cart-info-box">
            <h4>Your basket</h4>
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
            <tbody id="table-body">
                <?php if ($shoppingCartItems) : ?>
                    <?php foreach ($shoppingCartItems as $item) : ?>
                        <tr>
                            <td scope="row" itemName="<?php echo $item->itemData->item_name ?>">
                                <img src="<?php echo $item->itemData->item_image ?>" alt="<?php echo $item->itemData->item_name ?>" class="shopping-cart-image">
                                <a href="/item/<?php echo $item->itemData->item_id ?>"><?php echo $item->itemData->item_name ?></a>
                            </td>
                            <td>
                                <div class="item-price-box">
                                    € <span class="item-price"><?php echo $item->itemData->item_price ?></span>
                                </div>
                            </td>
                            <td>
                                <div class="item-quantity-box">
                                    <button class="quantity-button quantity-minus" itemId="<?php echo $item->itemData->item_id ?>">-</button>
                                    <div class="shopping-cart-quantity"><?php echo $item->itemQuantity ?></div>
                                    <button class="quantity-button quantity-plus" itemId="<?php echo $item->itemData->item_id ?>">+</button>
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
                <button id="buy-button">Continue</button>
            <?php endif; ?>
        </div>
        <div id="message-box"></div>
    </div>
    <div id="checkout-container">
        <div id="price-container">
            <span id="price-container-title">
                Gaming World
            </span>
            <img src="https://www.pngkey.com/png/full/105-1056555_gaming-png-transparent-image-video-games-clipart.png" alt="cheburashka" id="checkout-image">
            <span id="price-container-second-text">TOTAL</span>
            <span id="price-container-total">€0</span>
        </div>
        <div id="credit-card-container">
            <span id="checkout-message"></span>
            <span id="credit-card-container-text">PAY WITH CREDIT CARD</span>
            <form action="post" autocomplete="off" id="checkout-form">
                <div class="form-group">
                    <label for="card-name" class="card-input-paceholder">Name of Card Holder:</label>
                    <input type="text" class="form-control form-control-lg" name="card-name" id="card-name">
                    <span class="invalid-feedback" id="card-name-error"></span>
                </div>
                <div class="form-group">
                    <label for="card-number" class="card-input-paceholder">Credit Card Number:</label>
                    <input type="text" class="form-control form-control-lg" name="card-number" id="card-number">
                    <span class="invalid-feedback" id="card-number-error"></span>
                </div>
                <div id="card-expiration-cvc-container">
                    <div class="form-group">
                        <label for="month" class="card-input-paceholder">Expiration date</label><br>
                        <select name="month" id="month" class="card-form-selector">
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                            <option value=4>4</option>
                            <option value=5>5</option>
                            <option value=6>6</option>
                            <option value=7>7</option>
                            <option value=8>8</option>
                            <option value=9>9</option>
                            <option value=10>10</option>
                            <option value=11>11</option>
                            <option value=12>12</option>
                        </select>
                        <select name="year" id="year" class="card-form-selector">
                            <option value=2021>2021</option>
                            <option value=2022>2022</option>
                            <option value=2023>2023</option>
                            <option value=2024>2024</option>
                            <option value=2025>2025</option>
                            <option value=2026>2026</option>
                            <option value=2027>2027</option>
                            <option value=2028>2028</option>
                            <option value=2029>2029</option>
                            <option value=2030>2030</option>
                        </select>
                    </div>
                    <div class="form-group" id="card-cvc-group">
                        <label for="card-cvc" class="card-input-paceholder">CVC</label>
                        <input type="text" class="form-control form-control-lg" name="card-cvc" id="card-cvc">
                        <span class="invalid-feedback" id="card-cvc-error"></span>
                    </div>
                </div>
                <button type="submit" id="checkout-submit-button">PAY SECURELY</button>
            </form>
                <button id="back-to-shopping-cart-button">Back to the shopping cart</button>
        </div>
    </div>
</div>


<script>
    let totalSumEl = document.getElementById('total-sum');
    const shoppingCartCounterEl = document.getElementById('shopping-cart-counter');
    const shoppingCartContainer = document.getElementById('shopping-cart-container');
    const checkoutContainer = document.getElementById('checkout-container');
    const buyButton = document.getElementById('buy-button');
    const userId = <?php echo $userId ?>;
    const messageBoxEl = document.getElementById('message-box');
    const priceContainerTotalEl = document.getElementById('price-container-total');
    const backToShoppingCartButton = document.getElementById('back-to-shopping-cart-button');
    const checkoutSubmitButton = document.getElementById('checkout-submit-button');
    const checkoutFormEl = document.getElementById('checkout-form');
    const checkoutMessageEl = document.getElementById('checkout-message');
    const cardNameEl = document.getElementById('card-name');
    const cardNumberEl = document.getElementById('card-number');
    const cardCVCEl = document.getElementById('card-cvc');
    const monthSelectorEl = document.getElementById('month');
    const yearSelectorEl = document.getElementById('year');
    const cardNameErrorEl = document.getElementById('card-name-error');
    const cardNumberErrorEl = document.getElementById('card-number-error');
    const cardCVCErrorEl = document.getElementById('card-cvc-error');
    const errorElements = document.querySelectorAll('.invalid-feedback');
    const inputElements = document.querySelectorAll('.form-control');
    const tableBodyEl = document.getElementById('table-body');

    const minusSelectors = document.querySelectorAll('.quantity-minus');
    minusSelectors.forEach((element) => {
        element.addEventListener('click', () => changeQuantity(event, '-'));
    });

    const addSelectors = document.querySelectorAll('.quantity-plus');
    addSelectors.forEach((element) => {
        element.addEventListener('click', () => changeQuantity(event, '+'));
    });

    const deleteButtons = document.querySelectorAll('.shopping-cart-delete-button');
    deleteButtons.forEach((button) => {
        button.addEventListener('click', deleteItem);
    });

    buyButton.addEventListener('click', showCheckout);
    backToShoppingCartButton.addEventListener('click', backToCart);
    checkoutSubmitButton.addEventListener('click', checkout);

    sumTotal();

    function sumTotal() {
        const allTotalSums = document.querySelectorAll('.total-item-price-value');
        let totalSum = 0;

        allTotalSums.forEach(item => {
            let sum = Number(item.innerText);
            totalSum += sum;
        });
        totalSumEl.innerHTML = "Your total sum: € " + totalSum.toFixed(2);
        priceContainerTotalEl.innerText = `€ ${totalSum.toFixed(2)}`;
    }

    function changeQuantity(event, action) {
        clearMessageBox();

        const info = {
            itemId: event.target.attributes.itemId.value,
            itemQuantity: 1,
            userId: userId,
            action: action
        }

        if (action === "-" && (event.target.parentNode.children[1].innerText - 1) === 0) {
            null
        } else {
            fetch(`/manageCart`, {
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
                    if (data.response === true) {
                        handleSuccess(event, action);
                        recalculatePrices(event);
                    } else {
                        handleOutOfStock(event);
                    }
                }).catch(error => console.error());
        }
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

    function handleDeleteSuccess(event) {
        let row = event.target.parentNode.parentNode.parentNode;
        console.log(row);
        row.style.display = "none";
        shoppingCartCounterEl.innerText--;
        row.remove();
        sumTotal();
    }

    function handleOutOfStock(event) {
        const itemName = event.target.parentNode.parentNode.parentNode.children[0].attributes.itemName.value;
        messageBoxEl.innerText = `We are sorry, but there are no more "${itemName}" in stock!`;
    }

    function clearMessageBox() {
        messageBoxEl.innerText = "";
    }

    function handleSuccess(event, action) {
        if (action === "+") {
            event.target.parentNode.children[1].innerText++;
        } else {
            event.target.parentNode.children[1].innerText--;
        }
    }

    function showCheckout() {
        shoppingCartContainer.style.display = "none";
        checkoutContainer.style.display = "flex"
    }

    function backToCart() {
        shoppingCartContainer.style.display = "flex";
        checkoutContainer.style.display = "none"
    }

    function checkout() {
        event.preventDefault();
        removeErrors();
        const formData = new FormData(checkoutFormEl);
        fetch('/checkout', {
            method: 'post',
            body: formData
        }).then(resp => resp.json())
            .then(data => {
                if (data.errors.length === 0){
                    handleSuccess();
                } else {
                    handleErrors(data.errors);
                }
            }).catch(error => console.error())
    }

    function handleErrors(errors) {
        if (errors.cardNameError !== "") {
            cardNameErrorEl.innerText = errors.cardNameError;
            cardNameEl.classList.add("is-invalid");
        }
        if (errors.cardNumberError !== "") {
            cardNumberErrorEl.innerText = errors.cardNumberError;
            cardNumberEl.classList.add("is-invalid");
        }
        if (errors.cardCVCError !== "") {
            cardCVCErrorEl.innerText = errors.cardCVCError;
            cardCVCEl.classList.add("is-invalid");
        }
    }

    function removeErrors() {
        inputElements.forEach(item => {
            item.classList.remove("is-invalid");
        })
        errorElements.forEach(item => {
            item.innerText = "";
        })
    }

    function handleSuccess() {
        checkoutMessageEl.innerText = "Success! Your order was accepted!";
        cardNameEl.value = "";
        cardNumberEl.value = "";
        cardCVCEl.value = "";
        monthSelectorEl.value = 1;
        yearSelectorEl. value = 2021;

        shoppingCartCounterEl.innerText = 0;
        tableBodyEl.innerHTML = "";
        totalSumEl.innerHTML = "";
    }

</script>
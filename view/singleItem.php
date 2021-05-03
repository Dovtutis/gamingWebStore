<div class="single-item-container">
    <div class="single-item-left-container">
        <img src="<?php echo $item->item_image ?>" alt="" />
        <div class="single-item-rating-box">
            <?php for ($x = 0; $x < $item->item_rating; $x++) : ?>
                <i class="fas fa-star rating-star"></i>
            <?php endfor; ?>
            <?php for ($x = 0; $x < (5 - $item->item_rating); $x++) : ?>
                <i class="far fa-star rating-star-blank"></i>
            <?php endfor; ?>
        </div>
        <span><?php echo $item->item_name ?></span>
        <span>€<?php echo $item->item_price ?></span>
        <span class="single-item-quantity">Left in sale: <span id="item-quantity-counter"><?php echo $item->item_quantity ?></span> qty.</span>
    </div>
    <div class="single-item-right-container">
        <iframe src="<?php echo $item->item_video ?>">
        </iframe>
        <p>
            <?php echo $item->item_description ?>
        </p>
        <div class="single-item-add-to-cart-box">
            <?php if ($item->item_quantity == 0) : ?>
                <button class="items-container-add-to-cart-button item-out-of-stock-error" id="<?php echo $item->item_id ?>">Sorry. Out of stock!</button>
            <?php else : ?>
                <button class="add-to-cart-button allowed" id="<?php echo $item->item_id ?>">
                    <i class="fas fa-cart-arrow-down"></i>Add to Cart
                </button>
            <?php endif ?>
        </div>
    </div>
</div>

<script>
    const userId = <?php echo $_SESSION['user_id'] ?>;
    const addToCartButton = document.querySelector('.add-to-cart-button');
    const shoppingCartCounterEl = document.getElementById('shopping-cart-counter');
    const itemQuantityCounterEl = document.getElementById('item-quantity-counter');

    addToCartButton.addEventListener('click', addToShoppingCart);

    function addToShoppingCart(event) {
        if (userId) {
            const info = {
                itemId: event.target.id,
                itemQuantity: 1,
                userId: userId
            }

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
                        handleSuccess(event, data.items_quantity);
                    } else {
                        handleOutOfStock(event);
                    }
                }).catch(error => console.error())
        }
    }

    function handleSuccess(event, quantity) {
        shoppingCartCounterEl.innerHTML = quantity;
        event.target.innerHTML = "Added to the cart!";
        itemQuantityCounterEl.innerHTML--;

        setTimeout(() => {
            event.target.innerHTML = '<i class="fas fa-cart-arrow-down"></i> Add to Cart';
        }, 2000);
    }

    function handleOutOfStock(event) {
        event.target.innerHTML = "Sorry. Out of stock!";
        event.target.classList.add("item-out-of-stock-error");
        event.target.classList.remove("allowed");
        event.target.setAttribute("disabled", true);
    }
</script>
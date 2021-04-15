
<div class="ui-interface-page">
    <div class="ui-interface-container">
        <div class="ui-interface-controls-container">
            <button class="ui-interface-button" id="check-orders-button">
                Check your orders
            </button>
            <button class="ui-interface-button" id="account-information-button">
                Change account information
            </button>
            <button class="ui-interface-button" id="change-password-button">
                Change password
            </button>
        </div>
        <div class="ui-interface-info-container">
            <div id="orders-container">
                <?php foreach ($userOrders as $order) : ?>
                    <div class="order-row">
                        <div>
                            <strong>Order id</strong>
                            <p class="order-row-id">
                                <?php echo $order->orderId ?>
                            </p>
                        </div>
                        <div>
                            <strong>Ordered items:</strong>
                            <?php foreach ($order->items as $item) : ?>
                                <p class="order-row-list">
                                    <a class="order-link" href="<?php echo '/eshop/showItem/' . $item->itemId ?>">
                                        <?php echo $item->itemName ?>
                                    </a><?php echo ", " . $item->quantity . " items" ?>
                                </p>
                            <?php endforeach ?>
                        </div>
                        <div>
                            <strong>Message:</strong>
                            <p class="order-row-message">
                                <?php echo $order->message ?>
                            </p>
                        </div>
                        <div class="status-date-box">
                            <strong><span>Order status:</span></strong>
                            <div>
                                <span><?php echo $order->status ?></span>
                                <span><?php echo $order->date ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <div id="account-information-container">

            </div>
            <div id="password-change-container">

            </div>
        </div>
    </div>
    <?php var_dump($userOrders)?>
</div>


<script>
    const checkOrdersButton = document.getElementById('check-orders-button');
    const accountInformationButton = document.getElementById('account-information-button');
    const changePasswordButton = document.getElementById('change-password-button');
    const ordersEl = document.getElementById('orders-container');
    const accountInformationEl = document.getElementById('account-information-container');
    const passwordChangeEl = document.getElementById('password-change-container');

    checkOrdersButton.addEventListener('click', showOrders);
    accountInformationButton.addEventListener('click', showAccountInformation);
    changePasswordButton.addEventListener('click', showChangePassword);

    function showOrders() {
        ordersEl.style.display = "block";
        accountInformationEl.style.display = "none";
        passwordChangeEl.style.display = "none";
    }

    function showAccountInformation() {
        ordersEl.style.display = "none";
        accountInformationEl.style.display = "block";
        passwordChangeEl.style.display = "none";
    }

    function showChangePassword() {
        console.log("show pasword");
        ordersEl.style.display = "none";
        accountInformationEl.style.display = "none";
        passwordChangeEl.style.display = "block";
        // passwordChangeResponseElement.innerText = "";
    }


</script>
<?php

use \app\core\html\FormField; ?>

<div class="ui-interface-page">
    <div class="ui-interface-container">
        <div class="ui-interface-controls-container">
            <button class="ui-interface-button" id="add-new-item-container-button">
                Add new item
            </button>
            <button class="ui-interface-button" id="order-management-container-button">
                Order management
            </button>
        </div>
        <div class="admin-interface-info-container">
            <span class="response-message-element" id="add-new-item-message-element"></span>
            <div class="add-new-item-container" id="add-new-item-container">
                <span class="admin-panel-headline">Add new item</span>
                <form action="" method="post" autocomplete="off" id="add-new-item-form">
                    <?php echo new FormField('itemName', 'itemName', 'general-input', 'Item Name:', 'text', '*', '', $item); ?>
                    <label for="itemType">Choose item type:</label>
                    <select class="form-select general-input" aria-label="type select" name="itemType" id="itemType">
                        <option value=null selected>Choose item type</option>
                        <option value="console">Console</option>
                        <option value="accessory">Accessory</option>
                        <option value="game">Game</option>
                        <option value="other">Other</option>
                    </select>
                    <span class="invalid-feedback"></span>
                    <?php echo new FormField('itemImage', 'itemImage', 'general-input', 'Item Image:', 'text', '*', '', $item); ?>
                    <?php echo new FormField('itemVideo', 'itemVideo', 'general-input', 'Item Video URL:', 'text', '*', '', $item); ?>
                    <?php echo new FormField('itemPrice', 'itemPrice', 'general-input', 'Item Price:', 'number', '*', '', $item); ?>
                    <?php echo new FormField('itemQuantity', 'itemQuantity', 'general-input', 'Item Quantity:', 'number', '*', '', $item); ?>
                    <label for="itemDescription">Write item description:</label>
                    <textarea name="itemDescription" id="itemDescription" rows="5" class="general-input" placeholder="Item Description"></textarea>
                    <span class="invalid-feedback"></span>
                    <div class="row mt-3 d-flex">
                        <div class="col">
                            <input type="submit" class="btn btn-primary btn-block" value="Add New Item" id="add-new-item-button">
                        </div>
                    </div>
                </form>
            </div>
            <div class="order-management-container" id="order-management-container">
                <?php foreach ($orders as $order) : ?>
                    <form class="order-update-form">
                        <div class="order-row">
                            <div>
                                <strong>Order id:</strong>
                                <p class="order-row-id">
                                    <?php echo $order->id ?>
                                </p>
                            </div>
                            <div class="order-list-container">
                                <strong>Ordered items:</strong>
                                <?php foreach ($order->order_list as $item) : ?>
                                    <p class="order-row-list">
                                        <a href="<?php echo 'eshop/showItem/' . $item->itemId ?>">
                                            <?php echo $item->itemName ?></a><?php echo ", " . $item->quantity . " items" ?>
                                    </p>
                                <?php endforeach ?>
                            </div>
                            <div>
                                <strong>Message:</strong>
                                <textarea rows="4" cols="20" class="order-row-textarea" name="order-message"><?php echo $order->message ?></textarea>
                            </div>
                            <div class="status-date-box">
                                <strong><span>Order status:</span></strong>
                                <div>
                                    <textarea rows="4" cols="20" name="order-status"><?php echo $order->status ?></textarea>
                                </div>
                            </div>
                            <div class="orders-client-info-box">
                                <strong><span>Client info:</span></strong>
                                <div>
                                    <span><?php echo $order->user->firstname . " " . $order->user->lastname ?></span>
                                    <span><?php echo $order->user->address ?></span>
                                    <span><?php echo $order->user->email ?></span>
                                    <span><?php echo $order->user->phone ?></span>
                                </div>
                            </div>
                            <div>
                                <strong>Order date:</strong>
                                <p class="order-row-id">
                                    <?php echo $order->date ?>
                                </p>
                            </div>
                            <button type="submit" class="update-order-button">Update Order</button>
                        </div>
                    </form>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<script>
    const addNewItemContainerEl = document.getElementById('add-new-item-container');
    const managerOrdersContainerEl = document.getElementById('order-management-container');
    const addNewItemContainerButton = document.getElementById('add-new-item-container-button');
    const orderManagementContainerButton = document.getElementById('order-management-container-button');
    const addNewItemButton = document.getElementById('add-new-item-button');
    const addNewItemForm = document.getElementById('add-new-item-form');
    const itemNameEl = document.getElementById('itemName');
    const itemTypeEl = document.getElementById('itemType');
    const itemImageEl = document.getElementById('itemImage');
    const itemVideoEl = document.getElementById('itemVideo');
    const itemPriceEl = document.getElementById('itemPrice');
    const itemQuantityEl = document.getElementById('itemQuantity');
    const itemDescriptionEl = document.getElementById('itemDescription');
    const allInputEl = document.querySelectorAll('.general-input');
    const addNewItemMessageEl = document.getElementById('add-new-item-message-element');
    const updateOrderButtons = document.querySelectorAll('.update-order-button');

    let errorsAndElements = {
        itemNameError: itemNameEl,
        itemTypeError: itemTypeEl,
        itemImageError: itemImageEl,
        itemVideoError: itemVideoEl,
        itemPriceError: itemPriceEl,
        itemQuantityError: itemQuantityEl,
        itemDescriptionError: itemDescription
    };

    addNewItemContainerButton.addEventListener('click', showAddNewItemContainer);
    orderManagementContainerButton.addEventListener('click', showOrderManagementContainer);
    addNewItemButton.addEventListener('click', addNewItem);
    updateOrderButtons.forEach(button => {
        button.addEventListener('click', updateOrder);
    })

    function showAddNewItemContainer(params) {
        addNewItemContainerEl.style.display = "block";
        managerOrdersContainerEl.style.display = "none";
        addNewItemMessageEl.innerText = "";
    }

    function showOrderManagementContainer(params) {
        managerOrdersContainerEl.style.display = "flex";
        addNewItemContainerEl.style.display = "none";
        addNewItemMessageEl.innerText = "";
    }

    function addNewItem(e) {
        e.preventDefault();
        resetErrors();
        const formData = new FormData(addNewItemForm);

        fetch('/adminPanel', {
                method: 'post',
                body: formData
            }).then(resp => resp.json())
            .then(data => {
                console.log(data['response']);
                if (data.item.errors) {
                    handleErrors(data.item.errors);
                }
                if (data['response']) {
                    handleSuccess();
                }
            }).catch(error => console.error())
    }

    function updateOrder(e) {
        e.preventDefault();
        const orderId = Number(event.target.form.children[0].children[0].children[1].innerText);
        const formData = new FormData(event.target.form);
        formData.append('order-id', orderId);

        fetch('/updateOrder', {
            method: 'post',
            body: formData
        }).then(resp => resp.json())
            .then(data => {
                console.log(data)
                if (data.response === "success") {
                    addNewItemMessageEl.innerText = "Order edited successfully";
                }
            }).catch(error => console.error())
    }

    function handleErrors(errors) {
        let possibleErrors = Object.keys(errorsAndElements);
        for (let i = 0; i < possibleErrors.length; i++) {
            let errorName = possibleErrors[i];
            if (errors[errorName]) {
                let errorElement = errorsAndElements[errorName];
                errorElement.classList.add('is-invalid');
                errorElement.nextElementSibling.innerHTML = errors[errorName];
            }
        }
    }

    function resetErrors() {
        const errorEl = addNewItemForm.querySelectorAll('.is-invalid');
        errorEl.forEach((element) => {
            element.classList.remove('is-invalid');
        });
        addNewItemMessageEl.innerText = "";
    }

    function handleSuccess() {
        itemDescriptionEl.value = "";
        itemTypeEl.value = null;
        allInputEl.forEach(element => {
            element.value = ""
        });
        addNewItemMessageEl.innerText = "Item added successfully";
    }
</script>
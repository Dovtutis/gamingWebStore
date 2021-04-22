<?php use \app\core\html\FormField;?>

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
        <div class="ui-interface-info-container">
            <div class="add-new-item-container" id="add-new-item-container">
                <span class="admin-panel-headline">Add new item</span>
                <form action="" method="post" autocomplete="off" id="add-new-item-form">
                    <?php echo new FormField('itemName', 'itemName', 'general-input', 'Item Name:', 'text', '*', '', $item); ?>
                    <label for="itemType">Choose item type:</label>
                    <select class="form-select general-input" aria-label="type select"  name="itemType" id="itemType">
                        <option selected>Choose item type</option>
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
                menedzinam orderius kaip deremae
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

    function showAddNewItemContainer(params) {
        addNewItemContainerEl.style.display = "block";
        managerOrdersContainerEl.style.display = "none";
    }

    function showOrderManagementContainer(params) {
        managerOrdersContainerEl.style.display = "block";
        addNewItemContainerEl.style.display = "none";
    }

    function addNewItem(e) {
        e.preventDefault();
        resetErrors();
        const formData = new FormData(addNewItemForm);

        fetch('/adminPanel', {
            method: 'post',
            body: formData
        }).then(resp => resp.text())
            .then(data => {
                console.log(data)
                if (data.item.errors){
                    handleErrors(data.item.errors);
                }
            }).catch(error => console.error())
    }

    function handleErrors(errors){
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

    function resetErrors(){
        const errorEl = addNewItemForm.querySelectorAll('.is-invalid');
        errorEl.forEach((element) => {
            element.classList.remove('is-invalid');
        });
    }


</script>
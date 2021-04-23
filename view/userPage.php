<?php

use \app\core\html\FormField;
?>

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
                <span id="account-information-headline">Your account information.</span>
                <form action="" method="post" autocomplete="off" id="user-edit-form"">
                    <?php echo new FormField('firstName', 'firstName', 'editInput', 'Name', 'text', '*', 'disabled', $user); ?>
                    <?php echo new FormField('lastName', 'lastName', 'editInput', 'Last Name', 'text', '*', 'disabled', $user); ?>
                    <?php echo new FormField('email', 'email', 'editInput', 'Email', 'text', '*', 'disabled', $user); ?>
                    <?php echo new FormField('phone', 'phone', 'editInput', 'Phone', 'text', '', 'disabled', $user); ?>
                    <?php echo new FormField('address', 'address', 'editInput', 'Address', 'text', '', 'disabled', $user); ?>
                    <?php echo new FormField('postalCode', 'postalCode', 'editInput', 'Postal Code', 'text', '', 'disabled', $user); ?>
                    <div class="row mt-3 d-flex">
                        <div class="col">
                            <input type="submit" class="btn btn-primary btn-block" value="Edit" id="edit-button">
                        </div>
                    </div>
                </form>
            </div>
            <div id="password-change-container">
                <form action="" method="post" autocomplete="off" id="password-change-form">
                    <span id="password-change-headline">Change your password:</span>
                    <p id="passowrd-change-response-element"></p>
                    <div class="form-container">
                        <?php echo new FormField('password', 'password', '', 'New Password', 'password', '*', '', $user) ;?>
                        <?php echo new FormField('passwordConfirm', 'passwordConfirm', '', 'New Password Confirm', 'password', '*', '', $user) ;?>
                        <div class="row">
                            <div class="col">
                                <input type="submit" class="btn btn-primary btn-block" value="Save" id="submit-new-password-button"></input>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    const checkOrdersButton = document.getElementById('check-orders-button');
    const accountInformationButton = document.getElementById('account-information-button');
    const changePasswordButton = document.getElementById('change-password-button');
    const ordersEl = document.getElementById('orders-container');
    const accountInformationEl = document.getElementById('account-information-container');
    const passwordChangeEl = document.getElementById('password-change-container');
    const editButton = document.getElementById('edit-button');
    const editInputElements = document.querySelectorAll('.editInput');
    const firstNameEl = document.getElementById('firstName');
    const lastNameEl = document.getElementById('lastName');
    const emailEl = document.getElementById('email');
    const phoneEl = document.getElementById('phone');
    const addressEl = document.getElementById('address');
    const postalCodeEl = document.getElementById('postalCode');
    const passwordEl = document.getElementById('password');
    const passwordConfirmEl = document.getElementById('passwordConfirm');
    const userEditFormEl = document.getElementById('user-edit-form');
    const userPasswordFormEl = document.getElementById('password-change-form');
    const passwordChangeResponseElement = document.getElementById('passowrd-change-response-element');
    const submitNewPasswordButton = document.getElementById('submit-new-password-button');

    let userFormErrorsAndElements = {
        firstNameError: firstNameEl,
        lastNameError: lastNameEl,
        emailError: emailEl,
        phoneError: phoneEl,
        addressError: addressEl,
        postalCodeError: postalCodeEl,
    };

    let passwordFormErrorsAndElements = {
        passwordError: passwordEl,
        passwordConfirmError: passwordConfirmEl,
    }

    checkOrdersButton.addEventListener('click', showOrders);
    accountInformationButton.addEventListener('click', showAccountInformation);
    changePasswordButton.addEventListener('click', showChangePassword);
    editButton.addEventListener('click', changeUserInformation);
    submitNewPasswordButton.addEventListener('click', changeUserPassword);

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
        ordersEl.style.display = "none";
        accountInformationEl.style.display = "none";
        passwordChangeEl.style.display = "block";
        passwordChangeResponseElement.innerText = "";
    }

    function changeUserInformation(e) {
        e.preventDefault();
        resetErrors(userEditFormEl);
        const formData = new FormData(userEditFormEl);
        formData.append('oldEmail', '<?php echo $user['email'] ?>');

        if (editButton.value === "Edit") {
            editInputElements.forEach(input => {
                input.removeAttribute("disabled");
            })
            editButton.value = "Save";
        } else {
            fetch('/editUser' , {
                    method: 'post',
                    body: formData
                }).then(resp => resp.json())
                .then(data => {
                    if (data.response === "success") {
                        editInputElements.forEach(input => {
                            input.setAttribute("disabled", true);
                        })
                        editButton.value = "Edit";
                    } else {
                        handleErrors(data.errors, userFormErrorsAndElements)
                    }
                }).catch(error => console.error())
        }
    }

    function changeUserPassword(e) {
        e.preventDefault();
        resetErrors(userPasswordFormEl);
        const formData = new FormData(userPasswordFormEl);

        fetch('/changePassword', {
                method: 'post',
                body: formData
            }).then(resp => resp.json())
            .then(data => {
                if (data.response === "success") {
                    passwordChangeResponseElement.innerText = "Password changed successfully!";
                    passwordEl.value = "";
                    passwordConfirmEl.value = "";
                } else {
                    handleErrors(data.errors, passwordFormErrorsAndElements)
                }
            }).catch(error => console.error())
    }

    function handleErrors(errors, errorsAndElements) {
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

    function resetErrors(form) {
        const errorEl = form.querySelectorAll('.is-invalid');
        errorEl.forEach((element) => {
            element.classList.remove('is-invalid');
        });
    }

</script>
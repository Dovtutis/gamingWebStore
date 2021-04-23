<?php use \app\core\html\FormField;?>

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card card-body bd-light mt-5 p-4 container800" id="registration-container">
                <h2>Create an account</h2>
                <p>Please fill in the form to register with us</p>
                <form action="" method="post" autocomplete="off" id="registration-form">
                    <?php echo new FormField('firstName', 'firstName', '', 'Name', 'text', '*', '', $params) ;?>
                    <?php echo new FormField('lastName', 'lastName', '', 'Last Name', 'text', '*', '', $params) ;?>
                    <?php echo new FormField('email', 'email', '', 'Email', 'text', '*', '', $params) ;?>
                    <?php echo new FormField('password', 'password', '', 'Password', 'password', '*', '', $params) ;?>
                    <?php echo new FormField('passwordConfirm', 'passwordConfirm', '', 'Password Confirm', 'password', '*', '', $params) ;?>
                    <?php echo new FormField('phone', 'phone', '', 'Phone', 'text', '', '', $params) ;?>
                    <?php echo new FormField('address', 'address', '', 'Address', 'text', '', '', $params) ;?>
                    <?php echo new FormField('postalCode', 'postalCode', '', 'Postal Code', 'text', '', '', $params) ;?>
                    <div class="row mt-3 d-flex">
                        <div class="col">
                            <input type="submit" class="btn btn-primary btn-block" value="Register" id="register-button">
                        </div>
                        <div class="col">
                            <a href="/login" class="btn btn-light btn-block float-end">Have an account? Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    const registrationFormEl = document.getElementById('registration-form');
    const firstNameEl = document.getElementById('firstName');
    const lastNameEl = document.getElementById('lastName');
    const emailEl = document.getElementById('email');
    const passwordEl = document.getElementById('password');
    const passwordConfirmEl = document.getElementById('passwordConfirm');
    const phoneEl = document.getElementById('phone');
    const addressEl = document.getElementById('address');
    const postalCodeEl = document.getElementById('postalCode');
    const registerButton = document.getElementById('register-button');
    let errorsAndElements = {
        firstNameError: firstNameEl,
        lastNameError: lastNameEl,
        emailError: emailEl,
        passwordError: passwordEl,
        passwordConfirmError: passwordConfirmEl,
        phoneError: phoneEl,
        addressError: addressEl,
        postalCodeError: postalCodeEl
    };
    registrationFormEl.addEventListener('submit', registerFetch);

    function registerFetch(e) {
        e.preventDefault();
        resetErrors();
        const formData = new FormData(registrationFormEl);

        fetch('/register', {
            method: 'post',
            body: formData
        }).then(resp => resp.json())
            .then(data => {
                console.log(data)
                if (data === "registrationSuccessful"){
                    window.location.replace("/");
                }
                if (data.errors){
                    handleErrors(data.errors);
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
        const errorEl = registrationFormEl.querySelectorAll('.is-invalid');
        errorEl.forEach((element) => {
            element.classList.remove('is-invalid');
        });
    }

    // const currentPage = "<?php echo $currentPage?>";
    // const navBarActiveEl = document.getElementById('nav-register');
    // checkCurrentPage();

    // function checkCurrentPage() {
    //     if (currentPage === "register"){
    //         navBarActiveEl.classList.add('active');
    //     }
    // }
</script>
<?php ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>Gaming World</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42762d49f1.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav>
            <div id="navbar-container">
                <div class="container" id="navbar-inner-container">
                    <a href="/main" class="home-link">
                        <div class="nav-logo">GAMING WORLD</div>
                    </a>
                    <div id="search-box">
                        <input type="text" placeholder="Enter for search..." name="serach-input" id="search-input">
                        <a href="" id="search-link"><i class="fas fa-search" id="search-button"></i></a>
                    </div>
                    <button type="button" class="navbar-toggle">
                        <i class="fas fa-bars navbar-bars"></i>
                    </button>
                    <div class="navbar-menu">
                        <ul class="navbar-links">
                            <?php if (!\app\core\Session::isUserLoggedIn()) : ?>
                                <li class="navbar-item px-1"><a class="navbar-link" href="/register">Register</a></li>
                                <li class="navbar-item px-1"><a class="navbar-link" href="/login">Login</a></li>
                            <?php else : ?>
                                <?php if($_SESSION['status'] === 'customer') :?>
                                    <li class="navbar-item px-1"><a class="navbar-link" href="/userAccount">My Account</a></li>
                                    <li class="navbar-item px-1"><a class="navbar-link" href="#navbar-tag-contact">Shopping Cart</a></li>
                                <?php else : ?>
                                    <li class="navbar-item px-1"><a class="navbar-link" href="/adminPanel">Admin Panel</a></li>
                                <?php endif; ?>   
                                <li class="navbar-item px-1"><a class="navbar-link" href="/logout">Logout</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-container">
        {{content}}
    </div>


</body>

</html>

<script>

    const navbar = document.getElementById("navbar-container");
    const navbarToggle = document.querySelector(".navbar-toggle");
    const navbarMenu = document.querySelector(".navbar-menu");
    const navbarLinksContainer = document.querySelector(".navbar-links");
    const navbarLinks = document.querySelectorAll(".navbar-link")
    const searchEl = document.getElementById('search-input');
    const searchLinkEl = document.getElementById('search-link');

    searchEl.addEventListener('input', searchQuery);

    navbarToggle.addEventListener("click", () => {
        if (navbar.classList.contains("opened")) {
            closeMobileNavbar();
        } else {
            openMobileNavbar();
        }
    });

    navbarLinks.forEach(link => {
        link.addEventListener("click", closeMobileNavbar);
    });

    navbarLinksContainer.addEventListener("click", (clickEvent) => {
        clickEvent.stopPropagation();
    });

    navbarMenu.addEventListener("click", closeMobileNavbar);

    function openMobileNavbar() {
        navbar.classList.add("opened");
    }

    function closeMobileNavbar() {
        navbar.classList.remove("opened");
    }

    function searchQuery(event) {
        searchLinkEl.setAttribute('href', `/main/${event.target.value}`)
    }

</script>
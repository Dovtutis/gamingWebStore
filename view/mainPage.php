<main>
    <article>
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-interval="10000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href=""><img src="https://cdn.game.net/image/upload/dpr_auto,f_auto,q_auto/v1/game_img/merch2021/Games/NierReplicant/NierReplicant-Xclu-db.jpg" class="d-block w-100" alt=<img src="Nier Automata"></a>
                </div>
                <?php foreach ($galleryImages as $image) : ?>
                    <div class="carousel-item">
                        <a href=""><img src=<?php echo $image['img'] ?> class="d-block w-100" alt=<img src=<?php echo $image['alt'] ?>></a>
                    </div>
                <?php endforeach ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </article>
    <article>
        <div class="items-main-container">
            <div class="items-container-navbar">
                <button class="items-container-navbar-button" id="navbar-consoles-selection-button">Consoles</button>
                <button class="items-container-navbar-button" id="navbar-accessories-selection-button">Accessories</button>
                <button class="items-container-navbar-button" id="navbar-games-selection-button">Games</button>
                <button class="items-container-navbar-button" id="navbar-other-selection-button">Other</button>
            </div>
            <div class="items-container">
                <?php foreach ($items as $item) : ?>
                    <div class="items-container-card">
                        <a href="/item/<?php echo $item->item_id ?>">
                            <img src="<?php echo $item->item_image ?>"></img>
                        </a>
                        <p><?php echo $item->item_name ?></p>
                        <span>€<?php echo $item->item_price ?></span>
                        <?php if ($item->item_quantity == 0) : ?>
                            <button class="items-container-add-to-cart-button item-out-of-stock-error" id="<?php echo $item->item_id ?>">Sorry. Out of stock!</button>
                        <?php else : ?>
                            <button class="items-container-add-to-cart-button" id="<?php echo $item->item_id ?>"><i class="fas fa-cart-arrow-down"></i> Add to Cart</button>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </article>
</main>

<script>
    const itemsContainerEl = document.querySelector('.items-container');
    const navbarConsolesSelectionButton = document.getElementById('navbar-consoles-selection-button');
    const navbarAccessoriesSelectionButton = document.getElementById('navbar-accessories-selection-button');
    const navbarGamesSelectionButton = document.getElementById('navbar-games-selection-button');
    const navbarOtherSelectionButton = document.getElementById('navbar-other-selection-button');
    const shoppingCartCounterEl = document.getElementById('shopping-cart-counter');
    const addToCartButtons = document.querySelectorAll('.items-container-add-to-cart-button');
    const userId = <?php echo $_SESSION['user_id'] ?>;

    navbarConsolesSelectionButton.addEventListener('click', () => fetchForItemsByType('console'));
    navbarAccessoriesSelectionButton.addEventListener('click', () => fetchForItemsByType('accessory'));
    navbarGamesSelectionButton.addEventListener('click', () => fetchForItemsByType('game'));
    navbarOtherSelectionButton.addEventListener('click', () => fetchForItemsByType('other'));

    addToCartButtons.forEach(button => {
        button.addEventListener('click', addToShoppingCart);
    });

    function fetchForItemsByType(selection) {
        fetch(`/fetchItems/${selection}`, {
                method: 'post',
            }).then(resp => resp.json())
            .then(data => {
                console.log(data);
                handleItems(data.items);
            }).catch(error => console.error())
    }

    function handleItems(items) {
        console.log(items);

        itemsContainerEl.innerHTML = "";
        items.map(item => {
            const card = document.createElement('div');
            card.classList.add('items-container-card');
            const anchor = document.createElement('a');
            anchor.setAttribute("href", `/item/${item.item_id}`);
            anchor.innerHTML = `<img src="${item.item_image}"></img>`;
            const paragraph = document.createElement('p');
            paragraph.innerHTML = item.item_name;
            const span = document.createElement('span');
            span.innerHTML = `€${item.item_price}`;
            const button = document.createElement('button');
            button.classList.add('items-container-add-to-cart-button');
            button.innerHTML = '<i class="fas fa-cart-arrow-down"></i>Add to Cart'

            if (item.item_quantity == 0) {
                button.classList.add('item-out-of-stock-error');
                button.innerHTML = 'Sorry! Out of stock!';
            }

            card.appendChild(anchor);
            card.appendChild(paragraph);
            card.appendChild(span);
            card.appendChild(button);

            itemsContainerEl.appendChild(card);
        })
    }

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
                    console.log(data)
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

        setTimeout(() => { event.target.innerHTML = '<i class="fas fa-cart-arrow-down"></i> Add to Cart'; }, 2000);
    }

    function handleOutOfStock(event) {
        event.target.innerHTML = "Sorry. Out of stock!";
        event.target.classList.add("item-out-of-stock-error");
        event.target.setAttribute("disabled", true);
    }
</script>
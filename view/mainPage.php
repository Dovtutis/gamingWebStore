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
                        <a href="/<?php echo $item->item_id ?>">
                            <img src="<?php echo $item->item_image ?>"></img>
                        </a>
                        <p><?php echo $item->item_name ?></p>
                        <span>€<?php echo $item->item_price ?></span>
                        <button class="items-container-add-to-cart-button"><i class="fas fa-cart-arrow-down"></i> Add to Cart</button>
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

    navbarConsolesSelectionButton.addEventListener('click', () => fetchForItemsByType('console'));
    navbarAccessoriesSelectionButton.addEventListener('click', () => fetchForItemsByType('accessory'));
    navbarGamesSelectionButton.addEventListener('click', () => fetchForItemsByType('game'));
    navbarOtherSelectionButton.addEventListener('click', () => fetchForItemsByType('other'));

    function fetchForItemsByType(selection) {
        fetch(`/fetchItems/${selection}`, {
                method: 'post',
            }).then(resp => resp.json())
            .then(data => {
                handleItems(data.items);
            }).catch(error => console.error())
    }

    function handleItems(items) {
        console.log(items);

        itemsContainerEl.innerHTML = "";
        items.map(item => {
            itemsContainerEl.innerHTML += `
                <div class="items-container-card">
                    <a href="/${item.item_id}">
                        <img src="${item.item_image}"></img>
                    </a>
                    <p>${item.item_name}</p>
                    <span>€${item.item_price}</span>
                    <button class="items-container-add-to-cart-button"><i class="fas fa-cart-arrow-down"></i>Add to Cart</button>
                </div>
            `
        })
    }

</script>
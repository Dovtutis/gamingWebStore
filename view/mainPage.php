<main>
    <article>
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" data-interval="10000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                    <a href=""><img src="https://cdn.game.net/image/upload/dpr_auto,f_auto,q_auto/v1/game_img/merch2021/Games/NierReplicant/NierReplicant-Xclu-db.jpg" class="d-block w-100" alt=<img src="Nier Automata"></a>
            </div>
            <?php foreach ($galleryImages as $image) : ?>
                <div class="carousel-item">
                    <a href=""><img src=<?php echo $image['img']?> class="d-block w-100" alt=<img src=<?php echo $image['alt']?>></a>
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
</main>
<footer>
    <div id="index-footer-container">
        © 2021. Dovydas Tutinas, all rights reserved.
    </div>
</footer>
<?php var_dump($name) ?>


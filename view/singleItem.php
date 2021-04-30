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
        <span>Left in sale: <?php echo $item->item_quantity ?></span>
    </div>
    <div class="single-item-right-container">
        <iframe src="<?php echo $item->item_video ?>">
        </iframe>
        <p>
            <?php echo $item->item_description ?>
        </p>
        <div class="single-item-add-to-cart-box">
            <button>
                <i class="fas fa-cart-arrow-down"></i>Add to Cart
            </button>
        </div>
    </div>
</div>

<?php var_dump($params) ?>
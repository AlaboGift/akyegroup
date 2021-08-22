<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
    .img-product{
      display: block;
      min-width: 250px;
      height: auto;
    }

    .img-product-container{
        height: 100% !important;
        width: 100% !important;
    }

    @media screen and (max-width: 600px){
     .img-product{
        min-height: 180px;
        max-height: 180px;
        width: 100%;
     }
    }
    @media screen and (min-width: 768px){
        .img-product{
            min-height: 180px;
            max-height: 180px;
            width: 100%; 
        }
        .img-product-container{
            width: auto;
            object-fit: fill;
        }
    }
</style>
<div class="product-item" style="box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);">
    <div class="row-custom">

        <?php if (auth_check()): ?>
            <a class="item-favorite-button item-favorite-enable <?php echo (is_product_in_favorites(user()->id, $product->id) == true) ? 'item-favorited' : ''; ?>" data-product-id="<?php echo $product->id; ?>"></a>
        <?php else: ?>
            <a class="item-favorite-button" data-toggle="modal" data-target="#loginModal"></a>
        <?php endif; ?>

        <a href="<?php echo generate_product_url($product); ?>">
            <div class="img-product-container">
                <img src="<?php echo $img_bg_product_small; ?>" data-src="<?php echo get_product_small_image($product->id); ?>" alt="<?php echo html_escape($product->title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo $img_bg_product_small; ?>'" style="min-width:100%">
            </div>
        </a>
        <?php if($product->swapped == $product->quantity): ?>
        <span class="badge badge-dark badge-promoted">out of stock</span>
        <?php endif; ?>
    </div>
    <div class="row-custom item-details">
        <h3 class="product-title">
            <a href="<?php echo generate_product_url($product); ?>" class="text-truncate"><?php echo ucwords(html_escape($product->title)); ?></a>
        </h3>
        <div class="item-meta">
            <span class="price"><?php echo get_currency($product->currency) . price_format($product->price); ?></span>
        </div>
    </div>
</div>
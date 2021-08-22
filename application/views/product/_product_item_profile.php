<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="product-item">
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
    <div class="row-custom m-t-10" style="margin-left: 5px;">
        <a href="javascript:void(0)" class="btn-product-delete" onclick="delete_product(<?php echo $product->id; ?>,'<?php echo trans("confirm_product"); ?>');"><i class="icon-times"></i>&nbsp;<?php echo trans("delete"); ?></a>
        <a href="<?php echo base_url() . "update-product/" . $product->id; ?>" class="btn-product-edit"><i class="icon-edit"></i>&nbsp;<?php echo trans("edit"); ?></a>
        <a href="#" class="btn-product-promote" data-toggle="modal" data-target="#swapModal" onclick='sData("<?=$product->id?>","<?=($product->quantity-$product->swapped)?>","<?=$product->swapped?>","<?=$product->quantity?>")'><i><img src="<?=base_url()?>uploads/logo/direct.png" style="height: 15px;"></i>&nbsp;Swapped</a>
    </div>
    <div class="row-custom item-details">
        <h3 class="product-title">
            <a href="<?php echo generate_product_url($product); ?>" class="text-truncate"><?php echo html_escape($product->title); ?></a>
        </h3>
        <p class="product-user text-truncate">
            <a href="<?php echo base_url() . "profile" . '/' . html_escape($product->user_slug); ?>">
                <?php echo html_escape($product->user_username); ?>
            </a>
        </p>
        <span class="price">Quantity: <?=($product->quantity-$product->swapped)?></span>
        <div class="item-meta">
            <span class="price">Price: <?php echo get_currency($product->currency) . price_format($product->price); ?></span>
            
            <?php if ($general_settings->product_reviews == 1): ?>
                <span class="item-comments"><i class="icon-comment"></i>&nbsp;<?php echo get_product_comment_count($product->id); ?></span>
            <?php endif; ?>
            <span class="item-favorites"><i class="icon-heart-o"></i>&nbsp;<?php echo get_product_favorited_count($product->id); ?></span>
        </div>
    </div>
</div>
<?php $this->load->view("partials/_modal_swapped");?>
<script type="text/javascript">
    function sData(a,b,c,d){
    $('#prod_id').val(a);
    $('#init_quant').val(d);
    $('#init').val(b);
    $('#int_swapped').val(c);
}
</script>
</script>

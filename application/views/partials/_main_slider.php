<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="main-slider" class="owl-carousel main-slider">
    <?php foreach ($slider_items as $item): ?>
        <div class="item">
            <a href="<?php echo $item->link; ?>">
                <img src="<?php echo base_url() . $item->image; ?>" class="owl-image  .img-fluid" style="max-width: 100%;height: auto;" alt="slider">
            </a>
        </div>
    <?php endforeach; ?>
</div>

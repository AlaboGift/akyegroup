<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($promoted_products as $product): ?>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false]); ?>
    </div>
<?php endforeach; ?>
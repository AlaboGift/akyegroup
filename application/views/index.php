<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->

<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                    <section class="section section-latest-products">
                         <?php $this->load->view("partials/_mega_menu"); ?>
                    </section>
                    <section class="section section-categories">
                        <!-- featured categories -->
                        <?php $this->load->view("partials/_mobile_cat"); ?>
                    </section>
               
                <?php if ($general_settings->index_latest_products == 1 && !empty($products)): ?>
                    <section class="section section-latest-products" style="margin-top: -15px;">
                        <button class="btn btn-sm btn-danger" style="color:#fff; margin-bottom: 10px;">Hot New Deals&nbsp;<span class="fa fa-fire"></span></button>
                        <div class="row">
                            <!--print products-->

                            <?php foreach ($promoted_products as $product): ?>
                                
                                <div class="col-6 col-sm-4 col-md-2">
                                    <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="row-custom text-center more">
                            <a href="<?php echo base_url() . "products"; ?>" class="link-see-more"><span><?php echo trans("see_more"); ?>&nbsp;</span><i class="icon-arrow-right"></i></a>
                        </div>
                    </section>
                <?php endif; ?>
                <div class="row-custom row-bn" id="fr">
                <div class="item">
                <a href="#">
                <img src="<?php echo base_url()?>uploads/slider/banner.jpg " class=".img-fluid" style="max-width: 100%;height: auto;" alt="slider">
                </a>
                </div>
                </div>

                <?php if ($general_settings->index_latest_products == 1 && !empty($products)): ?>
                    <section class="section section-latest-products">
                        <button class="btn btn-sm btn-success" style="color:#fff; margin-bottom: 10px;">Latest Swap&nbsp;<span class="fa fa-tag"></span></button>
                        <div class="row">
                            <!--print products-->

                            <?php foreach ($products as $product): ?>
                                
                                <div class="col-6 col-sm-4 col-md-2">
                                    <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false]); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="row-custom text-center more">
                            <a href="<?php echo base_url() . "products"; ?>" class="link-see-more"><span><?php echo trans("see_more"); ?>&nbsp;</span><i class="icon-arrow-right"></i></a>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Wrapper End-->
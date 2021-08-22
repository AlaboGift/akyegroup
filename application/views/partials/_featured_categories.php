<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--featured categories-->
<style type="text/css">
 @media screen and (max-width: 600px){
.featured-categories{
    display:none;
}

.mobile-category{
    background-color: #F5F5F5;
    justify-content: center;
    padding-top: 5px;
    padding-bottom: 5px;
}

.cat-box{
/*  box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.20);*/
  max-height: 100px;
  min-height: 100px;
  margin: 3px;
  justify-content: center;
  padding-left: 5px;
  padding-right: 5px;
  background: #ffff;
  max-width: 30%;
  display: inline-block;
  vertical-align: center;
  padding-top: 10px;
}

.cat-header{
  font-size: 20px;
  font-weight: bolder;
}
.caption p{
    font-size:13px;
    font-family: tahoma;
}
}

 @media screen and (min-width: 600px){
    .mobile-category{
    display:none;
}
    .cat-header{
        display: none;
}
}
</style>
<div class="row featured-categories">
    <div class="col">
        <?php 
        if((isset($default_location)) && ($default_location!=='All')){
            $country='?condition=all&sort=most_recent&country='.$modesy_default_location;
        }else{
            $country='';
        }
        $f_cat_1 = get_featured_category(1); ?>
        <?php if (!empty($f_cat_1)): ?>
            <div class="featured-category featured-category-1">
                <div class="inner">
                    <a href="<?php echo generate_category_url($f_cat_1).''.$country; ?>">
                        <img src="<?php echo $img_bg_product_small; ?>" data-src="<?php echo base_url() . $f_cat_1->image_2; ?>" alt="<?php echo html_escape($f_cat_1->name); ?>" class="lazyload img-fluid" onerror="this.src='<?php echo $img_bg_product_small; ?>'">
                        <div class="caption text-truncate">
                            <span><?php echo html_escape($f_cat_1->name); ?></span>
                        </div>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col">
        <?php $f_cat_2 = get_featured_category(2); ?>
        <?php if (!empty($f_cat_2)): ?>
            <div class="featured-category featured-category-2">
                <div class="inner">
                    <a href="<?php echo generate_category_url($f_cat_2).''.$country; ?>">
                        <img src="<?php echo $img_bg_product_small; ?>" data-src="<?php echo base_url() . $f_cat_2->image_1; ?>" alt="<?php echo html_escape($f_cat_2->name); ?>" class="lazyload img-fluid" onerror="this.src='<?php echo $img_bg_product_small; ?>'">
                        <div class="caption text-truncate">
                            <span><?php echo html_escape($f_cat_2->name); ?></span>
                        </div>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php $f_cat_3 = get_featured_category(3); ?>
        <?php if (!empty($f_cat_3)): ?>
            <div class="featured-category featured-category-3">
                <div class="inner">
                    <a href="<?php echo generate_category_url($f_cat_3).''.$country; ?>">
                        <img src="<?php echo $img_bg_product_small; ?>" data-src="<?php echo base_url() . $f_cat_3->image_1; ?>" alt="<?php echo html_escape($f_cat_3->name); ?>" class="lazyload img-fluid" onerror="this.src='<?php echo $img_bg_product_small; ?>'">
                        <div class="caption text-truncate">
                            <span><?php echo html_escape($f_cat_3->name); ?></span>
                        </div>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col">
        <?php $f_cat_4 = get_featured_category(4); ?>
        <?php if (!empty($f_cat_4)): ?>
            <div class="featured-category featured-category-4">
                <div class="inner">
                    <a href="<?php echo base_url(); ?>request-service">
                        <img src="<?=base_url()?>uploads/category/service.jpg" data-src="<?=base_url()?>uploads/category/service.jpg" alt="Services" class="lazyload img-fluid" onerror="this.src='<?=base_url()?>uploads/category/service.jpg'">
                        <div class="caption text-truncate">
                            <span>SERVICES</span>
                        </div>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php $f_cat_5 = get_featured_category(5); ?>
        <?php if (!empty($f_cat_5)): ?>
            <div class="featured-category featured-category-5">
                <div class="inner">
                    <a href="<?php echo generate_category_url($f_cat_5).''.$country; ?>">
                        <img src="<?php echo $img_bg_product_small; ?>" data-src="<?php echo base_url() . $f_cat_5->image_1; ?>" alt="<?php echo html_escape($f_cat_5->name); ?>" class="lazyload img-fluid">
                        <div class="caption text-truncate">
                            <span><?php echo html_escape($f_cat_5->name); ?></span>
                        </div>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="mobile-category row">
                <div class="col-4 col-sm-4 col-md-4 col-xs-4 cat-box">
                    <?php if ($this->uri->segment(1)==""): ?>
                    <?php if (auth_check()): ?>
                    <center><img src="<?=base_url()?>uploads/logo/cam.png"></span>
                    <a href="<?php echo base_url(); ?>swap-now">
                       <div class="caption">
                            <p>Add a Swap</p>
                        </div>
                    </a></center>
                    <?php else: ?>
                    <center><img src="<?=base_url()?>uploads/logo/cam.png"></span>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal">
                       <div class="caption">
                            <p>Add a Swap</p>
                        </div>
                    </a></center>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>

            <div class="col-4 col-sm-4 col-md-4 col-xs-4 cat-box">
                    <center><img src="<?=base_url()?>uploads/logo/service.png"></span>
                    <a href="<?php echo base_url(); ?>request-service">
                       <div class="caption">
                            <p>Services</p>
                        </div>
                    </a></center>
            </div>

        <?php 
        foreach ($mobile_cat as $cat):
        if (isset($cat['id'])): ?>
            <div class="col-4 col-sm-4 col-md-4 col-xs-4 cat-box">
                    <center><img src="<?=base_url()?>uploads/logo/<?=$cat['icon'].'.png';?>"></span>
                    <a href="<?php echo base_url().'category/'.$cat['slug'].''.$country; ?>">
                       <div class="caption">
                            <p><?php echo  ucwords($cat['name']); ?></p>
                        </div>
                    </a></center>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
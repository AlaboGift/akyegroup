<style type="text/css">
._icon{
   border-bottom: 1px solid #F5F5F5;
}
 @media screen and (min-width: 600px){
.home-slideshow{
	width: 600px;
	}

#owl-img{
	height: 362px;
	width: 100%;
}
}
 @media screen and (max-width: 600px){
.e-banner{
    display:none;
}
.main-slider{
	margin-top: 20px;
}
.item{
	padding-bottom: 10px;
}
#owl-img{
max-width: 100%;height: auto;
border-radius: 20px 20px 20px 0px;
}
.home-slideshow{
	margin-top: -20px;
	background: #E4E4E4;
}
}
</style>
<section class="home_slideshow main-slideshow" style="margin-top: -50px;">
<div class="home-slideshow-wrapper">
<div class="container">
<div class="row">
<div class="group-home-slideshow">
<div class="home-sidemenu-inner col-sm-3" style="box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);">
<ul class="navigation_links_left">
<li class="nav-item _icon">
<a href="<?php echo base_url(); ?>request-service">
<img src="<?=base_url()?>uploads/logo/cam.png" alt="Add a Swap" style="width:23.5px;">
<span>Add a Swap</span>
</a>
</li>
<?php foreach ($mobile_cat as $cat): 
if($cat['slug'] == 'direct-sales'):
?>
<li class="nav-item _icon">
<a href="<?php echo base_url().'category/'.$cat['slug']; ?>">
<img src="<?=base_url()?>uploads/logo/<?=$cat['icon'].'.png';?>" alt="<?php echo  ucwords($cat['name']); ?>" style="width:23.5px;">
<span><?php echo  ucwords($cat['name']); ?><sup><span class="badge badge-danger">NEW</span></sup></span>
</a>
</li>
<?php else: ?>
<li class="nav-item _icon">
<a href="<?php echo base_url().'category/'.$cat['slug']; ?>">
<img src="<?=base_url()?>uploads/logo/<?=$cat['icon'].'.png';?>" alt="<?php echo  ucwords($cat['name']); ?>" style="width:23.5px;">
<span><?php echo  ucwords($cat['name']); ?></span>
</a>
</li>
<?php 
endif;
endforeach; ?>
<li class="nav-item _icon">
<a href="<?php echo base_url(); ?>request-service">
<img src="<?=base_url()?>uploads/logo/service.png" alt="services" style="width:23.5px;">
<span>Services</span>
</a>
</li>

<li class="nav-item nav-view-more">
<a href="<?=base_url()?>category/other-categories">
<img src="<?=base_url()?>uploads/logo/plus.png" alt="more" style="width:22px;">
<span>View More</span>
</a>
</li>

</ul>
</div>

<div class="home-slideshow-inner col-sm-6">
<div class="home-slideshow">
<div id="main-slider" class="carousel slide owl-carousel main-slider">
    <?php foreach ($slider_items as $item): ?>
     <div class="carousel-inner">
        <div class="item image">
            <a href="<?php echo $item->link; ?>">
                <img src="<?php echo base_url() . $item->image; ?>" class="owl-image .img-fluid" alt="slider" id="owl-img" >
            </a>
        </div>
     </div>
    <?php endforeach; ?>
</div>
</div>
</div>

<div class="col-sm-3 e-banner" >
<div class="banner-content">
<div class="banner-1">
<a href="#">
<img src="<?php echo base_url(); ?>uploads/images/home3_slideshow_banner_1.jpg" alt="">
</a>
</div>
<div class="banner-2">
<a href="<?php echo base_url(); ?>request-service">
<img src="<?php echo base_url(); ?>uploads/images/home3_slideshow_banner_2.jpg" alt="">
</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
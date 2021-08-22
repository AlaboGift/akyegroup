<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--featured categories-->
<style type="text/css">
@media screen and (max-width: 600px){
.featured-categories{
display:none;
}

.mobile-category{
background-color: #E4E4E4;
justify-content: center;
padding-top: 5px;
padding-bottom: 5px;
}

.cat-box{
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
border-radius: 10px;
padding-bottom: 10px;
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
if ($cat['slug'] == 'direct-sales'): ?>
<div class="col-4 col-sm-4 col-md-4 col-xs-4 cat-box">
<center><img src="<?=base_url()?>uploads/logo/<?=$cat['icon'].'.png';?>"></span>
<a href="<?php echo base_url().'category/'.$cat['slug']?>">
<div class="caption">
<p><?php echo  ucwords($cat['name']); ?><sup><span class="badge badge-danger">NEW</span></sup></p>
</div>
</a></center>
</div>
<?php else: ?>
<div class="col-4 col-sm-4 col-md-4 col-xs-4 cat-box">
<center><img src="<?=base_url()?>uploads/logo/<?=$cat['icon'].'.png';?>"></span>
<a href="<?php echo base_url().'category/'.$cat['slug']?>">
<div class="caption">
<p><?php echo  ucwords($cat['name']); ?></p>
</div>
</a></center>
</div>
<?php endif; ?>
<?php endforeach; ?>
</div>
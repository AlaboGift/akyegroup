<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style type="text/css">
    @media screen and (max-width: 320px){
/*     .desktop-footer,.hidden-nav{
        display: none;
     }*/
     .fix-bottom .container{
       z-index: 100;
       position: relative;
       left: -45px;
       margin-bottom:-35px;
       padding-bottom: 5px;
     }

     .container .user{ 
      z-index: 0;
      position: relative;
      top: -22px;
      right: -150px;
    }

    .feeter li{
     padding-top: 0px;
    }
    }

    @media screen and (max-width: 360px){
/*     .desktop-footer,.hidden-nav{
        display: none;
     }*/
     .fix-bottom .container{
       margin-left: -20px;
     }

    }

    @media screen and (max-width: 411px){
/*     .desktop-footer,.hidden-nav{
        display: none;
     }*/
     .fix-bottom .container{
       margin-left: -20px;
     }

    }

    @media screen and (max-width: 414px){
/*     .desktop-footer,.hidden-nav{
        display: none;
     }*/
     .fix-bottom .container{
       margin-left: -20px;
     }

    }

    @media screen and (max-width: 600px){
/*     .desktop-footer,.hidden-nav{
        display: none;
     }*/
     
    .scrollup{
        opacity: 0;
        margin-left:-10px;
     }

     .feeter li{
        display: inline;
        text-decoration: none;
        padding: 10px;
        margin-left: 15px;
        margin-right: 15px;
        position: relative;
        bottom: -10px;
        z-index: 1;
     }
     .sell-button{
        height: 10%;
        width: 20%;
        background-color: #3581ff;
        padding: 13px;
        z-index:102;
        position: relative;
        top: -35px;
        border-radius: 50px;
        font-weight: bolder;
        color: #fff;
        font-size: 16px;
     }

     .fix-bottom{
        height: 5%;
        z-index: 99;
        position: relative;
        width: 100%;
     }

     .feeter li i{
        color: #fff;
        font-size: 20px;
    }

    
     .fa-home{
        color: black;
     }
    .fixed-bottom{
        padding: 0px;
    }
}
    @media screen and (min-width: 600px){
        .mobile-footer{
            display: none;
        }
    }

</style>
<footer id="footer" style="margin-top: -10px; background: #051130;">
        <?php if(!is_service()): ?>
        <?php if ($this->uri->segment(1)==""): ?>
        <div class="container mobile-footer fixed-bottom">
        <div class="fix-bottom">
        <?php if (auth_check()): ?>
        <center><a href="<?php echo base_url(); ?>swap-now" class="sell-button">Swap Now &nbsp;<img src="<?=base_url()?>uploads/logo/camera.png" style="margin-top: -5px;"></a></center>
        <?php else: ?>
        <center><a href="javascript:void(0)" class="sell-button" data-toggle="modal" data-target="#loginModal">Swap Now &nbsp;<img src="<?=base_url()?>uploads/logo/camera.png" style="margin-top: -5px;"></a></center>
        <?php endif; ?>
        </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    <div class="container desktop-footer">
        <div class="row">
            <div class="col-12">

                <div class="footer-top">
                  <p><span>Akyegroup</span> is a localized swapping site but exchange is done in our offices, we deal on phones, laptops, watches, shoes, clothes, home appliances such as TV set, gas cooker, microwave, fridge etc, we swap out used items for new or old items for new depending on the customer's choice.</p>
                  <p>Also, we connect service providers such as electricians, engineers, hair dressers, event ushers etc to homes and offices, Our prices are friendly and affordable, delivering quality is our priority, we warranty on new item expressed by the manufacturer, be assured of maximum satisfaction when you contact us for swapping of items or service rendering.</p>
                    <hr style="background-color:#FFF;">
                    <div class="row">

                        <div class="col-md-3 col-sm-6 col-xs-6 footer-widget">
                            <div class="nav-footer">
                                <div class="row-custom">
                                    <h4 class="footer-title"><?php echo trans("footer_quick_links"); ?></h4>
                                </div>
                                <div class="row-custom">
                                    <ul>
                                        <li><a href="<?php echo base_url(); ?>"><?php echo trans("home"); ?></a></li>
                                        <li><a href="<?php echo base_url(); ?>contact"><?php echo trans("contact"); ?></a></li>
                                        <?php foreach ($footer_quick_links as $item): ?>
                                            <li><a href="<?php echo base_url() . $item->slug; ?>"><?php echo html_escape($item->title); ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 footer-widget">
                            <div class="nav-footer">
                                <div class="row-custom">
                                    <h4 class="footer-title"><?php echo trans("footer_information"); ?></h4>
                                </div>
                                <div class="row-custom">
                                    <ul>
                                        <?php foreach ($footer_information_links as $item): ?>
                                            <li><a href="<?php echo base_url() . $item->slug; ?>"><?php echo html_escape($item->title); ?></a></li>
                                        <?php endforeach; ?>
                                        <li><a href="#"><span class="fa fa-envelope"></span>&nbsp;info@akyegroup.com</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-sm-6 col-xs-6 footer-widget">
                            <div class="row-custom">
                                <h4 class="footer-title"><?php echo trans("follow_us"); ?></h4>
                                <div class="footer-social-links">
                                    <!--include social links-->
                                    <?php $this->load->view("partials/_social_links"); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-sm-6 col-xs-6 footer-widget">
                            <div class="row-custom">
                                <h4 class="footer-title">Visit Us Today</h4>
                                  <span class="fa fa-map-marker"></span>&nbsp;<?=get_settings()->contact_address;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php if (!isset($_COOKIE["modesy_cookies_warning"]) && $settings->cookies_warning): ?>
    <div class="cookies-warning">
        <div class="text"><?php echo $this->settings->cookies_warning_text; ?></div>
        <a href="javascript:void(0)" onclick="hide_cookies_warning();" class="icon-cl"> <i class="icon-close"></i></a>
    </div>
<?php endif; ?>
<!-- Scroll Up Link -->
<a href="javascript:void(0)" class="scrollup"><i class="icon-arrow-up"></i></a>
</footer>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var fb_app_id = '<?php echo $this->general_settings->facebook_app_id; ?>';
    var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
</script>
<!-- Popper JS-->
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/popper.min.js"></script>
<!-- Bootstrap JS-->
<script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Owl-carousel -->
<script src="<?php echo base_url(); ?>assets/vendor/owl-carousel/owl.carousel.min.js"></script>
<!-- Plugins JS-->
<script src="<?php echo base_url(); ?>assets/js/plugins.js"></script>
<!-- Custom JS-->
<script src="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<?php $this->load->view("partials/_js_footer.min.php"); ?>
<script src="<?php echo base_url(); ?>assets/js/choices.js"></script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5e91ae2069e9320caac2900f/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<script type="text/javascript">
  window.onscroll = function(){myFunction();}
  var nav = document.getElementById('stick');
  var sticky = nav.offsetTop;
  function myFunction(){
    if(window.pageYOffset >= sticky){
      nav.classList.add('fixed-top');
    }else{
      nav.classList.remove('fixed-top');
    }
  }
</script>
</body>
</html>
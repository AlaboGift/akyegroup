<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo html_escape($title); ?> - <?php echo html_escape($settings->site_title); ?></title>
    <meta name="description" content="<?php echo html_escape($description); ?>"/>
    <meta name="keywords" content="<?php echo html_escape($keywords); ?>"/>
    <meta name="author" content="Codingest"/>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($general_settings); ?>"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:site_name" content="<?php echo html_escape($general_settings->application_name); ?>"/>
<?php if (isset($show_og_tags)): ?>
    <meta property="og:type" content="<?php echo $og_type; ?>"/>
    <meta property="og:title" content="<?php echo $og_title; ?>"/>
    <meta property="og:description" content="<?php echo $og_description; ?>"/>
    <meta property="og:url" content="<?php echo $og_url; ?>"/>
    <meta property="og:image" content="<?php echo $og_image; ?>"/>
    <meta property="og:image:width" content="<?php echo $og_width; ?>"/>
    <meta property="og:image:height" content="<?php echo $og_height; ?>"/>
    <meta property="article:author" content="<?php echo $og_author; ?>"/>
    <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
<?php if (!empty($og_tags)):foreach ($og_tags as $tag): ?>
    <meta property="article:tag" content="<?php echo $tag->tag; ?>"/>
<?php endforeach; endif; ?>
    <meta property="article:published_time" content="<?php echo $og_published_time; ?>"/>
    <meta property="article:modified_time" content="<?php echo $og_modified_time; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?php echo html_escape($general_settings->application_name); ?>"/>
    <meta name="twitter:creator" content="@<?php echo html_escape($og_creator); ?>"/>
    <meta name="twitter:title" content="<?php echo html_escape($og_title); ?>"/>
    <meta name="twitter:description" content="<?php echo html_escape($og_description); ?>"/>
    <meta name="twitter:image" content="<?php echo $og_image; ?>"/>
<?php else: ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php echo html_escape($title); ?> - <?php echo html_escape($settings->site_title); ?>"/>
    <meta property="og:description" content="<?php echo html_escape($description); ?>"/>
    <meta property="og:url" content="<?php echo base_url(); ?>"/>
    <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?php echo html_escape($general_settings->application_name); ?>"/>
    <meta name="twitter:title" content="<?php echo html_escape($title); ?> - <?php echo html_escape($settings->site_title); ?>"/>
    <meta name="twitter:description" content="<?php echo html_escape($description); ?>"/>
<?php endif; ?>
    <meta name="google-signin-client_id" content="<?php echo $general_settings->google_client_id ?>">
    <link rel="canonical" href="<?php echo current_url(); ?>"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i&amp;subset=latin-ext" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/cs-3.styles.css" rel="stylesheet" type="text/css" media="all">
    <!-- Modesy Icon Font CSS -->
    <link href="<?php echo base_url(); ?>assets/vendor/font-icons/css/modesy-icons.min.css" rel="stylesheet"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <!-- Owl Carousel -->
    <link href="<?php echo base_url(); ?>assets/vendor/owl-carousel/owl.carousel.min.css" rel="stylesheet"/>
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/plugins.css"/>
    <!-- Style CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.css"/>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css"/>
<?php if (!empty($general_settings->site_color)): ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colors/<?php echo $general_settings->site_color; ?>.min.css"/>
<?php else: ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colors/default.min.css"/>
<?php endif; ?>
    <!-- jQuery JS-->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1/jquery-ui.min.css"> 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<?php echo $general_settings->google_analytics; ?>
<?php echo $general_settings->head_code; ?>
<script data-ad-client="ca-pub-3086835557848142" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
<style type="text/css">
  @media screen and (min-width: 600px){
        .mobile-location{
            display: none;
        }
    }

 @media screen and (min-width: 800px){
        .s13{
          display: none;
        }
  } 
 @media screen and (width: 1024px){
        .s130{
          position: relative;
          left: 80px;
          top: -25px;
        }
  } 
  .loginBtn {
  box-sizing: border-box;
  position: relative;
  /* width: 13em;  - apply for fixed size */
  margin: 0.2em;
  padding: 0 15px 0 46px;
  border: none;
  text-align: left;
  line-height: 34px;
  white-space: nowrap;
  border-radius: 0.2em;
  font-size: 16px;
  color: #FFF;
}
.loginBtn:before {
  content: "";
  box-sizing: border-box;
  position: absolute;
  top: 0;
  left: 0;
  width: 34px;
  height: 100%;
}
.loginBtn:focus {
  outline: none;
}
.loginBtn:active {
  box-shadow: inset 0 0 0 32px rgba(0,0,0,0.1);
}


/* Facebook */
.loginBtn--facebook {
  background-color: #4C69BA;
  background-image: linear-gradient(#4C69BA, #3B55A0);
  /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
  text-shadow: 0 -1px 0 #354C8C;
}
.loginBtn--facebook:before {
  border-right: #364e92 1px solid;
  background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
}
.loginBtn--facebook:hover,
.loginBtn--facebook:focus {
  background-color: #5B7BD5;
  background-image: linear-gradient(#5B7BD5, #4864B1);
}


/* Google */
.loginBtn--google {
  /*font-family: "Roboto", Roboto, arial, sans-serif;*/
  background: #DD4B39;
}
.loginBtn--google:before {
  border-right: #BB3F30 1px solid;
  background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png') 6px 6px no-repeat;
}
.loginBtn--google:hover,
.loginBtn--google:focus {
  background: #E74B37;
}
</style>
<header id="header">
    <div class="main-menu">
        <div class="container-fluid">
            <div class="row">
                <div class="nav-top">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-7 nav-top-left">
                                <div class="row-align-items-center">
                                    <div class="logo">
                                        <a href="<?php echo base_url(); ?>"><img src="<?php echo get_logo($general_settings); ?>" alt="logo"></a>
                                    </div>
                                        <div class="s130">
                                          <?php echo form_open(base_url() . 'filter-products', ['id' => 'form_validate_s']); ?>
                                            <div class="inner-form">
                                              <div class="input-field first-wrap">
                                                <div class="svg-wrapper">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                                                  </svg>
                                                </div>
                                                <input id="search" name="search" maxlength="300" pattern=".*\S+.*" class="input-search input-group-addon" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="What are you looking for?" />
                                              </div>
                                              <div class="input-field second-wrap">
                                                <button class="btn-search" type="submit" name="submit">SEARCH</button>
                                              </div>
                                            </div>
                                          <?php echo form_close(); ?>
                                        </div>

                                    

                                </div>
                            </div>
                            <div class="col-md-5 nav-top-right">
                                <ul class="nav align-items-center">
                                    <!--Check auth-->
                                    <?php if (auth_check()): ?>
                                        <?php   if(!is_service()): ?> 
                                        <li class="nav-item li-favorites"><a href="<?php echo base_url(); ?>favorites/<?php echo user()->slug; ?>" class=""> <i class="icon-heart-o"></i><?php echo trans("favorites"); ?></a></li>
                                        <?php endif; ?>
                                        <li class="dropdown profile-dropdown">
                                            <a class="dropdown-toggle a-profile" data-toggle="dropdown" href="javascript:void(0)"
                                               aria-expanded="false">
                                                <?php if ($unread_message_count > 0): ?>
                                                    <span class="notification"><?php echo $unread_message_count; ?></span>
                                                <?php endif; ?>
                                                <img src="<?php echo get_user_avatar(user()); ?>" alt="<?php echo html_escape(user()->username); ?>">
                                                <span class="username"><?php echo html_escape(user()->username); ?></span>
                                                <span class="icon-arrow-down"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <?php if (user()->role == "admin" OR user()->role == "super-admin"): ?>
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>">
                                                            <i class="icon-dashboard"></i>
                                                            <?php echo trans("admin_panel"); ?>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>profile/<?php echo user()->slug; ?>">
                                                        <i class="icon-user"></i>
                                                        <?php echo trans("view_profile"); ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>messages">
                                                        <i class="icon-mail"></i>
                                                        <?php echo trans("messages"); ?>
                                                        <?php if ($unread_message_count > 0): ?>
                                                            <span class="span-message-count"><?php echo $unread_message_count; ?></span>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                                <?php   if(is_service()){ ?> 
                                                <li>
                                                    <a href="<?php echo base_url(); ?>settings/service-profile">
                                                        <i class="icon-settings"></i>
                                                        <?php echo trans("settings"); ?>
                                                    </a>
                                                </li>
                                                <?php   }else{ ?>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>settings/update-profile">
                                                        <i class="icon-settings"></i>
                                                        <?php echo trans("settings"); ?>
                                                    </a>
                                                </li>
                                                <?php   } ?>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>logout" class="logout">
                                                        <i class="icon-logout"></i>
                                                        <?php echo trans("logout"); ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php   if(!is_service()): ?> 
                                        <li class="nav-item"><a href="<?php echo base_url(); ?>swap-now" class="btn btn-md btn-custom btn-sell-now">SWAP NOW</a></li>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <li class="nav-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a></li>
                                        <li class="nav-item"><a href="<?php echo base_url(); ?>register"><?php echo trans("register"); ?></a></li>
                                        <li class="nav-item"><a href="javascript:void(0)" class="btn btn-md btn-custom btn-sell-now" data-toggle="modal" data-target="#loginModal">SWAP NOW</a></li>
                                    <?php endif; ?>
                                    <?php if ($general_settings->multilingual_system == 1 && count($languages) > 1): ?>
                                        <li class="dropdown language-dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                               aria-expanded="false">
                                                <?php echo html_escape($selected_lang->short_form); ?> <span class="icon-arrow-down"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <?php foreach ($languages as $language): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" class="<?php echo ($language->id == $selected_lang->id) ? 'selected' : ''; ?> " onclick="set_site_language('<?php echo $language->id; ?>');">
                                                            <?php echo $language->short_form; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav-main">
                    <!--main navigation-->
                    <?php $this->load->view("partials/_main_nav"); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-menu">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-2">
                    <div class="mobile-menu-button">
                        <a href="javascript:void(0)" class="btn-open-mobile-nav"><i class="icon-menu"></i></a>
                    </div>
                </div>

                <div class="col-8">
                    <div class="mobile-logo">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo get_logo($general_settings); ?>" alt="logo"></a>
                    </div>
                </div>

                <div class="col-2">
                    <div class="mobile-search-button">
                    <?php if ($this->uri->segment(1)==""): ?>
                    <?php if (auth_check()): ?>
                    <a href="<?php echo base_url(); ?>profile/<?php echo user()->slug; ?>" ><img src="<?=base_url()?>uploads/logo/user.png"></a>
                    <?php else: ?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal"><img src="<?=base_url()?>uploads/logo/user.png"></a>
                    <?php endif; ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="s13" style="background-color: #E4E4E4;" id="stick">
<?php echo form_open(base_url() . 'filter-products', ['id' => 'form_validate_s']); ?>
<div class="inner-form">
<div class="input-field first-wrap" style="background-color: #fff;">
<div class="svg-wrapper">
</div>
<input id="search" name="search" maxlength="300" pattern=".*\S+.*" class="input-search input-group-addon" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="What are you looking for?"  />
</div>
<div class="input-field second-wrap">
<button class="btn-search" type="submit"><span class="fa fa-search"></span></button>
</div>
</div>
<?php echo form_close(); ?>
</div>
<!--include mobile menu-->
<?php $this->load->view("partials/_mobile_nav"); ?>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered login-modal" role="document">
        <div class="modal-content">
            <div class="auth-box">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="title"><?php echo trans("login"); ?></h4>
                <!-- form start -->
                <form id="form_login" novalidate="novalidate">
                    <div class="social-login-cnt">
                        <?php $this->load->view("partials/_social_login", ["google_button_id" => "googleSignIn", "or_text" => trans("login_with_email")]); ?>
                    </div>
                    <!-- include message block -->
                    <div id="result-login"></div>

                    <div class="form-group">
                        <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email_address"); ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("password"); ?>" minlength="4" required>
                    </div>
                    <div class="form-group text-right">
                        <a href="<?php echo base_url(); ?>reset-password" class="link-forgot-password"><?php echo trans("forgot_password"); ?></a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("login"); ?></button>
                    </div>

                    <p class="p-social-media m-0 m-t-5"><?php echo trans("dont_have_account"); ?>&nbsp;<a href="<?php echo base_url(); ?>register" class="link"><?php echo trans("register"); ?></a></p>
                    <!--<a class="loginBtn loginBtn--facebook form-control" href="">Login with Facebook</a>
                    <br>
                    <a class="loginBtn loginBtn--google form-control" href="">Login with Google</a>-->
                </form>
                <!-- form end -->
            </div>
        </div>
    </div>
</div>






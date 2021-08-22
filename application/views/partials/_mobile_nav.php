<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="navMobile" class="nav-mobile">
    
    <div class="mobile-nav-logo">
        <a href="<?php echo base_url(); ?>"><img src="<?php echo get_logo($general_settings); ?>" alt="logo"></a>
    </div>
    <a href="javascript:void(0)" class="btn-close-mobile-nav"><i class="icon-close"></i></a>
    <div class="nav-mobile-inner">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>" class="nav-link"><?php echo trans("home"); ?></a>
            </li>
            <?php if (!empty($parent_categories)):
                $count = 1;
                foreach ($parent_categories as $category):
                    $subcategories = get_subcategories_by_parent_id($category->id);
                    if (empty($subcategories)):?>
                        <li class="nav-item">
                            <a href="<?php echo generate_category_url($category); ?>" class="nav-link"><?php echo html_escape($category->name); ?></a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo html_escape($category->name); ?><i class="icon-arrow-down"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo generate_category_url($category); ?>"><?php echo html_escape($category->name); ?></a>
                                <?php foreach ($subcategories as $subcategory): ?>
                                    <a class="dropdown-item" href="<?php echo generate_category_url($subcategory); ?>"><?php echo html_escape($subcategory->name); ?></a>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    <?php endif;
                    $count++;
                endforeach;
            endif; ?>

            <li class="nav-item"><a href="<?php echo base_url(); ?>contact" class="nav-link"><?php echo trans("contact"); ?></a></li>
            <?php if (auth_check()): ?>
                <li class="nav-item"><a href="<?php echo base_url(); ?>profile/<?php echo user()->slug; ?>" class="nav-link"><?php echo trans("profile"); ?></a></li>

                 <?php   if(is_service()){ ?> 
                <li class="nav-item"><a href="<?php echo base_url(); ?>settings/service-profile" class="nav-link"><?php echo trans("settings"); ?></a></li>
                    <?php echo trans("settings"); ?>
                    </a>
                    </li>
                    <?php   }else{ ?>
                <li class="nav-item"><a href="<?php echo base_url(); ?>settings/update-profile" class="nav-link"><?php echo trans("settings"); ?></a></li>
                    <?php echo trans("settings"); ?>
                    </a>
                    </li>
                <?php   } ?>

                <li class="nav-item"><a href="<?php echo base_url(); ?>messages" class="nav-link"><?php echo trans("messages"); ?></a></li>
                <li class="nav-item"><a href="<?php echo base_url(); ?>logout" class="nav-link"><?php echo trans("logout"); ?></a></li>
            <?php else: ?>
                <li class="nav-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="nav-link close-mobile-nav"><?php echo trans("login"); ?></a></li>
                <li class="nav-item"><a href="<?php echo base_url(); ?>register" class="nav-link"><?php echo trans("register"); ?></a></li>
            <?php endif; ?>
            <?php if ($general_settings->multilingual_system == 1 && count($languages) > 1): ?>
                <li class="nav-item dropdown language-dropdown text-left">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo html_escape($selected_lang->short_form); ?><i class="icon-arrow-down"></i>
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
            <?php if (auth_check()): ?>
                <li class="nav-item item-sell-button"><a href="<?php echo base_url(); ?>swap-now" class="btn btn-md btn-custom btn-block m-t-10">Swap Now</a></li>
            <?php else: ?>
                <li class="nav-item item-sell-button"><a href="javascript:void(0)" class="btn btn-md btn-custom btn-block close-mobile-nav m-t-10" data-toggle="modal" data-target="#loginModal">Swap Now</a></li>
            <?php endif; ?>
        </ul>
        <div class="mobile-social-links">
            <?php $this->load->view("partials/_social_links"); ?>
        </div>
    </div>
</div>
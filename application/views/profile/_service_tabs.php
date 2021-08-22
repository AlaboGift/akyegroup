<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--profile page tabs-->
<div class="profile-tabs">
    <ul class="nav">
        <li class="nav-item <?php echo ($active_tab == 'profile') ? 'active' : ''; ?>">
            <a class="nav-link"  href="<?php echo base_url(); ?>profile/<?php echo user()->slug; ?>">
                <span><span class="fa fa-wrench"></span>&nbsp;&nbsp;Jobs</span>
                <span class="count">(<?=$jobs_count;?>)</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($active_tab == 'messages') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?=base_url()?>messages">
                <span><span class="fa fa-bell"></span>&nbsp;&nbsp;Notifications</span>
                <span class="count">(0)</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($active_tab == 'payment') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url() . "payment/" . $user->slug; ?>">
                <span><span class="fa fa-money"></span>&nbsp;&nbsp;Payment</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($active_tab == 'settings') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo base_url(); ?>settings/service-profile">
                <span><span class="fa fa-cog"></span>&nbsp;&nbsp;Settings</span>
                <span class="count">(*)</span>
            </a>
        </li>
    </ul>
</div>

<div class="row-custom">
    <!--Include banner-->
    <?php $this->load->view("partials/_ad_spaces_sidebar", ["ad_space" => "profile_sidebar", "class" => "m-t-30"]); ?>
</div>

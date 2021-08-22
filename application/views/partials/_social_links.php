<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<ul>
    <?php if (!empty($settings->facebook_url)): ?>
        <li><a href="<?php echo html_escape($settings->facebook_url); ?>"><i class="icon-facebook"></i>&nbsp;&nbsp;&nbsp;<?php echo html_escape($settings->facebook_url); ?></a></li>
    <?php endif; ?>
    <?php if (!empty($settings->twitter_url)): ?>
        <li><a href="<?php echo html_escape($settings->twitter_url); ?>"><i class="icon-twitter"></i>&nbsp;&nbsp;&nbsp;<?php echo html_escape($settings->twitter_url); ?></a></li>
    <?php endif; ?>
    <?php if (!empty($settings->google_url)): ?>
        <li><a href="<?php echo html_escape($settings->google_url); ?>"><i class="icon-google-plus"></i>&nbsp;&nbsp;&nbsp;<?php echo html_escape($settings->google_url); ?></a></li>
    <?php endif; ?>
    <?php if (!empty($settings->instagram_url)): ?>
        <li><a href="<?php echo html_escape($settings->instagram_url); ?>"><i class="icon-instagram"></i>&nbsp;&nbsp;&nbsp;<?php echo html_escape($settings->instagram_url); ?></a></li>
    <?php endif; ?>
    <?php if (!empty($settings->pinterest_url)): ?>
        <li><a href="<?php echo html_escape($settings->pinterest_url); ?>"><i class="icon-pinterest"></i>&nbsp;&nbsp;&nbsp;<?php echo html_escape($settings->pinterest_url); ?></a></li>
    <?php endif; ?>

    <?php if (!empty($settings->linkedin_url)): ?>
        <li><a href="<?php echo html_escape($settings->linkedin_url); ?>"><i class="icon-linkedin"></i>&nbsp;&nbsp;&nbsp;<?php echo html_escape($settings->linkedin_url); ?></a></li>
    <?php endif; ?>

    <?php if (!empty($settings->youtube_url)): ?>
        <li><a href="<?php echo html_escape($settings->youtube_url); ?>"><i class="icon-youtube"></i>&nbsp;&nbsp;&nbsp;<?php echo html_escape($settings->youtube_url); ?></a></li>
    <?php endif; ?>
</ul>

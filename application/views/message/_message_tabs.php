<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="profile-tabs">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>messages">
                <i class="icon-inbox"></i>
                <span><?php echo trans("messages"); ?></span>
                <?php if ($unread_message_count > 0): ?>
                    <span class="span-message-count float-right"><?php echo $unread_message_count; ?></span>
                <?php endif; ?>
            </a>
        </li>
    </ul>
</div>
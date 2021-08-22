<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo trans("messages"); ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?php echo trans("messages"); ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <!-- load profile nav -->
                    <?php $this->load->view("message/_message_tabs"); ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="row-custom messages-head">
                    <div class="head-item">
                        <div class="select-checkbox">
                            <label class="custom-checkbox checkbox-bordered">
                                <input type="checkbox" name="terms" id="checkAll">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <label for="checkAll" class="lbl-head"><?php echo trans("select_all"); ?></label>
                    </div>
                    <div class="head-item">
                        <a href="javascript:void(0)" onclick="delete_selected_conversations('<?php echo trans("confirm_messages"); ?>');" class="btn-delete-messages"><i class="icon-trash"></i> <label class="lbl-head"><?php echo trans("delete"); ?></label></a>
                    </div>
                    <div class="head-item float-right">
                        <strong><?php echo trans('total'); ?>: <?php echo $conversation_count; ?></strong>
                    </div>

                </div>
                <div class="row-custom messages-content">
                    <?php if (empty($conversations)): ?>
                        <p class="text-center"><?php echo trans("no_messages_found"); ?></p>
                    <?php endif; ?>
                    <?php foreach ($conversations as $conversation):
                        $message = get_last_message($conversation->id);
                        if ($message->receiver_id == user()->id):
                            $user = get_user($message->sender_id);

                            if (!empty($user) && !empty($message)):?>
                                <a href="<?php echo base_url(); ?>messages/message/<?php echo $conversation->id; ?>" class="message-item-link">
                                    <div class="message-item">
                                        <div class="left">
                                            <label class="custom-checkbox checkbox-bordered">
                                                <input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $conversation->id; ?>">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="middle">
                                            <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo html_escape($user->username); ?>">
                                        </div>
                                        <div class="right">
                                            <div class="row-custom">
                                                <strong class="username"><span class="to">From:</span><?php echo html_escape($user->username); ?></strong>
                                                <?php if ($conversation->is_read == 0 && $conversation->last_receiver_id == user()->id): ?>
                                                    <label class="badge badge-info badge-new"><?php echo trans("new"); ?></label>
                                                <?php endif; ?>
                                                <span class="time"><?php echo time_ago($message->created_at); ?></span>
                                            </div>
                                            <div class="row-custom m-b-0">
                                                <p class="subject"><?php echo html_escape($conversation->subject); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endif;

                        elseif ($message->sender_id == user()->id):
                            $user = get_user($message->receiver_id);

                            if (!empty($user) && !empty($message)):?>
                                <a href="<?php echo base_url(); ?>messages/message/<?php echo $conversation->id; ?>" class="message-item-link">
                                    <div class="message-item">
                                        <div class="left">
                                            <label class="custom-checkbox checkbox-bordered">
                                                <input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $conversation->id; ?>">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="middle">
                                            <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo html_escape($user->username); ?>">
                                        </div>
                                        <div class="right">
                                            <div class="row-custom">
                                                <strong class="username"><span class="to">To:</span><?php echo html_escape($user->username); ?></strong>
                                                <?php if ($conversation->is_read == 0 && $conversation->last_receiver_id == user()->id): ?>
                                                    <label class="badge badge-info badge-new"><?php echo trans("new"); ?></label>
                                                <?php endif; ?>
                                                <span class="time"><?php echo time_ago($message->created_at); ?></span>
                                            </div>
                                            <div class="row-custom m-b-0">
                                                <p class="subject"><?php echo html_escape($conversation->subject); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endif;
                        endif; ?>

                    <?php


                    endforeach; ?>
                </div>
                <div class="row-custom">
                    <div class="product-list-pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->


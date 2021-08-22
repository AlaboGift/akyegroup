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
                        <a href="javascript:void(0)" class="message-head-link" onclick='delete_conversation(<?php echo $conversation->id; ?>,"<?php echo trans("confirm_message"); ?>");'><i class="icon-trash"></i> <label class="lbl-head"><?php echo trans("delete_conversation"); ?></label></a>
                    </div>
                </div>

                <div class="row-custom messages-content">
                    <div class="messages-list message-custom-scrollbar">
                        <?php foreach ($messages as $item): ?>
                            <?php $sender = get_user($item->sender_id); ?>
                            <?php $receiver = get_user($item->receiver_id); ?>
                            <div class="message-list-item">
                                <div class="row-custom">
                                    <div class="message-user">
                                        <div class="left">
                                            <img src="<?php echo get_user_avatar($sender); ?>" alt="<?php echo html_escape($sender->username); ?>" class="img-profile">
                                        </div>
                                        <div class="right">
                                            <div class="row-custom">
                                                <span class="username"><?php echo html_escape($sender->username); ?></span>
                                            </div>
                                            <div class="row-custom">
                                                <span class="to"><?php echo trans("to"); ?>&nbsp;<?php echo html_escape($receiver->username); ?></span>
                                            </div>
                                        </div>
                                        <span class="time"><?php echo time_ago($item->created_at); ?></span>
                                    </div>
                                </div>
                                <div class="row-custom">
                                    <div class="message-text">
                                        <?php echo html_escape($item->message); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="message-reply">
                        <!-- form start -->
                        <?php echo form_open('message_controller/send_message', ['class' => 'needs-validation', 'novalidate' => 'novalidate']); ?>
                        <input type="hidden" name="conversation_id" value="<?php echo $conversation->id; ?>">
                        <input type="hidden" name="sender_id" value="<?php echo user()->id; ?>">
                        <?php if (user()->id == $conversation->sender_id): ?>
                            <input type="hidden" name="receiver_id" value="<?php echo $conversation->receiver_id; ?>">
                        <?php else: ?>
                            <input type="hidden" name="receiver_id" value="<?php echo $conversation->sender_id; ?>">
                        <?php endif; ?>
                        <input type="hidden" name="subject" value="<?php echo html_escape($conversation->subject); ?>">
                        <div class="form-group">
                            <textarea class="form-control" name="message" placeholder="<?php echo trans('write_a_message'); ?>" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-custom float-right"><i class="icon-send"></i> <?php echo trans("send"); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                        <!-- form end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->


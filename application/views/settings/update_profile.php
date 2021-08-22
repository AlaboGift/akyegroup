<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div class="container" style="padding-bottom: 50px;">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>

                <h1 class="page-title"><?php echo trans("settings"); ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <!-- load profile nav -->
                    <?php $this->load->view("settings/_setting_tabs"); ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>

                        <?php echo form_open_multipart("profile_controller/update_profile_post", ['id' => 'form_validate']); ?>
                        <div class="form-group">
                            <p>
                                <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo $user->username; ?>" class="form-avatar">
                            </p>
                            <p>
                                <a class='btn btn-md btn-secondary btn-file-upload'>
                                    <?php echo trans('select_image'); ?>
                                    <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info').html($(this).val());">
                                </a>
                                <span class='badge badge-info' id="upload-file-info"></span>
                            </p>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans("email_address"); ?></label>
                            <?php if ($this->general_settings->mail_confirmation_register == 1): ?>
                                <?php if ($user->email_status == 1): ?>
                                    &nbsp;<small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                                <?php else: ?>
                                    &nbsp;<small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                                    <button type="submit" name="submit" value="resend_activation_email" class="btn float-right btn-resend-email"><?php echo trans("resend_activation_email"); ?></button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <input type="email" name="email" class="form-control form-input" value="<?php echo html_escape($user->email); ?>" placeholder="<?php echo trans("email_address"); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="username" class="form-control form-input" value="<?php echo html_escape($user->username); ?>" placeholder="Full Name" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("slug"); ?></label>
                            <input type="text" name="slug" class="form-control form-input" value="<?php echo html_escape($user->slug); ?>" placeholder="<?php echo trans("slug"); ?>" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("about_me"); ?></label>
                            <textarea name="about_me" class="form-control form-textarea" placeholder="<?php echo trans("about_me"); ?>"><?php echo html_escape($user->about_me); ?></textarea>
                        </div>

                        <button type="submit" name="submit" value="update" class="btn btn-md btn-custom"><?php echo trans("save_changes") ?></button>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->


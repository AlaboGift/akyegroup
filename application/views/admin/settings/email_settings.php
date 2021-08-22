<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- form start -->
<?php echo form_open('admin_controller/email_settings_post'); ?>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('email_settings'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php
                $message = $this->session->flashdata('submit');
                if (!empty($message) && $message == "email") {
                    $this->load->view('admin/includes/_messages');
                }
                ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_protocol'); ?></label>

                    <select name="mail_protocol" class="form-control">
                        <option value="smtp" <?php echo ($general_settings->mail_protocol == "smtp") ? "selected" : ""; ?>><?php echo trans('smtp'); ?></option>
                        <option value="mail" <?php echo ($general_settings->mail_protocol == "mail") ? "selected" : ""; ?>><?php echo trans('mail'); ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_title'); ?></label>
                    <input type="text" class="form-control" name="mail_title"
                           placeholder="<?php echo trans('mail_title'); ?>" value="<?php echo html_escape($general_settings->mail_title); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_host'); ?></label>
                    <input type="text" class="form-control" name="mail_host"
                           placeholder="<?php echo trans('mail_host'); ?>" value="<?php echo html_escape($general_settings->mail_host); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_port'); ?></label>
                    <input type="text" class="form-control" name="mail_port"
                           placeholder="<?php echo trans('mail_port'); ?>" value="<?php echo html_escape($general_settings->mail_port); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_username'); ?></label>
                    <input type="text" class="form-control" name="mail_username"
                           placeholder="<?php echo trans('mail_username'); ?>" value="<?php echo html_escape($general_settings->mail_username); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_password'); ?></label>
                    <input type="password" class="form-control" name="mail_password"
                           placeholder="<?php echo trans('mail_password'); ?>" value="<?php echo html_escape($general_settings->mail_password); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>


                <div class="form-group">
                    <label class="control-label">Send confirmation mail</label>
                    <select class="form-control" name="mail_confirm" required> 
                    <option value="<?php echo html_escape($general_settings->mail_confirmation_register); ?>" >
                    <?php if($general_settings->mail_confirmation_register==1):?>
                    Yes</option>
                    <option value="0">No</option><?php else: ?>
                    No</option>
                    <option value="1">Yes</option>
                    <?php endif; ?>
                    </select>
                </div>

                <div class="callout" style="max-width: 500px;margin-top: 30px;">
                    <h4><?php echo trans('gmail_smtp'); ?></h4>

                    <p><strong><?php echo trans('mail_host'); ?>:&nbsp;&nbsp;</strong>smtp.gmail.com</p>
                    <p><strong><?php echo trans('mail_port'); ?>:&nbsp;&nbsp;</strong>587</p>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="email" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->

        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('contact_messages'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php
                if (!empty($message) && $message == "contact") {
                    $this->load->view('admin/includes/_messages');
                } ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('send_contact_to_mail'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="mail_contact_status" value="1" id="mail_contact_status_1" class="square-purple" <?php echo ($general_settings->mail_contact_status == '1') ? 'checked' : ''; ?>>
                            <label for="mail_contact_status_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="mail_contact_status" value="0" id="mail_contact_status_2" class="square-purple" <?php echo ($general_settings->mail_contact_status == '0') ? 'checked' : ''; ?>>
                            <label for="mail_contact_status_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('email_address'); ?> (<?php echo trans("contact_messages_will_send"); ?>)</label>
                    <input type="text" class="form-control" name="mail_contact"
                           placeholder="<?php echo trans('email_address'); ?>" value="<?php echo html_escape($general_settings->mail_contact); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="contact" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?><!-- form end -->

<style>
    h4 {
        color: #0d6aad;
        font-weight: 600;
        margin-bottom: 15px;
        margin-top: 30px;
    }
</style>
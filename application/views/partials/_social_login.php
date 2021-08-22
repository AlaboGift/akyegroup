<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ((!empty($general_settings->facebook_app_id) && !empty($general_settings->facebook_app_secret)) ||
    (!empty($general_settings->google_client_id) && !empty($general_settings->google_client_secret))): ?>
    <p class="p-social-media"><?php echo trans("connect_with_social"); ?></p>
    <div class="row">
        <div class="col-12 text-center">
            <?php if (!empty($general_settings->facebook_app_id) && !empty($general_settings->facebook_app_secret)): ?>
                <a href="javascript:void(0)" class="btn-social-login btn-login-facebook">
                    <i class="icon-facebook"></i>
                </a>
            <?php endif; ?>
            <?php if (!empty($general_settings->google_client_id) && !empty($general_settings->google_client_secret)): ?>
                <a href="javascript:void(0)" id="<?php echo $google_button_id; ?>" class="btn-social-login btn-login-google">
                    <i class="icon-google-plus"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group m-t-10">
        <p class="p-social-media m-0"><?php echo $or_text; ?></p>
    </div>
<?php endif; ?>
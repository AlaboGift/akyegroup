<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <div class="row">
                    <div class="col-12">
                        <h1 class="title"><?php echo trans("register"); ?></h1>
                        <!-- form start -->
                        <?php
                        if ($recaptcha_status) {
                            echo form_open('auth_controller/register_post', ['id' => 'form_validate',
                                'onsubmit' => "if(!$('#checkbox_register').is(':checked')){ $('.checkmark').addClass('is-invalid');}else{ $('.checkmark').removeClass('is-invalid');}          
                            var serializedData = $(this).serializeArray();var recaptcha = ''; $.each(serializedData, function (i, field) { if (field.name == 'g-recaptcha-response') {recaptcha = field.value;}});if (recaptcha.length < 5) { $('.g-recaptcha>div').addClass('is-invalid');return false;} else { $('.g-recaptcha>div').removeClass('is-invalid');}"]);
                        } else {
                            echo form_open('auth_controller/register_post', ['id' => 'form_validate', 'onsubmit' => "if(!$('#checkbox_register').is(':checked')){ $('.checkmark').addClass('is-invalid');}else{ $('.checkmark').removeClass('is-invalid');}"]);
                        }
                        ?>

                        <div class="social-login-cnt">
                            <?php $this->load->view("partials/_social_login", ["google_button_id" => "googleSignUp", "or_text" => trans("register_with_email")]); ?>
                        </div>
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>
                        <div class="form-group">
                            <input type="text" name="username" class="form-control auth-form-input" placeholder="Full Name" value="<?php echo old("username"); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email_address"); ?>" value="<?php echo old("email"); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone_number" class="form-control auth-form-input" placeholder="<?php echo trans("phone_number").' ( +123 XXXXXXXXXX)'; ?>" value="<?php echo old("phone_number"); ?>" required>
                        </div>

                        <div class="form-group">
                            <select class="form-control auth-form-input" name="service_type">
                                <option value="none">-Select Service Type-</option>
                                <option value="member">Swapper</option>
                                <option value="service">Service Provider</option>
                            </select>
                        </div>


                        <input value="<?php echo $modesy_default_location; ?>" name="country_id" type="hidden">
                        
                        <div class="form-group">
                        <select class="form-control auth-form-input" name="state_id"  onchange="get_cities(this.value);" id="states"> 
                        <option  value="none">-Select State-</option>
                        <?php foreach ($states as $item): ?>
                        <option  value="<?php echo $item->id; ?>"><?php echo html_escape($item->name); ?></option>
                        <?php endforeach; ?>
                        </select>
                        </div>
                        <div class="form-group">
                        <select id="cities" name="city_id" class="form-control auth-form-input"> 
                        <option value="none">-Select City/LGA-</option>
                        </select>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("password"); ?>" value="<?php echo old("password"); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="confirm_password" class="form-control auth-form-input" placeholder="<?php echo trans("password_confirm"); ?>" required>
                        </div>
                        <?php ?>
                        <div class="form-group m-t-10 m-b-20">
                            <label class="custom-checkbox checkbox-register">
                                <input type="checkbox" name="terms" id="checkbox_register" required>
                                <span class="checkmark"></span>
                            </label>
                            <label for="checkbox_register" class="checkbox-register-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;<a href="<?php echo base_url(); ?>terms-conditions" class="link"><?php echo trans("terms_conditions"); ?></a></label>
                        </div>
                        <?php if ($recaptcha_status): ?>
                            <div class="recaptcha-cnt">
                                <?php generate_recaptcha(); ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("register"); ?></button>
                        </div>
                        <p class="p-social-media m-0 m-t-15"><?php echo trans("already_have_account"); ?>&nbsp;<a href="javascript:void(0)" class="link" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a></p>

                        <?php echo form_close(); ?>
                        <!-- form end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

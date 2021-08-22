<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('payment_settings'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/payment_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_pay"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('currency'); ?></label>
                    <select name="currency" class="form-control">
                        <option value="USD" <?php echo ($general_settings->currency == "USD" || empty($general_settings->currency)) ? 'selected' : ''; ?>>U.S. Dollar (USD)</option>
                        <option value="AUD" <?php echo ($general_settings->currency == "AUD") ? 'selected' : ''; ?>>Australian Dollar (AUD)</option>
                        <option value="BRL" <?php echo ($general_settings->currency == "BRL") ? 'selected' : ''; ?>>Brazilian Real (BRL)</option>
                        <option value="CAD" <?php echo ($general_settings->currency == "CAD") ? 'selected' : ''; ?>>Canadian Dollar (CAD)</option>
                        <option value="CZK" <?php echo ($general_settings->currency == "CZK") ? 'selected' : ''; ?>>Czech Koruna (CZK)</option>
                        <option value="DKK" <?php echo ($general_settings->currency == "DKK") ? 'selected' : ''; ?>>Danish Krone (DKK)</option>
                        <option value="EUR" <?php echo ($general_settings->currency == "EUR") ? 'selected' : ''; ?>>Euro (EUR)</option>
                        <option value="HKD" <?php echo ($general_settings->currency == "HKD") ? 'selected' : ''; ?>>Hong Kong Dollar (HKD)</option>
                        <option value="HUF" <?php echo ($general_settings->currency == "HUF") ? 'selected' : ''; ?>>Hungarian Forint (HUF)</option>
                        <option value="ILS" <?php echo ($general_settings->currency == "ILS") ? 'selected' : ''; ?>>Israeli New Sheqel (ILS)</option>
                        <option value="JPY" <?php echo ($general_settings->currency == "JPY") ? 'selected' : ''; ?>>Japanese Yen (JPY)</option>
                        <option value="MYR" <?php echo ($general_settings->currency == "MYR") ? 'selected' : ''; ?>>Malaysian Ringgit (MYR)</option>
                        <option value="MXN" <?php echo ($general_settings->currency == "MXN") ? 'selected' : ''; ?>>Mexican Peso (MXN)</option>
                        <option value="NOK" <?php echo ($general_settings->currency == "NOK") ? 'selected' : ''; ?>>Norwegian Krone (NOK)</option>
                        <option value="NZD" <?php echo ($general_settings->currency == "NZD") ? 'selected' : ''; ?>>New Zealand Dollar (NZD)</option>
                        <option value="PHP" <?php echo ($general_settings->currency == "PHP") ? 'selected' : ''; ?>>Philippine Peso (PHP)</option>
                        <option value="PLN" <?php echo ($general_settings->currency == "PLN") ? 'selected' : ''; ?>>Polish Zloty (PLN)</option>
                        <option value="GBP" <?php echo ($general_settings->currency == "GBP") ? 'selected' : ''; ?>>Pound Sterling (GBP)</option>
                        <option value="SGD" <?php echo ($general_settings->currency == "SGD") ? 'selected' : ''; ?>>Singapore Dollar (SGD)</option>
                        <option value="SEK" <?php echo ($general_settings->currency == "SEK") ? 'selected' : ''; ?>>Swedish Krona (SEK)</option>
                        <option value="CHF" <?php echo ($general_settings->currency == "CHF") ? 'selected' : ''; ?>>Swiss Franc (CHF)</option>
                        <option value="TWD" <?php echo ($general_settings->currency == "TWD") ? 'selected' : ''; ?>>Taiwan New Dollar (TWD)</option>
                        <option value="THB" <?php echo ($general_settings->currency == "THB") ? 'selected' : ''; ?>>Thai Baht (THB)</option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label>Paypal</label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="paypal_enabled" value="1" id="paypal_enabled_1"
                                   class="square-purple" <?php echo ($general_settings->paypal_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="paypal_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="paypal_enabled" value="0" id="paypal_enabled_2"
                                   class="square-purple" <?php echo ($general_settings->paypal_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="paypal_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label>Stripe</label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="stripe_enabled" value="1" id="stripe_enabled_1"
                                   class="square-purple" <?php echo ($general_settings->stripe_enabled == 1) ? 'checked' : ''; ?>>
                            <label for="stripe_enabled_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="stripe_enabled" value="0" id="stripe_enabled_2"
                                   class="square-purple" <?php echo ($general_settings->stripe_enabled != 1) ? 'checked' : ''; ?>>
                            <label for="stripe_enabled_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('pricing'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/pricing_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_pricing"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('price_per_day'); ?></label>
                    <input type="number" name="price_per_day" class="form-control form-input price-input" min="0.00" step="0.01" value="<?php echo price_format_input($general_settings->price_per_day); ?>" placeholder="<?php echo trans("price_per_day"); ?>" required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('price_per_month'); ?></label>
                    <input type="number" name="price_per_month" class="form-control form-input price-input" min="0.00" step="0.01" value="<?php echo price_format_input($general_settings->price_per_month); ?>" placeholder="<?php echo trans("price_per_month"); ?>" required>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>


</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('paypal_account'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/paypal_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_paypal"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('store_name'); ?></label>
                    <input type="text" class="form-control" name="paypal_store_name" placeholder="<?php echo trans('store_name'); ?>"
                           value="<?php echo $general_settings->paypal_store_name; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('client_id'); ?></label>
                    <input type="text" class="form-control" name="paypal_client_id" placeholder="<?php echo trans('client_id'); ?>"
                           value="<?php echo $general_settings->paypal_client_id; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('client_secret'); ?></label>
                    <input type="text" class="form-control" name="paypal_client_secret" placeholder="<?php echo trans('secret_key'); ?>"
                           value="<?php echo $general_settings->paypal_client_secret; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('stripe_account'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/stripe_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_stripe"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('store_name'); ?></label>
                    <input type="text" class="form-control" name="stripe_store_name" placeholder="<?php echo trans('store_name'); ?>"
                           value="<?php echo $general_settings->stripe_store_name; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('publishable_key'); ?></label>
                    <input type="text" class="form-control" name="stripe_publishable_key" placeholder="<?php echo trans('publishable_key'); ?>"
                           value="<?php echo $general_settings->stripe_publishable_key; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('secret_key'); ?></label>
                    <input type="text" class="form-control" name="stripe_secret_key" placeholder="<?php echo trans('secret_key'); ?>"
                           value="<?php echo $general_settings->stripe_secret_key; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>



            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>
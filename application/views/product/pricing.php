<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div id="content" class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    </ol>
                </nav>

                <h1 class="page-title page-title-product"><?php echo trans("pricing"); ?></h1>
                <p class="payment-wait"><?php echo trans("please_wait"); ?></p>
                <div class="form-add-product">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg-10">
                            <div class="row">
                                <div class="col-12">
                                    <!-- include message block -->
                                    <?php $this->load->view('product/_messages'); ?>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <?php if ($this->input->get('m_type', true) != "existing"): ?>
                                    <div class="col-12 col-sm-6 col-md-4 m-b-30">
                                        <div id="pricing_card_1" class="card pricing-card selected-card">
                                            <div class="card-header">
                                                <h3 class="title">
                                                    <span class="currency"><?php echo get_currency($general_settings->currency); ?></span><span>0</span>
                                                </h3>
                                            </div>
                                            <div class="card-block">
                                                <h4 class="card-title">
                                                    <?php echo trans("free_plan"); ?>
                                                </h4>
                                                <ul class="list-group">
                                                    <li class="list-group-item"><?php echo trans("regular_listing"); ?></li>
                                                </ul>
                                                <a href="javascript:void(0)" class="btn btn-pricing-button" data-pricing="1"><?php echo trans("choose_plan"); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-12 col-sm-6 col-md-4 m-b-30">
                                    <div id="pricing_card_2" class="card pricing-card <?php echo ($this->input->get('m_type', true) == "existing") ? 'selected-card' : ''; ?>">
                                        <div class="card-header">
                                            <h3 class="title">
                                                <span class="currency"><?php echo get_currency($general_settings->currency); ?></span><span><?php echo price_format($general_settings->price_per_day); ?></span><span class="period">/<?php echo trans("day"); ?></span>
                                            </h3>
                                        </div>
                                        <div class="card-block">
                                            <h4 class="card-title">
                                                <?php echo trans("daily_plan"); ?>
                                            </h4>
                                            <ul class="list-group">
                                                <li class="list-group-item"><?php echo trans("regular_listing"); ?></li>
                                                <li class="list-group-item"><?php echo trans("promoted_badge"); ?></li>
                                                <li class="list-group-item"><?php echo trans("appear_on_homepage"); ?></li>
                                            </ul>
                                            <a href="javascript:void(0)" class="btn btn-pricing-button" data-pricing="2"><?php echo trans("choose_plan"); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 m-b-30">
                                    <div id="pricing_card_3" class="card pricing-card">
                                        <div class="card-header">
                                            <h3 class="title">
                                                <span class="currency"><?php echo get_currency($general_settings->currency); ?></span><span><?php echo price_format($general_settings->price_per_month); ?></span><span class="period">/<?php echo trans("month"); ?></span>
                                            </h3>
                                        </div>
                                        <div class="card-block">
                                            <h4 class="card-title">
                                                <?php echo trans("monthly_plan"); ?>
                                            </h4>
                                            <ul class="list-group">
                                                <li class="list-group-item"><?php echo trans("regular_listing"); ?></li>
                                                <li class="list-group-item"><?php echo trans("promoted_badge"); ?></li>
                                                <li class="list-group-item"><?php echo trans("appear_on_homepage"); ?></li>
                                            </ul>
                                            <a href="javascript:void(0)" class="btn btn-pricing-button" data-pricing="3"><?php echo trans("choose_plan"); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <?php
                                    $price_per_day = price_format($general_settings->price_per_day);
                                    $price_per_month = price_format($general_settings->price_per_month);
                                    ?>
                                    <input type="hidden" id="price_per_day" value="<?php echo $price_per_day; ?>">
                                    <input type="hidden" id="price_per_month" value="<?php echo $price_per_month; ?>">
                                </div>
                            </div>

                            <div class="container-free-plan">
                                <div class="row">
                                    <div class="col-12">
                                        <?php echo form_open('product_controller/pricing_post', ['onkeypress' => "return event.keyCode != 13;"]); ?>
                                        <input type="hidden" name="plan_type" value="free">
                                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                        <button type="submit" class="btn btn-lg btn-custom float-right"><?php echo trans("submit"); ?></button>
                                        <?php echo form_close(); ?><!-- form end -->
                                    </div>
                                </div>
                            </div>

                            <div class="container-daily-plan">
                                <?php echo form_open('product_controller/pricing_post', ['onkeypress' => "return event.keyCode != 13;"]); ?>
                                <div class="row">
                                    <div class="col-12 col-sm-6 m-b-15">
                                        <div class="form-group">
                                            <input type="hidden" name="plan_type" value="daily">
                                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                            <input type="hidden" name="m_type" value="<?php echo $this->input->get('m_type', true); ?>">
                                            <label class="control-label"><?php echo trans('select_payment_option'); ?></label>
                                            <div class="selectdiv" id="select_daily_payment_option">
                                                <select name="payment_option" class="form-control" required>
                                                    <?php if ($general_settings->paypal_enabled == 1 && !empty($general_settings->paypal_client_id) && !empty($general_settings->paypal_client_secret)): ?>
                                                        <option value="paypal"><?php echo trans('paypal'); ?></option>
                                                    <?php endif; ?>
                                                    <?php if ($general_settings->stripe_enabled == 1 && !empty($general_settings->stripe_secret_key) && !empty($general_settings->stripe_publishable_key)): ?>
                                                        <option value="stripe"><?php echo trans('stripe'); ?></option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 m-b-15">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo trans("day_count"); ?></label>
                                            <input type="number" id="pricing_day_count" name="day_count" class="form-control form-input price-input" min="1" value="1" required>
                                        </div>
                                    </div>

                                    <div class="col-12 text-right">
                                        <strong class="price-total"><?php echo trans("total_amount"); ?> <?php echo get_currency($general_settings->currency); ?><span class="span-price-total-daily"><?php echo $price_per_day * 1; ?></span>&nbsp;<?php echo $general_settings->currency; ?></strong>
                                        <input type="hidden" id="price_total_daily" name="total_daily" value="<?php echo $price_per_day * 1; ?>">
                                    </div>
                                    <div class="col-12 m-t-30">
                                        <?php if ($general_settings->stripe_enabled == 1 && !empty($general_settings->stripe_secret_key) && !empty($general_settings->stripe_publishable_key)): ?>
                                            <button type="submit" id="btn_daily_stripe_payment" class="btn btn-lg btn-custom float-right btn-daily-stripe-payment"><?php echo trans("submit"); ?></button>
                                        <?php endif; ?>
                                        <?php if ($general_settings->paypal_enabled == 1 && !empty($general_settings->paypal_client_id) && !empty($general_settings->paypal_client_secret)): ?>
                                            <button type="submit" class="btn btn-lg btn-custom float-right btn-daily-paypal-payment"><?php echo trans("submit"); ?></button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php echo form_close(); ?><!-- form end -->
                            </div>

                            <div class="container-monthly-plan">
                                <?php echo form_open('product_controller/pricing_post', ['onkeypress' => "return event.keyCode != 13;"]); ?>
                                <div class="row">
                                    <div class="col-12 col-sm-6 m-b-15">
                                        <div class="form-group">
                                            <input type="hidden" name="plan_type" value="monthly">
                                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                            <input type="hidden" name="m_type" value="<?php echo $this->input->get('m_type', true); ?>">
                                            <label class="control-label"><?php echo trans('select_payment_option'); ?></label>
                                            <div class="selectdiv" id="select_monthly_payment_option">
                                                <select name="payment_option" class="form-control" required>
                                                    <?php if ($general_settings->paypal_enabled == 1 && !empty($general_settings->paypal_client_id) && !empty($general_settings->paypal_client_secret)): ?>
                                                        <option value="paypal"><?php echo trans('paypal'); ?></option>
                                                    <?php endif; ?>
                                                    <?php if ($general_settings->stripe_enabled == 1 && !empty($general_settings->stripe_secret_key) && !empty($general_settings->stripe_publishable_key)): ?>
                                                        <option value="stripe"><?php echo trans('stripe'); ?></option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 m-b-15">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo trans("month_count"); ?></label>
                                            <input type="number" id="pricing_month_count" name="month_count" class="form-control form-input price-input" min="1" value="1" required>
                                        </div>
                                    </div>
                                    <div class="col-12 text-right">
                                        <strong class="price-total"><?php echo trans("total_amount"); ?> <?php echo get_currency($general_settings->currency); ?><span class="span-price-total-monthly"><?php echo $price_per_month * 1; ?></span>&nbsp;<?php echo $general_settings->currency; ?></strong>
                                        <input type="hidden" id="price_total_monthly" name="total_monthly" value="<?php echo $price_per_month * 1; ?>">
                                    </div>
                                    <div class="col-12 m-t-30">
                                        <?php if ($general_settings->stripe_enabled == 1 && !empty($general_settings->stripe_secret_key) && !empty($general_settings->stripe_publishable_key)): ?>
                                            <button type="submit" id="btn_monthly_stripe_payment" class="btn btn-lg btn-custom float-right btn-monthly-stripe-payment"><?php echo trans("submit"); ?></button>
                                        <?php endif; ?>
                                        <?php if ($general_settings->paypal_enabled == 1 && !empty($general_settings->paypal_client_id) && !empty($general_settings->paypal_client_secret)): ?>
                                            <button type="submit" class="btn btn-lg btn-custom float-right btn-monthly-paypal-payment"><?php echo trans("submit"); ?></button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php echo form_close(); ?><!-- form end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

<input type="hidden" id="product_id" value="<?php echo $product->id; ?>">
<input type="hidden" id="stripe_daily_description" value="<?php echo trans("stripe_payment_for"); ?>&nbsp;<?php echo $price_per_day; ?>&nbsp;<?php echo $general_settings->currency; ?>">
<input type="hidden" id="stripe_daily_amount" value="<?php echo $general_settings->price_per_day; ?>">
<input type="hidden" id="stripe_monthly_description" value="<?php echo trans("stripe_payment_for"); ?>&nbsp;<?php echo $price_per_month; ?>&nbsp;<?php echo $general_settings->currency; ?>">
<input type="hidden" id="stripe_monthly_amount" value="<?php echo $general_settings->price_per_month; ?>">
<input type="hidden" id="stripe_plan_type" value="daily">
<input type="hidden" id="stripe_m_type" value="<?php echo $this->input->get('m_type', true); ?>">


<script src="https://checkout.stripe.com/v2/checkout.js"></script>

<script>
    var handler = StripeCheckout.configure({
        key: '<?php echo html_escape($general_settings->stripe_publishable_key); ?>',
        image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
        locale: 'auto',
        currency: '<?php echo $general_settings->currency; ?>',
        token: function (token) {
            $(".payment-wait").show();
            var data = {
                product_id: $("#product_id").val(),
                token: token.id,
                email: token.email,
                plan_type: $("#stripe_plan_type").val(),
                day_count: $("#pricing_day_count").val(),
                month_count: $("#pricing_month_count").val(),
                m_type: $("#stripe_m_type").val()
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "product_controller/pay_with_stripe",
                data: data,
                success: function (response) {
                    window.location.href = response;
                }
            });
        }
    });
    document.getElementById('btn_daily_stripe_payment').addEventListener('click', function (e) {
        // Open Checkout with further options:
        handler.open({
            name: '<?php echo html_escape($general_settings->stripe_store_name); ?>',
            description: $("#stripe_daily_description").val(),
            amount: $("#stripe_daily_amount").val()
        });
        e.preventDefault();
    });
    document.getElementById('btn_monthly_stripe_payment').addEventListener('click', function (e) {
        // Open Checkout with further options:
        handler.open({
            name: '<?php echo html_escape($general_settings->stripe_store_name); ?>',
            description: $("#stripe_monthly_description").val(),
            amount: $("#stripe_monthly_amount").val()
        });
        e.preventDefault();
    });
    // Close Checkout on page navigation:
    window.addEventListener('popstate', function () {
        handler.close();
    });
</script>


<script>
    $(document).ready(function(){var e='<?php echo trans("stripe_payment_for"); ?>',i="<?php echo $general_settings->currency; ?>";$(document).on("click",".btn-pricing-button",function(){var n=$(this).attr("data-pricing");$(".pricing-card").removeClass("selected-card"),$("#pricing_card_"+n).addClass("selected-card"),$(".container-free-plan").hide(),$(".container-daily-plan").hide(),$(".container-monthly-plan").hide(),1==n&&($(".container-free-plan").show(),$("#stripe_plan_type").val("free")),2==n&&($(".container-daily-plan").show(),$("#stripe_plan_type").val("daily")),3==n&&($(".container-monthly-plan").show(),$("#stripe_plan_type").val("monthly"))}),$("#pricing_day_count").on("input",function(){var n=$("#pricing_day_count").val();$.isNumeric(n)||($("#pricing_day_count").val("1"),n=1),3650<n&&($("#pricing_day_count").val("3650"),n=3650);var t=$("#price_per_day").val(),a=(t*n).toFixed(2);$(".span-price-total-daily").text(a),$("#price_total_daily").val(a),$("#stripe_daily_amount").val(n*t*100),$("#stripe_daily_description").val(e+" "+a+" "+i)}),$("#pricing_month_count").on("input",function(){var n=$("#pricing_month_count").val();$.isNumeric(n)||($("#pricing_month_count").val("1"),n=1),480<n&&($("#pricing_month_count").val("480"),n=480);var t=$("#price_per_month").val(),a=(t*n).toFixed(2);$(".span-price-total-monthly").text(a),$("#price_total_monthly").val(a),$("#stripe_monthly_amount").val(n*t*100),$("#stripe_monthly_description").val(e+" "+a+" "+i)}),$("#select_daily_payment_option").on("change",function(){"stripe"==$("#select_daily_payment_option").find(":selected").val()?($(".btn-daily-stripe-payment").show(),$(".btn-daily-paypal-payment").hide()):($(".btn-daily-paypal-payment").show(),$(".btn-daily-stripe-payment").hide())}),$("#select_monthly_payment_option").on("change",function(){"stripe"==$("#select_monthly_payment_option").find(":selected").val()?($(".btn-monthly-stripe-payment").show(),$(".btn-monthly-paypal-payment").hide()):($(".btn-monthly-paypal-payment").show(),$(".btn-monthly-stripe-payment").hide())})});
</script>
<?php if ($this->input->get('m_type', true) == "existing"): ?>
    <style>
        .container-free-plan {
            display: none;
        }

        .container-daily-plan {
            display: block;
        }
    </style>
<?php endif; ?>
<?php if ($general_settings->paypal_enabled == 1 && !empty($general_settings->paypal_client_id) && !empty($general_settings->paypal_client_secret)): ?>
<?php else: ?>
    <style>
        .btn-monthly-stripe-payment {
            display: block;
        }

        .btn-daily-stripe-payment {
            display: block;
        }
    </style>
<?php endif; ?>

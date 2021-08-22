<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title; ?></h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('id'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->id; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('payment_method'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->payment_method; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('payment_id'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->payment_id; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('user_id'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->user_id; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('product_id'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->product_id; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('currency'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->currency; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('payment_amount'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->payment_amount; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('payer_email'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->payer_email; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('payment_status'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->payment_status; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('purchased_plan'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->purchased_plan; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('date'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $payment->created_at; ?>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="<?php echo $this->agent->referrer(); ?>" class="btn btn-danger pull-right m-r-5"><?php echo trans('back'); ?></a>
            </div>
            <!-- /.box-footer -->

        </div>
        <!-- /.box -->
    </div>
</div>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <center><h1 class="box-title">Service Details</h1></center>
            </div><!-- /.box-header -->

            <!-- form start -->

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                 <div class="col-md-7">
                <div class="row row-product-details">
               
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('status'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($service->provider_id != 0): ?>
                            <label class="label label-success">Assigned</label>
                        <?php else: ?>
                            <label class="label label-danger">No Agent Assigned</label>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('id'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $service->service_id; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Service Type</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $service->service_type; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Service Delivery Date</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?=date('jS F, Y',strtotime($service->service_date));?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Service Initial Request Time</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?=date('h:i a',strtotime($service->service_start_time))?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Service Closing Time</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?=date('h:i a',strtotime($service->service_end_time))?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Requester</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                       <?=$service->request_name;?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Phone Number</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                       <?=$service->request_phone;?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('location'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                       <?=$service->request_address;?>
                    </div>
                </div>


                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Description of Service</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                       <?=$service->service_description;?>
                    </div>
                </div>


                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('reviews'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $this->load->view('admin/includes/_review_stars', ['review' => $service->rating]); ?>
                        <span>(<?php echo $review_count; ?>)</span>
                        <style>
                            .rating {
                                float: left;
                                display: inline-block;
                                margin-right: 10px;
                            }
                        </style>
                    </div>
                </div>
             </div>
             <div class="col-md-5">
            <?php if($service->provider_id != 0): ?>
                <center>
                 <img src="<?php echo get_user_avatar($service); ?>" alt="user" class="user-image" style="height: 100px; border-radius: 50%;margin-top: -10px;">
                 <br>
               <div class="box-body">
                   <h4><?=ucwords($service->username)?></h4><hr>
                   <h3><?=ucwords($service->profession)?></h3>
                   <h3><?=ucwords($service->experience)?> years Experience</h3>
                   <h3><?=ucwords($service->address)?></h3>
                   <h3><?=ucwords($service->phone_number)?></h3>
               </div>

                </center>
            <?php endif; ?>
             </div>
            <!-- /.box-body -->
            <div class="row">
            <div class="box-footer">
                <?php if ($service->provider_id == 0): ?>
                <a class="btn btn-primary pull-right" href="<?php echo admin_url(); ?>assign-agent/<?php echo html_escape($service->service_id); ?>/<?php echo html_escape($service->service_type);?>">Assign Agent</a>
                 <?php endif; ?>
                <a href="<?php echo $this->agent->referrer(); ?>" class="btn btn-danger pull-right m-r-5"><?php echo trans('back'); ?></a>
            </div>
            <!-- /.box-footer -->
        </div>
        </div>
        <!-- /.box -->
    </div>
</div>
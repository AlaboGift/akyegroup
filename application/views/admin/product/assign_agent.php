<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">

            <!-- form start -->

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="row" style="padding-left: 20px;">
                <?php foreach ($service as $item):?>
                <?php if($item->country_id != 0 AND $item->state_id != 0 AND isset($item->address) AND isset($item->profession) AND isset($item->qualification) AND isset($item->experience) AND file_exists($item->guarantor_form) AND file_exists($item->referal_form)): ?>
                <div class="box-body col-md-5" style="border: 1px solid lightgrey;border-right: 4px solid #148770; margin: 20px;">
                    <center><h4><?=ucwords($item->username)?></h4></center><hr>
                    <div class="col-md-4 col-sm-4 col-xs-12" >
                        <img src="<?php echo get_user_avatar($service); ?>" alt="user" class="user-image" style="height: 100px; border-radius: 50%;margin-top: -10px;">
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <p class="box-title"><span class="fa fa-wrench"></span>&nbsp;<label>FIELD(SPECIALTY):</label>&nbsp;<?=ucwords($item->profession)?></p>
                        <p class="box-title"><span class="fa fa-certificate"></span>&nbsp;<label>QUALIFICATION:</label>&nbsp;<?=$item->qualification?></p>
                        <p class="box-title"><span class="fa fa-list"></span>&nbsp;<label>JOBS DELIVERED:</label>&nbsp;22</p>
                    </div>
                    <a href="javascript:void(0)" onclick="assign_agents('<?=$service_id?>','<?=$item->id; ?>');" class="btn btn-sm btn-success btn-site-prev"><span class="fa fa-wrench"></span>&nbsp; Assign Agent</a>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
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
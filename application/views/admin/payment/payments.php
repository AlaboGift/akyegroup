<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo trans('payments'); ?></h3>
    </div><!-- /.box-header -->


    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                           aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('payment_method'); ?></th>
                            <th><?php echo trans('payment_id'); ?></th>
                            <th><?php echo trans('user_id'); ?></th>
                            <th><?php echo trans('product_id'); ?></th>
                            <th><?php echo trans('payment_amount'); ?></th>
                            <th><?php echo trans('payment_status'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($payments as $item): ?>
                            <tr>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td><?php echo html_escape($item->payment_method); ?></td>
                                <td><?php echo html_escape($item->payment_id); ?></td>
                                <td><?php echo html_escape($item->user_id); ?></td>
                                <td><?php echo html_escape($item->product_id); ?></td>
                                <td><?php echo html_escape($item->payment_amount); ?>&nbsp;<?php echo html_escape($item->currency); ?></td>
                                <td><?php echo html_escape($item->payment_status); ?></td>
                                <td><?php echo $item->created_at; ?></td>
                                <td><a href="<?php echo admin_url(); ?>payment-details/<?php echo $item->id; ?>" class="btn btn-info btn-sm"><?php echo trans("details"); ?></a></td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
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
                    <table class="table table-bordered table-striped" role="grid" id="dataTables-example">
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th>Requester</th>
                            <th>Service Type</th>
                            <th>Service Date</th>
                            <th>Initial Delivery Time</th>
                            <th>Closing Delivery Time</th>
                            <th>Address</th>
                            <th>Phone Number</th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($services as $item): ?>
                            <tr>
                                <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->service_id; ?>"></td>
                                <td><?php echo html_escape($item->service_id); ?></td>
                                <td><?=$item->request_name?></td>
                                <td><?=$item->service_type?></td>
                                <td><?=date('jS F, Y',strtotime($item->service_date));?></td>
                                <td><?=date('h:i a',strtotime($item->service_start_time))?></td>
                                <td><?=date('h:i a',strtotime($item->service_end_time))?></td>
                                <td><?=$item->request_address; ?></td>
                                <td><?=$item->request_phone; ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="<?php echo admin_url(); ?>service-details/<?php echo html_escape($item->service_id); ?>"><i class="fa fa-info option-icon"></i><?php echo trans('view_details'); ?></a>
                                            </li>
                                        <?php if($item->provider_id == 0): ?>
                                            <li>
                                                <a href="<?php echo admin_url(); ?>assign-agent/<?php echo html_escape($item->service_id); ?>/<?php echo html_escape($item->service_type);?>"><i class="fa fa-users option-icon"></i>Assign Agent</a>
                                            </li>
                                        <?php endif; ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('product_admin_controller/delete_service','<?php echo $item->service_id; ?>','<?php echo trans("confirm_product"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?> Request</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($services)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">

                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                            <?php if (count($services) > 0): ?>
                                <div class="pull-left">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_products('<?php echo trans("confirm_products"); ?>');"><?php echo trans('delete'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
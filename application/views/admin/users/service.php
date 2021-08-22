<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title">Service Providers</h3>
        </div>
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
                            <th><?php echo trans('image'); ?></th>
                            <th><?php echo trans('username'); ?></th>
                            <th><?php echo trans('email'); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo html_escape($user->id); ?></td>
                                <td>
                                    <img src="<?php echo get_user_avatar($user); ?>" alt="user" class="img-responsive" style="height: 50px;">
                                </td>
                                <td><?php echo html_escape($user->username); ?></td>
                                <td><?php echo html_escape($user->email); ?></td>
                                <td>
                                    <?php if ($user->banned == 0 && $user->verified == 'Yes'){ ?>
                                        <label class="label label-success"><?php echo trans('active'); ?></label>
                                        <label class="label label-success"><?php echo 'Verified'; ?></label>
                                    <?php } else if ($user->banned == 0 && $user->verified == 'No'){ ?>
                                        <label class="label label-success"><?php echo trans('active'); ?></label>
                                        <label class="label label-danger"><?php echo 'Unverified'; ?></label>
                                    <?php } else if ($user->banned == 1 && $user->verified == 'Yes'){ ?>
                                        <label class="label label-danger"><?php echo trans('banned'); ?></label>
                                        <label class="label label-success"><?php echo 'Verified'; ?></label>
                                    <?php }else{ ?>
                                        <label class="label label-danger"><?php echo trans('banned'); ?></label>
                                        <label class="label label-danger"><?php echo 'Unverified'; ?></label>
                                    <?php } ?>
                                </td>
                                <td><?php echo $user->created_at; ?></td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <?php if ($user->banned == 0): ?>
                                                    <a href="javascript:void(0)" onclick="ban_remove_ban_user(<?php echo $user->id; ?>);"><i class="fa fa-stop-circle option-icon"></i><?php echo trans('ban_user'); ?></a>
                                                <?php else: ?>
                                                    <a href="javascript:void(0)" onclick="ban_remove_ban_user(<?php echo $user->id; ?>);"><i class="fa fa-circle option-icon"></i><?php echo trans('remove_user_ban'); ?></a>
                                                <?php endif; ?>
                                            </li>
                                            <li>
                                            <?php if ($user->verified == 'No'): ?>
                                                <a href="javascript:void(0)" onclick="make_verified('<?php echo $user->id;?>');"><i class="fa fa-shield option-icon"></i><?php echo 'Make Verified'; ?></a>
                                            <?php else: ?>
                                                <a href="javascript:void(0)" onclick="make_verified('<?php echo $user->id;?>');"><i class="fa fa-shield option-icon"></i><?php echo 'Make Unverified'; ?></a>
                                            <?php endif; ?>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_user_post','<?php echo $user->id; ?>','<?php echo trans("confirm_user"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
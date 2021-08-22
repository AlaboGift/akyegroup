<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("default_language"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('language_controller/set_language_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('mes_set_language'))):
                    $this->load->view('admin/includes/_messages_form');
                endif; ?>

                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="site_lang" class="form-control">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($selected_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("add_language"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('language_controller/add_language_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (empty($this->session->flashdata('mes_set_language'))):
                    $this->load->view('admin/includes/_messages_form');
                endif; ?>

                <div class="form-group">
                    <label><?php echo trans("language_name"); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?php echo trans("language_name"); ?>"
                           value="<?php echo old('name'); ?>" maxlength="200" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(Ex: English)</small>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("short_form"); ?> </label>
                    <input type="text" class="form-control" name="short_form" placeholder="<?php echo trans("short_form"); ?>"
                           value="<?php echo old('short_form'); ?>" maxlength="200" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(Ex: en)</small>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("language_code"); ?> </label>
                    <input type="text" class="form-control" name="language_code" placeholder="<?php echo trans("language_code"); ?>"
                           value="<?php echo old('language_code'); ?>" maxlength="200" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(Ex: en_us)</small>
                </div>

                <div class="form-group">
                    <label><?php echo trans('order'); ?></label>
                    <input type="number" class="form-control" name="language_order" placeholder="<?php echo trans('order'); ?>" value="1" min="1" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans('status'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="status" value="1" id="status1" class="square-purple" checked>
                            <label for="status1" class="option-label"><?php echo trans('active'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="status" value="0" id="status2" class="square-purple">
                            <label for="status2" class="option-label"><?php echo trans('inactive'); ?></label>
                        </div>
                    </div>
                </div>


            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_language'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?php echo trans('languages'); ?></h3>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="table-responsive">
                        <!-- include message block -->
                        <div class="col-sm-12">
                            <?php $this->load->view('admin/includes/_messages'); ?>
                        </div>
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('language_name'); ?></th>
                                    <th><?php echo trans('folder_name'); ?></th>
                                    <th class="th-options"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($languages as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td><?php echo html_escape($item->name); ?>&nbsp;
                                            <?php if ($item->status == 1): ?>
                                                <label class="label label-success pull-right lbl-lang-status"><?php echo trans('active'); ?></label>
                                            <?php else: ?>
                                                <label class="label label-danger pull-right lbl-lang-status"><?php echo trans('inactive'); ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo html_escape($item->folder_name); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-phrases/<?php echo $item->id; ?>?page=1"><i class="fa fa-exchange option-icon"></i><?php echo trans('edit_translations'); ?></a></li>
                                                    <li>
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-language/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('language_controller/delete_language_post','<?php echo $item->id; ?>','<?php echo trans("confirm_language"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</div>

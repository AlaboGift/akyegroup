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

                <h1 class="page-title page-title-product">Swap Now</h1>

                <div class="form-add-product">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg-10">
                            <div class="row">
                                <div class="col-12">
                                    <!-- include message block -->
                                    <?php $this->load->view('product/_messages'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans("photos"); ?></label>
                                        <div id="product_image_response">
                                            <?php $this->load->view("product/_image_upload_box"); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <!-- form start -->
                                    <?php echo form_open('product_controller/add_product_post', ['id' => 'form_validate', 'onkeypress' => "return event.keyCode != 13;"]); ?>

                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans("title"); ?></label>
                                        <input type="text" name="title" class="form-control form-input" placeholder="<?php echo trans("title"); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('category'); ?></label>
                                        <div class="selectdiv">
                                            <select id="categories" name="category_id" class="form-control selecter" onchange="get_subcategories(this.value);" required>
                                                <option value=""><?php echo trans('select_category'); ?></option>
                                                <?php foreach ($parent_categories as $item): ?>
                                                    <?php if ($item->id == old('category_id')): ?>
                                                        <option value="<?php echo html_escape($item->id); ?>"
                                                                selected><?php echo html_escape($item->name); ?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo html_escape($item->id); ?>"><?php echo html_escape($item->name); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="subcategories_container"></div>
                                    <div id="third_categories_container"></div>

                                    <div class="form-group">
                                     <div class="row">
                                        <div class="col-12 col-sm-6 m-b-sm-15">
                                        <label class="control-label"><?php echo trans('condition'); ?></label>
                                        <div class="selectdiv">
                                            <select name="product_condition" class="form-control" required>
                                                <option value="new"><?php echo trans('new'); ?></option>
                                                <option value="used"><?php echo trans('used'); ?></option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-12 col-sm-6 m-b-sm-15">
                                        <label class="control-label">Quantity</label>
                                        <input type="number" name="quantity" class="form-control form-input" placeholder="Quantity" required>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('price'); ?></label>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <div class="selectdiv">
                                                    <select name="currency" class="form-control" required style="pointer-events: none;background: #EDF0F4;">
                                                        <?php $currencies = get_currencies();
                                                        if (!empty($currencies)):
                                                            foreach ($currencies as $key => $value): ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value["name"] . " (" . $value["hex"] . ")"; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="number" name="price" class="form-control form-input price-input" min="0.00" step="0.01" placeholder="<?php echo trans("price"); ?>" required>
                                                <small class="input-small">(e.g: 45.99)</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="description"></div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('description'); ?></label>
                                        <textarea name="description" rows="4" class="form-control"></textarea>
                                    </div>

                                    <div class="form-group m-t-15">
                                        <button type="submit" class="btn btn-lg btn-custom float-right"><?php echo trans("submit"); ?></button>
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
</div>
<!-- Wrapper End-->
<!-- Ckeditor js -->
<script src="<?php echo base_url(); ?>assets/vendor/ckeditor/ckeditor.js"></script>
<!-- Ckeditor -->
<script>
    var ckEditor = document.getElementById('ckEditor');

    if (ckEditor != undefined && ckEditor != null) {
        CKEDITOR.replace('ckEditor', {
            language: 'en',
            filebrowserBrowseUrl: 'path',
            removeButtons: 'Image,Source,Flash,Table,Smiley,Iframe,SpecialChar,Styles',
        });
    }

    CKEDITOR.on('dialogDefinition', function (ev) {
            var editor = ev.editor;
            var dialogDefinition = ev.data.definition;

            // This function will be called when the user will pick a file in file manager
            var cleanUpFuncRef = CKEDITOR.tools.addFunction(function (a) {
                $('#ck_file_manager').modal('hide');
                CKEDITOR.tools.callFunction(1, a, "");
            });
            var tabCount = dialogDefinition.contents.length;
            for (var i = 0; i < tabCount; i++) {
                var browseButton = dialogDefinition.contents[i].get('browse');
                if (browseButton !== null) {
                    browseButton.onClick = function (dialog, i) {
                        editor._.filebrowserSe = this;
                        var iframe = $('#ck_file_manager').find('iframe').attr({
                            src: editor.config.filebrowserBrowseUrl + '&CKEditor=body&CKEditorFuncNum=' + cleanUpFuncRef + '&langCode=en'
                        });
                        $('#ck_file_manager').appendTo('body').modal('show');
                    }
                }
            }

        }
    );
</script>
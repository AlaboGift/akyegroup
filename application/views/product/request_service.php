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

                <h1 class="page-title page-title-product">Request Service</h1>

                <div class="form-add-product">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg-10">
  

                            <div class="row">
                                <div class="col-12">
                                    <?php $this->load->view('product/_messages'); ?>
                                    <!-- form start -->
                                    <?php echo form_open('product_controller/request_service_post', ['id' => 'form_validate', 'onkeypress' => "return event.keyCode != 13;"]); ?>


                                    <div class="form-group">
                                        <label class="control-label">Service Type</label>
                                        <div class="selectdiv">
                                            <select id="categories" name="service_type" class="form-control" required>
                                                <option value="none">Select Service Type</option>
                                                <?php foreach ($services as $service): ?>
                                                <option value="<?=$service->profession?>"><?=ucwords($service->profession)?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Date of Delivery</label>
                                        <div>
                                            <input  name="service_date" class="form-control" required type="date">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <label class="control-label">Service Start Time</label>
                                                <div>
                                                <input  name="service_start_time" class="form-control" required type="time">
                                                </div>    
                                            </div>
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <label class="control-label">Service Completion Time Approx.</label>
                                                <div>
                                                <input  name="service_end_time" class="form-control" required type="time">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('description'); ?></label>
                                        <textarea name="service_description" id="ckEditor" class="text-editor"></textarea>
                                    </div>
                                   <div>
                                    <h4 class="control-label">Contact Details</h4><hr/>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 m-b-sm-15">
                                                <label class="control-label">Contact Full Name</label>
                                                <div>
                                                <input  name="request_name" class="form-control" required type="text">
                                                </div>    
                                            </div>
                                            <div class="col-12 col-sm-4 m-b-sm-15">
                                                <label class="control-label">Contact Phone Number</label>
                                                <div>
                                                <input  name="request_phone" class="form-control" required type="text">
                                                </div>
                                            </div>
                                             <div class="col-12 col-sm-4 m-b-sm-15">
                                                <label class="control-label">Contact Email</label>
                                                <div>
                                                <input  name="request_email" class="form-control" required type="email">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Contact Address in Gombe</label>
                                        <textarea name="request_address" class="form-control" rows="5"></textarea>
                                    </div>
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
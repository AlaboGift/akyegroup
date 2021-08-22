<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<style type="text/css">
    .forms a{
        margin-right: 20px;
        color: #fff;
    }
     @media screen and (max-width: 800px){
        .forms a{
          width: 145px;
          font-size: 10px;
        }
        .forms{
            padding: 0px;
        }
  } 
</style>
<div id="wrapper">
    <div class="container" style="padding-bottom: 50px;">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>

                <h1 class="page-title"><?php echo trans("settings"); ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <!-- load profile nav -->
                    <?php $this->load->view("settings/_setting_tabs"); ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">

                <div class="row-custom">

                    <div class="profile-tab-content">
                        <?php if($user->referal_form == '' || $user->guarantor_form == ''): ?>
                        <div class="forms" style="margin-bottom: 20px;">
                            <a class="btn btn-primary" href="<?=base_url()?>download-guarantor">Download Guarantors Form&nbsp;<span class="fa fa-download"></span></a>&nbsp;&nbsp;<a class="btn btn-success" href="<?=base_url()?>download-referal">Download Referals Form&nbsp;<span class="fa fa-download"></span></a>
                        </div>
                        <hr>
                        <?php endif; ?>
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>

                        <?php echo form_open_multipart("profile_controller/update_service_profile", ['id' => 'form_validate']); ?>
                    <div class="row">
                    <div class="col-md-4">
                        <center class="form-group">
                            <p>
                                <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo $user->username; ?>" class="form-avatar">
                            </p>
                            <p>
                                <a class='btn btn-md btn-secondary btn-file-upload' style="min-width: 180px; margin-left: 15px;">
                                    <?php echo trans('select_image'); ?>
                                    <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info').html($(this).val());">
                                </a>
                                <span class='badge badge-info' id="upload-file-info"></span>
                            </p>
                        </center>
                     </div>
                    <div class="col-md-8">
                        <h4>Personal Details (Bio)</h4><hr>
                        <div class="form-group">
                            <label><?php echo trans("email_address"); ?></label>
                            <?php if ($this->general_settings->mail_confirmation_register == 1): ?>
                                <?php if ($user->email_status == 1): ?>
                                    &nbsp;<small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                                <?php else: ?>
                                    &nbsp;<small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                                    <button type="submit" name="submit" value="resend_activation_email" class="btn float-right btn-resend-email"><?php echo trans("resend_activation_email"); ?></button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <input type="email" name="email" class="form-control form-input" value="<?php echo html_escape($user->email); ?>" placeholder="<?php echo trans("email_address"); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="username" class="form-control form-input" value="<?php echo html_escape($user->username); ?>" placeholder="Full Name" required>
                        </div>
                     </div>

                     </div>
                     <h4>Work Details (Qualifications)</h4><hr>
                        <div class="form-group">
                            <label>Profession</label>
                             <input type="text" name="profession" class="form-control form-input" required placeholder="Profession" value="<?php echo html_escape($user->profession); ?>">
                         </div>

                          <div class="form-group">
                            <label>Qualification</label>
                             <select name="qualification" class="form-control form-input">
                            <?php  if($user->qualification != ''): ?>
                                <option value="<?php echo html_escape($user->qualification); ?>"><?php echo html_escape($user->qualification); ?></option>
                            <?php else: ?>
                                <option value="none">Select Option</option>
                            <?php endif; ?>
                                <option value="OND">OND</option>
                                <option value="HND">HND</option>
                                <option value="Degree">Degree</option>
                             </select>   
                         </div>

                        <div class="form-group">
                            <label>Years of Experience</label>
                             <select name="experience" class="form-control form-input">
                            <?php  if($user->experience != ''): ?>
                                <option value="<?php echo html_escape($user->experience); ?>"><?php echo html_escape($user->experience); ?> Year(s)</option>
                            <?php else: ?>
                                <option value="none">Select Option</option>
                            <?php endif; ?>
                            <?php for ($i=1; $i < 50 ; $i++): ?>
                                <option value="<?=$i?>"><?=$i?> Year(s)</option>
                            <?php endfor; ?>
                             </select>   
                         </div>


                         <div class="form-group">
                            <label>Upload guarantors form</label>
                             <input type="file" name="guarantor_form" class="form-control" accept=" .pdf, .jpg, .jpeg">
                         </div>
                        <div class="form-group">
                            <label>Upload referals form</label>
                             <input type="file" name="referal_form" class="form-control" accept=".pdf, .jpg, .jpeg">
                         </div>

                         <h4>Bank Details (Payment)</h4><hr>
                        <div class="form-group">
                            <label>Account Name</label>
                             <input type="text" name="acc_name" class="form-control form-input" required placeholder="Account Name" value="<?php echo html_escape($user->acc_name); ?>">
                         </div>
                         <div class="form-group">
                            <label>Bank Name</label>
                             <input type="text" name="bank_name" class="form-control form-input" required placeholder="Bank Name" value="<?php echo html_escape($user->bank_name); ?>">
                         </div>
                        <div class="form-group">
                            <label>Account Type</label>
                             <select name="acc_type" class="form-control form-input">
                            <?php  if($user->acc_type != ''): ?>
                                <option value="<?php echo html_escape($user->acc_type); ?>"><?php echo html_escape($user->acc_type); ?></option>
                            <?php else: ?>
                                <option value="none">Select Option</option>
                            <?php endif; ?>
                                <option value="Current">Current</option>
                                <option value="Savings">Savings</option>
                             </select> 
                         </div>
                        <div class="form-group">
                                    <label class="custom-checkbox checkbox-register">
                                        <input type="checkbox" name="terms" id="checkbox_register" required>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="checkbox_register" class="checkbox-register-label">I hereby agree that, in respect of information coming into my possession during my employment with akyegroup.com.<br>I will not at all time both during and after employment, maintain the strictest with regards to the affairs and business of the company and its customer and that I will not except when authorized to do so by my offer, the Board of Directors of the company or its authorized representative or by a court of Law. I understand dearly that any breach of this undertaking is a misconduct rendering me liable to disciplinary action.</label>
                        </div>

                        <button type="submit" name="submit" value="update" class="btn btn-md btn-custom"><?php echo trans("save_changes") ?></button>
                        <?php echo form_close(); ?>

                    </div>
                    <!--here-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->


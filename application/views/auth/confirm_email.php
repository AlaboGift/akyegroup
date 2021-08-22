<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-confirm">
                    <?php if (!empty($success)): ?>
                        <h1 class="title text-success">
                            <?php echo $success; ?>
                        </h1>
                        <a href="<?php echo base_url(); ?>profile/<?php echo $user->slug; ?>" class="btn btn-md btn-custom"><?php echo trans("view_profile"); ?></a>
                    <?php elseif (!empty($error)): ?>
                        <h1 class="title text-danger">
                            <?php echo $error; ?>
                        </h1>
                        <a href="<?php echo base_url(); ?>profile/<?php echo $user->slug; ?>" class="btn btn-md btn-custom"><?php echo trans("goto_home"); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

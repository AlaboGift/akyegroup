<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
if (isset($_SESSION["modesy_product_images"])) {
    $session_images = $_SESSION["modesy_product_images"];
} ?>

<div class="image-input-boxes">
    <div class="row row-image-inputs">
        <?php for ($i = 1; $i < 6; $i++): ?>
            <div class="col-6 col-sm-4 col-md-3 col-image-input">
                <div class="image-input-box">
                    <?php if ($i == 1): ?>
                        <div class="image-input-main-badge">
                            <label class="badge badge-dark"><?php echo trans("primary"); ?></label>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($session_images) && isset($session_images[$i])): ?>
                        <div class="input-uploaded-image">
                            <img src="<?php echo $img_bg_product_small; ?>" alt="bg" class="img-fluid img-input-bg">
                            <a href="javascript:void(0)" class="btn-img-delete btn-delete-product-img-session" data-image-order="<?php echo $i; ?>"><i class="icon-times"></i></a>
                            <img src="<?php echo base_url() . 'uploads/temp/' . $session_images[$i]["img_small"]; ?>" alt="" class="img-uploaded">
                        </div>
                    <?php else: ?>
                        <div class="top">
                            <?php echo form_open_multipart('file_controller/upload_image_session', ['id' => 'product_image_form_' . $i]); ?>
                            <img src="<?php echo $img_bg_product_small; ?>" alt="bg" class="img-fluid img-input-bg">
                            <input type="hidden" name="image_order" value="<?php echo $i; ?>">
                            <a class='btn-input btn-product-image-upload'>
                                <i class="icon-plus"></i>
                                <input type="file" id="img_file_input_<?php echo $i; ?>" name="file" class="img-file-input-session" data-image-order="<?php echo $i; ?>" accept=".png, .jpg, .jpeg, .gif" required>
                            </a>
                            <?php echo form_close(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="bottom">
                        <div class="product-image-progress">
                            <div id="progress-div-<?php echo $i; ?>" class="progress-div">
                                <div id="progress-bar-<?php echo $i; ?>" class="custom-progress-bar"></div>
                            </div>
                            <div id="targetLayer-<?php echo $i; ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <div class="error-message error-message-img-upload">
        <p>
            <?php echo trans("file_too_large") . " " . formatSizeUnits($this->img_uplaod_max_file_size); ?>
        </p>
    </div>
    <p class="images-exp"><i class="icon-exclamation-circle"></i><?php echo trans("product_image_exp"); ?></p>
</div>
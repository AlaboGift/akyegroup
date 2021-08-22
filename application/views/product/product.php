<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <!-- Wrapper -->
    <div id="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="nav-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo trans("home"); ?></a></li>
                            <?php if (!empty($category)): ?>
                                <li class="breadcrumb-item"><a href="<?php echo generate_category_url($category); ?>"><?php echo html_escape($category->name); ?></a></li>
                            <?php endif; ?>
                            <?php if (!empty($subcategory)): ?>
                                <li class="breadcrumb-item"><a href="<?php echo generate_category_url($subcategory); ?>"><?php echo html_escape($subcategory->name); ?></a></li>
                            <?php endif; ?>
                            <?php if (!empty($third_category)): ?>
                                <li class="breadcrumb-item"><a href="<?php echo generate_category_url($third_category); ?>"><?php echo html_escape($third_category->name); ?></a></li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo html_escape($product->title); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="product-content-top">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-7 col-lg-8">
                                <div class="product-slider-container">
                                    <div class="left">
                                        <div class="dots-container <?php echo (count($product_images) < 2) ? 'hide-dosts-mobile' : ''; ?>">
                                            <?php if (!empty($product_images)):
                                                foreach ($product_images as $image): ?>
                                                    <button class="dot"><img src="<?php echo get_product_image($image->image_small); ?>" alt="dot" style="min-width:100%"></button>
                                                <?php endforeach;
                                            endif; ?>
                                        </div>
                                    </div>
                                    <div class="right">
                                        <div id="product-slider" class="owl-carousel product-slider">
                                            <?php if (!empty($product_images)):
                                                foreach ($product_images as $image): ?>
                                                    <div class="item">
                                                        <a class="image-popup lightbox" href="<?php echo get_product_image($image->image_big); ?>" data-effect="mfp-zoom-out" title="">
                                                            <img src="<?php echo get_product_image($image->image_default); ?>" alt="<?php echo html_escape($product->title); ?>" style="min-width:100%">
                                                        </a>
                                                    </div>
                                                <?php endforeach;
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                                <div class="product-details">
                                    <h1 class="product-title"><?php echo ucwords(html_escape($product->title)); ?></h1>
                                    <?php if ($product->status == 0): ?>
                                        <label class="badge badge-warning"><?php echo trans("pending"); ?></label>
                                    <?php elseif ($product->visibility == 0): ?>
                                        <label class="badge badge-danger"><?php echo trans("hidden"); ?></label>
                                    <?php endif; ?>
                                    <div class="row-custom meta">
                                        <?php echo trans("by"); ?>&nbsp;<a href="<?php echo base_url() . 'profile' . '/' . $product->user_slug; ?>"><?php echo html_escape($product->user_username); ?></a>
                                        <?php if ($general_settings->product_reviews == 1): ?>
                                            <span><i class="icon-comment"></i><?php echo html_escape($comment_count); ?></span>
                                        <?php endif; ?>
                                        <span><i class="icon-heart"></i><?php echo get_product_favorited_count($product->id); ?></span>
                                        <span><i class="icon-eye"></i><?php echo html_escape($product->hit); ?></span>
                                    </div>
                                    <div class="row-custom price">
                                        <strong><?php echo get_currency($product->currency) . price_format($product->price); ?></strong>
                                    </div>

                                    <div class="row-custom details">
                                        <div class="item-details">
                                            <div class="left">
                                                <label><?php echo trans("condition"); ?></label>
                                            </div>
                                            <div class="right">
                                                <span><?php echo trans($product->product_condition); ?></span>
                                            </div>
                                        </div>

                                        <div class="item-details">
                                            <div class="left">
                                                <label><?php echo trans("uploaded"); ?></label>
                                            </div>
                                            <div class="right">
                                                <span><?php echo time_ago($product->created_at); ?></span>
                                            </div>
                                        </div>

                                        <div class="item-details">
                                            <div class="left">
                                                <label><?php echo trans("location"); ?></label>
                                            </div>
                                            <div class="right">
                                                <span><?php echo $user->address; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row-custom">
                                        <?php if (auth_check()): ?>
                                            <!-- form start -->
                                            <?php echo form_open('product_controller/add_remove_favorites', ['class' => 'form-inline']); ?>
                                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                            <?php if (is_product_in_favorites(user()->id, $product->id)): ?>
                                                <button class="btn btn-md btn-custom"><i class="icon-heart"></i><?php echo trans("favorite") ?></button>
                                            <?php else: ?>
                                                <button class="btn btn-md btn-outline"><i class="icon-heart-o"></i><?php echo trans("favorite") ?></button>
                                            <?php endif; ?>
                                            <?php echo form_close(); ?>
                                            <!-- form end -->
                                            <button class="btn btn-md btn-custom btn-contact-seller" data-toggle="modal" data-target="#messageModal"><i class="icon-envelope"></i><?php echo trans("ask_question") ?></button>
                                        <?php else: ?>
                                            <button class="btn btn-md btn-outline" data-toggle="modal" data-target="#loginModal"><i class="icon-heart-o"></i><?php echo trans("favorite") ?></button>
                                            <button class="btn btn-md btn-custom btn-contact-seller" data-toggle="modal" data-target="#loginModal"><i class="icon-envelope"></i><?php echo trans("ask_question") ?></button>
                                        <?php endif; ?>
                                    </div>

                                    <!--Include social share-->
                                    <?php $this->load->view("product/_product_share"); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-content-bottom">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-7 col-lg-8">
                                <div class="product-description">
                                    <h4 class="section-title"><?php echo trans("description"); ?></h4>
                                    <div class="description">
                                        <?php echo $product->description; ?><br><br>
                                        <?php if($product ->subcategory_id == 108): ?>
                                        <table class="table table-responsive table-striped">
                                            <tr><td class="col-sm-6">Brand</td><td class="col-sm-6"><?=$product->brand;?></td></tr>
                                            <tr><td>Model</td><td><?=$product->model;?></td></tr>
                                            <tr><td>RAM</td><td><?=$product->ram;?></td></tr>
                                            <tr><td>Internal Memory</td><td><?=$product->memory;?></td></tr>
                                            <tr><td>Color</td><td><div style="background-color:<?=$product->color;?>; height: 25px; width: 25px; border-radius: 50%;"></div></td></tr>
                                            <tr><td>Resolution</td><td><?=$product->screen_size;?></td></tr>
                                            <tr><td>Camera</td><td><?=$product->camera;?></td></tr>
                                            <tr><td>Battery</td><td><?=$product->battery;?></td></tr>
                                        </table>
                                         <?php endif; ?>
                                         <?php if($product ->subcategory_id == 71 OR $product ->subcategory_id == 72): ?>
                                        <table class="table table-responsive table-striped">
                                            <tr><td class="col-sm-6">Brand</td><td class="col-sm-6"><?=$product->brand;?></td></tr>
                                            <tr><td>Model</td><td><?=$product->model;?></td></tr>
                                            <tr><td>RAM</td><td><?=$product->ram;?></td></tr>
                                            <tr><td>Internal Memory</td><td><?=$product->memory;?></td></tr>
                                            <tr><td>Color</td><td><div style="background-color:<?=$product->color;?>; height: 25px; width: 25px; border-radius: 50%;"></div></td></tr>
                                            <tr><td>Resolution</td><td><?=$product->screen_size;?></td></tr>
                                        </table>
                                         <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row-custom row-bn">
                                    <!--Include banner-->
                                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "product", "class" => "m-b-30"]); ?>
                                </div>

                                <?php if ($general_settings->product_reviews == 1 || $general_settings->product_comments == 1): ?>
                                    <div class="product-reviews">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs">
                                            <?php if ($general_settings->product_reviews == 1): ?>
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#reviews"><?php echo trans("reviews"); ?></a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($general_settings->product_comments == 1): ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?php echo ($general_settings->product_reviews != 1) ? 'active' : ''; ?>" data-toggle="tab" href="#comments">
                                                        <?php echo trans("comments"); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <?php if ($general_settings->product_reviews == 1): ?>
                                                <div class="tab-pane container active" id="reviews">
                                                    <!-- include reviews -->
                                                    <div id="review-result">
                                                        <?php $this->load->view('product/_make_review'); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($general_settings->product_comments == 1): ?>
                                                <div class="tab-pane container <?php echo ($general_settings->product_reviews != 1) ? 'active' : 'fade'; ?>" id="comments">
                                                    <!-- include comments -->
                                                    <?php $this->load->view('product/_make_comment'); ?>
                                                    <div id="comment-result">
                                                        <?php $this->load->view('product/_comments'); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                                <div class="product-sidebar">
                                    <div class="widget-seller">
                                        <h4 class="sidebar-title">Swapper</h4>

                                        <div class="widget-content">
                                            <div class="left">
                                                <div class="user-avatar">
                                                    <a href="<?php echo base_url() . 'profile/' . $product->user_slug; ?>">
                                                        <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo html_escape($user->username); ?>">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <p>
                                                    <a href="<?php echo base_url() . 'profile/' . $product->user_slug; ?>">
                                                        <span class="user"><?php echo ucwords(html_escape($user->username)); ?></span>
                                                    </a>
                                                </p>
                                                <?php if ($user->verified == 'Yes'): ?>
                                                 
                                                        <p>
                                                         <span class="p-last-seen"> <i class="fa fa-shield"></i>&nbsp; <?php echo 'Verified Swapper'; ?></span>
                                                        </p>
                                                   
                                                <?php endif; ?>
                                                <p>
                                                <span class="last-seen">
                                                    <i class="icon-circle"></i> <?php echo trans("last_seen"); ?>&nbsp; <?php echo time_ago($user->last_seen); ?>
                                                </span>
                                                </p>
                                                    <p>
                                                        <a href="tel:<?=$user->phone_number; ?>" ><i class="icon-phone" ></i><?=$user->phone_number; ?></a>
                                                    </p>

                                                    <p>
                                                        <a href="mailto:<?=$user->email; ?>"><i class="icon-envelope"></i><?=$user->email; ?></a>
                                                    </p>
                                                <?php if (auth_check()): ?>
                                                    <?php if (user()->id != $user->id): ?>
                                                        <!--form follow-->
                                                        <?php echo form_open('profile_controller/follow_unfollow_user', ['class' => 'form-inline']); ?>
                                                        <input type="hidden" name="following_id" value="<?php echo $user->id; ?>">
                                                        <input type="hidden" name="follower_id" value="<?php echo user()->id; ?>">
                                                        <?php if (is_user_follows($user->id, user()->id)): ?>
                                                            <p class="m-t-5">
                                                                <button class="btn btn-md btn-custom"><i class="icon-user-plus"></i><?php echo trans("unfollow"); ?></button>
                                                            </p>
                                                        <?php else: ?>
                                                            <p class="m-t-5">
                                                                <button class="btn btn-md btn-outline"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                                                            </p>
                                                        <?php endif; ?>
                                                        <?php echo form_close(); ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <p class="m-t-15">
                                                        <button class="btn btn-md btn-outline" data-toggle="modal" data-target="#loginModal"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($user_products)): ?>
                                            <div class="more-from-seller">
                                                <span class="title"> <?php echo trans("more_products_by"); ?>&nbsp;<?php echo html_escape($user->username); ?></span>
                                                <div class="row">
                                                    <?php foreach ($user_products as $item): ?>
                                                        <div class="col-4 col-user-product">
                                                            <div class="user-product">
                                                                <a href="<?php echo generate_product_url($item); ?>">
                                                                    <img src="<?php echo get_product_small_image($item->id); ?>" alt="<?php echo html_escape($item->title); ?>" class="img-fluid img-product">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="widget-location">
                                        <h4 class="sidebar-title"><?php echo trans("location"); ?></h4>
                                        <div class="sidebar-map">
                                            <!--load map-->
                                            <iframe src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo get_location($product); ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                        </div>
                                    </div>
                                    <div class="row-custom">
                                        <!--Include banner-->
                                        <?php $this->load->view("partials/_ad_spaces_sidebar", ["ad_space" => "product_sidebar", "class" => "m-b-5"]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12" style="margin-bottom:15px;">
                    <div class="related-products">
                        <h4 class="section-title"><?php echo trans("related_products"); ?></h4>
                        <div class="row">
                            <!--print related posts-->
                            <?php foreach ($related_products as $item): ?>
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                    <?php $this->load->view('product/_product_item', ['product' => $item]); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Wrapper End-->

    <!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => $product->title]); ?>
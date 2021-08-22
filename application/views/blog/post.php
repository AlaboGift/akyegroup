<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <div class="blog-content">

                    <nav class="nav-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo trans("home"); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>blog"><?php echo trans("blog"); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>blog/<?php echo html_escape($post->category_slug); ?>"><?php echo html_escape($post->category_name); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo html_escape($post->title); ?></li>
                        </ol>
                    </nav>

                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <div class="post-content">
                                <div class="row-custom">
                                    <h1 class="title"><?php echo html_escape($post->title); ?></h1>
                                </div>
                                <div class="row-custom">
                                    <div class="blog-post-meta">
                                        <a href="<?php echo base_url(); ?>blog/<?php echo $post->category_slug; ?>">
                                            <i class="icon-folder"></i><?php echo html_escape($post->category_name); ?>
                                        </a>
                                        <span><i class="icon-clock"></i><?php echo time_ago($post->created_at); ?></span>
                                    </div>
                                </div>
                                <div class="row-custom">
                                    <div class="post-image">
                                        <img src="<?php echo base_url() . $post->image_default; ?>" alt="<?php echo html_escape($post->title); ?>" class="img-fluid">
                                    </div>
                                </div>
                                <div class="row-custom">
                                    <div class="post-text">
                                        <?php echo $post->content; ?>
                                    </div>
                                </div>

                                <div class="row-custom m-b-20">
                                    <div class="post-tags">
                                        <ul>
                                            <!--print tags-->
                                            <?php foreach ($post_tags as $tag): ?>
                                                <li>
                                                    <a href="<?php echo base_url(); ?>blog/tag/<?php echo html_escape($tag->tag_slug); ?>"><?php echo html_escape($tag->tag); ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row-custom row-bn">
                                    <!--Include banner-->
                                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "blog_post_details", "class" => "m-b-10"]); ?>
                                </div>
                                <div class="row-custom">
                                    <div class="post-share">
                                        <h4 class="title">Share</h4>
                                        <a href="javascript:void(0)"
                                           onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url() . "blog/" . $category->slug; ?>/<?php echo html_escape($post->slug); ?>', 'Share This Post', 'width=640,height=450');return false"
                                           class="btn btn-md btn-share facebook">
                                            <i class="icon-facebook"></i>
                                            <span>Facebook</span>
                                        </a>

                                        <a href="javascript:void(0)"
                                           onclick="window.open('https://twitter.com/share?url=<?php echo base_url() . "blog/" . $category->slug; ?>/<?php echo html_escape($post->slug); ?>&amp;text=<?php echo html_escape($post->title); ?>', 'Share This Post', 'width=640,height=450');return false"
                                           class="btn btn-md btn-share twitter">
                                            <i class="icon-twitter"></i>
                                            <span>Twitter</span>
                                        </a>

                                        <a href="javascript:void(0)"
                                           onclick="window.open('https://plus.google.com/share?url=<?php echo base_url() . "blog/" . $category->slug; ?>/<?php echo html_escape($post->slug); ?>', 'Share This Post', 'width=640,height=450');return false"
                                           class="btn btn-md btn-share gplus">
                                            <i class="icon-google-plus"></i>
                                            <span>Google</span>
                                        </a>

                                        <a href="https://api.whatsapp.com/send?text=<?php echo html_escape($post->title); ?> - <?php echo base_url() . "blog/" . $category->slug; ?>/<?php echo html_escape($post->slug); ?>" target="_blank"
                                           class="btn btn-md btn-share whatsapp">
                                            <i class="icon-whatsapp"></i>
                                            <span>Whatsapp</span>
                                        </a>

                                        <a href="javascript:void(0)"
                                           onclick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo base_url() . "blog/" . $category->slug; ?>/<?php echo html_escape($post->slug); ?>&amp;media=<?php echo base_url() . html_escape($post->image_small); ?>', 'Share This Post', 'width=640,height=450');return false"
                                           class="btn btn-md btn-share pinterest">
                                            <i class="icon-pinterest"></i>
                                            <span>Pinterest</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row-custom">
                                    <div class="related-posts">
                                        <h4 class="blog-section-title"><?php echo trans("related_posts"); ?></h4>
                                        <div class="row">
                                            <!--print related posts-->
                                            <?php foreach ($related_posts as $item): ?>
                                                <div class="col-xs-12 col-sm-6 col-lg-4">
                                                    <?php $this->load->view('blog/_blog_item_small', ['item' => $item]); ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($general_settings->blog_comments == 1): ?>
                                    <div class="row-custom">
                                        <div class="related-posts">
                                            <h4 class="blog-section-title"><?php echo trans("comments"); ?></h4>
                                            <!--include comment box-->
                                            <?php $this->load->view('blog/_comment_box'); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3">
                            <div class="latest-posts">
                                <h4 class="blog-section-title"><?php echo trans("latest_posts"); ?></h4>
                                <div class="row">
                                    <!--print related posts-->
                                    <?php foreach ($latest_posts as $item): ?>
                                        <div class="col-sm-12">
                                            <?php $this->load->view('blog/_blog_item_small', ['item' => $item]); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="blog-tags">
                                <h4 class="blog-section-title"><?php echo trans("tags"); ?></h4>
                                <ul>
                                    <!--print tags-->
                                    <?php foreach ($random_tags as $tag): ?>
                                        <li>
                                            <a href="<?php echo base_url(); ?>blog/tag/<?php echo html_escape($tag->tag_slug); ?>"><?php echo html_escape($tag->tag); ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="row-custom">
                                <!--Include banner-->
                                <?php $this->load->view("partials/_ad_spaces_sidebar", ["ad_space" => "blog_post_details_sidebar", "class" => "m-t-30 text-left"]); ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
<!-- Wrapper End-->

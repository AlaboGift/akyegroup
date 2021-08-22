<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <?php if (!empty($third_category) && !empty($subcategory) && !empty($category)): ?>
                            <li class="breadcrumb-item"><a href="<?php echo generate_category_url($category); ?>"><?php echo html_escape($category->name); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo generate_category_url($subcategory); ?>"><?php echo html_escape($subcategory->name); ?></a></li>
                            <li class=" breadcrumb-item active" aria-current="page"><?php echo html_escape($third_category->name); ?></li>
                        <?php elseif (!empty($category) && !empty($subcategory)): ?>
                            <li class="breadcrumb-item"><a href="<?php echo generate_category_url($category); ?>"><?php echo html_escape($category->name); ?></a></li>
                            <li class=" breadcrumb-item active" aria-current="page"><?php echo html_escape($subcategory->name); ?></li>
                        <?php elseif (!empty($category)): ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo html_escape($category->name); ?></li>
                        <?php else: ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo trans("products"); ?></li>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- form start -->
        <?php echo form_open(base_url() . "filter-products"); ?>
        <?php if (!empty($category)): ?>
            <input type="hidden" name="category_id" value="<?php echo $category->id; ?>">
        <?php endif; ?>
        <?php if (!empty($subcategory)): ?>
            <input type="hidden" name="subcategory_id" value="<?php echo $subcategory->id; ?>">
        <?php endif; ?>
        <?php if (!empty($third_category)): ?>
            <input type="hidden" name="third_category_id" value="<?php echo $third_category->id; ?>">
        <?php endif; ?>
        <?php if (!empty($filter_country)): ?>
            <input type="hidden" name="country" value="<?php echo $filter_country; ?>">
        <?php endif; ?>
        <?php if (!empty($filter_state)): ?>
            <input type="hidden" name="state" value="<?php echo $filter_state; ?>">
        <?php endif; ?>
        <?php if (!empty($filter_condition)): ?>
            <input type="hidden" name="condition" value="<?php echo $filter_condition; ?>">
        <?php endif; ?>
        <?php if (!empty($filter_p_max)): ?>
            <input type="hidden" name="p_max" value="<?php echo $filter_p_max; ?>">
        <?php endif; ?>
        <?php if (!empty($filter_p_min)): ?>
            <input type="hidden" name="p_min" value="<?php echo $filter_p_min; ?>">
        <?php endif; ?>
        <?php if (!empty($filter_search)): ?>
            <input type="hidden" name="search_type" value="product">
            <input type="hidden" name="search" value="<?php echo $filter_search; ?>">
        <?php endif; ?>

        <div class="row">
            <div class="col-12 product-list-header">
                <?php if (!empty($category)): ?>
                    <h1 class="page-title product-list-title"><?php echo html_escape($category->name); ?></h1>
                <?php else: ?>
                    <h1 class="page-title product-list-title"><?php echo trans("products"); ?></h1>
                <?php endif; ?>
                <div class="product-sort-by">
                    <span class="span-sort-by"><?php echo trans("sort_by"); ?></span>
                    <div class="dropdown sort-select">
                        <?php if (!isset($_SESSION["modesy_sort_products"])) {
                            $_SESSION["modesy_sort_products"] = "most_recent";
                        } ?>
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                            <?php echo trans($_SESSION["modesy_sort_products"]); ?>
                        </button>
                        <div class="dropdown-menu">
                            <button type="submit" name="sort" value="most_recent" class="dropdown-item"><?php echo trans("most_recent"); ?></button>
                            <button type="submit" name="sort" value="lowest_price" class="dropdown-item"><?php echo trans("lowest_price"); ?></button>
                            <button type="submit" name="sort" value="highest_price" class="dropdown-item"><?php echo trans("highest_price"); ?></button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-filter-products-mobile" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <?php echo trans("filter_products"); ?>
                </button>
            </div>
        </div>

        <div class="row">
            <?php $this->load->view('product/_product_filters'); ?>

            <div class="col-12 col-md-9">
                <div class="filter-tag-container">
                    <?php if (!empty($filter_search)): ?>
                        <div class="filter-tag">
                            <div class="left"><?php echo $filter_search; ?></div>
                            <div class="right">
                                <button type="submit" class="btn" name="reset_search" value="1"><i class="icon-close"></i></button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!is_null($filter_p_max) && !is_null($filter_p_min)): ?>
                        <div class="filter-tag">
                            <div class="left"><?php echo trans("price") . "&nbsp;(" . $filter_p_min . "-" . $filter_p_max . ")"; ?></div>
                            <div class="right">
                                <button type="submit" class="btn" name="reset_price" value="1"><i class="icon-close"></i></button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="product-list-content">
                    <div class="row">
                        <!--print products-->
                        <?php foreach ($products as $product): ?>
                            <div class="col-6 col-sm-4 col-md-3 col-xs-6">
                                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($products)): ?>
                            <div class="col-12">
                                <p class="no-records-found"><?php echo trans("no_products_found"); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="product-list-pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>

                <div class="col-12">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "products", "class" => "m-t-15"]); ?>
                </div>
            </div>
        </div>

        <?php echo form_close(); ?>
        <!-- form end -->
    </div>
</div>
<!-- Wrapper End-->


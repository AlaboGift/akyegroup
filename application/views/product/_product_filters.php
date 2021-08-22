<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--product filters-->
<div class="col-12 col-md-3 sidebar-products">

    <div id="collapseExample" class="product-filters">
        <?php if (!empty($third_categories)): ?>
            <div class="filter-item">
                <h4 class="title">
                    <a href="<?php echo generate_category_url($category) . "?" . $_SERVER["QUERY_STRING"]; ?>"><i class="icon-angle-left"></i><?php echo trans("categories_all"); ?></a>
                </h4>
                <div class="subcategory-link"><strong><?php echo $subcategory->name; ?></strong>&nbsp;(<?php echo get_products_count_by_subcategory($subcategory->id); ?>)</div>
                <div class="category-list-content custom-scrollbar">
                    <ul class="filter-list">
                        <?php foreach ($third_categories as $item): ?>
                            <li>
                                <div class="left">
                                    <label class="custom-checkbox">
                                        <input type="radio" name="third_category_id" value="<?php echo $item->id; ?>" id="cat_<?php echo $item->id; ?>" onchange="this.form.submit();" <?php echo (!empty($third_category) && $third_category->id == $item->id) ? 'checked' : ''; ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="rigt">
                                    <label for="cat_<?php echo $item->id; ?>" class="checkbox-category-name"><?php echo html_escape($item->name); ?>
                                        <span class="product-count">(<?php echo get_products_count_by_third_category($item->id); ?>)</span>
                                    </label>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php elseif (!empty($subcategories)): ?>
            <div class="filter-item">
                <h4 class="title">
                    <a href="<?php echo base_url() . "products?" . $_SERVER["QUERY_STRING"]; ?>"><i class="icon-angle-left"></i><?php echo trans("categories_all"); ?></a>
                </h4>
                <div class="category-list-content custom-scrollbar">
                    <ul class="filter-list">
                        <?php foreach ($subcategories as $item): ?>
                            <li>
                                <div class="left">
                                    <label class="custom-checkbox">
                                        <input type="radio" name="subcategory_id" value="<?php echo $item->id; ?>" id="cat_<?php echo $item->id; ?>" onchange="this.form.submit();" <?php echo (!empty($subcategory) && $subcategory->id == $item->id) ? 'checked' : ''; ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="rigt">
                                    <label for="cat_<?php echo $item->id; ?>" class="checkbox-category-name"><?php echo html_escape($item->name); ?>
                                        <span class="product-count">(<?php echo get_products_count_by_subcategory($item->id); ?>)</span>
                                    </label>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php elseif (!empty($categories)): ?>
            <div class="filter-item">
                <h4 class="title"><?php echo trans("categories"); ?></h4>
                <div class="category-list-content custom-scrollbar">
                    <ul class="filter-list">
                        <?php foreach ($categories as $item): ?>
                            <li>
                                <div class="left">
                                    <label class="custom-checkbox">
                                        <input type="radio" name="category_id" value="<?php echo $item->id; ?>" id="cat_<?php echo $item->id; ?>" onchange="this.form.submit();" <?php echo (!empty($category) && $category->id == $item->id) ? 'checked' : ''; ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="rigt">
                                    <label for="cat_<?php echo $item->id; ?>" class="checkbox-category-name"><?php echo html_escape($item->name); ?>
                                        <span class="product-count">(<?php echo get_products_count_by_category($item->id); ?>)</span>
                                    </label>
                                </div>

                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <div class="filter-item filter-location">
            <h4 class="title"><?php echo trans("location"); ?></h4>
            <?php if ($general_settings->default_product_location == 0): ?>
                <?php $countries = get_countries(); ?>
                <div class="selectdiv m-b-5">
                    <select name="country" class="form-control" onchange="this.form.submit();">
                    <?php if((isset($default_location)) && ($default_location!=='All')){
                         $default_id = $_SESSION["modesy_default_location"];
                        ?>
                        <option value="<?php echo $default_id; ?>"><?php echo $default_location; ?></option>
                    <?php } else{                              ?>
                        <option value=""><?php echo trans('country'); ?></option>
                        <option value="0"><?php echo trans('all'); ?></option>
                    <?php } ?>    
                        <?php if (!empty($countries)):
                            foreach ($countries as $item): ?>
                                <option value="<?php echo $item->id; ?>" <?php echo (!empty($filter_country) && $item->id == $filter_country) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            <?php else: ?>
                <input type="hidden" name="country" value="<?php echo $general_settings->default_product_location; ?>">
            <?php endif; ?>

            <div class="selectdiv">
                <select id="states" name="state" class="form-control" onchange="this.form.submit();">
                    <option value=""><?php echo trans('state_city'); ?></option>
                    <?php if ($general_settings->default_product_location != 0) {
                        $states = get_states_by_country($general_settings->default_product_location);
                    }
                    if (!empty($filter_country)) {
                        $states = get_states_by_country($filter_country);
                    } ?>
                    <?php if (!empty($states)):
                        foreach ($states as $item): ?>
                            <option value="<?php echo $item->id; ?>" <?php echo (!empty($filter_state) && $item->id == $filter_state) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                        <?php
                        endforeach;
                    endif; ?>
                </select>
            </div>
        </div>

        <div class="filter-item">
            <h4 class="title"><?php echo trans("condition"); ?></h4>
            <div class="condition-list-content">
                <ul class="filter-list">
                    <li>
                        <div class="left">
                            <label class="custom-checkbox">
                                <input type="radio" name="condition" value="all" id="condition_all" onchange="this.form.submit();" <?php echo ($filter_condition == "all" || empty($filter_condition)) ? 'checked' : ''; ?>>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="rigt">
                            <label for="condition_all" class="checkbox-category-name"><?php echo trans("all"); ?></label>
                        </div>
                    </li>
                    <li>
                        <div class="left">
                            <label class="custom-checkbox">
                                <input type="radio" name="condition" value="new" id="condition_new" onchange="this.form.submit();" <?php echo ($filter_condition == "new") ? 'checked' : ''; ?>>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="rigt">
                            <label for="condition_new" class="checkbox-category-name"><?php echo trans("new"); ?></label>
                        </div>
                    </li>
                    <li>
                        <div class="left">
                            <label class="custom-checkbox">
                                <input type="radio" name="condition" value="used" id="condition_used" onchange="this.form.submit();" <?php echo ($filter_condition == "used") ? 'checked' : ''; ?>>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="rigt">
                            <label for="condition_used" class="checkbox-category-name"><?php echo trans("used"); ?></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="filter-item">
            <h4 class="title"><?php echo trans("price"); ?></h4>
            <div class="price-filter-inputs">
                <div class="row align-items-baseline row-price-inputs">
                    <div class="col-4 col-md-4 col-lg-5 col-price-inputs">
                        <span><?php echo trans("min"); ?></span>
                        <input type="input" name="p_min" id="price_min" value="<?php echo $filter_p_min; ?>" class="form-control price-filter-input" placeholder="<?php echo trans("min"); ?>">
                    </div>
                    <div class="col-4 col-md-4 col-lg-5 col-price-inputs">
                        <span><?php echo trans("max"); ?></span>
                        <input type="input" name="p_max" id="price_max" value="<?php echo $filter_p_max; ?>" class="form-control price-filter-input" placeholder="<?php echo trans("max"); ?>">
                    </div>
                    <div class="col-4 col-md-4 col-lg-2 col-price-inputs text-left">
                        <button class="btn btn-sm btn-default btn-filter-price float-left"><i class="icon-arrow-right"></i></button>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="row-custom">
        <!--Include banner-->
        <?php $this->load->view("partials/_ad_spaces_sidebar", ["ad_space" => "products_sidebar", "class" => "m-b-15"]); ?>
    </div>
</div>
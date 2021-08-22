<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
    <div class="navbar navbar-light navbar-expand">
        <ul class="nav navbar-nav mega-menu">
            <?php
            if (!empty($parent_categories)):
                foreach ($parent_categories as $category): 
                    if($category->slug =='direct-sales'): ?>
                    <li class="nav-item">
                        <a href="<?=base_url()?>category/direct-sales" class="nav-link">
                            Direct Sales<sup><span class="badge badge-danger">NEW</span></sup>
                        </a>
                    </li>
                    <?php else: ?>

                    <li class="nav-item dropdown" data-category-id="<?php echo $category->id; ?>">
                        <a href="<?php echo generate_category_url($category); ?>" class="nav-link dropdown-toggle">
                            <?php echo html_escape($category->name); ?>
                        </a>
                        <?php $subcategories = get_subcategories_by_parent_id($category->id);
                        if (!empty($subcategories)):?>
                            <div id="mega_menu_content_<?php echo $category->id; ?>" class="dropdown-menu">
                                <div class="row">
                                    <div class="col-8 menu-subcategories">
                                        <div class="row">
                                            <?php foreach ($subcategories as $subcategory): ?>
                                                <div class="col-4 col-level-two text-truncate">
                                                    <a href="<?php echo generate_category_url($subcategory); ?>" class="text-truncate second-category"><?php echo html_escape($subcategory->name); ?></a>
                                                    <?php
                                                    $third_categories = get_subcategories_by_parent_id($subcategory->id);
                                                    if (!empty($third_categories)): ?>
                                                        <ul>
                                                            <?php foreach ($third_categories as $item): ?>
                                                                <li>
                                                                    <a href="<?php echo generate_category_url($item); ?>"><?php echo html_escape($item->name); ?></a>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>

                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <a href="<?php echo generate_category_url($category); ?>">
                                            <img src="<?php echo base_url() . $category->image_1; ?>" alt="<?php echo html_escape($category->name); ?>" class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php
                    endif;
                endforeach;
            endif;
            ?>
        </ul>
    </div>
</div>
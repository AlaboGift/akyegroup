<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($subcategories)): ?>
    <div class="form-group">
        <div class="selectdiv">
            <select name="subcategory_id" class="form-control selecter" onchange="get_third_categories(this.value);" <?php echo (!empty($subcategories)) ? 'required' : ''; ?>>
                <option value=""><?php echo trans('select_category'); ?></option>
                <?php foreach ($subcategories as $item): ?>
                    <option value="<?php echo html_escape($item->id); ?>"><?php echo html_escape($item->name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
<?php else: ?>
    <input type="hidden" name="subcategory_id" value="0">
    <input type="hidden" name="third_category_id" value="0">
<?php endif; ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Send Message Modal -->
<?php if (auth_check()): ?>
    <div class="modal fade" id="swapModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content" style="padding: 10px;">
                <!-- form start -->
                <?php echo form_open_multipart("product_controller/swapped", ['id' => 'form_validate']); ?>
                <input type="hidden" name="prod_id" id="prod_id">
                <input type="hidden" name="int_swapped" id="int_swapped">
                <input type="hidden" name="init_quant" id="init_quant">
                    <div class="modal-header">
                        <h4 class="title">Product Swapped</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                            <div class="form-group">
                                 <label>Initial Quantity</label>
                                 <input type="number" class="form-control" disabled id="init">
                             </div>
                             <div class="form-group">
                                 <label>Quantity Swapped</label>
                                 <input type="number" name="swapped" class="form-control">
                             </div>
                             <p>* Quantity Swapped can not be greater than initial quantity</p>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" >
                       <button type="submit" class="btn btn-md btn-success" style="color:#fff; font-weight: bolder;">Submit Inventory</button>
                    </div>
                </form>
                <!-- form end -->
            </div>

        </div>
    </div>
<?php endif; ?>
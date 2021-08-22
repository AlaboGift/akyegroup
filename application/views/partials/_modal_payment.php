<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Send Message Modal -->
<?php if (auth_check()): ?>
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <!-- form start -->
                <?php echo form_open_multipart("paystack_controller/paystack_standard", ['id' => 'form_validate']); ?>
                    <input type="hidden" name="agent_id" value="<?php echo $user->id;?>">
                    <input type="hidden" name="service_id" id="service_id">
                    <div class="modal-header">
                        <h4 class="title">Make Payment</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="send-message-result"></div>
                                <div class="form-group">
                                    <label class="control-label">Names</label>
                                    <input type="text" name="email" id="modal_name" class="form-control form-input" required>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-12 col-sm-6 m-b-sm-15">
                                    <label class="control-label"><?php echo trans("email"); ?></label>
                                    <input type="text" name="email" id="modal_email" class="form-control form-input"  required>
                                   </div>
                                   <div class="col-12 col-sm-6 m-b-sm-15">
                                    <label class="control-label">Phone Number</label>
                                    <input type="text" name="phone" id="modal_phone" class="form-control form-input" required>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group">
                                        <label class="control-label">Amount to charge</label>
                                        <div class="row">
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <div class="selectdiv">
                                                    <select name="currency" class="form-control" required style="pointer-events: none;background: #EDF0F4;">
                                                        <?php $currencies = get_currencies();
                                                        if (!empty($currencies)):
                                                            foreach ($currencies as $key => $value): ?>
                                                                <option value="<?php echo $key; ?>"><?php echo $value["name"] . " (" . $value["hex"] . ")"; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 m-b-sm-15">
                                                <input type="number" name="amount" class="form-control form-input price-input" min="0.00" step="0.01" placeholder="<?php echo trans("price"); ?>" required>
                                                <small class="input-small">(e.g: 45.99)</small>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" >
                       <button type="submit" class="btn btn-md btn-success" style="color:#fff; font-weight: bolder;">Pay Now</button>
                    </div>
                        <div align="center">
                            <img src="<?=base_url()?>uploads/logo/paystack-badge-cards-ngn.png" style="height:70px;">
                        </div>
                </form>
                <!-- form end -->
            </div>

        </div>
    </div>
<?php endif; ?>
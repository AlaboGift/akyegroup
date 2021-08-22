<?php if(!defined('BASEPATH') OR auth_check() == FALSE ){redirect(base_url());} ?>
<!-- Wrapper -->
<style type="text/css">
    :root,
:host,
html,
body {
    /* changing and setting default styles */
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-size: 14px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
        Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
    
    --color:#ef5350;
}

.alert {
    background: #eee;
    display: grid;
    border-radius: 5px;
    border-radius: 10px 10px 10px 0px;
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3), 0 15px 12px rgba(0, 0, 0, 0.22);
    &-message {
        border-left: 2px solid #17A2B8;
        padding-left: 1rem;
    }
}
.txt span{
    font-weight: bolder;
    color: #17A2B8;
}

</style>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo trans("profile"); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="profile-page-top">
                    <!-- load profile details -->
                    <?php 
                        $this->load->view("profile/_profile_user_info"); 
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-3">
                <!-- load profile nav -->
                <?php 
                if(!is_service()){
                    $this->load->view("profile/_profile_tabs"); 
                  }else{
                    $this->load->view("profile/_service_tabs");
                  }
                    ?>
            </div>
            <?php   if(!is_service()){ ?> 
            <div class="col-sm-12 col-md-9">
                <?php $this->load->view('partials/_messages'); ?>
                <div class="profile-tab-content">

                    <div class="row row-product-items">
                        <!--print products-->
                        <?php foreach ($products as $product): ?>
                            <?php if (auth_check() && user()->id == $product->user_id): ?>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                    <?php $this->load->view('product/_product_item_profile', ['product' => $product]); ?>
                                </div>
                            <?php else: ?>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                    <?php $this->load->view('product/_product_item', ['product' => $product]); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="product-list-pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <div class="row-custom">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
                </div>
            </div>
        <?php }else{ ?>
            <div class="col-sm-12 col-md-9">
            <?php if(user()->country_id == 0 OR user()->state_id == 0 OR !isset(user()->address) OR !isset(user()->profession) OR !isset(user()->qualification) OR !isset(user()->experience) OR !file_exists(user()->guarantor_form) OR !file_exists(user()->referal_form)): ?>
                    <div class="form-group">
                    <div class="alert alert-danger">
                    <p class="error-message">
                    <center>You Wont be Assigned Any Job due to Incomplete details please go to settings to complete your profile details.</center>
                    </p>
                    </div>
                    </div>

            <?php endif; ?>
                <?php $this->load->view('partials/_messages'); ?>
                <div class="profile-tab-content">
                    <div class="row row-product-items">
                       <?php $x = 1 + $opt; foreach ($jobs as $job): ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="alert">
                                    <h4><span class="badge badge-info" style="border-radius: 50%;"><?=$x++?></span>&nbsp;Job Request</h4>
                                    <p class="txt">
                                    You have a new Job Request for a <span><?=strtoupper($job->service_type);?></span>, at <span><?=strtoupper($job->request_address)?></span>, ordered by <span><?=strtoupper($job->request_name); ?></span> to be started on <span><?=date('jS F, Y',strtotime($job->service_date));?></span> at <span><?=date('h:i a',strtotime($job->service_start_time));?></span> and completed before <span><?=date('h:i a',strtotime($job->service_end_time))?></span>.<br>
                                    Accept the Job if you can handle it or Reject it so it can be given to another agent.
                                    </p>
                                    <div>
                                    <?php if($job->accepted == 0): ?>
                                    <a class="btn btn-info btn-xs" style="color:#fff" href="javascript:void(0)" onclick="accept_job('<?=$job->service_id?>');">Accept&nbsp;&nbsp;<span class="fa fa-check"></span></a>
                                    <?php else: ?>
                                    <button class="btn btn-info btn-xs" style="color:#fff" data-toggle="modal" data-target="#paymentModal" onclick='sendData("<?=$job->request_name?>","<?=$job->request_email?>","<?=$job->request_phone?>","<?=$job->service_id?>")'>Request Payment&nbsp;&nbsp;<span class="fa fa-money"></span></button>

                                    <?php endif; ?>
                                    &nbsp;&nbsp;<a class="btn btn-danger btn-xs" style="color:#fff" href="javascript:void(0)" onclick="reject_job('<?=$job->service_id?>','<?=$job->provider_id?>');">Reject&nbsp;&nbsp;<span class="fa fa-close"></span></a>
                                    </div>
                                    </div>
                                    </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                    <div class="pagination-links pull-right">
                    <?php echo $this->pagination->create_links(); ?>
                    </div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>
<!-- Wrapper End-->

<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?> 
<?php $this->load->view("partials/_modal_payment");?>
<script type="text/javascript">
    function accept_job(service_id){
    var data = {
        'service_id': service_id,
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "profile_controller/accept_job",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

function reject_job(service_id,agent_id){
    var data = {
        'service_id': service_id,
        'agent_id': agent_id,
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "profile_controller/reject_job",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};
function sendData(a,b,c,d){
    $('#modal_name').val(a);
    $('#modal_email').val(b);
    $('#modal_phone').val(c);
    $('#service_id').val(d);
}
</script>

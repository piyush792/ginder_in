<?php

$this->start('inline');?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#UserProfileForm").submit(function () {

            if ($("#firstname").val() == "") {
                $("#error_msg").html('<div class="alert alert-danger">Please Enter Your Name.</div>');
                $("#firstname").focus();
                return false;
            }
            if ($("#state").val() == "" || $("#state").val() == 0) {
                $("#error_msg").html('<div class="alert alert-danger">Please enter state.</div>');
                $("#state").focus();
                return false;
            }
            if ($("#city").val() == "" || $("#city").val() == 0) {
                $("#error_msg").html('<div class="alert alert-danger">Please enter city.</div>');
                $("#city").focus();
                return false;
            }
            if ($("#zipcode").val() == "") {
                $("#error_msg").html('<div class="alert alert-danger">Please enter pincode.</div>');
                $("#zipcode").focus();
                return false;
            }
            if ($("#mobile").val() == "") {
                $("#error_msg").html('<div class="alert alert-danger">Please enter mobile number.</div>');
                $("#mobile").focus();
                return false;
            }
            return true;
        });
    });
</script>
<?php $this->end();?>

<div class="admin-middle-content">
    <div class='admin-side-menu' id="admin-sidemenu-ctrl">
        <span class="glyphicon glyphicon-menu-hamburger"></span> <span class="txt-admin-side-menu">Side Menu</span>
    </div>
    <!-- Left sidebar section start -->
    <div class='admin-navigation-wrapper'>
        <!-- Left inner start -->
        <?php echo $this->element('user_left_inner'); ?>
        <!-- Left inner end -->
    </div>
    <!-- Left sidebar section end -->

    <!-- Right Content start -->
    <div class="admin-adverts-wrapper">

        <div id="error_msg" align="center"><?php echo $this->Session->flash();?></div> 
        <?php echo $this->Form->create('User', array('url'=>'/users/profile/','type'=>'post'));?>
        <div class="item-content admin-personal-details">
            <header class="header-wrapper">
                <h2 class="float-left">Personal Info</h2>
            </header>

            <div class="item-content-wrapper">
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-12 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">Your Name <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                            <?php echo $this->Form->input('firstname', array('id'=>'firstname','class' => "form-control", 'title' => __("Your Name"), 'label' => false));?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">State <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                        <?php 
                        echo $this->Form->input('state', array('id'=>'state','class' => "form-control", 'title' => __("State"), 'options'=>$states, 'label' => false));
                        ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <div id="loader_login" style="display: none;">&nbsp;</div>
                        <label for="selectSubCategory" class="col-form-label">City <span class="required-field">*</span></label>                        
                        <div class="col-sm-10 ctrl-field">
                        <?php 
                        echo $this->Form->input('city', array('id'=>'city','class' => "form-control", 'label' => false, 'options'=>$cities));
                        ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectSubCategory" class="col-form-label">Pincode <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                            <?php echo $this->Form->input('zipcode', array('id'=>'zipcode','class' => "form-control", 'title' => __("ZipCode"), 'label' => false));?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">Email Id <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                            <?php echo $this->Form->input('email', array('id'=>'email','class'=>"form-control", 'title' => __("Email Address"), 'readonly'=>true, 'label'=>false));?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectSubCategory" class="col-form-label">Mobile No. <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                            <?php echo $this->Form->input('mobile', array('id'=>'mobile','class' => "form-control", 'title' => __("Mobile No."), 'label' => false));?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectSubCategory" class="col-form-label">Facebook</label>
                        <div class="col-sm-10 ctrl-field">
                            <?php echo $this->Form->input('fbid', array('id'=>'fbid','class' => "form-control", 'title' => __("Facebook ID."), 'label' => false));?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-buttons-wrapper admin-page-button-wrapper">
        <?php
        echo $this->Form->input("Save",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'btn btn-secondary btn-save', 'style'=>'float: left'));
        //echo $this->Form->input("Cancel",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'btn btn-third btn-save', 'style'=>'float: left'));
        ?>
        <!-- <button class="btn btn-third btn-save">Cancel</button> -->
        </div>
        <?php
        echo $this->Form->end();
        ?>
    </div>
    <!-- Right Content end -->

</div>
<?php //echo $this->element('sql_dump'); ?>

<script>
$('#state').change(function(){
        var stateId = $('#state').val();
        $("#loader_login").show();
        if(stateId!=''){
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'users', 'action' => 'getCity')); ?>',
                type: "post",
                dataType: 'html',
                data: {stateId: stateId},
                success: function(data){
                    $("#loader_login").hide();                    
                    $('#city').html(data);
                    // location.reload();                    
                }
            });
        }

    });
</script>
<?php

$this->start('inline');?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#UserChangePasswordForm").submit(function () {

            if ($("#password").val() == "") {
                $("#error_msg").html('<div class="alert alert-danger">Please Enter Your New Password.</div>');
                $("#firstname").focus();
                return false;
            }
            if ($("#confirm_password").val() == "") {
                $("#error_msg").html('<div class="alert alert-danger">Please Enter Confirm Password.</div>');
                $("#confirm_password").focus();
                return false;
            }
            if ($("#password").val() != $("#confirm_password").val()) {
                $("#error_msg").html('<div class="alert alert-danger">Confirm Password Mismatched.</div>');
                $("#confirm_password").focus();
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
        <?php echo $this->Form->create('User', array('url'=>'/users/change_password/','type'=>'post'));?>
            <div class="item-content admin-personal-details">
                <header class="header-wrapper">
                    <h2 class="float-left">Settings - Password Reset</h2>
                </header>

                <div class="item-content-wrapper">                
                    <div class="form-group row">
                        <div class="frm-mobtab-topbot col-12">
                            <label class="inline-frm-label">Email Id</label>
                            <div class="inline-lbl-ro-value">
                            <?php echo $this->Form->input('email', array('id'=>'email','class' => "form-control", 'title' => __("Email"), 'readonly'=>true, 'label' => false));?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="frm-mobtab-topbot col-12">
                            <label class="inline-frm-label">New Password</label> 
                            <div class="inline-lbl-value">
                                <?php echo $this->Form->input('password', array('id'=>'password','class' => "form-control", 'title' => __("New Password"), 'label' => false));?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="frm-mobtab-topbot col-12">
                            <label class="inline-frm-label">Retype New Password</label> 
                            <div class="inline-lbl-value">
                                <?php echo $this->Form->input('confirm_password', array('id'=>'confirm_password', 'type'=>'password', 'class' => "form-control", 'title' => __("Confirm New Password"), 'label' => false));?>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <div class="frm-mobtab-topbot col-12">
                            <label class="inline-frm-label">Enter the value</label> 
                            <div class="inline-lbl-value"><img src="images/captcha.jpg" class="captcha-img"></div>
                        </div>
                    </div> -->
                </div>
            </div>

            <div class="page-buttons-wrapper admin-page-button-wrapper">
            <?php
            echo $this->Form->input("Save",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'btn btn-secondary btn-save', 'style'=>'float: left'));
            // echo $this->Form->input("Cancel",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'btn btn-third btn-save', 'style'=>'float: left'));
            ?>
            </div>
        <?php
        echo $this->Form->end();
        ?>
    </div>
    <!-- Right Content end -->

</div>
<?php //echo $this->element('sql_dump'); ?>
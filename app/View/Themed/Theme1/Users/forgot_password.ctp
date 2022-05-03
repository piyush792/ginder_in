<?php
$this->start('inline');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#UserForgotPasswordForm").submit(function(){
            if($("#email").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Your Email Id.</span>');
                $("#email").focus();
                return false;
            }
            var regex=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            if(!regex.test($("#email").val()))
            {
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Your Valid Email Id.</span>');
                $("#email").focus();
                return false;
            }
            $("#error_msg").html('');
            return true;
        });     
    });
</script>
<?php
$this->end();
?>
<div class="pagewrap">
    <nav>
        <div id="error_msg" style="margin-top: 10px;" align="center"><?php echo $this->Session->flash();?></div>
        
        <div class="regleft" style="height: 350px;">
            <h4> Home/Forgot Password</h4>
            <div id="create_account">
                <h2>Forgot Password</h2>
                <?php 
                echo $this->Form->create('User', array('id'=>'UserForgotPasswordForm','url' => '/users/forgot_password/','type'=>'post')); 
                ?>
                <?php echo $this->Form->input('email', array('id'=>'email','class'=>"input_field", 'title' => __("Email Address"), 'label' => array('text' => '<em>*</em>' . __('Email Address'))));?>
                <div class="cleaner h10"></div></br>
                <?php
                echo $this->Form->input("Submit",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'submit_btn float_l'));
                echo $this->Form->end();
                ?>
            </div>
        </div>

    </nav>
</div>
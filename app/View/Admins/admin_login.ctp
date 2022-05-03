<script language="JavaScript" type="text/javascript">
    function formValidate()
    {
        if(document.getElementById('username').value == ""){
            document.getElementById('error_msg').innerHTML ='Please Enter User Name.';
            document.getElementById('error_msg').style.display="block";
            $('#username').focus();
            return false;
        }
        if(document.getElementById('password').value == ""){
            document.getElementById('error_msg').innerHTML ='Please Enter Password.';
            document.getElementById('error_msg').style.display="block";
            $('#password').focus();
            return false;
        }
        return true;
    }
</script>

<div class='login_body'>
    <div class="wrap">
        <h2><?=SITE_NAME?> ADMIN</h2>
        <h4>Welcome to the login page</h4>
        <?php
            $msg_login=$this->Session->flash();
            if($msg_login!=""){
                $display = "block";
            }else{
                $display = "none";
            }
        ?>
        <?php echo $this->Form->create('Admin',array('id'=>'admin','action' => 'admin_login')); ?>
        <div id="error_msg" class="alert alert-error" style="margin:0 20px 0 20px;display:<?php echo $display;?>;"><?php echo $msg_login; ?></div>
        <div class="login">
            <div class="email">
                <label for="username">User Name </label><div class="email-input"><div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><?php echo $this->Form->input('username',array('id'=>'username',"label"=>false,"div"=>false));?>
                </div></div>
            </div>
            <div class="pw">
                <label for="password">Password</label><div class="pw-input"><div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span><?php echo $this->Form->input('password',array('id'=>'password',"label"=>false,"type"=>"password","div"=>false));?></div></div>
            </div>
        </div>
        <div class="submit">
            <?php //echo $this->Html->link('Forgot password?','/admin/admins/forgot_password/'); ?>
            <div align="right" style="margin-right:20px;">
                <?php echo $this->Form->end(array('label' => 'Login', 'div' => false,'class' => 'btn btn-red5','onclick'=>'return formValidate();'));?>
            </div>
        </div>
    </div>
</div>
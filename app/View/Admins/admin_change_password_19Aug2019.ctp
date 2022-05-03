<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
?>
<script type="text/javascript">
function formValidate()
{
    if($('#password').val()=="")
    {
        $("#error_msg").html("<div class='alert alert-error'>Please Enter New Password.</div>");
        $("#password").focus();
        return false;
    }
    if($('#confirm_password').val()=="")    
    {
        $("#error_msg").html("<div class='alert alert-error'>Please Re-enter New Password.</div>");
        $('#confirm_password').focus();
        return false;
    }
    if($('#password').val()!=$('#confirm_password').val())
    {
        $("#error_msg").html("<div class='alert alert-error'>Password Doesn't Match.</div>");
        $('#confirm_password').focus();
        return false;
    }
    return true;
}
</script>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Change Password</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?=$this->Session->flash();?></span>
                        <?php echo $this->Form->create('Admin', array('class' => 'form-horizontal validate')); ?>
                        <div class="control-group">
                            <label for="basic" class="control-label">New Password:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('password',array('label'=>false,'id'=>'password',"div"=>false,'size'=>40,"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Re-enter Password:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('confirm_password',array('label'=>false,'type'=>'password','id'=>'confirm_password',"div"=>false,'size'=>40,"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php echo $this->Form->input("Submit",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));
                        ?>
                        </div>
                    <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

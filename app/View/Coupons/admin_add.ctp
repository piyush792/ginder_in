<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
?>
<script type="text/javascript">
    function formValidate()
    {
        if($("#code").val()==""){
            $("#error_msg").html("<div class='alert alert-error'>Please Enter Coupon Code</div>");
            $("#code").focus();
            return false;
        }     
        if($("#coupon_type").val()==""){
            $("#error_msg").html("<div class='alert alert-error'>Please Select Coupon Type</div>");
            $("#coupon_type").focus();
            return false;
        }    
        if($("#coupon_value").val()==""){
            $("#error_msg").html("<div class='alert alert-error'>Please Enter Coupon Value</div>");
            $("#coupon_value").focus();
            return false;
        }    
    }
</script>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Add Coupon</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?=$this->Session->flash();?></span>
                        
                        <?php echo $this->Form->create('Coupon',array('method'=>'post','class'=>'form-horizontal')); ?>
                        <div class="control-group">
                            <label for="basic" class="control-label">*Coupon Code:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('code',array('label'=>false,'id'=>'code','size'=>40,"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">*Coupon Type:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('coupon_type',array('label'=>false,'id'=>'coupon_type','options'=>array('%'=>'%','$'=>'$'),"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">*Coupon Value:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('coupon_value',array('label'=>false,'id'=>'coupon_value',"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">*From Date:</label>
                            <div class="controls">
                               <?php echo $this->Form->input("from_date",array("id"=>"from_date","class"=>"datepick",'data-date-format'=>"yyyy-mm-dd","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?><span class="add-on"><i class="icon-calendar"></i></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">*To Date:</label>
                            <div class="controls">
                               <?php echo $this->Form->input("to_date",array("id"=>"to_date","class"=>"datepick",'data-date-format'=>"yyyy-mm-dd","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?><span class="add-on"><i class="icon-calendar"></i></span>
                            </div>
                        </div>
                         <div class="control-group">
                            <label for="basic" class="control-label">Maximum Uses: <br>( 0 => Unlimited )</label>
                            <div class="controls">
                                <?php echo $this->Form->input('maximum_uses',array('label'=>false,'value'=>0,'id'=>'maximum_uses','size'=>40,"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Description:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('description',array('label'=>false,'type'=>'textarea','id'=>'description','rows'=>5,'cols'=>'80',"class"=>"input-square"));?>
                            </div>
                        </div>                        
                        <div class="control-group">
                            <label for="basic" class="control-label">Status:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array(0=>'Inactive',1=>'Active'),"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php echo $this->Form->input("Add",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));
                            ?>
                        </div>
                        <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
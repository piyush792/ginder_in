<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
?>
<script type="text/javascript">
function formValidate()
{
          if(document.getElementById('handling_fee').value == "")
    {
        document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please Give Handling fee.</h4></div>';
        document.getElementById('handling_fee').focus();
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
                        <h3>Manage UPS</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?=$this->Session->flash();?></span>
                        <?php echo $this->Form->create('Shipping',array('id'=>'Shipping','url' =>'','type'=>'post','class' => 'form-horizontal')); 
                         echo $this->Form->input('id',array('label'=>false,'type'=>'hidden',"div"=>false));
                        ?>
                       
                        <fieldset>
                            <legend>Manage UPS</legend>
                        </fieldset>
                           <div class="control-group">
                            <label for="basic" class="control-label">UPS Pickup Method ::</label>
                            <div class="controls">
                                <?php 
                                 $ups_pickup=array('CC'=> 'Customer Counter' ,'RDP' => 'Daily Pickup','OTP' => 'One Time Pickup','LC' => 'Letter Center','OCA' => 'On Call Air');   
                                
                                echo $this->Form->input('pickup_method',array('label'=>false,'id'=>'pickup_method','options'=>array($ups_pickup),"div"=>false));
                                ?>
                            </div>
                        </div>
                        
                          <div class="control-group">
                            <label for="basic" class="control-label">UPS Packaging ::</label>
                            <div class="controls">
                                <?php 
                                 $pack=array('CP'=> 'Your Packaging' ,'ULE' => 'UPS Letter','UT' => 'UPS Tube','UBE' => 'UPS Express Box');   
                                
                                echo $this->Form->input('package_method',array('label'=>false,'id'=>'package_method','options'=>array($pack),"div"=>false));
                                ?>
                            </div>
                        </div>
                         <div class="control-group">
                            <label for="basic" class="control-label">Delivery Type ::</label>
                            <div class="controls">
                                <?php 
                                 $delv=array('RES'=> 'Residential Delivery' ,'COM' => 'Commercial Delivery');   
                                
                                echo $this->Form->input('delivery_method',array('label'=>false,'id'=>'delivery_method','options'=>array($delv),"div"=>false));
                                ?>
                            </div>
                        </div>
                         <div class="control-group">
                            <label for="basic" class="control-label">* Handling Fee:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('handling_fee', array('id' => 'handling_fee',"div"=>false,'label'=>false)); ?>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <?php echo $this->Form->input("Save",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary', 'onclick' => 'return formValidate();'));?>
                            <?php //echo $this->Form->input("Save",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));?>
                        </div>
                    <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


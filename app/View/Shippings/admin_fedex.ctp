<?php
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
?>
<script type="text/javascript">
function formValidate()
{
    if(document.getElementById('FedExAccountNumber').value == "")
    {
        document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please Give FedEx Account Number.</h4></div>';
        document.getElementById('FedExAccountNumber').focus();
        return false;
    }

    if(document.getElementById('FedExMeterNumber').value == "")
    {
        document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please Give FedEx Meter Number.</h4></div>';
        document.getElementById('FedExMeterNumber').focus();
        return false;
    } 
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
                        <h3>Manage Fedex</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?=$this->Session->flash();?></span>
                        <?php echo $this->Form->create('Shipping',array('id'=>'Shipping','url' =>'','type'=>'post','class' => 'form-horizontal')); 
                         echo $this->Form->input('id',array('label'=>false,'type'=>'hidden',"div"=>false));
                        ?>
                         <div class="control-group">
                            <label for="basic" class="control-label">* FedEx Account Number:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('FedExAccountNumber', array('id' => 'FedExAccountNumber',"div"=>false,'label'=>false)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">* FedEx Meter Number:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('FedExMeterNumber', array('id' => 'FedExMeterNumber',"div"=>false,'label'=>false)); ?>
                            </div>
                        </div>
                           <div class="control-group">
                            <label for="basic" class="control-label">FedEx Pickup Method:</label>
                            <div class="controls">
                                <?php 
                                 $FedEx_pickup=array('FDXE'=> 'Rate Express' ,'FDXG' => 'Rate Ground');   
                                
                                echo $this->Form->input('pickup_method',array('label'=>false,'id'=>'pickup_method','options'=>array($FedEx_pickup),"div"=>false));
                                ?>
                            </div>
                        </div>
                        
                          <div class="control-group">
                            <label for="basic" class="control-label">FedEx Packaging ::</label>
                            <div class="controls">
                                <?php 
                                 $pack=array('YOURPACKAGING'=> 'Your Packaging' ,'FEDEXENVELOPE' => 'FedEx Envelope','FEDEXBOX' => 'FedEx Box','FEDEXTUBE' => 'FedEx Tube','FEDEX10KGBOX' => 'FedEx 10 Kg Box','FEDEX25KGBOX' => 'FedEx 25 Kg Box');   
                                
                                echo $this->Form->input('package_method',array('label'=>false,'id'=>'package_method','options'=>array($pack),"div"=>false));
                                ?>
                            </div>
                        </div>
                         <div class="control-group">
                            <label for="basic" class="control-label">FedEx Dropoff Type ::</label>
                            <div class="controls">
                                <?php 
                                 $delv=array('REGULARPICKUP'=> 'Regular Pickup' ,'REQUESTCOURIER' => 'Request Courier','DROPBOX' => 'Dropbox','BUSINESSSERVICECENTER' => 'Business Service Center','STATION' => 'Station');   
                                
                                echo $this->Form->input('delivery_method',array('label'=>false,'id'=>'delivery_method','options'=>array($delv),"div"=>false));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">FedEx Payor Type ::</label>
                            <div class="controls">
                                <?php 
                                 $payor=array('SENDER'=> 'Sender' ,'RECIPIENT' => 'Recipient','THIRDPARTY' => 'Third Party','COLLECT' => 'Collect');   
                                
                                echo $this->Form->input('FedExPayorType',array('label'=>false,'id'=>'FedExPayorType','options'=>array($payor),"div"=>false));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">FedEx Server ::</label>
                            <div class="controls">
                                <?php 
                                 $server=array('https://gatewaybeta.fedex.com:443/GatewayDC'=> 'Test Server');   
                                
                                echo $this->Form->input('FedExServer',array('label'=>false,'id'=>'FedExServer','options'=>array($server),"div"=>false));
                                ?>
                            </div>
                        </div>
                         <div class="control-group">
                            <label for="basic" class="control-label">* FedEx Handling Fee::</label>
                            <div class="controls">
                                <?php echo $this->Form->input('handling_fee', array('id' => 'handling_fee',"div"=>false,'label'=>false)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">FedEx Weight Units ::</label>
                            <div class="controls">
                                <?php 
                                 $weight=array('LBS'=> 'LBS');   
                                
                                echo $this->Form->input('FedExWeightUnits',array('label'=>false,'id'=>'FedExWeightUnits','options'=>array($weight),"div"=>false));
                                ?>
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




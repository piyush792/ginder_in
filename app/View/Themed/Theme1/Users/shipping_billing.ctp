<?php $this->start('inline');?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#UserShippingBillingForm").submit(function(){
            
            if($("#ship_firstname").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Your First Name.</span>');
                $("#ship_firstname").focus();
                return false;
            }
            if($("#ship_lastname").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Your Last Name.</span>');
                $("#ship_lastname").focus();
                return false;
            }
            
            if($("#ship_address").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter your address.</span>');
                $("#ship_address").focus();
                return false;
            }
            if($("#ship_country").val()==0){
                $("#error_msg").html('<span style="color: #FF0000;">Please select country.</span>');
                $("#ship_country").focus();
                return false;
            }
            if($("#ship_city").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter city.</span>');
                $("#ship_city").focus();
                return false;
            }
            if($("#ship_state").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter state.</span>');
                $("#ship_state").focus();
                return false;
            }
            if($("#ship_zipcode").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter zipcode.</span>');
                $("#ship_zipcode").focus();
                return false;
            } 
            
            return true;
        });
    });
    
    function chk_shipping(){    
        if($("#check_shipping:checked").length > 0){
            fillbilling();
        }else{
            unfillbilling();
        }
    }     
    
    function fillbilling(){
        $("#bill_firstname").val($("#ship_firstname").val());
        $("#bill_lastname").val($("#ship_lastname").val());
        $("#bill_address").val($("#ship_address").val());
        $("#bill_phone").val($("#ship_phone").val());
        $("#bill_mobile").val($("#ship_mobile").val());
        $("#bill_city").val($("#ship_city").val());
        $("#bill_state").val($("#ship_state").val());
        $("#bill_zipcode").val($("#ship_zipcode").val());
        $("#bill_country").val($("#ship_country").val());
     }
     function unfillbilling(){
        $("#bill_firstname").val('');
        $("#bill_lastname").val('');
        $("#bill_address").val('');
        $("#bill_phone").val('');
        $("#bill_mobile").val('');
        $("#bill_city").val('');
        $("#bill_state").val('');
        $("#bill_zipcode").val('');
        $("#bill_country").val('');
     }
</script>
<?php $this->end();?>

<div class="pagewrap">
    <nav>
        <?php echo $this->element('user_links');?>
        
        <!--BILLING ADDRESS-->
        <div class="information" id="contact_form">
           <div id="error_msg" align="center"><?php echo $this->Session->flash();?></div> 
            <?php echo $this->Form->create('User', array('url'=>'/users/shipping_billing/','type'=>'post'));?>
            <div class="informationright">
                    <h3>billing details</h3>
                    <?php echo $this->Form->input('bill_firstname', array('id'=>'bill_firstname','class' => "input_field", 'title' => __("First Name"), 'label' => array('text' => '<em>*</em>'. __('First Name'))));?>
                    <div class="cleaner h10"></div></br>
                    <?php echo $this->Form->input('bill_lastname', array('id'=>'bill_lastname','class' => "input_field", 'title' => __("Last Name"), 'label' => array('text' => '<em>*</em>'.__('Last Name'))));?>
                    <div class="cleaner h10"></div></br>
                    <?php echo $this->Form->input('bill_address', array('id'=>'bill_address','class' => "input_field", 'title' => __("Address"), 'label' => array('text' =>'<em>*</em>'.__('Address'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('bill_phone', array('id'=>'bill_phone','class' => "input_field", 'title' => __("Phono No."), 'label' => array('text' =>__('Phono No.'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('bill_mobile', array('id'=>'bill_mobile','class' => "input_field", 'title' => __("Mobile No."), 'label' => array('text' =>__('Mobile No.'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('bill_country', array('id'=>'bill_country','class' => "input_field", 'title' => __("Country"),'options'=>$countries,'label' => array('text' =>'<em>*</em>'.__('Country'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('bill_city', array('id'=>'bill_city','class' => "input_field", 'title' => __("City"), 'label' => array('text' =>'<em>*</em>'.__('City'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('bill_state', array('id'=>'bill_state','class' => "input_field", 'title' => __("State"), 'label' => array('text' =>'<em>*</em>'.__('State'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('bill_zipcode', array('id'=>'bill_zipcode','class' => "input_field", 'title' => __("ZipCode"), 'label' => array('text' =>'<em>*</em>'.__('ZipCode'))));?>
                    <div class="cleaner h10"></div></br> 
            </div>   
            <!--SHIPPING DETAILS-->
            <div class="informationleft" id="contact_form2">
                    <h3>Shipping details</h3>
                    <?php echo $this->Form->input('ship_firstname', array('id'=>'ship_firstname','class' => "input_field", 'title' => __("First Name"), 'label' => array('text' => '<em>*</em>'. __('First Name'))));?>
                    <div class="cleaner h10"></div></br>
                    <?php echo $this->Form->input('ship_lastname', array('id'=>'ship_lastname','class' => "input_field", 'title' => __("Last Name"), 'label' => array('text' => '<em>*</em>'.__('Last Name'))));?>
                    <div class="cleaner h10"></div></br>
                    <?php echo $this->Form->input('ship_address', array('id'=>'ship_address','class' => "input_field", 'title' => __("Address"), 'label' => array('text' =>'<em>*</em>'.__('Address'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('ship_phone', array('id'=>'ship_phone','class' => "input_field", 'title' => __("Phono No."), 'label' => array('text' =>__('Phono No.'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('ship_mobile', array('id'=>'ship_mobile','class' => "input_field", 'title' => __("Mobile No."), 'label' => array('text' =>__('Mobile No.'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('ship_country', array('id'=>'ship_country','class' => "input_field", 'title' => __("Country"),'options'=>$countries,'label' => array('text' =>'<em>*</em>'.__('Country'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('ship_city', array('id'=>'ship_city','class' => "input_field", 'title' => __("City"), 'label' => array('text' =>'<em>*</em>'.__('City'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('ship_state', array('id'=>'ship_state','class' => "input_field", 'title' => __("State"), 'label' => array('text' =>'<em>*</em>'.__('State'))));?>
                    <div class="cleaner h10"></div></br> 
                    <?php echo $this->Form->input('ship_zipcode', array('id'=>'ship_zipcode','class' => "input_field", 'title' => __("ZipCode"), 'label' => array('text' =>'<em>*</em>'.__('ZipCode'))));?>
                    <div class="cleaner h10"></div></br>
                    <?php echo $this->Form->input('check_shipping',array('id'=>'check_shipping','type'=>'checkbox',"label"=>false,"div"=>false,'checked'=>false,'onclick'=>'chk_shipping();'));?><span>Use this address for my Billing Information</span>
                    <div class="cleaner h10"></div></br> 
            </div>
            <?php
            echo $this->Form->input("Save Changes",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'contactSubmit float_l'));
            echo $this->Form->end();
            ?>
        </div> 
        
    </nav>
</div>
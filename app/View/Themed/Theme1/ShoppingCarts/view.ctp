<?php
$this->start('inline');
if($popupflag==1){
?>
<script>parent.location='<?php echo SITE_URL;?>shopping_carts/view/';</script>
<?php
exit;
}
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#UserLoginForm").submit(function(){
            if($("#login_email").val()==""){
                $("#login_msg").html('<span style="color: #FF0000;">Please Enter Your Email Id.</span>');
                $("#login_email").focus();
                return false;
            }
            var regex=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            if(!regex.test($("#login_email").val()))
            {
                $("#login_msg").html('<span style="color: #FF0000;">Please Enter Your Valid Email Id.</span>');
                $("#login_email").focus();
                return false;
            }
            if($("#login_password").val()==""){
                $("#login_msg").html('<span style="color: #FF0000;">Please Enter Your Password.</span>');
                $("#login_password").focus();
                return false;
            }
            return true;
        });
    });     
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#UserBillingForm").submit(function(){
            
            if($("#bill_firstname").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Your First Name.</span>');
                $("#bill_firstname").focus();
                return false;
            }
            if($("#bill_lastname").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Your Last Name.</span>');
                $("#bill_lastname").focus();
                return false;
            }
            
            if($("#bill_address").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter your address.</span>');
                $("#bill_address").focus();
                return false;
            }
            if($("#bill_country").val()==0){
                $("#error_msg").html('<span style="color: #FF0000;">Please select country.</span>');
                $("#bill_country").focus();
                return false;
            }
            if($("#bill_city").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter city.</span>');
                $("#bill_city").focus();
                return false;
            }
            if($("#bill_state").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter state.</span>');
                $("#bill_state").focus();
                return false;
            }
            if($("#bill_zipcode").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter zipcode.</span>');
                $("#bill_zipcode").focus();
                return false;
            }
            return true;
        });
    });
</script> 
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#UserShippingForm").submit(function(){
            
            if($("#ship_firstname").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter your shipping first name.</span>');
                $("#ship_firstname").focus();
                return false;
            }
            if($("#ship_lastname").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter your shipping last name.</span>');
                $("#ship_lastname").focus();
                return false;
            }
            if($("#ship_address").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter your shipping address.</span>');
                $("#ship_address").focus();
                return false;
            }
            if($("#ship_country").val()==0){
                $("#error_msg").html('<span style="color: #FF0000;">Please select shipping country.</span>');
                $("#ship_country").focus();
                return false;
            }
            if($("#ship_city").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter shipping city.</span>');
                $("#ship_city").focus();
                return false;
            }
            if($("#ship_state").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter shipping state.</span>');
                $("#ship_state").focus();
                return false;
            }
            if($("#ship_zipcode").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter shipping zipcode.</span>');
                $("#ship_zipcode").focus();
                return false;
            }
            if($("input[name=shipping_price]:checked").length<1){
                $("#error_msg").html('<span style="color: #FF0000;">Please select a shipping method.</span>');
                $("#error_msg").focus();
                return false;
            }  
            return true;
        });
    });
</script>       
<?php
$this->end();
if($this->Session->read('cartstep')==1){
  ?>
  <script>
      jQuery(document).ready(function(){
          $("#cartstep1").show();
          $("#cartstep2").hide();
          $("#cartstep3").hide();
      });  
  </script>
  <?php  
}elseif($this->Session->read('cartstep')==2)
{
  ?>
  <script>
      jQuery(document).ready(function(){
          $("#cartstep1").hide();
          $("#cartstep2").show();
          $("#cartstep3").hide();
      });  
  </script>
  <?php    
}elseif($this->Session->read('cartstep')==3)
{
  ?>
  <script>
      jQuery(document).ready(function(){
          $("#cartstep1").hide();
          $("#cartstep2").hide();
          $("#cartstep3").show();
      });  
  </script>
  <?php    
}
    
?> 
<div class="pagewrap">
<nav>
  <div class="shoppingbag">
      <h2>your shopping bag</h2>
      <?php
        $total = 0;
        $cartnum = count($cartlist);
        if($cartnum>0){
            $ctr = 1;
            for ($i=0;$i<$cartnum;$i++){
             ?> 
                <div class="bag">
                   <?php
                   $product_amount=($cartlist[$i]['ShoppingCart']['quantity'] * $cartlist[$i]['ShoppingCart']['price']);
                   $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$cartlist[$i]['Product']['image'];
                   ?>
                   <a href="<?php echo SITE_URL."products/detail/".$cartlist[$i]['ShoppingCart']['product_id'];?>">
                   <?php
                   echo $this->Html->image($product_image,array('width' =>'127','height'=>'125','align'=>'left'));
                   ?>
                   </a>
                   <div class="del"><a href="<?php echo SITE_URL;?>shopping_carts/delete/<?php echo $cartlist[$i]['ShoppingCart']['id'];?>"></a></div>
                   <p>
                    <?php echo $cartlist[$i]['Product']['name'];?> <br>#<?php echo $cartlist[$i]['Product']['article_no'];?><br />
                    <?php echo $cartlist[$i]['ShoppingCart']['attribute_name'];?><br />
                    Qty: <?php echo $cartlist[$i]['ShoppingCart']['quantity'];?><br />
                    Item Price: <span><?php echo CURRENCY_SYMBOL.number_format($cartlist[$i]['ShoppingCart']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></span><br />
                    Total Price: <span><?php echo CURRENCY_SYMBOL.number_format($product_amount,2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></span>
                   </p>
                </div>
            <?php
                $total+=($cartlist[$i]['ShoppingCart']['quantity'] * $cartlist[$i]['ShoppingCart']['price']);
            }
        }else{
        ?>
          <div class="bag"><span>There is 0 item in your bag</span></div>
        <?php
        } 
        $shipping_price='';
        if($total_cart_item>0){
        ?>  
         <div class="bagsummery"><h2>Summary of charges</h2></div>
         <div class="total"> 
           <p>Sub Total :</p>
           <span><?php echo CURRENCY_SYMBOL.number_format($total,2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></span>
           
           <?php
            $shipping_price=$this->Session->read("shipping_price");
            //$shipping_price=0.00;
            
            //$total-=$total_discount;
           ?>
           <p>Shipping Price (+):</p>
           <span><?php echo CURRENCY_SYMBOL.number_format($shipping_price,2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></span>
           <?php
           /* CODE FOR COUPON DISCOUNT START*/
            $discount_amount=0;
            $couponnum = count($couponlist);
            if($couponnum>0){
                if($couponlist['Coupon']['code']!=''){
                    $coupon_value = $couponlist['Coupon']['coupon_value'];
                    if($couponlist['Coupon']['coupon_type']=='%'){
                        $discount_amount = ($total*$coupon_value)/100;
                    }elseif($couponlist['Coupon']['coupon_type']=='$'){
                        $discount_amount = $coupon_value;
                    }
                ?>
                <p>Discount (-):</p>
                <span><?php echo CURRENCY_SYMBOL.number_format($discount_amount,2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></span>
                <?php
                }
            }
            /* CODE FOR COUPON DISCOUNT END*/
            $total-=$discount_amount;
            $total+=$shipping_price;
           ?>
           <h3>Grand Total :</h3>
           <span style="margin-top: -35px;"><?php echo CURRENCY_SYMBOL.number_format($total,2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></span>
         </div>
       <?php
       }
       ?>
    </div>
  
   <div class="chackout">
   <h1>checkout</h1>
   <div id="error_msg" align="left"><?php echo $this->Session->flash();?></div><br /> 
   
   <h2>customer <?php if(AuthComponent::user('id')){?> <span><?php echo AuthComponent::user('email');?></span><?php }?></h2>
   <div id='cartstep1' style="display: block;">
        <div id="contact_form">
            <div id="login_msg" align="left"></div>
            <h3>Login In Here</h3>
            <?php echo $this->Form->create('User',array('id'=>'UserLoginForm','url'=>'/shopping_carts/login/','type'=>'post'));?>
            <div class="cleaner h10"></div></br> 
            <?php echo $this->Form->input('login_email',array('id'=>'login_email','class'=>"validate-email required input_field", 'title'=>__("Email Address"),'label'=>array('text'=>'<em>*</em>'.__('Email Address')), 'div'=>false));?>
            <div class="cleaner h10"></div></br>
            <?php echo $this->Form->input('login_password',array('id'=>'login_password','type'=>'password','class'=>"input_field", 'title'=>__("Password"),'label'=>array('text'=>'<em>*</em>'.__('Password')), 'div'=>false));?>
            <div class="cleaner h10"></div></br>
            <a href="<?php echo SITE_URL;?>users/registration/">Sign Up</a><br /><br />
            <?php 
            echo $this->Form->input("Login",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'submit_btn float_l'));
            echo $this->Form->end();
            ?>
        </div>
    </div>
   <h2>
    <?php 
    if($this->Session->read('cartstep')==3){?>
     <a href="<?php echo SITE_URL;?>shopping_carts/shipping_detail_edit/">Shipping</a>   
    <?php }else{
     echo 'Shipping';   
    }
    ?>
   </h2>
   <div id='cartstep2' style="display: block;">
       <div id="contact_form">
            <h3>Shipping address</h3>
                <?php echo $this->Form->create('User', array('id'=>'UserShippingForm','url'=>'/shopping_carts/shipping_detail/','type'=>'post')); ?>
                <div>
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
                    <?php echo $this->Form->input('ship_check',array('id'=>'ship_check','type'=>'checkbox',"label"=>false,"div"=>false,'checked'=>false));?><span>Use this address for my Billing Information</span>
                    <div class="cleaner h10"></div></br>
                </div>
            
        
            <h3>Shipping method:</h3>
            <?php $shipping_price=$this->Session->read("shipping_price");?>
            <input type="radio" name="shipping_price" value="0.00" <?php if($shipping_price=='0.00') echo 'checked';?>><span>7-9 business days - $0.00</span><br/>
            <input type="radio" name="shipping_price" value="7.00" <?php if($shipping_price=='7.00') echo 'checked';?>><span>3-5 business days - $7.00</span><br/>
            <!--<input type="radio" name="shipping_price" value="Bike"><span>2 business days - $17.00</span><br/>
            <input type="radio" name="shipping_price" value="Bike"><span>1 business day - $22.00</span><br/>--> <br/>  <br/>
            <?php
            if(AuthComponent::user('id') && $total_cart_item>0){
            echo $this->Form->input("Continue",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'submit_btn float_l'));
            }
            echo $this->Form->end();
            ?>  
        </div>
   </div>
   <h2>Payment/Billing</h2>
   <div id='cartstep3' style="display: block;">
        <input type="radio" name="payment_type" value="Credit Card"><span>Credit Card</span>
        <input type="radio" name="payment_type" value="Debit Card"><span>Debit Card</span>
        <input type="radio" name="payment_type" value="Net banking"><span>Net banking</span>
        <input type="radio" name="payment_type" value="Paypal"><span>Paypal</span>
        <h3>Enter Card Details</h3>
        <div class="contactForm">
            <form action="#">
                <div>
                    <label>Name Of The Card</span></label>
                    <input type="text" class="contactTxt">
                </div>
                <div>
                    <label>Card Number</label>
                    <input type="text" class="contactTxt">
                </div>
                <div>
                    <label>CCV:</label>
                    <input type="text" class="contactTxt">
                    <?php echo $this->Html->image('img.png'); ?>
                </div>
            </form>
        </div>
        <div class="cardType">
            <p>Card Type</p>
            <input type="radio" name="cardType" value="mastercard"><?php echo $this->Html->image('mastercard.png'); ?>
            <input type="radio" name="cardType" value="visa"><?php echo $this->Html->image('visa.png'); ?>
            <input type="radio" name="cardType" value="american"><?php echo $this->Html->image('american.png'); ?>
        </div>
        <br />
        <div class="expridate">
            <h4>Expiry Date</h4>
            <form action="">
                <select name="cars">
                    <option value="volvo" selected></option>
                </select>
            </form>
        </div>
        <br /> <br /> 

        <div id="contact_form2">
            <h3>Billing Address</h3>
            <?php echo $this->Form->create('User', array('id'=>'UserBillingForm','url'=>'/shopping_carts/order_payment/','type'=>'post')); ?>
            <?php
            echo $this->Form->input("amount",array('type'=>'hidden','id'=>'amount','value'=>$total));
            echo $this->Form->input("shipping_price",array('type'=>'hidden','id'=>'shipping_price','value'=>$shipping_price));
            ?>
            <?php echo $this->Form->input('ship_check',array('id'=>'ship_check','type'=>'checkbox',"label"=>false,"div"=>false,));?><span>Same as shipping address</span> <br /> <br />
            
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
            <div class="cleaner h10" style="height: 60px;"></div></br> 
             <?php
             echo $this->Form->input("Place Order",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'submit_btn float_l'));
             echo $this->Form->end();
             ?>
            <?php 
            if($couponnum>0){
               echo '<div class="coupon_applied"> COUPON APPLIED : '.$couponlist['Coupon']['code'].' &nbsp;'.$this->Html->link($this->Html->image('del_red.png',array('style'=>'margin: 2px 0px 0px 10px;')),array('controller'=>'shopping_carts','action'=>'coupon_remove',$ShoppingCoupon_id),array('escape'=>false)).'</div>';
            }else{
                echo $this->Form->create('ShoppingCart', array('url'=>'/shopping_carts/coupon_apply/','type'=>'post'));
                echo '<div class="FL">';
                echo $this->Form->input('coupon_code', array('id'=>'coupon_code','class' => "input_field","div"=>false, 'title' => __("PROMO CODE"), 'label' => array('text' =>__('PROMO CODE'))));
                echo '</div>';
                ?>  <?php
                echo '<div class="FL">'.$this->Form->input("Apply",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'submit_btn float_l')).'</div>';
                echo $this->Form->end();
            }
            ?>
            <div class="cleaner h10"></div></br> 
        </div>
        
   </div>
     
</div> 
</nav>
</div>
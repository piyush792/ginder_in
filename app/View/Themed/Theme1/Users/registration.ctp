<?php
    $this->start('inline');
?>
<script type="text/javascript">
    function refresh_captcha(){
        jQuery("#captcha_image").attr("src","<?php echo SITE_URL;?>users/get_captcha/"+new Date().getTime());
    } 
    jQuery(document).ready(function(){
        jQuery("#captcha_image").contextmenu(function(e){return false;});

        jQuery("#UserRegistrationForm").submit(function(){

            if($("#firstname").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Your First Name.</span>');
                $("#firstname").focus();
                return false;
            }
            if($("#lastname").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Your Last Name.</span>');
                $("#lastname").focus();
                return false;
            }
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
            if($("#password").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Your Password.</span>');
                $("#password").focus();
                return false;
            }   
            if($("#address").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter your address.</span>');
                $("#address").focus();
                return false;
            }
            if($("#country").val()==0){
                $("#error_msg").html('<span style="color: #FF0000;">Please select country.</span>');
                $("#country").focus();
                return false;
            }
            if($("#city").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter city.</span>');
                $("#city").focus();
                return false;
            }
            if($("#state").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter state.</span>');
                $("#state").focus();
                return false;
            }
            if($("#zipcode").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please enter zipcode.</span>');
                $("#zipcode").focus();
                return false;
            }
            if($("#captcha").val()==""){
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Security Code.</span>');
                $("#captcha").focus();
                return false;
            }
            
            return true;
        });
        
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
<?php
    $this->end();
?>

<div class="pagewrap">
    <nav>
    
         <div style="margin-top: 10px;" align="center"><?php echo $this->Session->flash();?></div>
        
         <div class="rigright">
            <div id="contact_form">
                <h2>already have an account?</h2>
                
                <div id="login_msg" align="left"></div>
                
                <h3>Login In Here</h3>
                <?php echo $this->Form->create('User',array('id'=>'UserLoginForm','url'=>'/users/login/','type'=>'post'));?>
                <div class="cleaner h10"></div></br> 
                <?php echo $this->Form->input('login_email',array('id'=>'login_email','class'=>"validate-email required input_field", 'title'=>__("Email Address"),'label'=>array('text'=>'<em>*</em>'.__('Email Address')), 'div'=>false));?>
                <div class="cleaner h10"></div></br>
                <?php echo $this->Form->input('login_password',array('id'=>'login_password','type'=>'password','class'=>"input_field", 'title'=>__("Password"),'label'=>array('text'=>'<em>*</em>'.__('Password')), 'div'=>false));?>
                <div class="cleaner h10"></div></br>
                <?php echo $this->Form->input('remember',array('id'=>'remember','type'=>'checkbox',"label"=>false,"div"=>false,));?><span>Remember Me</span>
                
                <a href="<?php echo SITE_URL;?>users/forgot_password/"><strong>Forgot your Password? </strong></a><br></br>
                
                <?php 
                echo $this->Form->input("Login",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'submit_btn float_l'));
                echo $this->Form->end();
                ?>
            </div>
        </div>   
        <div class="regleft">
            <h4> Home/Register</h4>
            <h2>login with facebook</h2>
            <p>Use your Facebok account to login or login/register below.</p>
            <?php
                    require_once 'faceconn/facebook.php';
                    require_once 'faceconn/faceconn/faceconn.php';
                    UseGraphAPI();
                    ?>
                    <!-- CONTENT DIV -->
                    <form id="form1" action="<?php echo SITE_URL;?>users/registration/" method='post'>
                        <?php
                        $login = new CustomLoginButton();
                        $login->SetImage(SITE_URL."theme/theme1/img/fb.png");
                        $login->SetPermissions("email,publish_stream");
                        $login->SetOnLoginSubmitForm("form1");
                        $login->Render();
                        ?>
                    </form> 
                    <?php include 'faceconn/SessionCheck.php'; ?>
            
            <div id="create_account">
                <h2>new to silver bliss?</h2>
                
                <div id="error_msg" align="left"></div>
                
                <h3>SIGN UP HERE</h3>
                <?php 
                echo $this->Form->create('User', array('url' => '/users/registration/', 'type' => 'post')); 
                echo $this->Form->hidden('fbid');
                echo $this->Form->input('firstname', array('id'=>'firstname','class' => "input_field", 'title' => __("First Name"), 'label' => array('text' => '<em>*</em>'. __('First Name'))));
                ?>
                <div class="cleaner h10"></div></br>
                <?php echo $this->Form->input('lastname', array('id'=>'lastname','class' => "input_field", 'title' => __("Last Name"), 'label' => array('text' => '<em>*</em>'.__('Last Name'))));?>
                <div class="cleaner h10"></div></br>
                <?php echo $this->Form->input('email', array('id'=>'email','class'=>"input_field", 'title' => __("Email Address"), 'label' => array('text' => '<em>*</em>' . __('Email Address'))));?>
                <div class="cleaner h10"></div></br>
                <?php echo $this->Form->input('password', array('id'=>'password','class' => "required input_field", 'title' => __("Password"), 'label' => array('text' => '<em>*</em>' . __('Password')))); ?>
                <div class="cleaner h10"></div></br>
                <?php echo $this->Form->input('address', array('id'=>'address','class' => "input_field", 'title' => __("Address"), 'label' => array('text' =>__('Address'))));?>
                <div class="cleaner h10"></div></br> 
                <?php echo $this->Form->input('phone', array('id'=>'phone','class' => "input_field", 'title' => __("Phono No."), 'label' => array('text' =>__('Phono No.'))));?>
                <div class="cleaner h10"></div></br> 
                <?php echo $this->Form->input('mobile', array('id'=>'mobile','class' => "input_field", 'title' => __("Mobile No."), 'label' => array('text' =>__('Mobile No.'))));?>
                <div class="cleaner h10"></div></br> 
                <?php echo $this->Form->input('country', array('id'=>'country','class' => "input_field", 'title' => __("Country"),'options'=>$countryList,'label' => array('text' =>__('Country'))));?>
                <div class="cleaner h10"></div></br> 
                <?php echo $this->Form->input('city', array('id'=>'city','class' => "input_field", 'title' => __("City"), 'label' => array('text' =>__('City'))));?>
                <div class="cleaner h10"></div></br> 
                <?php echo $this->Form->input('state', array('id'=>'state','class' => "input_field", 'title' => __("State"), 'label' => array('text' =>__('State'))));?>
                <div class="cleaner h10"></div></br> 
                <?php echo $this->Form->input('zipcode', array('id'=>'zipcode','class' => "input_field", 'title' => __("ZipCode"), 'label' => array('text' =>__('ZipCode'))));?>
                <div class="cleaner h10"></div></br> 
                <?php echo $this->Form->input('captcha', array('id'=>'captcha','class' => "input_field", 'title' => __("Security Code"), 'label' => array('text' => '<em>*</em>' . __('Security Code'))));?>
                <div class="cleaner h10"></div></br>
                <?php
                echo $this->Html->image(SITE_URL.'users/get_captcha/',array('id'=>"captcha_image"));
                echo $this->Html->image('reload.png', array('id' =>"captcha-reload", 'alt' => __("Reload captcha"),'title'=>'Refresh','onclick' => "refresh_captcha()", "style" => "cursor:hand;cursor:pointer;"));
                ?>
                <div class="cleaner h10"></div></br> 
                <?php echo $this->Form->input('newsletter',array('id'=>'newsletter','type'=>'checkbox',"label"=>false,"div"=>false,));?><span>I want to receive Silver Bliss Newsletter</span><br></br>
                <?php
                echo $this->Form->input("Register",array('type'=>'submit',"label"=>false,"div"=>false,'class'=>'submit_btn float_l'));
                echo $this->Form->end();
                ?>
            </div>
        </div>

    </nav>
</div>
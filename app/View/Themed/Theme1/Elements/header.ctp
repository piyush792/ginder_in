<!-- Mobile search modal start -->
<!-- <div id="mobile-search-ctrl" class="mobile-search-control"> <span id="mobile-search-close" class="glyphicon glyphicon-remove-circle"></span>
    <input type="search" placeholder="I am looking for..." class="field-search">
    <button class="btn-search"><?php echo $this->Html->image('/images/icon-search.png');?></button>
</div> -->
<!-- Mobile search modal end --> 

<!--  login modal start -->
<?php
if(isset($valid)){
    if (false != $valid)
    {
        // echo "<script>alert('test')</script>";
    }
}
?>
<div class="modal hide fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="registration-features-col">
                    <header class="heading">Benefits</header>
                    <ul>
                        <li>Publish multiple ads in <span class="highlight-text">Free</span></li>
                        <li>Provide <span class="highlight-text">personalise dashboard</span> to manage posted ads after registration</li>
                        <li>Provide ability to Share ads with friends on <span class="highlight-text">social networking</span> </li>
                    </ul>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

                <div class="login-signup-wrapper">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Login</a> </li>
                        <li class="nav-item"> <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Register</a> </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        
                            <div id="loader_login" style="display: none;">&nbsp;</div>
                            <div id="errMsg"></div>
                            <?php //echo $this->Form->create('User',array('id'=>'UserLoginForm','url'=>'/users/login/','type'=>'post', 'class'=>'form-signup'));?>
                                <div class="form-label-group">
                                    <?php echo $this->Form->input('login_email',array('id'=>'login_email','class'=>"validate-email required form-control", 'div'=>false, 'placeholder'=>'Enter your registered email id', 'label'=>false, 'required'));?>
                                    <label for="login_email">Email</label>
                                </div>
                                <div class="form-label-group">
                                    <?php echo $this->Form->input('login_password',array('id'=>'login_password','type'=>'password','class'=>"form-control", 'label'=>false, 'div'=>false, 'placeholder'=>'Enter your password', 'required'));?>
                                    <label for="login_password">Password</label>
                                </div>
                                <div class="form-label-group" style="float:left;">
                                <?php echo $this->Form->button("Login",array('id'=>'login', 'type'=>'button',"label"=>false,"div"=>false,'class'=>'button button-primary'));?>
                                </div>
                                <div class="form-label-group" style="float: right;">
                                    <button type="button" href="#ForgotModal" id="Forgot_login_modal" role="button" class="button button-primary" data-toggle="modal">Forgot Password</button>
                                </div>
                            <?php
                            //echo $this->Form->end();
                            ?>
                        </div>

                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div id="loader_reg" style="display: none;">&nbsp;</div>
                            <div id="regMsg"></div>
                            <!-- <form class="form-signup"> -->
                                <div class="form-label-group">
                                    <!-- <input type="text" class="form-control" id="label-reg-email" placeholder="Enter your email id"> -->
                                    <?php echo $this->Form->input('reg_email',array('id'=>'reg_email','class'=>"validate-email required form-control", 'div'=>false, 'placeholder'=>'Enter your registered email id', 'label'=>false, 'required'));?>
                                    <label for="reg_email">Email</label>
                                </div>
                                <div class="form-label-group">
                                    <!-- <input type="password" class="form-control" id="label-reg-password" placeholder="Enter your password"> -->
                                    <?php echo $this->Form->input('reg_password',array('id'=>'reg_password','type'=>'password','class'=>"form-control", 'label'=>false, 'div'=>false, 'placeholder'=>'Enter your password', 'required'));?>
                                    <label for="reg_password">Password</label>
                                </div>
                                <div class="form-label-group">
                                    <!-- <input type="password" class="form-control" id="label-regconf-password" placeholder="Enter your password"> -->
                                    <?php echo $this->Form->input('reg_cpassword',array('id'=>'reg_cpassword','type'=>'password','class'=>"form-control", 'label'=>false, 'div'=>false, 'placeholder'=>'Enter your password', 'required'));?>
                                    <label for="reg_cpassword">Confirm Password</label>
                                </div>
                                <div class="form-label-group">
                                    <?php
                                    echo $this->Form->button("Register",array('id'=>'register', 'type'=>'button',"label"=>false,"div"=>false,'class'=>'button button-primary'));
                                    ?>
                                </div>
                            <!-- </form> -->
                        </div>

                    </div>
                </div>
                <div class="single-signup-wrapper">
                    <div class="single-signup-content">
                        <div class="regular-text">Sign in With</div>
                        <!-- <button class="icon-gmail-signup"><?php //echo $this->Html->image('/images/icon-gmail-login.png');?> Gmail Account</button> -->                        
                        <?php
                        if(isset($authUrl)){ //user is not logged in, show login button
                            echo '<a class="login" href="'.$authUrl.'"><button class="icon-gmail-signup">'.$this->Html->image('/images/icon-gmail-login.png'). 'Gmail Account</button></a>';
                        }
                        ?>
                        <!-- <button class="icon-facebook-signup">
                            <?php //echo $this->Html->image('/images/icon-facebook-login.png'); ?>
                        </button> -->
                        <?php echo $output; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- login modal end -->        


<!-- forgot password modal start -->
<div id="ForgotModal" class="modal hide fade" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labelledby="ForgotModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-forgot-form-content">
                    <div class="forgot-features-col">
                        <header class="heading">Forgot Password</header>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    <div class="forgot-signup-wrapper">
                        <div id="loader_forgot_login" style="display: none;">&nbsp;</div>
                        <div id="errForgotMsg"></div>
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="form-label-group">
                                <?php echo $this->Form->input('forgot_email',array('id'=>'forgot_email','class'=>"validate-email required form-control", 'div'=>false, 'placeholder'=>'Enter your registered email id', 'label'=>false, 'required'));?>
                            </div>
                            <br/>
                            <div class="form-label-group">
                            <?php
                                echo $this->Form->button("Submit",array('id'=>'forgot_login', 'type'=>'button',"label"=>false,"div"=>false,'class'=>'button button-primary'));
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- thanks for the confirmation message start -->
                <div class="confirmation-msg-wrapper">
                    <div class="confirmation-icon-wrapper success-msg"><span class="glyphicon glyphicon-ok"></span></div>
                    <div class="confirmation-title success-title">Password has heen Reset And Emailed to your Email Id !</div>
                    <div class="confirmation-button"><button class="btn-teritory">Ok</button></div>
                </div>
                <!-- thanks for the confirmation message end -->
            </div>
        </div>
    </div>
</div>
<!-- end the forgot password modal start -->


<header class="page-header container-fluid">
    <div class="page-header-content">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"> <span class="glyphicon glyphicon-menu-hamburger"></span> </button>
        <?php
        echo $this->Html->link($this->Html->image('/images/brand-logo.png'), '/index', array('escape' => false, 'class'=>'brand-logo'));
        ?>
        <div class="mobile-ctrl-header">
            
            <div class="search-wrapper">
                <?php
                echo $this->Form->create("Product",array("id"=>"Search","type"=>"post","url"=>"/products/search"));
                ?>
                <div class="mobtab-search-bar">
                    <div class="btn-search" id="SearchModal-MobTab"><span class="glyphicon glyphicon-search"></span></div>
                </div>
                <div id="mobile-search-ctrl" class="desktop-search-bar">
                <span id="mobile-search-close" class="glyphicon glyphicon-remove-circle"></span>
                    <?php
                    echo $this->Form->input("keyword",array("id"=>"keyword","type"=>'text',"placeholder"=>"Search for electronics, appliance, furniture, vehicles...","label"=>false,"div"=>false,"value"=>$keyword,'class'=>'required input-search', 'autocomplete'=>'off'));
                    echo $this->Form->input('city', array('id'=>'citySearch','class' => "input-location", 'style'=>'float:left', 'title' => __("City"), 'options'=>$cities, 'label' => false));
                    ?>
                    <!-- <input type='button' value='Seleted option' id='but_read'>
                    <br/>
                    <div id='result'></div> -->
                    <input type="submit" value="Search" class="btn-search">
                </div>
                <?php
                echo $this->Form->end();
                ?>
            </div>

            <div class="login-wrapper">
                <?php
                if(AuthComponent::user('id')){
                    ?>
                    <div class="user-loged-in"><div class="user-logedin-control" id="userlogedinMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $this->Html->image('/images/btn-user-logedin.png'); ?>
                    </div>
                    <div class="dropdown-menu" aria-labelledby="userlogedinMenu">
                        <span class="user-logedin-name">Welcome <br> <?php echo (AuthComponent::user('firstname')!='')?AuthComponent::user('firstname'):AuthComponent::user('email');?></span>
                        <?php echo $this->Html->link('Dashboard','/users/index', array('class'=>'dropdown-item')); ?>
                        <?php echo $this->Html->link('View Saved Favourite','/users/my_favourite', array('class'=>'dropdown-item')); ?>
                        <?php echo $this->Html->link('Sign Out','/users/logouts', array('class'=>'dropdown-item')); ?>
                    </div>
                    
                    <!-- <div class="dropdown">
                        <button class="btn-post-ad" type="button" data-toggle="dropdown">My Account</button>
                        <ul class="dropdown-menu">
                            <li style="padding: 4px; 2px;"><?php //echo $this->Html->link('Dashboard','/users/index'); ?></li>
                            <li style="padding: 4px; 2px;"><?php //echo $this->Html->link('Profile','/users/profile'); ?></li>
                            <li style="padding: 4px; 2px;"><?php //echo $this->Html->link('My Favourite','/users/my_favourite'); ?></li>
                            <li style="padding: 4px; 2px;"><?php //echo $this->Html->link('Logout','/users/logout'); ?></li>
                        </ul>
                    </div>   -->
                    <?php
                } else{
                //echo $this->Html->link('Sign Up','/users/registration'); 
                ?>
                <div class="mobile-login"><?php echo $this->Html->image('/images/mob-userlogin.png', array('data-toggle'=>'modal', 'data-target'=>'#LoginModal')); ?></div>
                <div class="desktop-login"> <?php echo $this->Html->image('/images/btn-login.png', array('data-toggle'=>'modal', 'data-target'=>'#LoginModal')); ?></div>
                <?php
                }
                ?>
            </div>
            <?php
            if(AuthComponent::user('id')){
                ?>
                </div>
                <div class="post-ad-wrapper">
                    <button class="btn-post-ad">
                        <?php echo $this->Html->link('Post an Ad','/users/post_an_ad', array("style"=>"color: #fff;")); ?>
                    </button>
                </div>
                <?php
            }else{
                ?>
                <div class="post-ad-wrapper">
                    <button class="btn-post-ad">
                        <?php echo $this->Html->link('Post an Ad','#', array("style"=>"color: #fff;", "data-toggle"=>"modal", "data-target"=>"#LoginModal")); ?>
                    </button>
                    
                </div>
                <?php
            }
            ?>        
        </div>
    </div>
</header>
<script>
$(document).ready(function(){

    $("#citySearch").select2();
    // // Read selected option
    // $('#but_read').click(function(){
    //     var username = $('#citySearch option:selected').text();
    //     var userid = $('#citySearch').val();
    //     $('#result').html("id : " + userid + ", name : " + username);
    // });

    $('#LoginModal').on('hidden.bs.modal', function (e) {
        $("#errMsg").html("");
        $("#regMsg").html("");
        // $("#regMsg").html("");
        // $('#LoginModal').modal('show');
    });

    $('#Forgot_login_modal').click(function () {
        $("#errForgotMsg").html("");
        $('#LoginModal').modal('hide');
        $('.modal-forgot-form-content').show();
        $('.confirmation-msg-wrapper').hide();
    });

    $(".confirmation-button").click(function () {
        $("input#user_email").val("");
        $('#ForgotModal').modal('hide');
    });

    $('#login').click(function(){
        var login_email = $('#login_email').val();
        var login_password = $('#login_password').val();        
        $("#loader_login").show();
        if(login_email!='' && login_password!=''){
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'users', 'action' => 'login')); ?>',
                type: "post",
                data: {login_email: login_email, login_password: login_password},
                success: function(data){
                    $("#loader_login").hide();
                    if(data=="No"){
                        $('#errMsg').html('<div class="alert alert-danger">Entered user name & password is incorrect or blocked!</div>');
                    }else{
                        $('#errMsg').html('<div class="text-success">Login successfully!</div>');
                        // $('#LoginModal').hide();
                        // location.reload();
                        top.location.href = '<?php echo SITE_URL; ?>homes/index';
                    }
                }
            });
        }else{
            $("#loader_login").hide();
            if($("#login_email").val()==""){
                $('#errMsg').html('<div class="alert alert-danger">Please Enter Your Email Id.</div>');
                $("#login_email").focus();
                return false;
            }
            var regex=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            if(!regex.test($("#login_email").val()))
            {
                $('#errMsg').html('<div class="alert alert-danger">Please Enter Your Valid Email Id.</div>');
                $("#login_email").focus();
                return false;
            }
            if($("#login_password").val()==""){
                $('#errMsg').html('<div class="alert alert-danger">Please Enter Your Password.</div>');
                $("#login_password").focus();
                return false;
            }
            return true;
        }
    });

    $('#register').click(function(){
        var reg_email = $('#reg_email').val();
        var reg_password = $('#reg_password').val();
        var reg_cpassword = $('#reg_cpassword').val();
        $("#loader_reg").show();
        if(reg_password != reg_cpassword){
            $('#regMsg').html('<div class="alert alert-danger">Confirm password mismatched!</div>');
            $("#loader_reg").hide();
            return false;
        }

        if(reg_email!='' && reg_password!=''){
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'users', 'action' => 'registration')); ?>',
                type: "post",
                data: {reg_email: reg_email, reg_password: reg_password},
                success: function(data){
                    console.log(data);
                    $("#loader_reg").hide();
                    if(data=="No"){
                        $('#regMsg').html('<div class="alert alert-danger">Something went wrong!</div>');
                    }else if(data=="already_exist"){
                        $('#regMsg').html('<div class="alert alert-danger">This email already exist Please try another!</div>');
                        return false;
                    }else if(data=="yes"){
                        $('#regMsg').html('<div class="text-success">Account created successfully!</div>');
                        // $('#LoginModal').hide();
                        top.location.href = '<?php echo SITE_URL; ?>homes/index';
                    }
                }
            });
        }else{
            $("#loader_reg").hide();
            if($("#reg_email").val()==""){
                $('#regMsg').html('<div class="alert alert-danger">Please Enter Your Email Id.</div>');
                $("#reg_email").focus();
                return false;
            }
            var regex=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            if(!regex.test($("#reg_email").val()))
            {
                $('#regMsg').html('<div class="alert alert-danger">Please Enter Your Valid Email Id.</div>');
                $("#reg_email").focus();
                return false;
            }
            if($("#reg_password").val()==""){
                $('#regMsg').html('<div class="alert alert-danger">Please Enter Your Password.</div>');
                $("#reg_password").focus();
                return false;
            }
            return true;
        }
    });

    $('#forgot_login').click(function(){
        
        if($("#forgot_email").val()==""){
            $('#errForgotMsg').html('<div class="alert alert-danger">Please Enter Your Email Id.</div>');
            $("#forgot_email").focus();
            return false;
        }
        var regex=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        if(!regex.test($("#forgot_email").val()))
        {
            $('#errForgotMsg').html('<div class="alert alert-danger">Please Enter Your Valid Email Id.</div>');
            $("#forgot_email").focus();
            return false;
        }

        $("#loader_forgot_login").show();
        var forgot_email = $('#forgot_email').val();
        if(forgot_email!=''){
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'users', 'action' => 'forgot_password')); ?>',
                type: "post",
                data: {forgot_email: forgot_email},
                success: function(data){
                    $("#loader_forgot_login").hide();
                    if(data=="No"){
                        $('#errForgotMsg').html('<div class="alert alert-danger">Entered Email is incorrect or blocked!</div>');
                        $('.modal-forgot-form-content').show();
                        $('.confirmation-msg-wrapper').hide();
                    }else{
                        // $('#errForgotMsg').html('<div class="text-success">Password has heen Reset And Emailed to your Email Id !</div>');
                        $('.modal-forgot-form-content').hide();
                        $('.confirmation-msg-wrapper').show();
                        // $('#LoginModal').hide();
                        // location.reload();
                        // top.location.href = 'homes/index';
                    }
                }
            });
        }
    });

});
</script>
<!-- Mobile search modal start -->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<div id="mobile-search-ctrl" class="mobile-search-control"> <span id="mobile-search-close" class="glyphicon glyphicon-remove-circle"></span>
    <input type="search" placeholder="I am looking for..." class="field-search">
    <button class="btn-search"><?php echo $this->Html->image('/images/icon-search.png');?></button>
</div>
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
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
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
                                <div class="form-label-group">
                                <?php
                                    echo $this->Form->button("Login",array('id'=>'login', 'type'=>'button',"label"=>false,"div"=>false,'class'=>'button button-primary'));
                                ?>
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
                        <button class="icon-gmail-signup"><?php echo $this->Html->image('/images/icon-gmail-login.png');?> Gmail Account</button>
                        <button class="icon-facebook-signup"><?php echo $this->Html->image('/images/icon-facebook-login.png');?> Facebook Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- login modal end -->        

<header class="page-header container-fluid">
    <div class="page-header-wrapper">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"> <span class="glyphicon glyphicon-menu-hamburger"></span> </button>
        <?php
        echo $this->Html->link($this->Html->image('/images/brand-logo.png'), '/', array('escape' => false, 'class'=>'brand-logo'));
        ?>
        <div class="mobile-ctrl-header">
            <div class="search-wrapper">
                <?php
                echo $this->Form->create("Product",array("id"=>"Search","type"=>"post","url"=>"/products/search"));
                ?>
                <div class="mobtab-search-bar">
                    <div class="btn-search" id="SearchModal-MobTab"><span class="glyphicon glyphicon-search"></span></div>
                </div>
                <div class="desktop-search-bar">
                    <?php
                    echo $this->Form->input("keyword",array("id"=>"keyword","type"=>'text',"placeholder"=>"Search for electronics, appliance, furniture, vehicles...","label"=>false,"div"=>false,"value"=>$keyword,'class'=>'required input-search'));
                    echo $this->Form->input('state', array('id'=>'state','class' => "input-location", 'title' => __("State"), 'options'=>$states, 'label' => false, 'onchange'=>'getCity(this.value)'));
                    ?>                
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
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">My Account
                        <!-- <span class="caret"></span>\ -->
                        </button>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('Dashboard','/users/index'); ?></li>
                            <li><?php echo $this->Html->link('Profile','/users/profile'); ?></li>
                            <li><?php echo $this->Html->link('My Favourite','/users/my_favourite'); ?></li>
                            <li><?php echo $this->Html->link('Logout','/users/logout'); ?></li>
                        </ul>
                    </div>                    
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
            <div style="clear: both;"></div>
            
            <div class="post-ad-wrapper">
            <button class="btn-post-ad">
            <?php
            if(AuthComponent::user('id')){
                echo $this->Html->link('Post an Ad','/users/post_an_ad', array("style"=>"color: #fff;"));
            }else{
                echo $this->Html->link('Post an Ad','#', array("style"=>"color: #fff;", "data-toggle"=>"modal", "data-target"=>"#LoginModal"));
            }
            ?>
            </button>
            </div>
        </div>
    </div>
</header>

<!-- <script type="text/javascript">
    function searchform(){
        if($("#keyword").val()==""){
            alert("Please Write Keyword To Search");
            $("#keyword").focus(); 
        }else{
            $('#Search').submit();    
        }
    }
</script> -->
<script>
$(document).ready(function(){

    $('#LoginModal').on('hidden.bs.modal', function (e) {
        $("#errMsg").html("");
        $("#regMsg").html("");
    })

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
                        top.location.href = 'users/index';
                    }
                }
            });
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
                    $("#loader_reg").hide();
                    if(data=="No"){
                        $('#regMsg').html('<div class="alert alert-danger">Something went wrong!</div>');
                    }else if(data=="already_exist"){
                        $('#regMsg').html('<div class="alert alert-danger">This email already exist Please try another!</div>');
                    }else if(data=="yes"){
                        $('#regMsg').html('<div class="text-success">Account created successfully, Please activate your account by email sent to you for activation !</div>');
                        // $('#LoginModal').hide();
                        // location.reload();
                    }
                }
            });
        }
    });
});
</script>

<?php //echo $this->element('sql_dump'); ?>
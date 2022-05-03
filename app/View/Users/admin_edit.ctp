<?php 
echo $this->element("admin_header");
?>
<script type="text/javascript">
    function formValidate()
    {
         if($("#firstname").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter your firstname.</div>");
            $("#firstname").focus();
            return false;
        }
        if($("#lastname").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter your lastname.</div>");
            $("#lastname").focus();
            return false;
        }
        /*var phoneNumberPattern = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;          
        if(!phoneNumberPattern.test($("#phone").val()) && $("#phone").val()!='')
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter your valid phone number.</div>");
            $("#phone").focus();
            return false;
        }*/
        if($("#state").val()=="" || $("#state").val()==0)
        {
            $("#error_msg").html("<div class='alert alert-error'>Please select your state.</div>");
            $("#state").focus();
            return false;
        }
        if($("#city").val()=="" || $("#city").val()==0)
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter your city.</div>");
            $("#city").focus();
            return false;
        }
        if($("#zipcode").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter your zip code.</div>");
            $("#zipcode").focus();
            return false;
        }

        $("#error_msg").html('');
        return true;
    }
</script>

<div class="clearfix"></div>
<div class="admin-middle-content">
    <div class='admin-side-menu' id="admin-sidemenu-ctrl"> <span class="glyphicon glyphicon-menu-hamburger"></span>
    <span class="txt-admin-side-menu">Side Menu</span> </div>

    <?php echo $this->element("admin_left"); ?>

    <!-- Right Content start -->
    <div class="superadmin-adverts-wrapper">
        <!-- recent ads section start -->
      
      <section class="superadmin-recent-ads-wrapper">
      <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to Users Lists', array('controller' => 'users','action' => 'index'), array('escape' => false, 'class'=>'anchor-black header-anchor',"title"=>"Back to Users")); ?>
        <header class="clearfix">
          <h2 class="section-heading">Contact Details</h2>
          <!-- <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div> -->
        </header>        

        <section class="table-grid-wrapper">
        <span id="error_msg"><?=$this->Session->flash();?></span>
            <div class="item-content-wrapper">
                <?php echo $this->Form->create('User',array('id'=>'User','class'=>'form-horizontal','type'=>'post')); ?>
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Email <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                        <?php echo $this->Form->input('email',array('label'=>false,'id'=>'email','size'=>40,"class"=>"form-control",'readonly'=>true));?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Firstname <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                        <?php echo $this->Form->input('firstname',array('label'=>false,'id'=>'firstname','size'=>40, "class"=>"form-control"));?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Lastname <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                    <?php echo $this->Form->input('lastname',array('label'=>false,'id'=>'lastname','size'=>40, "class"=>"form-control"));?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Address </label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                    <?php echo $this->Form->input('address',array('label'=>false,'id'=>'address','size'=>40, "class"=>"form-control"));?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Phone No. </label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                    <?php echo $this->Form->input('phone',array('label'=>false,'id'=>'phone','size'=>40, "class"=>"form-control"));?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Mobile No. </label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                    <?php echo $this->Form->input('mobile',array('label'=>false,'id'=>'mobile','size'=>40, "class"=>"form-control"));?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">State <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                    <?php 
                        echo $this->Form->input('state', array('id'=>'state','class' => "form-control", 'title' => __("State"), 'options'=>$states, 'label' => false, 'onchange'=>'getCity(this.value)'));
                    ?>
                    <?php //echo $this->Form->input('state',array('label'=>false,'id'=>'state','type'=>'text',"class"=>"form-control"));?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">City <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                    <?php 
                        echo $this->Form->input('city', array('id'=>'city','class' => "form-control", 'label' => false, 'options'=>$cities));
                    ?>
                    <?php //echo $this->Form->input('city',array('label'=>false,'id'=>'city','type'=>'text',"class"=>"form-control"));?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Zipcode <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                    <?php echo $this->Form->input('zipcode',array('label'=>false,'id'=>'zipcode','type'=>'text',"class"=>"form-control"));?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Status <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                    <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'), "class"=>"form-control"));?>
                    </div>
                </div>
                
                <div class="form-group row">
                <label for="selectCategory" class="col-sm-2 col-form-label">Newsletter Subscribe </label>
                <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                        <?php echo $this->Form->input('newsletter',array('id'=>'newsletter','type'=>'checkbox',"label"=>false,"div"=>false,"class"=>""));?>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo $this->Form->input("SAVE",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));?>
                </div>
                <?php echo $this->Form->end();?>
            </div>
        </section>
      </section>
      <!-- recent ads sectioin end -->
    </div>  
</div>
<!-- recent ads sectioin end -->
<!-- Right Content end -->
</div>

<script type="text/javascript">
$('#state').change(function(){
    var stateId = $('#state').val();
    $("#loader_login").show();
    if(stateId!=''){
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'users', 'action' => 'getCity')); ?>',
            type: "post",
            dataType: 'html',
            data: {stateId: stateId},
            success: function(data){
                $("#loader_login").hide();                    
                $('#city').html(data);
                // location.reload();                    
            }
        });
    }
});
</script>

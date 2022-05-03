<?php
echo $this->element("admin_header");
?>
<style>
    .custom-control-label{
        /* margin-right: 60px !important; */
    }
    .alert-error{
        background-color:#b94a48;
        color: #fff;
    }
</style>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode: "exact",
        elements: "description",
        theme: "advanced",
        plugins: "safari,spellchecker,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        theme_advanced_buttons1: "save,bold,italic,underline,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,cut,copy,paste,pastetext,pasteword,search,replace,bullist,numlist,outdent,indent,blockquote,undo,redo",
        theme_advanced_buttons2: "link,unlink,anchor,cleanup,code,insertdate,inserttime,preview,forecolor,backcolor,tablecontrols,hr,removeformat,sub,sup,charmap",
        theme_advanced_buttons3: "",
        theme_advanced_buttons4: "",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "center",
        theme_advanced_statusbar_location: "",
        template_external_list_url: "js/template_list.js",
        external_link_list_url: "js/link_list.js",
        external_image_list_url: "js/image_list.js",
        media_external_list_url: "js/media_list.js",
        height: "380"
    });

    function changeSelect(val) {        
        var dataSet = val;        
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array('controller' => 'products', 'action' => 'ajaxSubcategories')); ?>',
            data: {catId: dataSet},
            success: function (result) {
                $('#subcategories').html(result);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function getAttributeLists(val) {
        var dataSet = val;
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array('controller' => 'products', 'action' => 'getAttributeLists')); ?>',
            data: {catId: dataSet},
            success: function (result) {
                $('#attribute_lists').html(result);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function formValidate()
    {        
        if ($("#name").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please Enter Product Name</div>");
            $("#name").focus();
            return false;
        }
        if ($("#categories").val() == null || $("#categories").val() == 0)
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please select category</div>");
            $("#categories").focus();
            return false;
        }
        if ($("#subcategories").val() == null || $("#subcategories").val() == 0)
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please select sub-category</div>");
            $("#subcategories").focus();
            return false;
        }

        if ($("#price").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please Enter Product Price</div>");
            $("#price").focus();
            return false;
        } 
        // else if (!NumberPattern.test($("#price").val()) && $("#price").val() != "") {
        //     $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>                              Price should be numeric</div>");
        //     $("#price").focus();
        //     return false;
        // } else if ($("#price").val() == "" || $("#price").val() <= 0) {
        //     $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Price should be greater than 0</div>");
        //     $("#price").focus();
        //     return false;
        // }

        // if ($("#image").val() == "")
        // {
        //     $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please insert product image</div>");
        //     $("#image").focus();
        //     return false;
        // }

        var i = removeHTMLTags(tinyMCE.get("description").getContent());
        try
        {
            i = i.replace(/^\s+|\s+$/g, "");
        } catch (oe)
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please Enter description </div>");
            return false;
        }
        i = i.replace(/^\s+|\s+$/g, "");
        if (i == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please Enter description </div>");
            return false;
        }
        
        if ($("#contact_name").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact name</div>");
            $("#contact_name").focus();
            return false;
        }
        if ($("#state").val() == "" || $("#state").val() == 0)
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact state</div>");
            $("#state").focus();
            return false;
        }
        if ($("#city").val() == "" || $("#city").val() == 0)
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact city</div>");
            $("#city").focus();
            return false;
        }
        // if ($("#contact_zipcode").val() == "")
        // {
        //     $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact zipcode</div>");
        //     $("#contact_zipcode").focus();
        //     return false;
        // }
        if ($("#contact_email").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact email</div>");
            $("#contact_email").focus();
            return false;
        }
        // if ($("#contact_mobile").val() == "")
        // {
        //     $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact mobile</div>");
        //     $("#contact_mobile").focus();
        //     return false;
        // }        
        
        return true;
    }
    function removeHTMLTags(htmlString)
    {
        if (htmlString) {
            var mydiv = document.createElement("div");
            mydiv.innerHTML = htmlString;
            if (document.all) // IE Stuff
            {
                return mydiv.innerText;
            } else // Mozilla does not work with innerText
            {
                return mydiv.textContent;
            }
        }
    }

    var photo_upload_count = 1;
    function add_more_photo()
    {
        if(photo_upload_count < 5){
            var upload = '<br /><input id="product_image_' + photo_upload_count + '" type="file" name="data[ProductImage][' + photo_upload_count + '][product_image]">';
            $("#photo_upload_div").append(upload);
            photo_upload_count++;
        }
    }
</script>

<div class="clearfix"></div>
<div class="admin-middle-content">
    <div class='admin-side-menu' id="admin-sidemenu-ctrl"> <span class="glyphicon glyphicon-menu-hamburger"></span>
        <span class="txt-admin-side-menu">Side Menu</span> </div>

    <?php echo $this->element("admin_left"); ?>

    <!-- Right Content start -->
    <div class="superadmin-adverts-wrapper">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span>Back to Manage Ads', array('controller' => 'products','action' => 'index'), array('escape' => false, 'class'=>'anchor-black header-anchor',"title"=>"Back to Products")); ?>
        <?php echo $this->Form->create('Product',array('id'=>'Product','enctype' =>'multipart/form-data','class'=>'form-horizontal')); ?>
        <span id="error_msg" class="alert-error"><?=$this->Session->flash();?></span>
        <div class="item-content">
            <header class="header-wrapper">
                <h2 class="float-left">Product Details <span class="admin-promoted-ad">Promoted Ad</span></h2>
                <div class="admin-ad-status-wrapper">
                    <div class="ad-status-wrapper">
                        <div class="row">
                            <div class="col-sm-12">
                                <span class="admin-ad-status">Ad Status</span>
                                <button type="button" class="btn btn-sm btn-toggle active" data-toggle="button" aria-pressed="true"
                                        autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="item-content-wrapper">
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Ad Title <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                    <?php echo $this->Form->input('name',array('label'=>false,'id'=>'name',"div"=>false,'size'=>40,"class"=>"form-control"));?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">Category <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                        <?php echo $this->Form->input('ParentCategory',array('label'=>false,'id'=>'categories','options'=>array($catoptions),'empty' => 'Select', 'onchange'=>"changeSelect(this.value)", 'class'=>'form-control'));?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectSubCategory" class="col-form-label">Sub-category <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                        <?php echo $this->Form->input('Category',array('label'=>false, 'type'=>'select','id'=>'subcategories','empty' => 'Select', 'onchange'=>"getAttributeLists(this.value)",'class'=>'form-control'));?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectSubCategory" class="col-form-label">Is product </label>
                        <div class="col-sm-10 ctrl-field">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="Product[new_product]" class="custom-control-input" id="customRadio" value="1" checked>
                                <label class="custom-control-label" for="customRadio">New</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="Product[new_product]" class="custom-control-input" id="customRadio2" value="0">
                                <label class="custom-control-label" for="customRadio2">Used</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row" id="attribute_lists"></div>                

                <div class="form-group row">
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">Enter Product Price <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                        <?php echo $this->Form->input('price',array('label'=>false,'id'=>'price',"div"=>false,"class"=>"form-control"));?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">Is the price</label>
                        <div class="col-sm-10 ctrl-field">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="priceRadio" name="Product[price_option]" value="1"
                                       checked>
                                <label class="custom-control-label" for="priceRadio">Fixed</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="priceRadio2" name="Product[price_option]" value="2">
                                <label class="custom-control-label" for="priceRadio2">Negotiable</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="priceRadio3" name="Product[price_option]" value="3">
                                <label class="custom-control-label" for="priceRadio3">Contact Me</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-12 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">Product Description <span class="required-field">*</span></label>
                        <div class="col-sm-12 ctrl-field">
                            <?php echo $this->Form->input('description', array('id' => 'description','label'=>false)); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="basic" class="col-sm-2 col-form-label"> Product Image: </label>
                    <div class="controls">                        
                            <?php echo $this->Form->input('image',array('label'=>false,'type'=>'file','id'=>'image',"div"=>false));?>
                            <!-- <span class="filename" style="-moz-user-select: none;">No file selected</span>
                            <span class="action" style="-moz-user-select: none;">Choose File</span> -->                        
                            &nbsp;&nbsp;&nbsp;<span class="alert alert-info" style="width: 400px"> Supported File Types: jpg, jpeg, png, gif - <?php echo "Max File size:<b>".ini_get('upload_max_filesize');?></b></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="basic" class="col-sm-2 col-form-label"> Gallery Images:</label>
                    <div class="controls" id="photo_upload_div">
                        <?php echo $this->Form->input('ProductImage.0.product_image',array('label'=>false,'type'=>'file','id'=>'product_image_0',"div"=>false));?>
                        &nbsp;&nbsp;&nbsp;<span class="alert alert-info" style="width: 400px"> Supported File Types: jpg, jpeg, png, gif</span>
                    </div>
                </div>
                <div class="form-group row add-more-wrapper">
                    <div class="controls" style="margin-top: 0px; padding-top: 0px;">
                        <div class="popup_row add_btn_row"><a href="javascript:add_more_photo();">+Add More</a></div>
                    </div>
                </div>                
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">Status</label>
                        <div class="col-sm-12 ctrl-field">
                            <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),"div"=>false,"class"=>"form-control"));?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="item-content admin-contact-details">
            <header class="header-wrapper">
                <h2 class="float-left">Contact Details</h2>
            </header>
            <div class="item-content-wrapper">

                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Your Name <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                        <!-- <input type="text" class="form-control" value="Batra Steel Furniture"> -->
                        <?php echo $this->Form->input('ProductContact.name',array('label'=>false,'id'=>'contact_name',"div"=>false,'size'=>40,"class"=>"form-control"));?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">State <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                        <?php 
                            echo $this->Form->input('ProductContact.state', array('id'=>'state','class' => "form-control", 'title' => __("State"), 'options'=>$states, 'label' => false));
                        ?>
                        <?php //echo $this->Form->input('ProductContact.contact_state',array('label'=>false,'id'=>'contact_state',"div"=>false,'size'=>40,"class"=>"form-control"));?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectSubCategory" class="col-form-label">City <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                        <?php 
                            echo $this->Form->input('ProductContact.city', array('id'=>'city','class' => "form-control", 'label' => false, 'options'=>$cities));
                        ?>
                        <?php //echo $this->Form->input('ProductContact.contact_city',array('label'=>false,'id'=>'contact_city',"div"=>false,'size'=>40,"class"=>"form-control"));?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectSubCategory" class="col-form-label">Pincode </label>
                        <div class="col-sm-10 ctrl-field">
                        <?php echo $this->Form->input('ProductContact.pincode',array('label'=>false,'id'=>'contact_zipcode',"div"=>false,'size'=>40,"class"=>"form-control"));?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectCategory" class="col-form-label">Email Id <span class="required-field">*</span></label>
                        <div class="col-sm-10 ctrl-field">
                        <?php echo $this->Form->input('ProductContact.email',array('label'=>false,'id'=>'contact_email',"div"=>false,'size'=>40,"class"=>"form-control"));?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                        <label for="selectSubCategory" class="col-form-label">Mobile No. </label>
                        <div class="col-sm-10 ctrl-field">
                        <?php echo $this->Form->input('ProductContact.mobile',array('label'=>false,'id'=>'contact_mobile',"div"=>false,'size'=>40,"class"=>"form-control"));?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="item-content">
            <header class="header-wrapper">
                <h2 class="float-left">Promote Your Ad</h2>
            </header>
            <div class="item-content-wrapper">                    
                <div class="form-group row frm-mobtab-topbot">
                    <label for="selectCategory" class="col-form-label col-form-help">Make it a promoted ad?</label>
                    <div class="col-sm-12 ctrl-field">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="featured-ad-1" name="Product[featured_product]" value="1" checked>
                            <label class="custom-control-label" for="featured-ad-1">Yes</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="featured-ad-2" name="Product[featured_product]" value="0">
                            <label class="custom-control-label" for="featured-ad-2">No</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-buttons-wrapper admin-page-button-wrapper">
            <?php echo $this->Form->input("Save",array('type'=>'submit','style'=>'float:left','label'=>false,'class'=>'btn btn-secondary','onclick'=>'return formValidate();'));?>
            <?php //echo $this->Form->input("Cancel",array('type'=>'submit','style'=>'float:left','label'=>false,'class'=>'btn btn-third btn-save'));?>
        </div>
        <?php echo $this->Form->end();?>
</div>
<!-- Right Content end -->

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
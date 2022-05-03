<?php echo $this->Html->script("popup"); ?>
<script type="text/javascript">
    function getPageHeight() {
        return (document.getElementById('main_page').offsetHeight);
    }
</script>


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
            url: '<?php echo Router::url(array('controller' => 'users', 'action' => 'ajaxSubcategories')); ?>',
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
            url: '<?php echo Router::url(array('controller' => 'users', 'action' => 'getAttributeLists')); ?>',
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

        if ($("#image").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please insert product image</div>");
            $("#image").focus();
            return false;
        }
        if ($("#contact_name").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact name</div>");
            $("#contact_name").focus();
            return false;
        }
        if ($("#contact_state").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact state</div>");
            $("#contact_state").focus();
            return false;
        }
        if ($("#contact_city").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact city</div>");
            $("#contact_city").focus();
            return false;
        }
        if ($("#contact_zipcode").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact zipcode</div>");
            $("#contact_zipcode").focus();
            return false;
        }
        if ($("#contact_email").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact email</div>");
            $("#contact_email").focus();
            return false;
        }
        if ($("#contact_mobile").val() == "")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter contact mobile</div>");
            $("#contact_mobile").focus();
            return false;
        }
        
        // var i = removeHTMLTags(tinyMCE.get("description").getContent())
        // try
        // {
        //     i = i.replace(/^\s+|\s+$/g, "");
        // } catch (oe)
        // {
        //     $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please Enter description </div>");
        //     return false;
        // }
        // i = i.replace(/^\s+|\s+$/g, "");
        // if (i == "")
        // {
        //     $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please Enter description </div>");
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
        var upload = '<br /><input id="product_image_' + photo_upload_count + '" type="file" name="data[ProductImage][' + photo_upload_count + '][product_image]">';
        $("#photo_upload_div").append(upload);
        photo_upload_count++;
    }
</script>

<!--MAIN PAGE CONTENT START-->
<div class="clearfix"></div>
  
<div class="page-breadcrumb">
    <span class="page-breadcrumb-item"><a href="index.html" class="anchor-black header-anchor">Home</a></span> 
    <span class="page-breadcrumb-currentitem">Post an Ad</span>
</div>

<div class="main-cotent col-lg-12 col-md-12 col-sm-12 float-left">

<span id="error_msg" class="alert-error"><?=$this->Session->flash();?></span>

    <section class="middle-content-wrapper">
            <?php //echo $this->Form->create('Product',array('id'=>'Product', 'url' =>'/products/post_an_ad/', 'enctype' =>'multipart/form-data','class'=>'form-horizontal')); ?>
            <?php echo $this->Form->create('User',array('id'=>'User', 'url' =>'/users/post_an_ad/', 'enctype' =>'multipart/form-data','class'=>'form-horizontal')); ?>
        
            <!-- Right Content start -->
                <div class="item-content">
                    <header class="header-wrapper">
                    <h2 class="float-left">Product Details</h2>
                    </header>
                    <div class="item-content-wrapper">
                        <div class="form-group row">
                            <label for="selectCategory" class="col-sm-2 col-form-label">Ad Title <span class="required-field">*</span></label>
                            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                            <?php echo $this->Form->input('Product.name',array('label'=>false,'id'=>'name',"div"=>false,'size'=>40,"class"=>"form-control"));?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectCategory" class="col-form-label">Category <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('Product.ParentCategory',array('label'=>false,'id'=>'categories','options'=>array($catoptions),'empty' => 'Select', 'onchange'=>"changeSelect(this.value)", 'class'=>'form-control'));?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectSubCategory" class="col-form-label">Sub-category <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('Category.Category',array('label'=>false, 'type'=>'select','id'=>'subcategories','empty' => 'Select', 'onchange'=>"getAttributeLists(this.value)",'class'=>'form-control'));?>
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
                                <?php echo $this->Form->input('Product.price',array('label'=>false,'id'=>'price',"div"=>false,"class"=>"form-control"));?>
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
                                    <?php echo $this->Form->input('Product.description', array('id' => 'description','label'=>false)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="basic" class="col-sm-2 col-form-label"> Product Image: <span class="required-field">*</span></label>
                            <div class="controls">                        
                                    <?php echo $this->Form->input('Product.image',array('label'=>false,'type'=>'file','id'=>'image',"div"=>false));?>
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
                        <div class="form-group row" style="margin-top: 10px; margin-left: 150px; padding-top: 0px;">
                            <div class="controls" style="margin-top: 0px; padding-top: 0px;">
                                <div class="popup_row add_btn_row"><a href="javascript:add_more_photo();">+Add More</a></div>
                            </div>
                        </div>                
                        <div class="form-group row">
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectCategory" class="col-form-label">Status</label>
                                <div class="col-sm-12 ctrl-field">
                                    <?php echo $this->Form->input('Product.active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),"div"=>false,"class"=>"form-control"));?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            

                <div class="item-content">
                    <header class="header-wrapper">
                        <h2 class="float-left">Contact Details</h2>
                    </header>
                    <div class="item-content-wrapper">

                        <div class="form-group row">
                            <label for="selectCategory" class="col-sm-2 col-form-label">Your Name <span class="required-field">*</span></label>
                            <div class="col-sm-10 col-lg-6 ctrl-field-adtitle">
                                <!-- <input type="text" class="form-control" value="Batra Steel Furniture"> -->
                                <?php echo $this->Form->input('ProductContact.contact_name',array('label'=>false,'id'=>'contact_name',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$loggedInUserDetails['User']['firstname']." ".$loggedInUserDetails['User']['lastname']));?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectCategory" class="col-form-label">State <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('ProductContact.contact_state',array('label'=>false,'id'=>'contact_state',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$loggedInUserDetails['User']['state']));?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectSubCategory" class="col-form-label">City <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('ProductContact.contact_city',array('label'=>false,'id'=>'contact_city',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$loggedInUserDetails['User']['city']));?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectSubCategory" class="col-form-label">Pincode <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('ProductContact.contact_pincode',array('label'=>false,'id'=>'contact_zipcode',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$loggedInUserDetails['User']['zipcode']));?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectCategory" class="col-form-label">Email Id <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('ProductContact.contact_email',array('label'=>false,'id'=>'contact_email',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$loggedInUserDetails['User']['email']));?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectSubCategory" class="col-form-label">Mobile No. <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('ProductContact.contact_mobile',array('label'=>false,'id'=>'contact_mobile',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$loggedInUserDetails['User']['mobile']));?>
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
                            <label for="selectCategory" class="col-form-label col-form-help">You have the option to advertise your AD
                                in the top in feature section by paying Rs. 50 only.</label>

                            <div class="col-sm-12 ctrl-field">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="featured-ad-1" name="Product[featured_product]" value="1" checked>
                                    <label class="custom-control-label" for="featured-ad-1">Yes, I am interested</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="featured-ad-2" name="Product[featured_product]" value="0">
                                    <label class="custom-control-label" for="featured-ad-2">No, I do not want to advertise AD in feature section</label>
                                </div>
                            </div>

                            <div class="col-sm-12 ctrl-field btn-make-payment">
                                <button class="btn btn-primary">Make Payment</button>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="page-buttons-wrapper">
                    <?php echo $this->Form->input("Publish My Ad",array('type'=>'submit','style'=>'float:left','label'=>false,'class'=>'btn btn-secondary btn-publish-add'));?>
                </div>        
            <!-- Right Content end -->
            <?php echo $this->Form->end();?>
    </section>

</div>
<!--MAIN PAGE CONTENT END-->
<?php //echo $this->element('sql_dump'); ?>

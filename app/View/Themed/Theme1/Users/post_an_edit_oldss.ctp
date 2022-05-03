<style>
    .custom-control-label{
        /* margin-right: 60px !important; */
    }
    .alert-error{
        background-color:#b94a48;
        color: #fff;
    }
</style>
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

        // if ($("#image").val() == "" && $("#image_exist").val() == "")
        // {
        //     $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please insert product image</div>");
        //     $("#image").focus();
        //     return false;
        // }
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
<div class="admin-middle-content">

    <div class='admin-side-menu' id="admin-sidemenu-ctrl">
        <span class="glyphicon glyphicon-menu-hamburger"></span> <span class="txt-admin-side-menu">Side Menu</span>
    </div>

    <!-- Left sidebar section start -->
    <div class='admin-navigation-wrapper'>
        <!-- Left inner start -->
        <?php echo $this->element('user_left_inner'); ?>
        <!-- Left inner end -->
    </div>    
    <!-- Left sidebar section end --> 

    <!-- Right Content start -->
    <div class="admin-adverts-wrapper">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span>Back to Manage Advert', array('controller'=>'users','action'=>'/index'), array('escape' => false, 'class'=>'anchor-black header-anchor')); ?>
        <!-- Right Content start -->

        <div class="item-content">
            <span id="error_msg"><?=$this->Session->flash();?></span>
            <div class="item-content-wrapper">
                <header class="header-wrapper">
                    <h2 class="float-left">Image Gallery</h2>
                    <div class="edit-icon"  data-toggle="modal" data-target="#ProductDetailsModal"><span style="float:right;" class="glyphicon glyphicon-pencil"></span></div>            
                </header>
                <?php 
                if(count($galleryimage)>0)
                {
                ?>
                <div class="product-image">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">                                                      
                        <?php
                            for($i=0;$i<count($galleryimage);$i++)
                            {
                                if($i==0){
                                    $active = 'active';
                                }else{
                                    $active = '';
                                }
                                echo '<div class="carousel-item '. $active .'">';
                                // echo "<div class='uploaded-image-item'>".$this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'/thumbnail/'.$galleryimage[$i]['ProductImage']['product_image'], array());
                                echo "<div>".$this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'/'.$galleryimage[$i]['ProductImage']['product_image'], array('width'=>'760px', 'height'=>'auto', 'class'=>'d-block w-100'))."</div>";
                                echo '</div>';
                            }
                        ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <?php 
                }
                ?>            
            </div>
        </div>    

        <!-- Product Details modal start -->
        <div class="modal fade" id="ProductDetailsModal" tabindex="-1" role="dialog" aria-labelledby="ProductDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 840px;left: -140px;padding: 30px 48px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ProductDetailsModalLabel">Edit Product Images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="uploaded-image-wrapper">
                        <div class="heading">Uploaded Images</div>
                        <?php
                            for($i=0;$i<count($galleryimage);$i++)
                            {
                                if($i % 3==0){
                                    echo "<div style='clear: both;'></div>";
                                }
                                echo "<div class='uploaded-image-item'>".$this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'/thumbnail/'.$galleryimage[$i]['ProductImage']['product_image'], array());
                                echo "<div class='remove-item'>".$this->Html->link("<span class='glyphicon glyphicon-remove'></span>Remove",array('controller' => 'users', 'action' => 'galleryimage_delete',$galleryimage[$i]['ProductImage']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete ?")."</div>";
                                echo "</div>";
                            }
                        ?>                            
                    </div>
                    <div class="modal-body">
                        <!-- images form submit here -->
                        <?php echo $this->Form->create('User',array('id'=>'User', 'action' => 'imageUpdate', 'enctype' =>'multipart/form-data', 'class' => 'form-horizontal')); ?>
                            <?php
                                echo $this->Form->input('Product.product_id',array('type'=>'hidden','label'=>false,'id'=>'product_id',"div"=>false,'size'=>40,"class"=>"input-square","value"=>$this->request->data['Product']['id']));
                            ?>
                        <div class="form-group row">
                            <label for="basic" class="col-sm-2 col-form-label"> Gallery Image: </label>
                            <div class="col-sm-10" id="photo_upload_div">
                                    <?php echo $this->Form->input('ProductImage.0.product_image',array('label'=>false,'type'=>'file','id'=>'product_image_0',"div"=>false, "class"=> ""));?>
                                <span class="alert alert-info" style="width: 400px">Recommended size is 760px X 250px.</span>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <div class="col-sm-10" >
                                <div class="popup_row add_btn_row"><a href="javascript:add_more_photo();">+Add More</a></div>
                            </div>
                        </div>
                        <div>&nbsp;</div>

                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-primary">Save</button> -->
                            <div>
                                <?php echo $this->Form->input("Update Images",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary')); ?>
                            </div> 
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        </div>
                        <?php echo $this->Form->end();?>
                        <!-- images form submit end here -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Details modal end -->
        
        <section class="middle-content-wrapper">
            
            <?php echo $this->Form->create('User',array('id'=>'User', 'enctype' =>'multipart/form-data','class'=>'form-horizontal')); ?>
        
            <!-- Right Content start -->
                <div class="item-content">
                    <header class="header-wrapper">
                    <h2 class="float-left">Product Details <span class="admin-promoted-ad">Promoted Ad</span></h2>
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
                                <?php echo $this->Form->input('Product.ParentCategory',array('label'=>false,'id'=>'categories','options'=>array($catoptions),'empty' => 'Select', 'onchange'=>"changeSelect(this.value)", 'class'=>'form-control', 'value'=>$selectedCategory));?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectSubCategory" class="col-form-label">Sub-category <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('Category.Category',array('label'=>false, 'type'=>'select','id'=>'subcategories','onchange'=>"getAttributeLists(this.value)",'class'=>'form-control'));?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectSubCategory" class="col-form-label">Is product </label>
                                <div class="col-sm-10 ctrl-field">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="Product[new_product]" class="custom-control-input" id="customRadio" value="1" <?php echo ($this->request->data['Product']['new_product']==1)?'checked':''; ?>>
                                        <label class="custom-control-label" for="customRadio">New</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="Product[new_product]" class="custom-control-input" id="customRadio2" value="0" <?php echo ($this->request->data['Product']['new_product']==0)?'checked':''; ?>>
                                        <label class="custom-control-label" for="customRadio2">Used</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group row" id="attribute_lists"></div>     -->
                        <div class="form-group row" id="attribute_lists">
                        <?php                    
                        $attribute_value=array();
                        foreach($ProductAttributes as $value)
                        {
                            $attribute_id=$value['id']; 
                            if(!empty($value[$value['name']])){
                                foreach($value[$value['name']] as $val){
                                    $attribute_value[$val['id']]=ucfirst($val['name']);
                                }
                            ?>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectCategory" class="col-form-label"><?php echo $value['name']?>:</label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input("attributes.".$attribute_id."][]",array('label'=>false,'id'=>"attributes_".$attribute_id,'options'=>$attribute_value,'selected'=>$Selected_Attributes,"div"=>false, "class"=>"form-control custom-dropdown"));?>   
                                </div>
                            </div>
                            <?php
                            }
                            unset($attribute_value);
                        }
                        ?>
                    </div>            

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
                                        <?php echo ($this->request->data['Product']['price_option']==1)?'checked':''; ?>>
                                        <label class="custom-control-label" for="priceRadio">Fixed</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="priceRadio2" name="Product[price_option]" value="2" <?php echo ($this->request->data['Product']['price_option']==2)?'checked':''; ?>>
                                        <label class="custom-control-label" for="priceRadio2">Negotiable</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="priceRadio3" name="Product[price_option]" value="3" <?php echo ($this->request->data['Product']['price_option']==3)?'checked':''; ?>>
                                        <label class="custom-control-label" for="priceRadio3">Contact Me</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-lg-12 frm-mobtab-topbot">
                                <label for="selectCategory" class="col-form-label">Product Description </label>
                                <div class="col-sm-12 ctrl-field">
                                    <?php echo $this->Form->input('Product.description', array('id' => 'description','label'=>false)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="basic" class="col-sm-2 col-form-label"> Product Image: </label>
                            <div class="controls">                        
                                    <?php echo $this->Form->input('Product.image',array('label'=>false,'type'=>'file','id'=>'image',"div"=>false));?>
                                    <!-- <span class="filename" style="-moz-user-select: none;">No file selected</span>
                                    <span class="action" style="-moz-user-select: none;">Choose File</span> -->                        
                                    &nbsp;&nbsp;&nbsp;<span class="alert alert-info" style="width: 400px"> Supported File Types: jpg, jpeg, png, gif - <?php echo "Max File size:<b>".ini_get('upload_max_filesize');?></b></span>
                            </div>
                            <?php echo $this->Form->input('Product.image_exist',array('type'=>"hidden",'id'=>'image_exist',"div"=>false,"value"=>$this->data['Product']['image']));?>
                        </div>         
                        <div class="form-group row">
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <?php
                                    if(file_exists(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['image']) && ($this->data['Product']['image']<>"")){
                                        echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['image'], array('width' => '100px','height' => '100px'));
                                    }else{
                                        // echo $this->Html->image(SITE_URL.NO_IMAGE, array('width' => '100px','height' => '100px'));
                                        echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . 'no_image.jpg', array('width' => '100', 'height' => '100'));
                                    }
                                ?>
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
                                <?php echo $this->Form->input('ProductContact.name',array('label'=>false,'id'=>'contact_name',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$productContacts[0]['ProductContact']['name']));?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectCategory" class="col-form-label">State <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php 
                                    echo $this->Form->input('ProductContact.state', array('id'=>'state','class' => "form-control", 'title' => __("State"), 'options'=>$states, 'label' => false, "value"=>$productContacts[0]['ProductContact']['state']));
                                ?>
                                <?php //echo $this->Form->input('ProductContact.contact_state',array('label'=>false,'id'=>'contact_state',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$productContacts[0]['ProductContact']['contact_state']));?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectSubCategory" class="col-form-label">City <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php 
                                    echo $this->Form->input('ProductContact.city', array('id'=>'city','class' => "form-control", 'label' => false, 'options'=>$cities, "value"=>$productContacts[0]['ProductContact']['city']));
                                ?>
                                <?php //echo $this->Form->input('ProductContact.contact_city',array('label'=>false,'id'=>'contact_city',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$productContacts[0]['ProductContact']['contact_city']));?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectSubCategory" class="col-form-label">Pincode <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('ProductContact.pincode',array('label'=>false,'id'=>'contact_zipcode',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$productContacts[0]['ProductContact']['pincode']));?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectCategory" class="col-form-label">Email Id <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('ProductContact.email',array('label'=>false,'id'=>'contact_email',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$productContacts[0]['ProductContact']['email']));?>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 frm-mobtab-topbot">
                                <label for="selectSubCategory" class="col-form-label">Mobile No. <span class="required-field">*</span></label>
                                <div class="col-sm-10 ctrl-field">
                                <?php echo $this->Form->input('ProductContact.mobile',array('label'=>false,'id'=>'contact_mobile',"div"=>false,'size'=>40,"class"=>"form-control", "value"=>$productContacts[0]['ProductContact']['mobile']));?>
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
                                    <input type="radio" class="custom-control-input" id="featured-ad-1" name="Product[featured_product]" value="1" <?php echo ($this->request->data['Product']['featured_product']==1)?'checked':''; ?>>
                                    <label class="custom-control-label" for="featured-ad-1">Yes, I am interested</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" id="featured-ad-2" name="Product[featured_product]" value="0" <?php echo ($this->request->data['Product']['featured_product']==0)?'checked':''; ?>>
                                    <label class="custom-control-label" for="featured-ad-2">No, I do not want to advertise AD in feature section</label>
                                </div>
                            </div>

                            <!-- <div class="col-sm-12 ctrl-field btn-make-payment">
                                <button class="btn btn-primary">Make Payment</button>
                            </div> -->
                        </div>                    
                    </div>
                </div>
                <div class="page-buttons-wrapper">
                    <?php echo $this->Form->input("Publish My Ad",array('type'=>'submit','style'=>'float:left','label'=>false,'class'=>'btn btn-secondary btn-publish-add', 'onclick'=>'return formValidate();'));?>
                </div>        
            <!-- Right Content end -->
            <?php echo $this->Form->end();?>
        </section>
        <!-- Right Content end -->

    </div>
    <!-- Right Content end -->
</div>

<script>
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
<?php

$this->start('inline');
    echo $this->Html->script("jquery.raty");
    echo $this->Html->script("jquery.raty.min");
    echo $this->Html->script("popup"); 
?>

<script>
    function refresh_captcha() {
        jQuery("#captcha_image").attr("src", "<?php echo SITE_URL;?>products/get_captcha/" + new Date().getTime());
    }

    

    $(document).ready(function () {
        //spam report submit
        $('#report_submit').click(function(){
            var productID = $('#product_id').val();
            var description = $('#description').val();
            var user_name = $('#user_name').val();
            var user_email = $('#user_email').val();
            $("#loader_report").show();
            if(user_name!='' && user_email!=''){
                $.ajax({
                    url: '<?php echo Router::url(array('controller' => 'products', 'action' => 'spam_report')); ?>',
                    type: "post",
                    data: {productID:productID, description: description, user_name: user_name, user_email: user_email},
                    success: function(data){
                        $("#loader_report").hide();
                        if(data=="No"){
                            $('#reportMsg').html('<div class="alert alert-danger">Email cannot send successfully!</div>');
                            $('.modal-form-content').show();
                            $('.confirmation-msg-wrapper').hide();
                        }else{
                            $('#reportMsg').html('');
                            $('.modal-form-content').hide();
                            $('.confirmation-msg-wrapper').show();
                            // location.reload();
                            // top.location.href = 'users/profile';
                        }
                    }
                });
            }else{
                $('.modal-form-content').show();
                $('.confirmation-msg-wrapper').hide();

                $("#loader_report").hide();
                if($("#user_name").val()==""){
                    $('#reportMsg').html('<div class="alert alert-danger">Please Enter Your Name</div>');
                    $("#user_name").focus();
                    return false;
                } 
                if($("#user_email").val()==""){
                    $('#reportMsg').html('<div class="alert alert-danger">Please Enter Your Email</div>');
                    $("#user_email").focus();
                    return false;
                }
                $('#reportMsg').html("");
                return true;
            }
        });

        $('#interested_submit').click(function(){
            var user_productID = $('#user_product_id').val();
            var user_enquiry_description = $('#user_enquiry_description').val();
            var user_enquiry_name = $('#user_enquiry_name').val();
            var user_enquiry_email = $('#user_enquiry_email').val();
            var user_enquiry_mobile = $('#user_enquiry_mobile').val();
            var user_enquiry_offer = $('#user_enquiry_offer').val();

            $("#loader_interested").show();
            if(user_enquiry_name!='' && user_enquiry_email!=''){
                $.ajax({
                    url: '<?php echo Router::url(array('controller' => 'products', 'action' => 'product_interested')); ?>',
                    type: "post",
                    data: {user_productID: user_productID, user_enquiry_description: user_enquiry_description, user_enquiry_name: user_enquiry_name, user_enquiry_email: user_enquiry_email, user_enquiry_mobile: user_enquiry_mobile, user_enquiry_offer: user_enquiry_offer},
                    success: function(data){
                        $("#loader_interested").hide();
                        if(data=="No"){
                            $('#interestedMsg').html('<div class="alert alert-danger">Product description is not matched!</div>');
                            $('.modal-form-content').show();
                            $('.confirmation-msg-wrapper').hide();
                        }else{
                            $('#interestedMsg').html('');
                            $('.modal-form-content').hide();
                            $('.confirmation-msg-wrapper').show();
                            // location.reload();
                            // top.location.href = 'users/profile';
                        }
                    }
                });
            }else{

                $('.modal-form-content').show();
                $('.confirmation-msg-wrapper').hide();

                $("#loader_interested").hide();

                if($("#user_enquiry_name").val()==""){
                    $('#interestedMsg').html('<div class="alert alert-danger">Please Enter Your Name</div>');
                    $("#user_enquiry_name").focus();
                    return false;
                } 
                if($("#user_enquiry_email").val()==""){
                    $('#interestedMsg').html('<div class="alert alert-danger">Please Enter Your Email</div>');
                    $("#user_enquiry_email").focus();
                    return false;
                }
                $('#interestedMsg').html("");
                return true;
            }
        });
    
        jQuery("#captcha_image").contextmenu(function (e) {
            return false;
        });

        if ($(window).width() > 1280) {
            slider = $('.premiumbxslider').bxSlider({
                slideWidth: 1200,
                minSlides: 5,
                maxSlides: 5,
                slideMargin: 0,
                responsive: true,
                pager: false
            });
        } else if ($(window).width() > 767) {
            slider = $('.premiumbxslider').bxSlider({
                slideWidth: 768,
                minSlides: 3,
                maxSlides: 3,
                slideMargin: 0,
                responsive: true,
                pager: false
            });
        } else {
            slider = $('.premiumbxslider').bxSlider({
                slideWidth: 500,
                minSlides: 1,
                maxSlides: 1,
                slideMargin: 0,
                responsive: true,
                controls: false,
                pager: false
            });
        }

        $(".btn-favourite").click(function () {
            $(this).children('span').addClass('glyphicon-star selected-favourite').removeClass('glyphicon-star-empty');
        });

        $('[data-toggle="tooltip"]').tooltip();

        /* Global Navigation on close click for resposnive design start*/
        $('.navbar-toggler').click(function () {
            $('body').addClass("fixedPosition");
        });

        $("#ctrl-navbar-close, .mobile-global-navbar-overlay").click(function () {
            $("#collapsibleNavbar").removeClass('show');
            $('body').removeClass("fixedPosition");
        });
        /* Global Navigation on close click for resposnive design end*/

        /* Mobile search control */
        $('#mobile-search-ctrl').hide();

        $('#SearchModal-MobTab').click(function () {
            $('#mobile-search-ctrl').show();

        });
        $("#mobile-search-close").click(function () {
            $('#mobile-search-ctrl').hide();
        });
        /* Mobile search control end */

        /* Mobile filter control start */
        $('#ctrl-mobile-filter').click(function () {
            $('#ctrl-filter-sidebar').show();
        });
        $('#ctrl-filter-close').click(function () {
            $('#ctrl-filter-sidebar').hide();
        });
        /* Mobile filter control start */

        $(".captcha-submit").click(function () {
            if ($("#captcha").val() == "") {
                $("#error_msg").html('<span style="color: #FF0000;">Please Enter Security Code.</span>');
                $("#captcha").focus();
                return false;
            }
        });

        /* spam pop-up start */
        $(".report-spam-wrapper").click(function () {
            $('.modal-form-content').show();
            $('.confirmation-msg-wrapper').hide();
        });

        $(".im-interested-panel").click(function () {
            $('.modal-form-content').show();
            $('.confirmation-msg-wrapper').hide();
        });

        $(".btn-modal-teritory").click(function () {
            $('#SpamReportModal').modal('hide');
            $('#imInterestedModal').modal('hide');
        });

        $(".confirmation-button").click(function () {
            $("input#user_name,input#user_email,textarea#description").val("");
            $("input#user_enquiry_name,input#user_enquiry_email,textarea#user_enquiry_description,input#user_enquiry_mobile,input#user_enquiry_offer").val("");
            $('#SpamReportModal').modal('hide');
            $('#imInterestedModal').modal('hide');
        });
        // $('.confirmation-msg-wrapper').hide();
        
        /* spam pop-up end */

    });

</script>

<script type="text/javascript">
    function getPageHeight() {
        return (document.getElementById('main_page').offsetHeight);
    }
</script>
<script>
    $(function () {
        $('.slideShow').bxSlider({mode: 'horizontal', auto: true, infiniteLoop: true, pause: 3500, speed: 1250, pager: false, controls: true});
        $('.gallery a').click(function () {
            var imagePath = $(this).attr('href');
            $('.bigimage').html('<img width="381px" height="360" src="' + imagePath + '" />');
            return false;
        })

        $('.available').click(function () {
            var param = $(this).attr('params');
            var spdata = param.split(',');
            var at1 = spdata[0];
            var at2 = spdata[1];
            $("#box" + at1).find(".attr").removeClass("attr_border");
            $("#box" + at1).find("#attr" + at2).addClass("attr_border");
            $("#attributes_" + at1).val(at2);
        })

    });

    function addto_wishlist(product_id)
    {
        if (product_id == 0) {
            jQuery("#errormsg").html('<span style="color: red;">Please Login To Add Product In Wishlist !</span>');
        } else {
            var siteUrl = '<?php echo SITE_URL;?>';
            var url = siteUrl + "products/wish_list/" + product_id;

            var frmData = jQuery('#ProductDetail').serialize();

            jQuery.ajax({
                type: 'POST',
                url: url,
                data: frmData,
                dataType: 'text',
                success: function (responseData, status, XMLHttpRequest) {
                    var result = responseData;
                    jQuery('#errormsg').html(result);
                }
            });
        }
    }

    function email_to_friend(product_id)
    {
        if (product_id == 0) {
            jQuery("#errormsg").html('<span style="color: red;">Please Login For Email To Friend !</span>');
        }
    }

    function check_quantity()
    {
        var product_id = $('#product_id').val();
        var attribute_value_id = $('#attributes_<?php echo SIZE_ID;?>').val();
        var quantity = $('#quantity').val();
        if (attribute_value_id == '') {
            jQuery('#errormsg').html('<span style="color: red;">Please Select A Size</span>');
        } else {
            if (quantity == '')
                quantity = 1;

            var siteUrl = '<?php echo SITE_URL;?>';
            var url = siteUrl + "products/check_quantity/" + product_id + "/" + attribute_value_id + "/" + quantity;
            jQuery.ajax({
                type: 'POST',
                url: url,
                dataType: 'text',
                success: function (responseData, status, XMLHttpRequest) {
                    var result = responseData;
                    var arr = result.split('-');
                    if (arr[1] == 1)
                        $('#ProductDetail').submit()
                    else
                        jQuery('#errormsg').html('<span style="color: red;">The Available Quantity is ' + arr[0] + ' for this Product</span>');
                }
            });
        }
    }

</script>

<script>
    <?php
    $check_user_review=count($user_review);
    if($check_user_review>0)
    $readonly_chk=true;
    else
    $readonly_chk=false;
    ?>
    $(function () {
        $('#score').raty({
            path: '<?php echo SITE_URL;?>/theme/theme1/img/',
            starOn: 'red_ster.png',
            starOff: 'ster.png',
            readOnly: '<?php echo $readonly_chk;?>',
            score: function () {
                return $(this).attr('data-rating');
            },
            click: function (score, evt) {
                $('#RatingOverall').val(score);
            }
        });

        $('#score2').raty({
            path: '<?php echo SITE_URL;?>/theme/theme1/img/',
            starOn: 'red_ster.png',
            starOff: 'ster.png',
            readOnly: '<?php echo $readonly_chk;?>',
            score: function () {
                return $(this).attr('data-rating');
            },
            click: function (score2, evt) {
                $('#RatingComfort').val(score2);
            }
        });
        $('#score3').raty({
            path: '<?php echo SITE_URL;?>/theme/theme1/img/',
            starOn: 'red_ster.png',
            starOff: 'ster.png',
            readOnly: '<?php echo $readonly_chk;?>',
            score: function () {
                return $(this).attr('data-rating');
            },
            click: function (score3, evt) {
                $('#RatingStyle').val(score3);
            }
        });
    });
</script>
<?php
    $this->end();
?>

<div class="clearfix"></div>
<div class="page-breadcrumb">
    <span class="page-breadcrumb-item"><?php echo $this->Html->link('Home', '/index');?></span>
    <span class="page-breadcrumb-item"><?php echo $cat_name['Category']['name'];?></span>
    <span class="page-breadcrumb-currentitem">
        <?php
            $link = $sub_cat_name['Category']['id']."/".$cat_name['Category']['name'];
        ?>
        <?php echo '<a href="'.SITE_URL.'products/view/'.$link.'">'.$sub_cat_name['Category']['name'].'</a>'; ?>
    </span>
</div>
<div class="middle-content-advert">
    <?php //echo $this->Form->create('Product',array('id'=>'ProductDetail','url'=>'/shopping_carts/addtocart','type'=>'post')); ?>

    <!-- product image section start -->
    <div class='product-page-left-sidebar'>
        <div class='bigimage product-large-image'>
            <!-- <img src='images/product-detail-img.png'> -->
            <?php 
                $image_exist = PRODUCT_IMAGE_UPLOAD.$productDetail['Product']['image'];
                if(file_exists($image_exist) && $productDetail['Product']['image']!='')
                echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$productDetail['Product']['image'],array('width'=>'381','height'=>'360'));
                else
                echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg',array('width'=>'381','height'=>'360'));
            ?>
        </div>
        <div class='gallery product-thumbnail-image-wrapper'>
            <ul>
                <li class='thumbnail-img'>
                    <a href="<?php echo SITE_URL.PRODUCT_IMAGE_UPLOAD.'large/'.$productDetail['Product']['image'];?>">
                    <?php echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$productDetail['Product']['image'],array('width' =>'119px','height'=>'119px','alt'=>''));?>
                    </a>
                </li>
        <?php
            foreach($productDetail['ProductImage'] as $k=>$galleryimage)
            {
            ?>
                <li class='thumbnail-img'>
                    <a href="<?php echo SITE_URL.PRODUCT_IMAGE_UPLOAD.'large/'.$galleryimage['product_image'];?>">
                <?php echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$galleryimage['product_image'],array('width' =>'119px','height'=>'119px','alt'=>'')); ?> 
                    </a>
                </li>
            <?php
            }
        ?>
            </ul>
        </div>
    </div>
    <!-- product image section end --> 

    <!-- product details section start -->
    <section class='product-page-right-sidebar'>
        <header>
            <h1 class='product-title'><?php echo strtoupper($productDetail['Product']['name']);?><br /><br /> </h1>
        </header>
        <div class='product-owner-details'>
            <div class='left-sidebar'>
                <div class='owner-heading'>Owner Details</div>
                <div class='owner-title'><?php echo $productDetail['ProductContact']['name']; ?></div>
                <div class="owner-location">Location: <?php echo (isset($cityName['City']['name'])? $cityName['City']['name'] : '') . (isset($stateName['State']['name'])? "(".$stateName['State']['name'].")":''); ?></div>
            </div>

            <div id="error_msg" align="left"></div>

            <div class='right-sidebar'>
                <div class='title'>Enter captcha code to view owner contact details</div>

            <?php
            echo $this->Html->image(SITE_URL.'products/get_captcha/',array('id'=>"captcha_image"));
            echo $this->Html->image('reload.png', array('id' =>"captcha-reload", 'alt' => __("Reload captcha"),'title'=>'Refresh','onclick' => "refresh_captcha()", "style" => "cursor:hand;cursor:pointer;"));
            ?>
                <form method="post" action="">
                    <div class='captcha-wrapper'> 
                    <?php echo $this->Form->input('captcha', array('id'=>'captcha', 'label'=> false, 'div'=> false, 'class' => "captcha-field"));?>
                        <input class="captcha-submit" type="submit" value="Submit">
                    </div>
                </form>
                <div class="owner-location" id='show-contact-details'><?php echo $contactDetailsSet; ?></div>
            </div>
        </div>

        <!-- product attribute start -->
        <section class='product-attribute-wrapper'>
            <div class="attribute-heading">Product Details</div>
            <ul class='product-attribute-content'>
        <?php
            $attribute_value=array();
            foreach($ProductAttributes as $value){
                $attribute_id=$value['id']; 
                if(!empty($value[$value['name']])){
                    ?>
                <li class='attribute-item'>
                    <div class='attribute-label'>
                        <strong><?php echo $value['name']?>:</strong>
                    </div>
                        <?php echo $this->Form->input("attributes.".$attribute_id,array('label'=>false,'id'=>"attributes_".$attribute_id,"div"=>false,'type'=>'hidden','value'=>''));?>
                            <?php
                            foreach($value[$value['name']] as $val){
                            $attribute_value[$val['id']]=ucfirst($val['name']);
                            
                            if(empty($val['quantity']) && $value['id']==1)
                            $class_for_availability='attr un-available';
                            else
                            $class_for_availability='attr available';
                            ?>
                    <div class='attribute-value'>
                                <?php echo ucfirst($val['name']);?>
                    </div>                
                            <?php
                            }
                            ?>                    
                </li>
                    <?php
                }
                unset($attribute_value);
            }
            ?>
                <li class='attribute-item'>
                    <div class='attribute-label'><strong>Price:</strong></div>
                    <div class='attribute-value'><span class="product-price">Rs. <?=$productDetail['Product']['price'];?></span> <Span class="price-tag">Fixed price</span></div>
                </li>
            </ul>
        </section>
        <!-- product attribute end --> 

        <!-- product description start -->
        <section class='prdouct-description-wrapper'>
            <div class="prdouct-description-heading">Product Description:</div>
            <ul class='product-description-content'>
            <?php echo $productDetail['Product']['description']; ?>
            </ul>
        </section>
        <!-- product description end --> 

        <!-- product share start -->
        <div class="product-share-wrapper">
            <span class="product-share-heading">Share at:</span> 
            <?php
            if($social_linked['SocialLink']['facebook_status']==1){
            ?>
            <span><a href="<?php echo $social_linked['SocialLink']['facebook'];?>" target="_blank"><?php echo $this->Html->image(SITE_URL.'img/icon-facebook.png');?></a></span>
            <?php
            }
            ?>
            <?php
            if($social_linked['SocialLink']['twitter_status']==1){
            ?>
            <span><a href="<?php echo $social_linked['SocialLink']['twitter'];?>" target="_blank"><?php echo $this->Html->image(SITE_URL.'img/icon-twitter.png');?></a></span>
            <?php
            }
            ?>
            <?php
            if($social_linked['SocialLink']['pinterest_status']==1){
            ?>
            <span><a href="<?php echo $social_linked['SocialLink']['pinterest'];?>" target="_blank"><?php echo $this->Html->image(SITE_URL.'img/icon-pinterest.png');?></a></span>
            <?php
            }
            ?>
            <?php
            if($social_linked['SocialLink']['instagram_status']==1){
            ?>
            <span><a href="<?php echo $social_linked['SocialLink']['instagram'];?>" target="_blank"><?php echo $this->Html->image(SITE_URL.'img/icon-instagram.png');?></a></span>
            <?php
            }
            ?>    
        </div>
        <!-- product share end -->


        <!--  spam report pop-up start -->
        <div class="modal fade" id="SpamReportModal" tabindex="-1" role="dialog" aria-labelledby="SpamReportModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        
                    <div id="loader_report" style="display: none;">&nbsp;</div>
                    <div id="reportMsg"></div>

                        <div class="modal-form-content">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>          
                            <div class="modal-title">Report Spam</div>
                            <div class="modal-overview">
                                We always ensure to serves our users better. But still if any content is inappropriate,  spam, 
                                against community and person please share your thoughts with us.
                            </div>
                            <div class="modal-form">
                                <div class="modal-form-row">
                                <?php echo $this->Form->input('id',array('id'=>'product_id','type'=>'hidden','value'=>$productDetail['Product']['id'], 'class'=>"ctrl-singleline", 'div'=>false));?>
                                    <textarea name="description" id="description" class="ctrl-multiline"></textarea>
                                </div>
                                <div class="modal-form-row">                    
                                    <div class="col-sm-12 col-lg-5 modal-form-col float-left">
                                        <?php echo $this->Form->input('user_name',array('id'=>'user_name','class'=>"required form-control", 'div'=>false, 'placeholder'=>'Name *', 'label'=>false, 'required'));?>
                                        <!-- <input type="text" name="user_name" id="user_name" value="" for="user_name" placeholder="Name *" class="ctrl-singleline" /> -->
                                        <!-- <div class="warning-wrapper-field error-msg-field">
                                            <span class="glyphicon glyphicon-alert"></span> Cannot leave name field blank.
                                        </div> -->
                                    </div>
                                    <div class="col-sm-12 col-lg-5 modal-form-col modal-rightcol-field float-left">
                                    <?php echo $this->Form->input('user_email',array('id'=>'user_email','class'=>"validate-email required form-control", 'div'=>false, 'placeholder'=>'Email *', 'label'=>false, 'required'));?>
                                        <!-- <input type="text" name="email" id="user_email" value="" placeholder="Email *" class="ctrl-singleline" /> -->
                                        <!-- <div class="warning-wrapper-field error-msg-field">
                                            <span class="glyphicon glyphicon-alert"></span> Cannot leave email field blank.
                                        </div> -->
                                    </div>
                                </div>
                                <div  class="modal-form-footer">
                                    <!-- <button class="btn-primary btn-mid-size" id="btn-submit-request">Send Message</button>  -->
                                    <?php echo $this->Form->button("Send Message",array('id'=>'report_submit', 'type'=>'button',"label"=>false,"div"=>false,'class'=>'btn-primary btn-mid-size'));?>
                                    <button class="btn-teritory btn-mid-size btn-modal-teritory">Close</button>
                                </div>
                            </div>
                        </div>

                        <!-- thanks for the confirmation message start -->
                        <div class="confirmation-msg-wrapper">
                            <div class="confirmation-icon-wrapper success-msg"><span class="glyphicon glyphicon-ok"></span></div>
                            <div class="confirmation-title success-title">Thanks for sharing your feedback.</div>
                            <div class="confirmation-message">Our support team will look into this and contact you with an update.</div>
                            <div class="confirmation-button"><button class="btn-teritory">Ok</button></div>
                        </div>
                        <!-- thanks for the confirmation message end -->                
                    </div>
                </div>
            </div>
        </div>
        <!--  spam report pop-up end -->

        <!-- product spam report stop-->    
        <div class="report-spam-wrapper" data-toggle="modal" data-target="#SpamReportModal" >Report Spam</div>
        <!-- product spam report end -->


        <div class="modal fade" id="imInterestedModal" tabindex="-1" role="dialog" aria-labelledby="imInterestedModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                    <div id="loader_interested" style="display: none;">&nbsp;</div>
                    <div id="interestedMsg"></div>

                        <div class="modal-form-content">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>          
                            <div class="modal-title">Send Query to</div>
                            <div class="modal-overview">
                                <b><?php echo $productDetail['Product']['name'];?></b>
                            </div>
                            <div class="modal-form">
                                <div class="modal-form-row">
                                    <?php echo $this->Form->input('id',array('id'=>'user_product_id','type'=>'hidden','value'=>$productDetail['Product']['id'], 'class'=>"ctrl-singleline", 'div'=>false));?>
                                    <textarea name="user_enquiry_description" id="user_enquiry_description" class="ctrl-multiline"></textarea>
                                </div>
                                <div class="modal-form-row">                    
                                    <div class="col-sm-12 col-lg-5 modal-form-col float-left">
                                        <?php echo $this->Form->input('user_enquiry_name',array('id'=>'user_enquiry_name','class'=>"ctrl-singleline", 'div'=>false, 'placeholder'=>'Name *', 'label'=>false, 'required'));?>
                                        <!-- <div class="warning-wrapper-field error-msg-field">
                                            <span class="glyphicon glyphicon-alert"></span>Cannot leave name field blank.
                                        </div> -->
                                    </div>
                                    <div class="col-sm-12 col-lg-5 modal-form-col modal-rightcol-field float-left">
                                        <?php echo $this->Form->input('user_enquiry_email',array('id'=>'user_enquiry_email','class'=>"validate-email required ctrl-singleline", 'div'=>false, 'placeholder'=>'Email *', 'label'=>false, 'required'));?>
                                        <!-- <div class="warning-wrapper-field error-msg-field">
                                            <span class="glyphicon glyphicon-alert"></span> Cannot leave email field blank.
                                        </div> -->
                                    </div>                        
                                </div>
                                <div class="modal-form-row">                    
                                    <div class="col-sm-12 col-lg-5 modal-form-col float-left">
                                        <?php echo $this->Form->input('user_enquiry_mobile',array('id'=>'user_enquiry_mobile','class'=>"ctrl-singleline", 'div'=>false, 'placeholder'=>'Mobile', 'label'=>false));?>
                                    </div>
                                    <div class="col-sm-12 col-lg-5 modal-form-col modal-rightcol-field float-left">
                                        <?php echo $this->Form->input('user_enquiry_offer',array('id'=>'user_enquiry_offer','class'=>"ctrl-singleline", 'div'=>false, 'placeholder'=>'Offer', 'label'=>false));?>
                                    </div>                        
                                </div>                                
                                <div class="modal-form-footer">
                                    <?php echo $this->Form->button("Send Message",array('id'=>'interested_submit', 'type'=>'button',"label"=>false,"div"=>false,'class'=>'btn-primary btn-mid-size'));?>
                                    <button class="btn-teritory btn-mid-size btn-modal-teritory">Close</button>
                                </div>
                            </div>
                        </div>
                        <!-- thanks for the confirmation message start -->
                        <div class="confirmation-msg-wrapper" id="im-interested-conf">
                            <div class="confirmation-icon-wrapper success-msg"><span class="glyphicon glyphicon-ok"></span></div>
                            <div class="confirmation-title success-title">Your message has been sent.</div>
                            <div class="confirmation-message">Check your <strong>My Account Inbox</strong> to view sent and recevided messages after login</div>
                            <div class="confirmation-button"><button class="btn-teritory">Ok</button></div>
                        </div>
                        <!-- thanks for the confirmation message end -->                
                    </div>
                </div>
            </div>
        </div>

        <div class='im-interested-panel' data-toggle="modal" data-target="#imInterestedModal" ></div>
        <!-- I am interested panel end -->

    </section>
    <!-- product details section end -->
</div>

<!-- premium section start -->
<?php
$num_similar = count($similar_products);
if($num_similar>0)
{
?>
<section class="product-premium-ads-wrapper">
    <header>
        <h2 class="section-heading">Premium ads related to this category</h2>
    </header>

    <ul class="premiumbxslider">
        <?php
            for($i=0;$i<$num_similar;$i++){
            ?>
        <li>
            <div class="card">
                    <?php
                        $image_exist = PRODUCT_IMAGE_UPLOAD.$similar_products[$i]['Product']['image'];
                        if(file_exists($image_exist) && $similar_products[$i]['Product']['image']!='')
                        $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$similar_products[$i]['Product']['image'];
                        else
                        $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg';
                        echo $this->Html->image($product_image,array('class'=>'card-img-top', 'width' =>'176','height'=>'176'));
                    ?>                
                <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
                <div class="card-body">
                    <a class="card-title" href="<?php echo SITE_URL."products/detail/".$similar_products[$i]['Product']['id'];?>">
                            <?php echo $similar_products[$i]['Product']['name'];?>
                        <h4>
                                <?php
                                    //echo CURRENCY_SYMBOL.$similar_products[$i]['Product']['price'];  
                                ?>
                        </h4>
                    </a>
                </div>
            </div>
        </li>
            <?php
            }
        ?>
    </ul>    
</section>
<?php
}
?>
<!-- premium section end --> 

<!--- previous and next product start -->
<!-- <section class="product-prev-next-wrapper">
        <a href="#" class="product-previous-ad"><span class="glyphicon glyphicon-chevron-left"></span> Previous Ad: <span class="previous-ad-label">Batrat Steel Furniture</span></a>
        <a href="#" class="product-next-ad">Next Ad: <span class="next-ad-label">Amit Furniture & Interior</span> <span class="glyphicon glyphicon-chevron-right"></span> </a>
</section> -->
<!--- previous and next product end -->
<?php //echo $this->element('sql_dump'); ?>
<?php
    $this->start('inline');
    echo $this->Html->script("jquery.raty");
    echo $this->Html->script("jquery.raty.min");
    echo $this->Html->script("popup"); 
?>

<script>
function refresh_captcha(){
    jQuery("#captcha_image").attr("src","<?php echo SITE_URL;?>products/get_captcha/"+new Date().getTime());
} 

$(document).ready(function(){

    jQuery("#captcha_image").contextmenu(function(e){return false;});

	if($(window).width() > 1280){
	  	slider = $('.premiumbxslider').bxSlider({
		slideWidth: 1200,
        minSlides: 5,
        maxSlides: 5,
        slideMargin: 0,
		responsive: true,
        pager: false
	    });		
	} else if($(window).width() > 767){
	  	slider = $('.premiumbxslider').bxSlider({
		slideWidth: 768,
        minSlides: 3,
        maxSlides: 3,
        slideMargin: 0,
		responsive: true,
        pager: false
	    });
	} else{
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
	
    $(".btn-favourite").click(function(){
        $(this).children('span').addClass('glyphicon-star selected-favourite').removeClass('glyphicon-star-empty');
    });
	
	$('[data-toggle="tooltip"]').tooltip(); 
	
	/* Global Navigation on close click for resposnive design start*/
	$('.navbar-toggler').click(function(){
			$('body').addClass("fixedPosition");
	});

	$("#ctrl-navbar-close, .mobile-global-navbar-overlay").click(function(){
        $("#collapsibleNavbar").removeClass('show');
		$('body').removeClass("fixedPosition");		
    });
	/* Global Navigation on close click for resposnive design end*/	
	
	/* Mobile search control */
	$('#mobile-search-ctrl').hide();
	
	$('#SearchModal-MobTab').click(function(){
		$('#mobile-search-ctrl').show();
		
	});
	$("#mobile-search-close").click(function(){
		$('#mobile-search-ctrl').hide();
	});
	/* Mobile search control end */
	
	/* Mobile filter control start */
	$('#ctrl-mobile-filter').click(function(){
		$('#ctrl-filter-sidebar').show();
	});
	$('#ctrl-filter-close').click(function(){
		$('#ctrl-filter-sidebar').hide();
	});
    /* Mobile filter control start */	
    
    $(".captcha-submit").click(function(){
        if($("#captcha").val()==""){
            $("#error_msg").html('<span style="color: #FF0000;">Please Enter Security Code.</span>');
            $("#captcha").focus();
            return false;
        }
    });
    
});    
    
</script>

<script type="text/javascript">
    function getPageHeight() {
        return (document.getElementById('main_page').offsetHeight);
    }
</script>
<script>
    $(function(){
        $('.slideShow').bxSlider({mode:'horizontal',auto:true,infiniteLoop:true,pause:3500,speed:1250,pager:false,controls:true});
        $('.gallery a').click(function(){
            var imagePath = $(this).attr('href');
            $('.bigimage').html('<img width="381px" height="360" src="'+ imagePath +'" />');
            return false;
        })
        
        $('.available').click(function(){
           var param = $(this).attr('params');
           var spdata=param.split(',');
           var at1=spdata[0];
           var at2=spdata[1];        
           $("#box"+at1).find(".attr").removeClass("attr_border");                  
           $("#box"+at1).find("#attr"+at2).addClass("attr_border");      
           $("#attributes_"+at1).val(at2);
        })
        
    });

    function addto_wishlist(product_id)
    {
        if(product_id==0){
            jQuery("#errormsg").html('<span style="color: red;">Please Login To Add Product In Wishlist !</span>');    
        }else{
            var siteUrl= '<?php echo SITE_URL;?>';
            var url=siteUrl+"products/wish_list/"+product_id;
            
            var frmData = jQuery('#ProductDetail').serialize(); 
            
            jQuery.ajax({
                type:'POST',
                url: url,
                data:frmData,
                dataType:'text',
                success:function(responseData,status,XMLHttpRequest){
                    var result = responseData;
                    jQuery('#errormsg').html(result);
                }
            });     
        }
    }

    function email_to_friend(product_id)
    {
        if(product_id==0){
            jQuery("#errormsg").html('<span style="color: red;">Please Login For Email To Friend !</span>');    
        }
    }
    
    function check_quantity()
    {
        var product_id = $('#product_id').val();
        var attribute_value_id = $('#attributes_<?php echo SIZE_ID;?>').val();
        var quantity = $('#quantity').val();
        if(attribute_value_id==''){
                jQuery('#errormsg').html('<span style="color: red;">Please Select A Size</span>');    
        }else{
            if(quantity=='')
            quantity=1;

            var siteUrl= '<?php echo SITE_URL;?>';
            var url=siteUrl+"products/check_quantity/"+product_id+"/"+attribute_value_id+"/"+quantity;
            jQuery.ajax({
                type:'POST',
                url: url,
                dataType:'text',
                success:function(responseData,status,XMLHttpRequest){
                    var result = responseData;
                    var arr = result.split('-');
                    if(arr[1]==1)
                    $('#ProductDetail').submit() 
                    else
                    jQuery('#errormsg').html('<span style="color: red;">The Available Quantity is '+arr[0]+' for this Product</span>');
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
    $(function() {
        $('#score').raty({
            path: '<?php echo SITE_URL;?>/theme/theme1/img/',
            starOn  : 'red_ster.png',
            starOff : 'ster.png',
            readOnly   : '<?php echo $readonly_chk;?>',
            score: function() {
                return $(this).attr('data-rating');
            },
            click: function(score, evt) {
                $('#RatingOverall').val(score);
            }
        });
        
        $('#score2').raty({
            path: '<?php echo SITE_URL;?>/theme/theme1/img/',
            starOn  : 'red_ster.png',
            starOff : 'ster.png',
            readOnly   : '<?php echo $readonly_chk;?>',
            score: function() {
                return $(this).attr('data-rating');
            },
            click: function(score2, evt) {
               $('#RatingComfort').val(score2); 
            }
        });
        $('#score3').raty({
            path: '<?php echo SITE_URL;?>/theme/theme1/img/',
            starOn  : 'red_ster.png',
            starOff : 'ster.png',
            readOnly   : '<?php echo $readonly_chk;?>',
            score: function() {
                return $(this).attr('data-rating');
            },
            click: function(score3, evt) {
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
    <span class="page-breadcrumb-currentitem"><?php echo $sub_cat_name['Category']['name'];?></span>
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
        <div class="prdouct-description-heading">Product Descripttion:</div>
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
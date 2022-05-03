<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Silverbliss</title>
    <?php
        echo $this->Html->css('style');
        echo $this->Html->css("popup");
        echo $this->Html->script("modernizr");
        echo $this->Html->script("jquery");
        echo $this->Html->script("easing");
        echo $this->Html->script("jquery.bxslider");
        echo $this->Html->script("main");
    ?> 
    <?php echo $this->Html->script("popup"); ?>
    <script type="text/javascript">
        function getPageHeight() {
            return (document.getElementById('main_page_popup').offsetHeight);
        }
    </script>
    <script>
        $(function(){
            $('.slideShow').bxSlider({mode:'horizontal',auto:true,infiniteLoop:true,pause:3500,speed:1250,pager:false,controls:true});
            $('.popupgallery a').click(function(){
                var imagePath = $(this).attr('href');
                $('.bigimagepopup').html('<img width="301" height="286" src="'+ imagePath +'" />');
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
</head>
<body> 
<div class="popup" id="main_page_popup">
<nav>
<?php echo $this->Form->create('Product',array('id'=>'ProductDetail','url'=>'/shopping_carts/addtocart','type'=>'post')); ?>
<div class="cut">
    <p>CLOSE<a href="javascript:parent.closePopUp();"><?php echo $this->Html->image('cut.png',array('align'=>'right'));?></a></p>
</div>
<h1><?php echo '#'.$productDetail['Product']['article_no'].' '.strtoupper($productDetail['Product']['name']);?> 
    Price:
    <?php
        if($productDetail['Product']['price_actual']!=0){
        ?><strong><strike><?php echo CURRENCY_SYMBOL.number_format($productDetail['Product']['price_actual'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></strike></strong>
        <span><?php echo CURRENCY_SYMBOL.number_format($productDetail['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></span>
        <?php
            }else{
        ?><strong><?php echo CURRENCY_SYMBOL.number_format($productDetail['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></strong><?php    
        }
    ?> 
</h1>

<div class="popupdetail">
<div id="errormsg" style="margin-bottom: 15px;text-decoration:none;font-family:Georgia, "Times New Roman", Times, serif;></div>
<?php
    $attribute_value=array();
    foreach($ProductAttributes as $value){
        $attribute_id=$value['id']; 
        if(!empty($value[$value['name']])){
            /*foreach($value[$value['name']] as $val){
            $attribute_value[$val['id']]=ucfirst($val['name']);
            }*/  
        ?>

        <div class="sige full-width">
        <h4><?php echo $value['name']?>:</h4>
        <?php //echo $this->Form->input("attributes.".$attribute_id,array('label'=>false,'id'=>"attributes_".$attribute_id,'options'=>$attribute_value,"div"=>false));?>
        <?php echo $this->Form->input("attributes.".$attribute_id,array('label'=>false,'id'=>"attributes_".$attribute_id,"div"=>false,'type'=>'hidden','value'=>''));?>
        <div id="box<?php echo $attribute_id;?>" >
        <?php
            foreach($value[$value['name']] as $val){
                $attribute_value[$val['id']]=ucfirst($val['name']);
                
                if(empty($val['quantity']) && $value['id']==1)
                $class_for_availability='attr un-available';
                else
                $class_for_availability='attr available';
            ?>
            <div class="<?php echo $class_for_availability;?>" id="attr<?php echo $val['id'];?>" params="<?php echo $value['id'];?>,<?php echo $val['id'];?>">
            <?php echo ucfirst($val['name']);?>
            </div>                
            <?php
                }    
        ?>
        </div>    
        </div>
        <div class="clear"></div>
        <?php
            }
        unset($attribute_value);
    }
?>
<!--<div class="reating">
<h3>Ring Size Guide<img src="images/guide.png"><br> reting<img src="images/red_ster.png"><img src="images/red_ster.png"><img src="images/red_ster.png"><img src="images/red_ster.png"><img src="images/ster.png"></h3>
</div>-->
<p><?php echo $productDetail['Product']['description'];?></p>
<div class="full_detail">
<?php 
    if(!empty($productDetail['Product']['metal'])){
    ?><p> Metal: <?php echo $productDetail['Product']['metal'];?></p><?php
        }
    if(!empty($productDetail['Product']['measure_band'])){
    ?><p> Measurement Band: <?php echo $productDetail['Product']['measure_band'];?></p><?php
        }
    if(!empty($productDetail['Product']['stone_length'])){
    ?><p>Stone Length: <?php echo $productDetail['Product']['stone_length'];?></p><?php
        }
    if(!empty($productDetail['Product']['weight'])){
    ?><p>Weight: <?php echo $productDetail['Product']['weight'];?></p><?php
        }
    if(!empty($productDetail['Product']['measure_width'])){
    ?><p>Measurement Width: <?php echo $productDetail['Product']['measure_width'];?></p><?php
        }
    if(!empty($productDetail['Product']['stone_width'])){
    ?><p>Stone Width: <?php echo $productDetail['Product']['stone_width'];?></p><?php
        }
    if(!empty($productDetail['Product']['finishing'])){
    ?><p>Finishing: <?php echo $productDetail['Product']['finishing'];?></p><?php
        }
    if(!empty($productDetail['Product']['measure_height'])){
    ?><p>Measurement Height: <?php echo $productDetail['Product']['measure_height'];?></p><?php
        }
    if(!empty($productDetail['Product']['stone_depth'])){
    ?><p>Stone Depth: <?php echo $productDetail['Product']['stone_depth'];?></p><?php
        }
    if(!empty($productDetail['Product']['cirumference'])){
    ?><p>Cirumference: <?php echo $productDetail['Product']['cirumference'];?></p><?php
        }
?>
</div>

<ul>
<li>
<?php
    if(AuthComponent::user('id'))
    {?>
    <?php echo $this->Html->image('add.png');?><a href="javascript://" onclick="addto_wishlist(<?php echo $this->request->params['pass'][0];?>)">Add to Wishlist</a> 
    <?php
        }else{
    ?><?php echo $this->Html->image('add.png');?><a href="javascript://" onclick="addto_wishlist(0)">Add to Wishlist</a>
    <?php    
    }
?>
</li>
<li>
<?php
    if(AuthComponent::user('id'))
    {?>
    <?php echo $this->Html->image('email.png');?> <a href="javascript:popup('<?php echo SITE_URL.'products/email_to_friend/'.$this->request->params['pass'][0];?>');" class="quick-view">Email to Friend</a>
    <?php
        }else{
    ?><?php echo $this->Html->image('email.png');?><a href="javascript://" onclick="email_to_friend(0)">Email to Friend</a>
    <?php    
    }
?>
</li>
<li>Share: <a href="http://www.facebook.com/sharer.php?s=100&p[url]=<?php echo urlencode($this->Html->url(null, true));?>&p[images][0]=<?php echo urlencode(SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$productDetail['Product']['image']); ?>&p[title]=<?php echo urlencode(strip_tags($productDetail['Product']['name']));?>&p[summary]=<?php echo urlencode(String::truncate(strip_tags($productDetail['Product']['description']), 50));?>" target="_blank" ><?php echo $this->Html->image('facebook.png');?></a><a href="http://twitter.com/home?status=<?php echo urlencode($this->Html->url(null, true)); ?>" target="_blank"><?php echo $this->Html->image('twitter.png');?></a><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($this->Html->url(null, true));?>&media=<?php echo urlencode(SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$productDetail['Product']['image']); ?>&description=<?php echo urlencode(String::truncate(strip_tags($productDetail['Product']['description']), 50)); ?>" target="_blank"><?php echo $this->Html->image('pintrest.png');?></a><a href="https://plus.google.com/share?url=<?php echo urlencode($this->Html->url(null, true)); ?>" target="_blank" ><?php echo $this->Html->image('google.png');?></a></li>
</ul>  
</div>
<div class="popupchackout">
<div class="bigimagepopup">
<?php 
    $image_exist = PRODUCT_IMAGE_UPLOAD.$productDetail['Product']['image'];
    if(file_exists($image_exist) && $productDetail['Product']['image']!='')
    echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$productDetail['Product']['image'],array('width'=>'301','height'=>'286'));
    else
    echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg',array('width'=>'301','height'=>'286'));
?>
</div>
</div>
<div class="popupgallery">
<a href="<?php echo SITE_URL.PRODUCT_IMAGE_UPLOAD.'large/'.$productDetail['Product']['image'];?>">
<?php echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$productDetail['Product']['image'],array('width' =>'95px','height'=>'95px','alt'=>''));?>
</a>
<?php
    foreach($productDetail['ProductImage'] as $k=>$galleryimage){
    ?>
    <a href="<?php echo SITE_URL.PRODUCT_IMAGE_UPLOAD.'large/'.$galleryimage['product_image'];?>">
    <?php echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$galleryimage['product_image'],array('width' =>'95px','height'=>'95px','alt'=>'')); ?> 
    </a>
    <?php
        }
?>
<h4>QTY:</h4>
<?php
    $product_price=$productDetail['Product']['price'];
    $product_id=$productDetail['Product']['id'];
    echo $this->Form->input("product_id", array('type' => 'hidden', 'id' => 'product_id','value'=>$product_id));
    echo $this->Form->input("price", array('type' => 'hidden', 'id' => 'price', 'value' => $product_price));
    echo $this->Form->input('quantity',array('label'=>false,'id'=>'quantity',"div"=>false,'class'=>'popupquantity','maxlength'=>2,'style'=>'text-decoration:none;color:#616161;font-family:Georgia, "Times New Roman", Times, serif;'));
    echo $this->Form->input("from_popup", array('type' => 'hidden', 'id' => 'from_popup','value'=>1));
    echo $this->Form->button("Add To Cart",array('type'=>'button','label'=>false,'onclick'=>'check_quantity()'));
?>
            </div>
        </div>
        </div>
        <?php echo $this->Form->end();?>
        </nav>
    </body>
</html>    
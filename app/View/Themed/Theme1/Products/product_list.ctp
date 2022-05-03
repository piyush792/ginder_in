<?php echo $this->Html->script("popup"); ?>
<script type="text/javascript">
    function getPageHeight() {
        return (document.getElementById('main_page').offsetHeight);
    }
</script>
<script type="text/javascript">
    var scale_range_st=<?php echo $price_min;?>;
    var scale_range_en=<?php echo $price_max;?>;
    var start_range_st=<?php echo $price_start;?>; 
    var start_range_en=<?php echo $price_end;?>; 

    $(function () {
        var init = function () {
            if ($('#disable').is(':checked')) {
                $(".noUiSlider").noUiSlider('enable');
                $('#disable').attr('checked', false);
            }
            var stepSetting = false;
            if ($("#valueInput input[type='checkbox']").is(':checked')) {
                stepSetting = 1;
            }
            $(".noUiSlider").empty().noUiSlider('init', {
                step: <?php echo $stepmove;?>,
                change: function () {
                    var values = $(this).noUiSlider('value');
                    $(this).find('.noUi-lowerHandle .infoBox').text('Rs '+values[0]);
                    $(this).find('.noUi-upperHandle .infoBox').text('Rs '+values[1]);

                    $('#price_search').val(values); 

                },
                end: function (type) {
                    var message = "The slider was last changed by ";
                    if (type == "click") {
                        message = message + "clicking the bar.";
                    } else if (type == "slide") {
                        message = message + "sliding a handle.";
                    } else if (type == "move") {
                        message = message + "calling the move function.";
                    }
                    $("#slideType").fadeOut(function () {
                        $(this).text(message).fadeIn();
                    });
                    var frmData = jQuery('#ProductProductListForm').serialize();
                    jQuery.triggerProductsSearchForm(frmData);
                },
                scale: [scale_range_st,scale_range_en],
                start: [start_range_st,start_range_en]
            }).find('.noUi-handle div').each(function (index) {
                $(this).append('<span class="infoBox">Rs ' + $(this).parent().parent().noUiSlider('value')[index] + '</span>');
            });
        };
        init.call();
        $("#goNow").click(trigger);
        $("#snap").change(init);
        $('#disable').change(function () {
            if ($(this).is(':checked')) {
                $(".noUiSlider").noUiSlider('disable');
            } else {
                $(".noUiSlider").noUiSlider('enable');
            }
        });
    });
    var trigger = function () {
        $(".noUiSlider").noUiSlider('move', {
            handle: $("#whichKnob").val(),
            to: $("#valueInput input").val()
        })
    };
</script> 
<script type="text/javascript">
    function check_orderby(orderby_value){
         $('#order_by').val(orderby_value); 
         var frmData = jQuery('#ProductProductListForm').serialize();
         jQuery.triggerProductsSearchForm(frmData);
    }
    
    function uncheck_selection(uncheck_value){
         $('#'+uncheck_value).attr('checked',false);
         var frmData = jQuery('#ProductProductListForm').serialize();
         jQuery.triggerProductsSearchForm(frmData);
    }
</script>

<!--MAIN PAGE CONTENT START-->
<div class="clearfix"></div>
  <div class="page-breadcrumb">
    <span class="page-breadcrumb-item"><?php echo $this->Html->link('Home', '/index');?></span>    
    <span class="page-breadcrumb-item"><?php echo '<a href="'.SITE_URL.'products/show_category/'.$cat_name['Category']['id'].'">'.$cat_name['Category']['name'].'</a>'; ?></span>
    <span class="page-breadcrumb-currentitem"><?php echo $main_category_data['Category']['name'];?></span>
  </div>

<div class="middle-content-advert">
    <!-- filter section start -->
    <div id='ctrl-mobile-filter' class="mobile-filter-ctrl">
    Filter
    </div>
    <section id='ctrl-filter-sidebar' class='sitebar filter-sidebar'>
    <?php echo $this->Form->create('Product', array('url' =>'product_list/'.$this->request->params['pass'][0])); ?>
        <div class='filter-section' style="min-height: auto;">
            <div class='heading'>Filters <span id='ctrl-filter-close' class="glyphicon glyphicon-remove-circle"></span></div>
        </div>
        <?php
        // echo "<pre>";
        // print_r($leftArr);    
        $YourSelection=array();  
            
        foreach($leftArr as $values){
        ?>
        <div class='filter-section'>
            <div class='heading'><?php echo $values['name']?></div>
            <div class="filter-options">
                <ul class="filter-item-wrapper">
                    <?php
                    foreach($values[$values['name']] as $newVal){
                        if($this->Session->read('SessionLeftFilter.Product.'.$values['name'].'_'.$newVal['id'])!=0){
                        $checked = true;
                        $YourSelection['Product'.$values['name'].$newVal['id']]=$newVal['name']; 
                        }else{
                        $checked = false; 
                        }
                    ?>
                        <li class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <!-- <input type="checkbox" class="custom-control-input" id="EbeeCheck" name="bandsItems"> -->
                                <?php
                                echo $this->Form->input($values['name'].'_'.$newVal['id'],array("type" => "checkbox","id"=>$newVal['name']."Check",'value'=>$newVal['id'],'label' =>false,'div' =>false,'checked' =>$checked, 'class'=>"custom-control-input"));
                                ?>
                                <label class="custom-control-label" for="<?php echo $newVal['name'];?>Check"><?php echo ucfirst($newVal['name']);?></label>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php
        }
        ?>
        
        <?php
        if(!empty($price_min) && !empty($price_max)){
        ?>
        <div class='filter-section' style='border-bottom:none;'>
            <div class='heading'>Price</div>
            <div class="noUiSlider" id="noUiSlider"></div>
        </div>
        <?php } ?>
        <?php echo $this->Form->input('price_search',array('type'=>'hidden','label'=>false,'id'=>'price_search',"div"=>false,'size'=>40)); ?>

        <?php 
        if($this->Session->read('SessionLeftFilter.Product.order_by'))
        $order_by=$this->Session->read('SessionLeftFilter.Product.order_by');
        else
        $order_by='newest';
        echo $this->Form->input('order_by',array('type'=>'hidden','label'=>false,'id'=>'order_by',"div"=>false,'value'=>$order_by)); 
        ?>
        <?php
        echo $this->Form->end();
        //print_r($YourSelection);
        ?>
    </section>
    <!-- filter section end -->    
    <!-- <div style="clear: both;"></div> -->

    <?php 
    if(count($list_featured_products)>0 || count($productListArray) > 0){
        // print_r($list_featured_products);
    ?>    
    <!-- Advert Content start -->



    <div class="jewelerycat">
        <ul> 
            <li>Your selections:</li>
            <?php
            if(count($YourSelection)>0){
                //  echo "<pre>";
                //  print_r($YourSelection);
                foreach($YourSelection as $SelectionKey=>$SelectionValue){
                ?><li><a href="javascript:void(0);" onclick="uncheck_selection('<?php echo $SelectionKey;?>');"><?php echo $SelectionValue;?><?php echo $this->Html->image('crossicon.png'); ?></a></li><?php   
                }
            }
            ?>
        </ul>    
    </div>                                                                           
    <?php 
    if($this->Session->read('SessionLeftFilter.Product.order_by'))
    $SelectionOrder=$this->Session->read('SessionLeftFilter.Product.order_by');
    else
    $SelectionOrder ='newest';
    ?>
    <div class="jewelery">
        <ul>
            <li><a href="javascript:void(0);" onclick="check_orderby('premium');" style="color:<?php echo ($SelectionOrder=='premium')?'#0AA4EA':'';?>">Premium Ads</a></li>
            <li><a href="javascript:void(0);" onclick="check_orderby('newest');" style="color:<?php echo ($SelectionOrder=='newest')?'#0AA4EA':'';?>">Newest</a></li>
            <li><a href="javascript:void(0);" onclick="check_orderby('highest');" style="color:<?php echo ($SelectionOrder=='highest')?'#0AA4EA':'';?>">Highest Price</a></li>
            <li><a href="javascript:void(0);" onclick="check_orderby('lowest');" style="color:<?php echo ($SelectionOrder=='lowest')?'#0AA4EA':'';?>">Lowest Price</a></li>
            <!-- <li><a href="javascript:void(0);" onclick="check_orderby('rating');" style="color:<?php echo ($SelectionOrder=='rating')?'#0AA4EA':'';?>">Customer Rating</a></li>                 -->
        </ul>    
    </div>

    <div class="category-right-siderbar">
    <div id="errormsg" align="center"><?php echo $this->Session->flash();?></div>         
      <?php
      if(count($list_featured_products)> 0){
      ?>
      <section class="premium-ads-wrapper">
        <header>
          <h2 class="section-heading">Premium Ads</h2>
        </header>
        <div class="card-deck">
            <?php
            for($i=0;$i<count($list_featured_products);$i++)
            {
                if($i % 5 == 0){
                    echo "</div><div class='card-deck'>";
                }
            ?>
            <div class="card">
                <?php
                $image_exist = PRODUCT_IMAGE_UPLOAD.$list_featured_products[$i]['Product']['image'];
                $gallery_image_exist = PRODUCT_IMAGE_UPLOAD.$list_featured_products[$i]['ProductImages']['product_image'];  // get the first gallery image

                if(file_exists($image_exist) && $list_featured_products[$i]['Product']['image']!=''){
                    $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$list_featured_products[$i]['Product']['image'];
                }
                else if(file_exists($gallery_image_exist) && $list_featured_products[$i]['ProductImages']['product_image']!=''){
                    $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$list_featured_products[$i]['ProductImages']['product_image'];
                }
                else{
                    $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg';
                }
                echo $this->Html->image($product_image,array("class"=>"card-img-top","alt"=>"Card image cap"));
                ?>
                <?php
                if(AuthComponent::user('id'))
                {
                ?>
                <a href="javascript://" onclick="addto_wishlist(<?php echo $list_featured_products[$i]['Product']['id'];?>)"><div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom" title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div></a>
                <?php
                }
                else
                {
                ?>
                <a href="javascript://" onclick="addto_wishlist(0)"><div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom" title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div></a>
                <?php
                }
                ?>
            <div class="card-body">
                    <a class="card-title" href="<?php echo SITE_URL."products/detail/".$list_featured_products[$i]['Product']['id']."/".$list_featured_products[$i]['Product']['name'];?>">
                        <?php echo $list_featured_products[$i]['Product']['name'];?>
                    </a>
                    <h4>
                    <?php echo CURRENCY_SYMBOL." ".number_format($list_featured_products[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?>
                    </h4>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
      </section>
      <?php
      }
      ?>

      <?php
        if(count($productListArray)> 0){
        ?>
        <section class="recent-ads-wrapper">
            <header>
            <h2 class="section-heading">Recent Ads</h2>
            </header>
            <div class="card-deck">
                <?php
                for($i=0;$i<count($productListArray);$i++)
                {
                    if($i % 5 == 0){
                        echo "</div><div class='card-deck'>";
                    }
                ?>
                <div class="card">
                    <?php
                    $image_exist = PRODUCT_IMAGE_UPLOAD.$productListArray[$i]['Product']['image'];
                    $gallery_image_exist = PRODUCT_IMAGE_UPLOAD.$productListArray[$i]['ProductImages']['product_image'];  // get the first gallery image

                    if(file_exists($image_exist) && $productListArray[$i]['Product']['image']!=''){
                        $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$productListArray[$i]['Product']['image'];
                    }else if(file_exists($gallery_image_exist) && $productListArray[$i]['ProductImages']['product_image']!=''){
                        $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$productListArray[$i]['ProductImages']['product_image'];
                    }else{
                        $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg';
                    }
                    echo $this->Html->image($product_image,array("class"=>"card-img-top","alt"=>"Card image cap"));
                    ?>
                    <?php
                    if(AuthComponent::user('id'))
                    {
                    ?>
                    <a href="javascript://" onclick="addto_wishlist(<?php echo $productListArray[$i]['Product']['id'];?>)"><div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom" title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div></a>
                    <?php
                    }
                    else
                    {
                    ?>
                    <a href="javascript://" onclick="addto_wishlist(0)"><div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom" title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div></a>
                    <?php
                    }
                    ?>
                <div class="card-body">
                        <a class="card-title" href="<?php echo SITE_URL."products/detail/".$productListArray[$i]['Product']['id']."/".$productListArray[$i]['Product']['name'];?>">
                            <?php echo $productListArray[$i]['Product']['name'];?>
                        </a>
                        <h4>
                        <?php echo CURRENCY_SYMBOL." ".number_format($productListArray[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?>
                        </h4>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </section>
        <?php
        }
       ?>
    </div>
    <!-- Advert Content end -->

    <div class="paginations">
        <ul>
        <?php 
            // echo $this->Paginator->options(array('update' =>'#productdata'));            
            // echo $this->Paginator->prev("",array('escape'=>false,'tag'=>'li'), null, array('class'=>'previous disabled','escape'=>false,'tag'=>'li'));
            // echo $this->Paginator->numbers(array('tag'=>'li','separator'=>'','ellipsis' =>'...','currentClass'=>'active'));
            // echo $this->Paginator->next("", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
            // echo $this->Js->writeBuffer();
        ?>
        </ul>
    </div>
    <?php
    }else{
    ?>
    <div class="produtsrings" style="height: 300px;">
    <!-- <div class="alert alert-danger" role="alert"> -->
        <span class="alert alert-danger">we are sorry but there are no ads available in this category</span>        
    </div>
    <?php
    }
    ?>
</div>
<!--MAIN PAGE CONTENT END-->
<?php //echo $this->element('sql_dump'); ?>

<script type="text/javascript">
    function addto_wishlist(product_id)
    {
        if(product_id==0){
            jQuery("#errormsg").html('<span class="text-danger">Please Login To Add Product In Favorite !</span>');    
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
</script>

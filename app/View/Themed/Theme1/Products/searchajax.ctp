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
                    $(this).find('.noUi-lowerHandle .infoBox').text('$'+values[0]);
                    $(this).find('.noUi-upperHandle .infoBox').text('$'+values[1]);

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
                    var frmData = jQuery('#ProductSearchajaxForm').serialize();
                    jQuery.triggerProductsSearchForm(frmData);
                },
                scale: [scale_range_st,scale_range_en],
                start: [start_range_st,start_range_en]
            }).find('.noUi-handle div').each(function (index) {
                $(this).append('<span class="infoBox">$' + $(this).parent().parent().noUiSlider('value')[index] + '</span>');
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
         var frmData = jQuery('#ProductSearchajaxForm').serialize();
         jQuery.triggerProductsSearchForm(frmData);
    }
    
    function uncheck_selection(uncheck_value){
         $('#'+uncheck_value).attr('checked',false);
         var frmData = jQuery('#ProductSearchajaxForm').serialize();
         jQuery.triggerProductsSearchForm(frmData);
    }
</script>
 
<!--LEFT MENU CONTENT START--> 
<?php echo $this->Form->create('Product', array('url' =>'searchajax/')); ?>
<div class="sitebar">
<h4>SEARCH RESULTS</h4>
<?php
$YourSelection=array();
/*if(count($list_subcategory)>0){
?>
  <h2>SubCategory</h2>
  <?php
    foreach($list_subcategory as $value){
        if($this->Session->read('SessionLeftFilter.Product.subcat_'.$value['Category']['id'])!=0){
           $checked = true;
           $YourSelection['ProductSubcat'.$value['Category']['id']]=$value['Category']['name']; 
        }else{
           $checked = false; 
        }
       echo $this->Form->input('subcat_'.$value['Category']['id'],array('type'=>'checkbox','value'=>$value['Category']['id'],'label'=>false,'div' =>false,'checked'=>$checked))
  ?>   <label><?php echo $value['Category']['name'];?></label><br>
<?php
    }
}  */

foreach($leftArr as $values){
?>   
    <h2><?php echo $values['name']?></h2>
    <?php
    foreach($values[$values['name']] as $newVal){
        
        if($this->Session->read('SessionLeftFilter.Product.'.$values['name'].'_'.$newVal['id'])!=0){
           $checked = true;
           $YourSelection['Product'.$values['name'].$newVal['id']]=$newVal['name']; 
        }else{
           $checked = false; 
        }
       echo $this->Form->input($values['name'].'_'.$newVal['id'],array("type" => "checkbox",'value'=>$newVal['id'],'label' =>false,'div' =>false,'checked' =>$checked))
    ?>
       <label><?php echo ucfirst($newVal['name']);?></label><br>
   <?php 
    }
}

if(!empty($price_min) && !empty($price_max)){
?>
<h2>Price</h2>
<div class="noUiSlider" id="noUiSlider"></div>
<?php } ?>
<br /><br />
<?php echo $this->Form->input('price_search',array('type'=>'hidden','label'=>false,'id'=>'price_search',"div"=>false,'size'=>40)); ?>
</div>

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
<!--LEFT MENU CONTENT END--> 

<!--MAIN PAGE CONTENT START--> 
<div class="jewelerycat">
   <ul> 
         <li>Your selections:</li>
         <?php
         if(count($YourSelection)>0){
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
          <li><a href="javascript:void(0);" onclick="check_orderby('newest');" style="color:<?php echo ($SelectionOrder=='newest')?'#0AA4EA':'';?>">Newest</a></li>
          <li><a href="javascript:void(0);" onclick="check_orderby('highest');" style="color:<?php echo ($SelectionOrder=='highest')?'#0AA4EA':'';?>">Highest Price</a></li>
          <li><a href="javascript:void(0);" onclick="check_orderby('lowest');" style="color:<?php echo ($SelectionOrder=='lowest')?'#0AA4EA':'';?>">Lowest Price</a></li>
          <li><a href="javascript:void(0);" onclick="check_orderby('rating');" style="color:<?php echo ($SelectionOrder=='rating')?'#0AA4EA':'';?>">Customer Rating</a></li>                
     </ul>    
</div>

<div> 
<?php 
if(count($productListArray)>0){
?>    
  <div class="produtsrings">
    <ul>
       <?php 
       for($i=0;$i<count($productListArray);$i++)
       {
       ?> 
            <li>
                <div class="listItem">
                <a href="<?php echo SITE_URL."products/detail/".$productListArray[$i]['Product']['id'];?>">
                <?php
                    $image_exist = PRODUCT_IMAGE_UPLOAD.$productListArray[$i]['Product']['image'];
                    if(file_exists($image_exist) && $productListArray[$i]['Product']['image']!='')
                    $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$productListArray[$i]['Product']['image'];
                    else
                    $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg';
                    echo $this->Html->image($product_image,array('width' =>'216','height'=>'179'));
                    if($productListArray[$i]['Product']['price_actual']!=0){
                    ?> <div class="salerRed"></div>
                    <?php 
                    }elseif($productListArray[$i]['Product']['new_product']!=0){
                    ?> <div class="salerBlue"></div>
                    <?php 
                    }
                    ?> 
                    </a>
                    
                    <a href="javascript:popup('<?php echo SITE_URL.'products/product_popup/'.$productListArray[$i]['Product']['id'];?>');" class="quick-view"></a>
                    <p><?php echo $productListArray[$i]['Product']['name'];?></p>
                    <h4>
                    <?php
                    if($productListArray[$i]['Product']['price_actual']!=0){
                    ?><strike><?php echo CURRENCY_SYMBOL.number_format($productListArray[$i]['Product']['price_actual'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></strike>
                      <span><?php echo CURRENCY_SYMBOL.number_format($productListArray[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></span>
                    <?php
                    }else{
                      echo CURRENCY_SYMBOL.number_format($productListArray[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);
                    }
                    ?>
                    </h4>
                </div>
           </li>
       <?php
       }
       ?>
   </ul>
</div>

  <div class="paginations">
  <ul>
  <?php 
        echo $this->Paginator->options(array('update' =>'#productdata'));
        
        echo $this->Paginator->prev("",array('escape'=>false,'tag'=>'li'), null, array('class'=>'previous disabled','escape'=>false,'tag'=>'li'));
        echo $this->Paginator->numbers(array('tag'=>'li','separator'=>'','ellipsis' =>'...','currentClass'=>'active'));
        echo $this->Paginator->next("", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
        
        echo $this->Js->writeBuffer();
    ?>
    </ul>
  </div>
<?php
 }else{
 ?>
   <div class="produtsrings" style="height: 300px;">
     <ul> <li>we are sorry but there are no ads available in this category</li></ul>
   </div>
<?php
 }
?>
</div>
<!--MAIN PAGE CONTENT END-->
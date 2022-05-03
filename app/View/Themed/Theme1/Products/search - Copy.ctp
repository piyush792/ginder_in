<?php
$this->start('inline');
echo $this->Html->css('nouislider');
echo $this->Html->script("nouislider");
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
         get_product_listing();
         
         jQuery(document).on('click',".sitebar input[type='checkbox']",function(){  
             var frmData = jQuery('#ProductSearchajaxForm').serialize();
            jQuery.triggerProductsSearchForm(frmData);
        }); 
    });

    function get_product_listing()
    {
         var siteUrl= '<?php echo SITE_URL;?>';
         var url=siteUrl+"products/searchajax/";
         jQuery('#productdata').html('<div align="center"><img  src="'+siteUrl+'img/loading_big.gif"></div>');
         jQuery.post(url,{},function(data){
            jQuery("#productdata").html(data);
        });
    }   

   jQuery.triggerProductsSearchForm = function(frmData)
   {
       var siteUrl= '<?php echo SITE_URL;?>';
       
       var url=siteUrl+"products/searchajax/";
        jQuery.ajax({
           type:'POST',
                url: url,
                data:frmData,
                dataType:'text',
                beforeSend:function(){
                   jQuery('.listItem').html('<img  src="'+siteUrl+'img/loading.gif">');
                },success:function(responseData,status,XMLHttpRequest){
                    var result = responseData;
                   jQuery('#productdata').html(result);
                }
            });
    };
</script>   
<?php
$this->end();
?> 
<div class="pagewrap">
  <nav id='productdata'></nav>
</div>
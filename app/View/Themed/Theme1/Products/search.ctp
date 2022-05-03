<div class="clearfix"></div>
<!-- search result section start -->
<?php
$count_productSearch=count($productSearch);
if($count_productSearch>0){
?>
<section class="recent-ads-wrapper">
  <header>
    <h3 class="section-heading">Showing <?php echo $count_productSearch;?> Results</h3>
  </header>

    <div id="errormsg" align="center"><?php echo $this->Session->flash();?></div>            
    <div class="card-deck">
    <?php
    if($keyword!='')     
    {
        $this->Paginator->options(array('url' => array('keyword' => $keyword)));    
    }
    
    for ($i = 0; $i < $count_productSearch; $i++) 
    {
        if($i % 6 == 0){
            echo "</div><div class='card-deck'>";
        }
        ?>            
            <div class="card">
                <a href="<?php echo SITE_URL."products/detail/".$productSearch[$i]['Product']['id']."/".$productSearch[$i]['Product']['name'];?>">
                    <?php
                    $image_exist = PRODUCT_IMAGE_UPLOAD . $productSearch[$i]['Product']['image'];
                    if (file_exists($image_exist) && $productSearch[$i]['Product']['image'] != '')
                        echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . $productSearch[$i]['Product']['image'], array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
                    else
                        echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . 'no_image.jpg', array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
                    ?>
                </a>

                <?php
                    if(AuthComponent::user('id'))
                    {
                    ?>
                    <a href="javascript://" onclick="addto_wishlist(<?php echo $productSearch[$i]['Product']['id'];?>)"><div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom" title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div></a>
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
                    <a class="card-title" href="<?php echo SITE_URL."products/detail/".$productSearch[$i]['Product']['id']."/".$productSearch[$i]['Product']['name'];?>"><?php echo $productSearch[$i]['Product']['name']; ?></a>
                    <h4><?php echo CURRENCY_SYMBOL." ".number_format($productSearch[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></h4>
                </div>
            </div>        
        <?php
    }
    ?>
    </div>

    <!-- <div class="pagination-wrapper">
        <ul class="pagination">
            <?php 
                // echo $this->Paginator->first("First", array('escape'=>false,'tag'=>'li'), null, array('class' => 'first disabled','escape'=>false,'tag'=>'li'));
                // echo $this->Paginator->prev("&larr; Previous", array('escape'=>false,'tag'=>'li'), null, array('class' => 'prev disabled','escape'=>false,'tag'=>'li'));
                // echo '&nbsp;'.$this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active')); 
                // echo $this->Paginator->next("Next &rarr;", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                // echo $this->Paginator->last("Last", array('escape'=>false,'tag'=>'li'), null, array('class' => 'last disabled','escape'=>false,'tag'=>'li'));
            ?>
        </ul>
    </div> -->
</section>
<?php
 }else{
 ?>
 <section class="recent-ads-wrapper  col-sm-5 col-lg-5">
   <div class="alert alert-warning">
   we are sorry but there are no ads available in this category
   </div>
 </section>
<?php
 }
?>
<!-- product search section end -->
<?php //echo $this->element('sql_dump'); ?>
<script type="text/javascript">
    function addto_wishlist(product_id)
    {
        if(product_id==0){
            jQuery("#errormsg").html('<span style="color: red;">Please Login To Add Product In Favorite !</span>');    
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
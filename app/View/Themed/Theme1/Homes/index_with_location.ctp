<div class="clearfix">&nbsp;</div>
<div id="errormsg" align="center"><?php echo $this->Session->flash();?></div>
<div class="clearfix"></div>
<!-- featured section start -->
<!-- <section class="featured-ads-wrapper">
  <header>
    <h2 class="section-heading">Featured Ads</h2>
  </header>
  
  <ul class="featuredbxslider">
    <?php
    // $count_featuredList=count($featuredList);
    // for ($i = 0; $i < $count_featuredList; $i++) {
        ?>
        <li>
          <div class="card">
            <a href="<?php //echo SITE_URL."products/detail/".$featuredList[$i]['Product']['id'];?>">
                <?php
                // $image_exist = PRODUCT_IMAGE_UPLOAD . $featuredList[$i]['Product']['image'];
                // if (file_exists($image_exist) && $featuredList[$i]['Product']['image'] != '')
                //     echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . $featuredList[$i]['Product']['image'], array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
                // else
                //     echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . 'no_image.jpg', array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
                ?>
            </a>
            <?php
                // if(AuthComponent::user('id'))
                // {
                // ?>
                // <a href="javascript://" onclick="addto_wishlist(<?php //echo $featuredList[$i]['Product']['id'];?>)"><div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom" title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div></a>
                // <?php
                // }
                // else
                // {
                // ?>
                // <a href="javascript://" onclick="addto_wishlist(0)"><div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom" title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div></a>
                // <?php
                // }
            ?>
            <div class="card-body">
              <a class="card-title" href="<?php //echo SITE_URL."products/detail/".$featuredList[$i]['Product']['id'];?>"><?php //echo $featuredList[$i]['Product']['name']; ?></a>
              <h4><?php //echo CURRENCY_SYMBOL." ".number_format($featuredList[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></h4>
            </div>
          </div>
        </li>
        <?php
    //}
    ?>    
  </ul>
</section> -->
<!-- featured section end --> 

<!-- recent ads section start -->
<section class="recent-ads-wrapper">
  <header>
    <h2 class="section-heading">Recent Ads</h2>
  </header>

  <div class="card-deck">
    <?php
      $count_recentList=count($recentList);
      for ($i = 0; $i < $count_recentList; $i++) {
        if($i % 5 == 0){
          echo "</div><div class='card-deck'>";
        }
      ?>    
        <div class="card">
          <a href="<?php echo SITE_URL."products/detail/".$recentList[$i]['Product']['id']."/".$recentList[$i]['Product']['name'];?>">
            <?php
              $image_exist = PRODUCT_IMAGE_UPLOAD.$recentList[$i]['Product']['image'];  // get the product image
              $gallery_image_exist = PRODUCT_IMAGE_UPLOAD.$recentList[$i]['ProductImages']['product_image'];  // get the first gallery image
              if(file_exists($image_exist) && $recentList[$i]['Product']['image']!=''){
                echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$recentList[$i]['Product']['image'],array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
              }
              else if(file_exists($gallery_image_exist) && $recentList[$i]['ProductImages']['product_image']!=''){
                echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$recentList[$i]['ProductImages']['product_image'],array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
              }
              else{
                echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg',array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
              }
            ?>
          </a>
          <?php
                if(AuthComponent::user('id'))
                {
                ?>
                <a href="javascript://" onclick="addto_wishlist(<?php echo $recentList[$i]['Product']['id'];?>)"><div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom" title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div></a>
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
            <a class="card-title" href="<?php echo SITE_URL."products/detail/".$recentList[$i]['Product']['id']."/".$recentList[$i]['Product']['name'];?>"><?php echo $recentList[$i]['Product']['name']; ?></a>
            <h4><?php echo CURRENCY_SYMBOL." ".number_format($recentList[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></h4>
          </div>
        </div>
      <?php
      }
      ?>    
  </div>

</section>
<!-- recent ads sectioin end -->

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

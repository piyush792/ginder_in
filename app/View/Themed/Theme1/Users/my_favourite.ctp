<div class="clearfix">&nbsp;</div>
<div id="errormsg" align="center"><?php echo $this->Session->flash();?></div>
<div class="clearfix"></div>

<!-- My favourite section start -->
<section class="recent-ads-wrapper">
  <header>
    <h2 class="section-heading">My favourite Lists</h2>
  </header>

  <div class="card-deck">
    <?php
      $count_FavouriteList=count($myFavouriteList);
      for ($i = 0; $i < $count_FavouriteList; $i++) {
        if($i % 5 == 0){
          echo "</div><div class='card-deck'>";
        }
      ?>
        <div class="card">
          <a href="<?php echo SITE_URL."products/detail/".$myFavouriteList[$i]['Product']['id'];?>">
            <?php
              $image_exist = PRODUCT_IMAGE_UPLOAD . $myFavouriteList[$i]['Product']['image'];
              if (file_exists($image_exist) && $myFavouriteList[$i]['Product']['image'] != '')
                  echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . $myFavouriteList[$i]['Product']['image'], array("class"=>"card-img-top",'width' => '196', 'height' => '144'));
              else
                  echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . 'no_image.jpg', array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
            ?>
          </a>
          
          <a href="javascript://" onclick="remove_wishlist(<?php echo $myFavouriteList[$i]['Product']['id'];?>)">
            <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom" title="Remove from Favourite"><span class="glyphicon glyphicon-star fav-active"></span></div>
          </a>
          <div class="card-body">
            <a class="card-title" href="<?php echo SITE_URL."products/detail/".$myFavouriteList[$i]['Product']['id'];?>"><?php echo $myFavouriteList[$i]['Product']['name']; ?></a>
            <h4><?php echo CURRENCY_SYMBOL.number_format($myFavouriteList[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></h4>
          </div>
        </div>
      <?php
      }
      ?>    
  </div>

</section>
<!-- My Favourite sectioin end -->

<script type="text/javascript">
    function remove_wishlist(product_id)
    {
      var siteUrl= '<?php echo SITE_URL;?>';
      var url=siteUrl+"products/remove_wishlist/"+product_id;
      
      var frmData = jQuery('#ProductDetail').serialize(); 
      
      jQuery.ajax({
          type:'POST',
          url: url,
          // data:frmData,
          dataType:'text',
          success:function(responseData){
              var result = responseData;
              jQuery('.recent-ads-wrapper').html(result);
          }
      });
    }
</script>
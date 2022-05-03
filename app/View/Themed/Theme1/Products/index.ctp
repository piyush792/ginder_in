<div class="clearfix"></div>
<!-- featured section start -->
<section class="featured-ads-wrapper">
  <header>
    <h2 class="section-heading">Featured Ads</h2>
  </header>
  <ul class="featuredbxslider">
    <?php
    $count_featuredList=count($featuredList);
    for ($i = 0; $i < $count_featuredList; $i++) {
        ?>
        <li>
          <div class="card"> 
            <a href="<?php echo SITE_URL."products/detail/".$featuredList[$i]['Product']['id'];?>">
                <?php
                $image_exist = PRODUCT_IMAGE_UPLOAD . $featuredList[$i]['Product']['image'];
                if (file_exists($image_exist) && $featuredList[$i]['Product']['image'] != '')
                    echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . $featuredList[$i]['Product']['image'], array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
                else
                    echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . 'no_image.jpg', array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
                ?>
            </a>
            <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
            <div class="card-body">
              <a class="card-title" href="<?php echo SITE_URL."products/detail/".$featuredList[$i]['Product']['id'];?>"><?php echo $featuredList[$i]['Product']['name']; ?></a>
              <h4><?php echo CURRENCY_SYMBOL.number_format($featuredList[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></h4>
            </div>
          </div>
        </li>
        <?php
    }
    ?>    
  </ul>
</section>
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
          <a href="<?php echo SITE_URL."products/detail/".$recentList[$i]['Product']['id'];?>">
            <?php
              $image_exist = PRODUCT_IMAGE_UPLOAD . $recentList[$i]['Product']['image'];
              if (file_exists($image_exist) && $recentList[$i]['Product']['image'] != '')
                  echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . $recentList[$i]['Product']['image'], array("class"=>"card-img-top",'width' => '196', 'height' => '144'));
              else
                  echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . 'no_image.jpg', array("class"=>"card-img-top", 'width' => '196', 'height' => '144'));
            ?>
          </a>
          <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
          <div class="card-body">
            <a class="card-title" href="<?php echo SITE_URL."products/detail/".$recentList[$i]['Product']['id'];?>"><?php echo $recentList[$i]['Product']['name']; ?></a>
            <h4><?php echo CURRENCY_SYMBOL.number_format($recentList[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></h4>
          </div>
        </div>
      <?php
      }
      ?>    
  </div>

</section>
<!-- recent ads sectioin end -->

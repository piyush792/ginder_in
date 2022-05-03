<div class="admin-middle-content">

    <div class='admin-side-menu' id="admin-sidemenu-ctrl">
        <span class="glyphicon glyphicon-menu-hamburger"></span> <span class="txt-admin-side-menu">Side Menu</span>
    </div>

  <!-- Left sidebar section start -->
  <div class='admin-navigation-wrapper'>
    <!-- Left inner start -->
    <?php echo $this->element('user_left_inner'); ?>
    <!-- Left inner end -->
  </div>
  
  <!-- Left sidebar section end --> 
  
  <!-- Right Content start -->
  <div class="admin-adverts-wrapper">
  <span id="error_msg" class="alert-error"><?=$this->Session->flash();?></span>
    <?php
    echo $indexSection;
    for($i=0;$i<count($productList);$i++)
    {
    ?>
    <!-- <section class='admin-adverts-item'>
        <div class='advert-image'>            
            <?php
                if(file_exists(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$productList[$i]['Product']['image']) && ($productList[$i]['Product']['image']<>"")){
                    echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$productList[$i]['Product']['image'], array('height' => '100px'));
                }else{
                    echo $this->Html->image(SITE_URL.NO_IMAGE, array('height' => '100px'));
                }
            ?>
        </div>
        <div class='advert-details-wrapper'> 
        <div class="advert-title col-lg-11 float-left"><?=$productList[$i]['Product']['name'];?></div>
        <div class="advert-edit-wrapper col-lg-1 float-right">
            <?php echo $this->Html->link('<span class="advert-edit-ctrl glyphicon glyphicon-pencil"></span>',array('controller' => 'users', 'action' => 'post_an_edit', $productList[$i]['Product']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));?>    
        </div>
            <section class="product-attribute-wrapper">
                <ul class="admin-product-attribute-content">
                    <?php
                    for($j=0;$j<count($AttributesArray);$j++)
                    {
                    ?>                    
                    <li class="attribute-item">
                        <div class="attribute-label"><?=$AttributesArray[$j]['ProductAttribute']['attribute_code'];?></div>
                        <div class="attribute-value"><?=$AttributesArray[$j]['ProductAttributeValue']['name'];?></div>
                    </li>
                    <?php
                    }
                    ?>
                    <li class="attribute-item">
                        <div class="attribute-label">Price:</div>
                        <div class="attribute-value">
                            <span class="product-price">Rs. <?=$productList[$i]['Product']['price'];?></span>
                            <span class="price-tag">
                            <?php
                            if($productList[$i]['Product']['price_option']==0){
                                echo "Fixed";
                            }else if($productList[$i]['Product']['price_option']==1){
                                echo "Negotiable";
                            }else if($productList[$i]['Product']['price_option']==2){
                                echo "Contact Me";
                            }
                            ?>
                            </span>
                        </div>
                    </li>
                </ul>
            </section>
        </div>
    </section> -->
    <?php
    }
    ?>
  
  </div>
  <!-- Right Content end --> 
  
</div>
<?php //echo $this->element('sql_dump'); ?>
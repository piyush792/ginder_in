<div class="pagewrap">
    <nav>
        <?php echo $this->element('user_links');?>
        <div align="center" style="margin-top: 10px;"><?php echo $this->Session->flash();?></div>
        <div class="wishlist" style="height: 300px;">
            <ul>
                <?php 
                $wishnum = count($wishlist_products);
                
                if($wishnum>0)
                {
                    for($i=0;$i<$wishnum;$i++){
                    ?>
                        <li>
                        <a href="<?php echo SITE_URL."products/detail/".$wishlist_products[$i]['Product']['id'];?>">
                        <?php 
                        $image_exist = PRODUCT_IMAGE_UPLOAD.$wishlist_products[$i]['Product']['image'];
                        if(file_exists($image_exist) && $wishlist_products[$i]['Product']['image']!='')
                        $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'thumbnail/'.$wishlist_products[$i]['Product']['image'];
                        else
                        $product_image = SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg';
                        echo $this->Html->image($product_image,array('width' =>'127','height'=>'125'));
                            ?>
                        </a>
                            <p>
                            <?php echo '#'.$wishlist_products[$i]['Product']['article_no'];?>&nbsp;&nbsp;<?php echo $wishlist_products[$i]['Product']['name'];?><br />
                            <?php echo $wishlist_products[$i]['WishList']['attribute_name'];?>
                            </p>
                            
                            <h4>
                                <?php
                                if($wishlist_products[$i]['Product']['price_actual']!=0){
                                ?><strong><strike><?php echo CURRENCY_SYMBOL.$wishlist_products[$i]['Product']['price_actual'];?></strike></strong> <span><?php echo CURRENCY_SYMBOL.$wishlist_products[$i]['Product']['price'];?></span>
                                <?php
                                }else{
                                ?> <span><?php echo CURRENCY_SYMBOL.$wishlist_products[$i]['Product']['price'];?></span> 
                                <?php
                                }
                                ?>
                           </h4>
                            
                            <h3>
                            <a href="<?php echo SITE_URL."products/detail/".$wishlist_products[$i]['Product']['id'];?>">ADD TO CART</a>  |  
                            <a href="<?php echo SITE_URL."users/wishlist_delete/".$wishlist_products[$i]['WishList']['id'];?>" onclick="return window.confirm('Are you sure you wish to delete?');">DELETE</a>
                            </h3>
                        </li>
                    <?php
                    }
                }else
                {
                  ?>
                  <div style="margin-left: 35px; color: #00ABE7;">No Product In Your Wish List !</div>
                  <?php  
                }   
                ?>
            </ul>
        </div>
    </nav>
</div>
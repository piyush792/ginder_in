<?php
    echo $this->Html->css('rating');
    //echo $this->Html->css('jquery.jqzoom.css');
    //echo $this->Html->script(array('jquery.jqzoom-core-pack.js', 'rating.js'));
    echo $this->Html->script(array('rating.js'));
?> 

<div class="productMain clear">
    <div class="pagewrap">
        <div class="breadcrumb">
            <ul>
                <li><a href="<?php echo SITE_URL ?>">Home</a></li>
                <li><a href="<?php echo SITE_URL . 'products/view/' . $cat_name[0]['Category']['id'] ?>"><?php echo $cat_name[0]['Category']['name']; ?></a></li>
                <li class="no-arrow"><a href="<?php echo SITE_URL . 'products/view/' . $sub_cat_name['id'] ?>"><?php echo $sub_cat_name['name']; ?></a></li>
                <!-- <li><a href="#">Home</a></li> -->
                <!--<li class="no-arrow"><a href="#">Home</a></li>-->
            </ul>
            <div class="clr"></div>
        </div>
        <!-- details page start here -->
        <div class="no_sidebar">
            <div class="prod_image FL">
                <div class="prod_img">
                    <div class="image">        
                        <div class="jqzoom">        
                            <div class="single">        
                                <div> 

                                    <?php
                                        $image = $productDetail['Product']['image'];
                                        if (file_exists(PRODUCT_IMAGE_UPLOAD . $image) && ($image <> "")) {
                                            $image_thumb = PRODUCT_IMAGE_UPLOAD . 'thumbnail/' . $image;
                                            $image_large = PRODUCT_IMAGE_UPLOAD . 'large/' . $image;
                                            $image = PRODUCT_IMAGE_UPLOAD . $image;
                                        } else {
                                            $image = PRODUCT_IMAGE_UPLOAD . 'no_image.jpg';
                                        }
                                    ?>
                                    <a href="<?php echo SITE_URL . $image; ?>"  class="jqzoom" rel='gal1' style="display:block;">
                                    
                                        <?php echo $this->Html->image(SITE_URL . $image_large, array("border: 4px solid #666")); ?>
                                    </a>
                                    <div class="clr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="product_zoom"><a href="#">rollover to zoom</a></div>
                <div class="prod_similar">
                    <?php
                        //PRODUCT_IMAGE_UPLOAD  
                        $img1 = $sample_image[0]['ProductImage']['product_image'];
                        $img2 = $sample_image[1]['ProductImage']['product_image'];
                        $img3 = $sample_image[2]['ProductImage']['product_image'];
                        $img4 = $sample_image[3]['ProductImage']['product_image'];

                        if (file_exists(PRODUCT_IMAGE_UPLOAD . $img1) && ($img1 <> "")) {
                            $sample_img1 = PRODUCT_IMAGE_UPLOAD . 'large/' . $img1;
                            $sample_1 = PRODUCT_IMAGE_UPLOAD . 'thumbnail/' . $img1;
                        } else {
                            $sample_img1 = PRODUCT_IMAGE_UPLOAD . 'large/' . 'no_image.jpg';
                            $sample_1 = PRODUCT_IMAGE_UPLOAD . 'thumbnail/' . 'no_image.jpg';
                        }
                        if (file_exists(PRODUCT_IMAGE_UPLOAD . $img2) && ($img2 <> "")) {
                            $sample_img2 = PRODUCT_IMAGE_UPLOAD . 'large/' . $img2;
                            $sample_2 = PRODUCT_IMAGE_UPLOAD . 'thumbnail/' . $img2;
                        } else {
                            $sample_img2 = PRODUCT_IMAGE_UPLOAD . 'large/' . 'no_image.jpg';
                            $sample_2 = PRODUCT_IMAGE_UPLOAD . 'thumbnail/' . 'no_image.jpg';
                        }
                        if (file_exists(PRODUCT_IMAGE_UPLOAD . $img3) && ($img3 <> "")) {
                            $sample_img3 = PRODUCT_IMAGE_UPLOAD . 'large/' . $img3;
                            $sample_3 = PRODUCT_IMAGE_UPLOAD . 'thumbnail/' . $img3;
                        } else {
                            $sample_img3 = PRODUCT_IMAGE_UPLOAD . 'large/' . 'no_image.jpg';
                            $sample_3 = PRODUCT_IMAGE_UPLOAD . 'thumbnail/' . 'no_image.jpg';
                        }
                        if (file_exists(PRODUCT_IMAGE_UPLOAD . $img4) && ($img4 <> "")) {
                            $sample_img4 = PRODUCT_IMAGE_UPLOAD . 'large/' . $img4;
                            $sample_4 = PRODUCT_IMAGE_UPLOAD . 'thumbnail/' . $img4;
                        } else {
                            $sample_img4 = PRODUCT_IMAGE_UPLOAD . 'large/' . 'no_image.jpg';
                            $sample_4 = PRODUCT_IMAGE_UPLOAD . 'thumbnail/' . 'no_image.jpg';
                        }
                    ?>
                    <ul id="small_photos" class="thumbs">

                        <li>
                            <a class="" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo(SITE_URL . $sample_img1) ?>',largeimage: '<?php echo(SITE_URL . PRODUCT_IMAGE_UPLOAD . $img1) ?>'}">
                                <?php echo $this->Html->image(SITE_URL . $sample_1, array("height" => "61", "width" => "81")); ?> 
                            </a>
                        </li>
                        <li>
                            <a class="" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo(SITE_URL . $sample_img2) ?>',largeimage: '<?php echo(SITE_URL . PRODUCT_IMAGE_UPLOAD . $img2) ?>'}">
                                <?php echo $this->Html->image(SITE_URL . $sample_2, array("height" => "61", "width" => "81")); ?> 
                            </a>
                        </li>
                        <li>
                            <a class="" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo(SITE_URL . $sample_img3) ?>',largeimage: '<?php echo(SITE_URL . PRODUCT_IMAGE_UPLOAD . $img3) ?>'}">
                                <?php echo $this->Html->image(SITE_URL . $sample_3, array("height" => "61", "width" => "81")); ?> 
                            </a>
                        </li>  
                        <li>
                            <a class="" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo(SITE_URL . $sample_img4) ?>',largeimage: '<?php echo( SITE_URL . PRODUCT_IMAGE_UPLOAD . $img4) ?>'}">
                                <?php echo $this->Html->image(SITE_URL . $sample_4, array("height" => "61", "width" => "81")); ?> 
                            </a>
                        </li>  
                    </ul>          
                    <div class="clear"></div>
                </div>
            </div>

            <?php echo $this->Form->create("Product", array("id" => "Product", 'type' => 'post', 'url' => '')); ?>        

            <div class="product_details FR">
                <!-- right side -->
                <h1 class="sb_prd_name"><?php echo $productDetail['Product']['name']; ?></h1>
                <!--<div class="head_slogan">Rarely Pierced Earrings </div>-->
                <div class="sb_prod_price">
                    <?php
                        if ($productDetail['Product']['discount'] != '0') {
                            $product_price = $productDetail['Product']['discount'];
                        ?>

                        <del class="FL">$<?php echo $productDetail['Product']['price']; ?></del><div class="FL _red">$<?php echo $productDetail['Product']['discount']; ?></div>
                        <?php
                            } else {
                            $product_price = $productDetail['Product']['price'];
                        ?>
                        <div class="FL">$<?php echo $productDetail['Product']['price']; ?></div>
                        <?php
                            }
                    ?>     

                    <!--<div class="FL">$500</div><del class="FL _red">$400</del>-->
                    <div class="clr"></div>
                </div>
                <div class="_prod_separator">&nbsp;</div>
                <div class="_prod_smldesc">

                    <?php
                        if (count($productDetail['Product']['description']) > 0) {
                        ?>

                        <?php echo $productDetail['Product']['description']; ?>
                        <?php }
                    ?>
                </div>  
                <!-- Chic and eye-catching, this pair of pierced earrings is adorned with 
                glittering clear crystal and Crystal Silver Shade for an exceptional
                brilliance. They make an elegant statement whether worn alone 
                or combined with other Rarely designs.  -->

                <div class="_prod_separator">&nbsp;</div>

                <!-- blocks -->
                <div class="prod_type_blocks">
                    <!-- block 1 -->

                    <?php
                        //  print_r ($productDetail['Product']['metal']);
                        if (trim($productDetail['Product']['metal']) !== '') {
                        ?>   

                        <div class="type_block Btype1">
                            <div class="type_block_container"> 
                                <h4>METAL</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['metal']; ?> 
                                </div>  
                            </div>
                        </div>
                        <?php }
                    ?>

                    <!-- block 1 // -->
                    <!-- block 2 -->

                    <?php
                        if (trim($productDetail['Product']['weight']) !== '') {
                        ?> 
                        <div class="type_block Btype2">
                            <div class="type_block_container">
                                <h4>WEIGHT</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['weight']; ?> 
                                </div> 
                            </div>
                        </div>
                        <?php }
                    ?>

                    <!-- block 2 // -->
                    <!-- block 3 -->

                    <?php
                        if (trim($productDetail['Product']['finishing']) !== '') {
                        ?>
                        <div class="type_block Btype3">
                            <div class="type_block_container">
                                <h4>FINISHING</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['finishing']; ?> 
                                </div>
                            </div>
                        </div>
                        <?php }
                    ?>

                    <!-- block 3 // -->
                    <!-- block 4 -->

                    <?php
                        if (trim($productDetail['Product']['measure_band']) !== '') {
                        ?>
                        <div class="type_block Btype4">
                            <div class="type_block_container">
                                <h4>MEASURE BAND</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['measure_band']; ?> 
                                </div>
                            </div>
                        </div>
                        <?php }
                    ?>

                    <!-- block 4 // -->
                    <!-- block 5 -->

                    <?php
                        if (trim($productDetail['Product']['measure_width']) !== '') {
                        ?>
                        <div class="type_block Btype5">
                            <div class="type_block_container">
                                <h4>MEASURE WIDTH</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['measure_width']; ?> 
                                </div>
                            </div>
                        </div>
                        <?php }
                    ?>

                    <!-- block 5 // -->
                    <!-- block 6 -->

                    <?php
                        if (trim($productDetail['Product']['measure_height']) !== '') {
                        ?>
                        <div class="type_block Btype6">
                            <div class="type_block_container">
                                <h4>MEASURE HEIGHT</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['measure_height']; ?> 
                                </div>
                            </div>
                        </div>
                        <?php }
                    ?>

                    <!-- block 6 // -->
                    <!-- block 7 -->

                    <?php
                        if (trim($productDetail['Product']['stone_length']) !== '') {
                        ?>
                        <div class="type_block Btype7">
                            <div class="type_block_container">
                                <h4>STONE LENGTH</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['stone_length']; ?> 
                                </div>
                            </div>
                        </div>         
                        <?php }
                    ?>               

                    <!-- block 7 // -->
                    <!-- block 8 -->  

                    <?php
                        if (trim($productDetail['Product']['stone_width']) !== '') {
                        ?>
                        <div class="type_block Btype8">
                            <div class="type_block_container">
                                <h4>STONE WIDTH</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['stone_width']; ?> 
                                </div>
                            </div>
                        </div>        
                        <?php }
                    ?>    

                    <!-- block 8 // -->
                    <!-- block 9 -->  

                    <?php
                        if (trim($productDetail['Product']['stone_depth']) !== '') {
                        ?>
                        <div class="type_block Btype9">
                            <div class="type_block_container">
                                <h4>STONE DEPTH</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['stone_depth']; ?> 
                                </div>
                            </div>
                        </div>
                        <?php }
                    ?>

                    <!-- block 9 // -->
                    <!-- block 10 -->  

                    <?php
                        if (trim($productDetail['Product']['cirumference']) !== '') {
                        ?>
                        <div class="type_block Btype9">
                            <div class="type_block_container">
                                <h4>CIRCUMFERENCE</h4>
                                <div class="type_content">
                                    <?php echo $productDetail['Product']['cirumference']; ?> 
                                </div>
                            </div>
                        </div> 
                        <?php }
                    ?>

                    <!-- block 10 // -->
                    <div class="clr"></div>
                </div>
                <!-- blocks // -->
                <!-- small form -->
                <div class="sbfrm dt_form">
                    <?php
                        //if(count($attributeNameArr['3']['Color'])>0){

                        $color = array();
                        $c = 0;
                        $attArr = array();
                        //print_r($attributeNameArr);
                        foreach ($attributeNameArr as $k => $vArr) {
                            $attArr[] = $k;
                            $color[$k] = $v;
                            $attributename = 'attributename.' . $c;
                            $options = array();

                            foreach ($vArr as $k1 => $v1) {
                                //echo "k: ".$k;
                                echo '<label for="basic" class="control-label">Select ' . $k1 . ':</label>';
                                //print_r($v1);
                                //echo "<hr>";
                                $key = $k . "|";
                                $options = $v1;
                            }

                            if ($k1 == 'Color') {
                                $d1 = $default;
                            } elseif ($k1 == 'Size') {
                                $d1 = $defaults;
                            }
                            echo $this->Form->input($attributename, array('label' => false, 'id' => 'attributename' . $k, 'options' => array('' => '--select--', $options), "div" => false, 'default' => $d1));
                            $c++;
                        }
                    ?>
                </div>
                <!-- small form // -->
                <!-- quick navigation -->
                <div class="details_quick_nav">
                    <ul>
                        <li class="size"><a href="#">Size Guide</a></li>
                        <li class="print"><a href="#">Print Page</a></li>
                        <li class="fav"><a href="#">Favorite</a></li>
                        <li class="share"><a href="#">Share</a></li>
                    </ul>
                    <div class="clr"></div>
                </div>
                <!-- quick navigation // -->
                <!-- addtocart -->
                <div class="details_addtocart">
                       <?php echo $this->Form->button("Add to Cart", array('type' => 'button', 'id' => 'addtocart', 'label' => false, 'class' => 'add_to_cart button')); ?>
                    <?php //echo $this->Form->input("Add to Cart", array('type' => 'button', 'id' => 'addtocart', 'label' => false, 'class' => 'add_to_cart button')); ?>
                </div>


                <?php
                    echo $this->Form->input("product_id", array('type' => 'hidden', 'id' => 'prod_id', 'name' => 'product_id', 'value' => $product_id));
                    echo $this->Form->input("price", array('type' => 'hidden', 'id' => 'price', 'value' => $product_price));
                    echo $this->Form->input("quantity", array('type' => 'hidden', 'id' => 'quantity', 'value' => '1'));
                ?>           
                <!-- addtocart // -->
                <!-- product rating -->
                <div class="_prod_rating">
                    <div class="votes">  <?php echo $rating_bar; ?><span> <?php echo $votes_total; ?> votes </span></div>
                </div>
                <!-- product rating // -->
                <!-- right side // -->
            </div>
            <div class="clr"></div>
            <!-- also Like -->
            <div class="alsolike_box">
                <h2>You may Also like</h2>
                <div>
                    <ul>

                        <?php
                            for ($k = 0; $k < count($similar_products); $k++) {

                                $s_image = $similar_products[$k]['Product']['image'];
                                $s_image1 = PRODUCT_IMAGE_UPLOAD . $similar_products[$k]['UserProfile']['image']; //for localhost only

                                if (file_exists($s_image1) && ($s_image <> "")) {
                                    $s_image = PRODUCT_IMAGE_UPLOAD . $s_image;
                                } else {
                                    $s_image = PRODUCT_IMAGE_UPLOAD . 'no_image.jpg';
                                }


                                if ($similar_products[$k]['Product']['discount'] < $similar_products[$k]['Product']['price'] && $similar_products[$k]['Product']['price'] != 0) {
                                    $product_price = $similar_products[$k]['Product']['price'];
                                    $price = '<span class="price"><em>$' . $similar_products[$k]['Product']['price'] . '</em>$' . $similar_products[$k]['Product']['discount'] . '</span>';
                                    $percentage = 100 - (( $similar_products[$k]['Product']['discount'] / $similar_products[$k]['Product']['price']) * 100);
                                } elseif ($similar_products[$k]['Product']['price'] != 0) {
                                    $product_price = $similar_products[$k]['Product']['price'];
                                    $price = '<span class="price"><em>$' . $similar_products[$k]['Product']['price'] . '</em></span>';
                                }
                            ?>

                            <li>
                                <div class="listItem">
                                    <?php
                                        if ($similar_products[$k]['Product']['discount'] != '0') {
                                        ?>
                                        <strong><img src="<?php echo SITE_URL; ?>img/sale-banner-small.png" alt=""></strong>  
                                        <?php
                                            } elseif ($similar_products[$k]['Product']['new_product'] != '0') {
                                        ?>
                                        <strong><img src="<?php echo SITE_URL; ?>img/new-banner-small.png" alt=""></strong>
                                        <?php
                                            }
                                    ?>
                                    <a href="<?php echo SITE_URL . '/products/detail/' . $similar_products[$k]['Product']['id']; ?>"><?php echo $this->Html->image(SITE_URL . $s_image, array("height" => "179", "width" => "216")); ?>
                                        <span class="productName"><?php echo $similar_products[$k]['Product']['name']; ?></span>
                                        <?php
                                            if ($similar_products[$k]['Product']['discount'] != '0') {
                                                echo $price;
                                            } else {
                                            ?>
                                            <span class="price2">$<?php echo $product_price; ?></span>
                                            <?php
                                                }
                                        ?>
                                    </a>
                                    <div class="also_like_rating">
                                        <?php echo $similar_rating_bar[$similar_products[$k]['Product']['id']]; ?>
                                    </div>

                                </div>
                            </li>


                            <?php
                                }
                        ?>           



                        <!--<li>
                        <div class="listItem">
                        <strong><img src="http://www.webvirtue.com/demo/ecomsimon/img/sale-banner-small.png" alt=""></strong>  
                        <a href="#">  
                        <img src="<?php echo SITE_URL . '/img/dummylike.png' ?>" width="216" height="179" alt="">                    
                        <span class="productName">pro9</span>
                        <span class="price"><em>$10.00</em>$8.00</span><small>Take an Additional 20% Off!</small>
                        </a>
                        </div>
                        </li>-->
                    </ul>
                    <div class="clr"></div>
                </div>
            </div>
            <!-- also Like // -->
            <!-- recview -->
            <div>
                <div class="review_title">Customer Reviews</div>

                <?php
                    if (count($Reviewdata) > 0) {
                        for ($i = 0; $i < count($Reviewdata); $i++) {
                        ?>
                        <div class="review_desc"> 

                            <?php $sdate = date("F d,Y", strtotime($Reviewdata[$i]['Rating']['created']));
                            ?><p><?php echo $Reviewdata[$i]['Rating']['description']; ?>  </p>



                            <!-- <p>These shoes are beautiful and comfortable and matched my dress perfectly but they creak! There is a noisy creaky sound from both of them. I asked 
                            my daughter to try them to be sure I was not imagining it but they drove her crazy too. I am so bummed!
                            </p>                                                                                                         -->
                            <div class="review_rating">
                                <div class="FL review_user">
                                    <!-- <span class="FL"> <?php echo $Reviewdata[$i]['Rating']['firstname']; ?>-customer </span>| <?php echo $sdate; ?>            -->
                                    <span class="FL"><?php echo $Reviewdata[$i]['Rating']['firstname']; ?></span> <span class="no-italic">|</span><?php echo $sdate; ?>
                                    <div class="clr"></div>
                                </div>       
                                <!--<div class="FR rating"><img src="<?php echo SITE_URL . '/img/rating.png' ?>"></div> --> 
                                <div class="FR rating">
                                    <?php echo $user_rating_bar[$Reviewdata[$i]['Rating']['id']]; ?>
                                </div>  
                                <div class="clr"></div>  
                            </div>
                        </div>

                        <?php }
                    ?>
                    <?php

                        if ($this->Paginator->counter( '{:count}')>PAGING) {      ?>
                        <div class="sortPanel clear">       
                            <ul class="pager FR">
                                <?php
                                    echo $this->Paginator->prev($this->Html->image(SITE_URL . "img/listing-pager-first.png"), array('escape' => false, 'tag' => 'li'), null, array('class' => 'prev disabled', 'escape' => false, 'tag' => 'li'));
                                    echo '&nbsp;' . $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentClass' => 'active'));
                                    echo $this->Paginator->next($this->Html->image(SITE_URL . "img/listing-pager-next.png"), array('escape' => false, 'tag' => 'li'), null, array('class' => 'next disabled', 'escape' => false, 'tag' => 'li'));
                                ?>
                            </ul>           
                        </div>
                        <?php   }?>
                    <?php
                        } else {
                    ?>
                    <div class="review_desc">
                        <?php echo "No Reviews"; ?> 
                    </div>
                    <?php }
                ?>   


                <!-- recview // -->

                <!-- write review -->
            <?php      if ($purchased_item == '1') {      ?>
                <div class="write_review">
                    <h2>Write a review.</h2>
                    <div class="rate_our_product">
                        rate our product.
                    </div>

                    <div class="sbfrm review_form">
                        <span id="error_msg"><?= $this->Session->flash(); ?></span>
                        <!--<?php echo $this->Form->create('Rating', array('id' => 'Rating', 'url' => '')); ?> -->

                        <div class="control-group">
                            <label for="basic" class="control-label">Let us know what u think <span class="star">*</span></label>
                            <div class="controls">
                                <?php echo $this->Form->input('description', array('label' => false, 'type' => 'textarea', 'id' => 'description', 'rows' => 4, 'cols' => '50', "class" => "input-square")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Ratings: <span class="star">*</span></label>
                            <div class="controls">
                                <?php
                                    $Rating = array("0" => "--Select Rating--", 1, 2, 3, 4, 5);

                                    echo $this->Form->input('rating', array('label' => false, 'id' => 'rating', 'options' => array($Rating), "div" => false));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label"> Tell us a little about yourself</label>
                            <div class="controls FL">
                                <?php echo $this->Form->input('firstname', array('label' => false, 'id' => 'firstname', "div" => false, 'size' => 40, "class" => "input-square", "placeholder" => "firstname")); ?>
                            </div>
                            <div class="controls FR">
                                <?php echo $this->Form->input('lastname', array('label' => false, 'id' => 'lastname', "div" => false, 'size' => 40, "class" => "input-square", "placeholder" => "lastname")); ?>
                            </div>
                            <div class="controls FL">
                                <?php echo $this->Form->input('email', array('label' => false, 'id' => 'email', "div" => false, 'size' => 40, "class" => "input-square", "placeholder" => "Email address")); ?>
                            </div>
                            <!-- <div class="controls FR">
                            <?php echo $this->Form->input('email', array('label' => false, 'id' => 'email', "div" => false, 'size' => 40, "class" => "input-square", "placeholder" => "Email address")); ?>
                            </div>-->
                            <div class="clr"></div>
                        </div>


                        <div class="FL dt_notes" style="width: 600px;">
                            <span>Note:</span> All submitted reviews become the licensed property of Silverbliss as set forth in our Terms of Use.<br>
                            Your reviews will be reviewed by our staff and posted within five business days.
                        </div>
                        <div class="FR">
                            <?php echo $this->Form->input("Post", array('type' => 'button', 'id' => 'Review', 'label' => false, 'class' => 'Review'));
                            ?>


                        </div>
                        <div class="clr"></div>
                    </div>


                </div>
                <?php   }?>   
                <!-- write review -->

            </div>
            <!-- details page start here // -->     
        </div>    
    </div>
</div>   
<div style="clear: both;">&nbsp;</div>    
</div> 

<?php
    echo $this->Form->end();
?>   
<div class="alertlogin _layer_form">

    <div class="_layer_close"></div>
    <div class="detail_heading">
        <h2 class="page_title" style="text-align: center;font-size: 30px;font-weight: normal;margin-bottom: 15px;">to leave a review</h2>
    </div>
    <div class="no-margin-bottom detail_heading">
        <h2 class="page_title" style="font-size: 24px;font-weight: normal; color: #0094fb;">Login</h2>
    </div>
    <div class="signup normal_text lession_container">
        <div class="FL login">
            <div class="lessionform">
                <!--<h4 class="">Returning User</h4>-->
                <?php echo $error_msg; ?>
                <!--// echo $this->Form->create('User');  -->
                <?php echo $this->Form->create("User", array("id" => "User", 'type' => 'post', 'url' => SITE_URL . 'Users/login')); ?>        
                <?php echo $this->Form->input("referer", array("id" => "referer", "type" => "hidden", "value" => $referer)); ?>        
                <fieldset>
                    <div class="form_element"><input id="email" type="text" name="data[User][email]" placeholder="User Name"></div><div class="clear"></div>
                    <div class="form_element"><input id="password" type="password" name="data[User][password]" placeholder="Password"></div><div class="clear"></div>
                    <div class="_layer_signup">
                        Not a User ? <?php echo $this->Form->button("Sign Up here", array('type' => 'button', 'onclick' => "javascript:window.location='" . SITE_URL . "Membership';")); ?>
                    </div>

                    <!--<label>&nbsp;</label><div class="form_element nobg"><input type="checkbox" name="data[User][remember_me]" id="remember_me">  Remember me</div><div class="clear"></div>-->
                    <div class="login_submit">
                        <?php echo $this->Form->button('Login', array("type" => "submit", "id" => "login", "value" => "Login")); ?>
                    </div><div class="clear"></div>
                </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>  
        </div>
        <div class="clear"></div>
    </div> 
</div>


<script type="text/javascript">
    $(document).ready(function(){ 
        /* $('#addtocart').click(function(){
        $('#Product').attr('action', '<? echo SITE_URL ?>shopping_carts/addtocart');
        });

        $('#addtowishlist').click(function(){
        $('#Product').attr('action', '<? echo SITE_URL ?>wishlists/addtowishlist');
        });    
        */



        <?php if ($user_id == '') { ?> 

            $('#Review').click(function(){  

            
                var width = $(document).width(); // or $(window).width()
                var height = $(document).height(); // or $(window).height()
                var wwidth =  parseInt($(window).width());
                var wheight = parseInt($(window).height());
                $('.mask').css({
                    width: width,
                    height:height,
                    display:'block'
                });
                $('.alertlogin').css({
                    // top: ((wheight/2)-150),
                    top: ($(document).scrollTop()+200),
                    left:((wwidth/2)-200),
                    display:'block'
                });
                return false;
            });
            $('.mask, ._layer_close').click(function(){
                //$(this).hide();
                $('.mask').css('display','none');
                $('.alertlogin').css('display','none');
                $('.reportabuse').css('display','none');
            });

            <?php } else { ?>    
            $('#Review').click(function(){
                {
                    if($("#description").val()=="")
                    {
                        $("#error_msg").html("<div class='alert-error'><a class='close' data-dismiss='alert' href='#'></a>Please Enter Description</div>");
                        $("#description").focus();
                        return false;
                    }
                    if(document.getElementById('rating').value == "0")
                    {
                        document.getElementById('error_msg').innerHTML ='<div class="alert-error"><a href="#" data-dismiss="alert" class="close"></a>Please select atleast one Rating.</div>';
                        document.getElementById('rating').focus();
                        return false;
                    }
                }
                $('#Product').attr('action', '<? echo SITE_URL ?>users/post_comment');
            });
            <?php } ?>

    });   


</script>
<script>
    $(document).ready(function() {
        var jqzoomOptions={
            zoomType: 'standard',
            lens:true,
            preloadImages: false,
            alwaysOn:false,
            zoomWidth: 450,
            zoomHeight: 400,
            xOffset:60,
            yOffset:20,
            position:'right'
        }
        $('.jqzoom').jqzoom(jqzoomOptions);

        //$('.jqzoom').jqzoom();
    });
</script>

<script>
    $(document).ready(function(){
        $(".tabbed").tabbed();

        $('#feedback').click(function(){
            $(".tabbed li").removeClass('active');
            $(".tabbed li.rating01").addClass("active");

            $('#overview').css('display','none');
            $('#question').css('display','none');
            $('#seller').css('display','none');
            $('#postcomment').css('display','none');


            $('#rating').css('display','block');
        });

        //$("#feedback").tabbed();

        $("#follow_me").click(function(){           
            var s_id = $("#seller_id").val();   
            //alert(s_id);

            $.post('<?php echo SITE_URL; ?>users/favorite_seller',{ seller_id: s_id }, function(data) {               
                $("#follow_me").html(data);
                // $("#follow_me").html("Follow Me ("+data+" Followers)");
            });

        });



    });  
</script>

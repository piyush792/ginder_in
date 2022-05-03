<!-- CONTANT AREA START -->
<!-- LEFT CONTAINER START -->           

<div class="contant_left left_details FL">
    <div class="left_detail_container shop_leftcontainer">
        <div class="shopping_level four">
            <ul style="">
                <li class="bill_signup">Sign Up</li>
                <li class="bill_address">Address</li>
                <li class="bill_review">Review</li>
                <li class="bill_sucess">Sucess</li>
            </ul>
        </div>
    </div>
</div>
<!-- LEFT CONTAINER END -->

<!-- RIGHT CONATAINER START -->
<div class="contant_right FR">
    <div class="no-margin-bottom detail_heading ">
        <h2 class="FL page_title">Thanks for shopping</h2>
        <div class="clear"></div>
    </div>

    <!-- Review form-->
    <div class="normal_text lession_container3">
        <div class="thanks_sucess">
            Thanks for shopping with us<br>
            Your Order ID is:
            <span>LPG<?php echo $orderDetails[0]['Order']['order_id'];?></span>
            <div class="sucess_continue_shopping">
                <!--<input type="button" class="button continue_shopping">-->
                <a href="<?php echo SITE_URL;?>products/view/"><img src="<?php echo SITE_URL;?>images/continue_shopping.png"></a>
            </div>
        </div>

        <div class="ct_item_container sucess">
            <div class="sucess_cart_title">Shopping Details are:</div>
            <table width="100%" border="0" cellpadding="15" cellspacing="1" bgcolor="#d3d1d0">
                <tr>
                    <th bgcolor="#FFFFFF" scope="col" width="604">Product</th>
                    <th align="center" bgcolor="#FFFFFF" scope="col" width="100">Unit Price</th>
                    <th align="center" bgcolor="#FFFFFF" scope="col">Quantity</th>
                    <th align="center" bgcolor="#FFFFFF" scope="col">Subtotal</th>
                </tr>
                <?php 
                $total=0;
                $sum_total=0;
                    // print_r($orderDetails);
                    for($i=0;$i<count($orderDetails);$i++){
                        //echo orderDetail[];                    
                        ?>
                    <tr>
                        <td bgcolor="#FFFFFF"><div>
                            <div class="FL ct_item">

                                <?php 

                                    $image_exist = PRODUCT_IMAGE_UPLOAD.$orderDetails[$i]['Product']['image'];

                                    if(file_exists($image_exist) && $orderDetails[$i]['Product']['image']!='')
                                    {?>
                                    <a href="#"><?php echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$orderDetails[$i]['Product']['image'],array('width'=>'80'));?></a>
                                    <?php }else{?>
                                    <a href="#"><?php echo$this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg',array('width'=>'80'));?></a>

                                    <?php }?>
                            </div>
                            <div class="FL ct_item_desc">
                                <div class="ct_item_name">
                                    <?php  echo $this->Html->link($orderDetails[$i]['Product']['product_name'],"/products/detail/".$orderDetails[$i]['Product']['id']);?>
                                </div>
                                <div class="ct_item_autohor"><span>By:</span> <?php echo $sellerData[$orderDetails[$i]['Product']['id']];?></div>
                            </div>
                            <div class="clear"></div>
                        </td>
                        <td align="center" bgcolor="#FFFFFF"><div class="ct_unit_price">$<?php echo $orderDetails[$i]['OrderItem']['order_price'];?></div></td>
                        <td align="center" bgcolor="#FFFFFF"><div class="ct_qty"><?php echo $orderDetails[$i]['OrderItem']['quantity'];?></div></td>
                        <td align="right" bgcolor="#FFFFFF"><div class="ct_subtital">$<?php 
                        
                        $total=$orderDetails[$i]['OrderItem']['order_price']*$orderDetails[$i]['OrderItem']['quantity']; $sum_total+= $total;
                        echo number_format($total,2,'.','');
                        ?>
                        </div></td>
                    </tr>
                    <?php }?>
            </table>
        </div>
        <div class="FR">
            <div class="FL subtotal" align="right">    Subtotal:</div>
            <div class="FR subtotal_price">$<?php echo number_format($sum_total,2,'.','');?></div>
            <div class="clear"></div>

            <div class="FL grandtotal" align="right">Grand Total:</div>
            <div class="FR grandtotal_price">$<?php echo number_format($sum_total,2,'.','');?></div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <!-- Review Form //-->
</div>
            <!-- RIGHT CONATAINER END -->       
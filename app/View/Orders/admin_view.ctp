<?php 
    echo $this->element("admin_header"); 
    echo $this->element("admin_dashboard"); 
    echo $this->element("admin_left");
?>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Order Information</h3>
                    </div>
                    <div class="box-head">
                        <div style="float: left; width: 200px;text-align:left;font-size:14px; font-weight:bold;">Order#: <?php echo $orderData['id'];?></div><div style="float: right; width: 230px;text-align:right;font-size:14px; font-weight:bold;">Customer: <?php echo '(#'.$orderData['user_id'].') '.$userData['firstname'].' '.$userData['lastname'];?></div>
                    </div>
                    <div class="box-content box-nomargin">
                        <?php echo $this->Session->flash();?>
                        <table width="100%">
                            <tr>
                                <td width="50%">
                                    <table width="98%" align="center" border='0' cellspacing="5" cellpadding="5" bgcolor="#ffffff" class="box">
                                        <tr bgcolor="#f1f1f1">
                                            <td><b>Billing Information</b></td>
                                        </tr>
                                        <tr bgcolor="#ffffff">
                                            <td>Customer Name: 
                                                <?php echo $orderData['bill_firstname']." ".$orderData['bill_lastname'];?>
                                            </td>
                                        </tr>
                                        <tr><td>Address : <?php echo $orderData['bill_address1'];?></td></tr>
                                        <tr><td>City: <?php echo $orderData['bill_city'];?></td></tr>
                                        <tr bgcolor="#ffffff"><td>State: <?php echo $orderData['bill_state'];?></td></tr>
                                        <tr ><td>Country: <?php echo $orderData['bill_country'];?></td></tr>
                                        <tr bgcolor="#ffffff"><td>Zip: <?php echo $orderData['bill_zip'];?></td></tr>
                                        <tr><td>Phone: <?php echo $orderData['bill_phone'];?></td></tr>
                                    </table>
                                </td>
                                <td width="50%" valign="top">
                                    <table width="98%" border='0' cellspacing="5" cellpadding="5" bgcolor="#f1f1f1" class="box">
                                        <tr bgcolor="#f1f1f1">
                                            <td><b>Shipping Information</b></td>
                                        </tr>
                                        <tr bgcolor="#ffffff">
                                            <td>Customer Name: 
                                                <?php echo $orderData['ship_firstname']." ".$orderData['ship_lastname'];?>
                                            </td>
                                        </tr>
                                        <tr><td>Address : <?php echo $orderData['ship_address1'];?></td></tr>
                                        <tr><td>City: <?php echo $orderData['ship_city'];?></td></tr>
                                        <tr bgcolor="#ffffff"><td>State: <?php echo $orderData['ship_state'];?></td></tr>
                                        <tr ><td>Country: <?php echo $orderData['ship_country'];?></td></tr>
                                        <tr bgcolor="#ffffff"><td>Zip: <?php echo $orderData['ship_zip'];?></td></tr>
                                        <tr>
                                        <td>Phone: <?php echo $orderData['ship_phone'];?></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <?php
                            echo $this->Form->create("OrderItem",array("type"=>"post"));
                            echo $this->Form->input("order_id",array("type"=>"hidden","value"=>$id));
                        ?>
                        <table width="98%" align="center" border='0' cellspacing="5" cellpadding="5" bgcolor="#ffffff" class="box">
                            <tr bgcolor="#f1f1f1">
                                <td colspan="6"><b>Item Information</b></td>
                            </tr>
                            <tr bgcolor="#f1f1f1">
                                <td width="10%"><b>Status</b></td>
                                <td width="25%"><b>Item Name</b></td>
                                <td align="left" width="25%"><b>Attribute</b></td>
                                <td align="center"><b>Qty</b></td>
                                <td align="right"><b>Item Price</b></td>
                                <td align="right"><b>Total Price</b></td>
                            </tr>

                            <?php
                                $orderstatusOptions = array("0"=>"Pending","1"=>"Processed","2"=>"Shipped");
                                for($i=0;$i<count($orderItem);$i++)
                                {
                                ?>
                                <tr bgcolor="#ffffff">
                                    <td>
                                        <?php 
                                        if($orderItem[$i]['OrderItem']['status']==2)
                                            echo "Shipped";
                                        else
                                            echo $this->Form->input("status.".$orderItem[$i]['OrderItem']['id'],array("options"=>$orderstatusOptions,"label"=>false,"default"=>$orderItem[$i]['OrderItem']['status'],'style'=>'width:auto;'));
                                        ?>
                                    </td>
                                    <td><?=$orderItem[$i]['Product']['name']?></td>
                                    <td align="left"><?=$orderItem[$i]['OrderItem']['attribute_name']?></td>
                                    <td align="center"><?=$orderItem[$i]['OrderItem']['quantity']?></td>
                                    <td align="right"><?php echo CURRENCY_SYMBOL.number_format($orderItem[$i]['OrderItem']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></td>
                                    <td align="right"><?php echo CURRENCY_SYMBOL.number_format(($orderItem[$i]['OrderItem']['quantity']*$orderItem[$i]['OrderItem']['price']),2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></td>
                                </tr>        
                                <?
                                }
                            ?>
                            <tr>
                                <td colspan="6">
                                    <table width="100%" align="center" border='0' cellspacing="2" cellpadding="2" bgcolor="#ffffff" class="box">
                                        <tr>
                                        <td align="left" >
                                        <?php 
                                         if($orderData['order_status']!="2")
                                         echo $this->Form->button("Update",array("type"=>"submit","id"=>"update"));
                                         else
                                         echo '&nbsp;';
                                        ?>
                                        </td>
                                         </tr>
                                        <tr bgcolor="#f1f1f1">
                                         <td><div align="right"><b>SubTotal: <?php echo CURRENCY_SYMBOL.number_format($orderData['subtotal'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></b></div></td>
                                        </tr>
                                        <tr>
                                         <td><div align="right">Shipping (+): <?php echo CURRENCY_SYMBOL.number_format($orderData['shipping_price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></div></td>
                                        </tr>
                                        <?php
                                        if(!empty($orderData['coupon_discount'])){
                                        ?>
                                        <tr>
                                         <td><div align="right">Coupon Discount (-): <?php echo CURRENCY_SYMBOL.number_format($orderData['coupon_discount'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></div></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr bgcolor="#f1f1f1">
                                         <td><div align="right"><b>Total: <?php echo CURRENCY_SYMBOL.number_format($orderData['order_total'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></b></div></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <?php echo $this->Form->end();?>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>    
</div>

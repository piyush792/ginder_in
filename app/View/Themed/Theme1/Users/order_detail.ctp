<?php 
    echo $this->Html->css("siteStyle");
?>
<div class="pagewrap">
    <nav>
        <?php echo $this->element('user_links'); ?>
        <div class="information">

            <h3>Order Detail</h3>
            <div id="tabs" style="min-height: 350px;">
                <table border="0" width="100%">
                    <tr>
                        <td width="50%">
                            <table width="100%" border='0'>
                                <tr bgcolor="#f1f1f1">
                                    <td style="padding: 10px;"><b>Billing Information</b></td>
                                </tr>
                                <tr bgcolor="#ffffff">
                                    <td>Name: <?php echo $orderData['bill_firstname']." ".$orderData['bill_lastname'];?></td>
                                </tr>
                                <tr bgcolor="#ffffff"><td>Address : 
                                        <?php echo $orderData['bill_address1'];?>&nbsp;
                                        <?php echo $orderData['bill_city'];?>&nbsp;
                                        <?php echo $orderData['bill_state'];?>&nbsp;
                                        <?php echo $orderData['bill_country'];?>&nbsp;
                                        <?php echo $orderData['bill_zip'];?>
                                </td></tr>
                                <tr bgcolor="#ffffff"><td>
                                        Phone: <?php echo $orderData['bill_phone'];?>
                                </td></tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table width="100%" border='0'>
                                <tr>
                                    <td bgcolor="#f1f1f1" style="padding: 10px;"><b>Shipping Information</b></td>
                                </tr>
                                <tr bgcolor="#ffffff">
                                <td>Name: <?php echo $orderData['ship_firstname']." ".$orderData['ship_lastname'];?></td></tr>
                                <tr>
                                    <td>Address :
                                        <?php echo $orderData['ship_address1'];?>&nbsp;
                                        <?php echo $orderData['ship_city'];?>&nbsp;
                                        <?php echo $orderData['ship_state'];?>&nbsp;
                                        <?php echo $orderData['ship_country'];?>&nbsp;
                                        <?php echo $orderData['ship_zip'];?>
                                </td></tr>
                                <tr bgcolor="#ffffff"><td>
                                        Phone: <?php echo $orderData['ship_phone'];?>
                                </td></tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                </table>

                <table width="100%" border='0'>
                    <tr>
                        <td colspan="6" bgcolor="#f1f1f1" style="padding: 10px;"><b>Order Information</b></td>
                    </tr>
                    <tr bgcolor="#ffffff">
                        <td width="10%"><b>Status</b></td>
                        <td width="25%"><b>Item Name</b></td>
                        <td width="25%"><b>Item Attribute</b></td>
                        <td align="center"><b>Item Qty</b></td>
                        <td align="right"><b>Item Price</b></td>
                        <td align="right"><b>Total Price</b></td>
                    </tr>
                    <?php
                        for($i=0;$i<count($orderItem);$i++){
                        ?>  <tr bgcolor="#ffffff">
                            <td><?php 
                                    if($orderItem[$i]['OrderItem']['status']==2)
                                    echo "Shipped";
                                    elseif($orderItem[$i]['OrderItem']['status']==1)
                                    echo "Processed";
                                    else
                                    echo "Pending";
                                ?>
                            </td>
                            <td><?=$orderItem[$i]['Product']['name']?></td>
                            <td><?=$orderItem[$i]['OrderItem']['attribute_name']?></td>
                            <td align="center"><?=$orderItem[$i]['OrderItem']['quantity']?></td>
                            <td align="right"><?php echo CURRENCY_SYMBOL.number_format($orderItem[$i]['OrderItem']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></td>
                            <td align="right"><?php echo CURRENCY_SYMBOL.number_format(($orderItem[$i]['OrderItem']['quantity']*$orderItem[$i]['OrderItem']['price']),2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></td>
                        </tr>        
                        <?php
                            }
                    ?>
                    <tr>
                        <td colspan="6">
                            <table width="100%" align="center" cellpadding="0" cellspacing="0">
                                <tr bgcolor="#ffffff">
                                    <td colspan="6">
                                        <div align="right"  style="margin-top: 10px;"><b>SubTotal: <?php echo CURRENCY_SYMBOL.number_format($orderData['subtotal'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></b></div>
                                        <div align="right" style="margin-top: 10px; margin-bottom: 10px;">Shipping (+): <?php echo CURRENCY_SYMBOL.number_format($orderData['shipping_price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></div>
                                        <div align="right"><b>Total: <?php echo CURRENCY_SYMBOL.number_format($orderData['order_total'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></b></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </nav>
</div>
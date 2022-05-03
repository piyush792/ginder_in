<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table cellpadding="0" cellspacing="0" width="638" style="table-layout:fixed;">
            <tr>
                <td>
                    <table id="header" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 10px;" width="100%" align="center">
                        <tbody>
                            <tr>
                                <td align="center">
                                    <img src="<?php echo SITE_URL;?>img/mainlogo.png" style="border-color:transparent; border-style:none; border-width:0; display:block; margin: auto;" alt=""  />                            
                                    <br>
                                </td>
                            </tr>                    
                            <tr><td  height="5" style="font-size:1px;">&zwnj;</td></tr>
                        </tbody>
                    </table>

                </td>
            </tr>

            <tr>
                <td>
                    <table width="638" border="0"  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; table-layout: fixed;">
                        <tr>
                            <td height="30" valign="middle" bgcolor="#ececec" align="left" style="padding-left:10px; font-size:12px;" width="300" >Order Number: <?php echo $orderData['id']; ?> </td>
                            <td height="30" valign="middle" bgcolor="#ececec" align="right" style="padding-right:20px; font-size:12px;" width="317"><!--Customer Number:--> <?php //echo $customer_number; ?> </td>
                        </tr>
                        <tr><td colspan="2" style="border-bottom: 1px solid #B4B5B0;">&nbsp;</td></tr>
                        <tr>
                            <td colspan="2">
                             <p style="font-family:Georgia, Times New Roman, Times, serif; font-size:20px; padding-top:20px; padding-left:10px; margin: 0 0 12px 0; font-style:italic; text-transform: uppercase;">
                                  Dear <?php echo $orderData['bill_firstname']." ".$orderData['bill_lastname'];?>,
                             </p>
                             <p style="font:Arial, Helvetica, sans-serif; font-size:12px; margin-top:0; padding-left:10px; margin-bottom:0">Thank you for shopping at <?=SITE_NAME?>.<br/></p>
                             <p style="font:Arial, Helvetica, sans-serif; font-size:12px; margin-top:5px; padding-left:10px; margin-bottom:15px">Here is a summary of the item(s) you have ordered:</p></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style=" padding-top:20px; padding-bottom:10px;" >
                    <table cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width: 638px; table-layout: fixed;" width="638">
                        <tr>
                            <td bgcolor="#ececec" colspan="2" style="color:#666666; padding-left:10px; padding-bottom:5px; text-transform:uppercase;"><b>Billing Information</b></td>
                        </tr>
                        <tr>
                            <td bgcolor="#ececec" style="color:#666666; padding-left:10px; padding-bottom:5px; text-transform:uppercase;"><strong> Shipping Address</strong></td>
                            <td bgcolor="#ececec" style="color:#666666; padding-left:10px; padding-bottom:5px; text-transform:uppercase;"><strong> Billing Address</strong> </td>                    
                        </tr>
                        <tr>
                            <td valign="top" style="padding:10px;">
                                <?php echo $orderData['ship_firstname']." ".$orderData['ship_lastname'];?>
                                <br/>
                                <?php echo $orderData['ship_address1'];?>
                                <br/>
                                <?php echo $orderData['ship_city'];?>
                                <br/>
                                <?php echo $orderData['ship_state'];?>
                                <br/>
                                <?php echo $orderData['ship_zip'];?>
                                <br/>
                                <?php echo $orderData['ship_country'];?>
                            </td>

                            <td style="padding:10px;" valign="top">
                                <?php echo $orderData['bill_firstname']." ".$orderData['bill_lastname'];?>
                                <br/>
                                <?php echo $orderData['bill_address1'];?>
                                <br/>
                                <?php echo $orderData['bill_city'];?>
                                <br/>
                                <?php echo $orderData['bill_state'];?>
                                <br/>
                                <?php echo $orderData['bill_zip'];?>
                                <br/>
                                <?php echo $orderData['bill_country'];?>
                            </td>                
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td>
                    <table id="desc-main" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; table-layout: fixed;" width="638">
                        <tr>
                            <td bgcolor="#ececec" style="color:#666666; padding-left:10px; padding-bottom:5px; text-transform:uppercase;"><b>Order Information</b></td>
                        </tr>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; table-layout: fixed;" width="638">
                                    <tr bgcolor="#ececec">
                                        <td width="25%" align="left" style="color:#666666; padding-left:10px; padding-bottom:5px; text-transform:uppercase;"><b>Item Name</b></td>
                                        <td width="25%" align="left" style="color:#666666; padding-left:10px; padding-bottom:5px; text-transform:uppercase;"><b>Item Attribute</b></td>
                                        <td width="10%" align="left" style="color:#666666; padding-bottom:5px; text-transform:uppercase;"><b>Item Qty</b></td>
                                        <td width="20%" align="right" style="color:#666666;padding-right:30px; padding-bottom:5px; text-transform:uppercase;" ><b>Item Price</b></td>
                                        <td width="20%" align="right" style="color:#666666;padding-right:30px; padding-bottom:5px; text-transform:uppercase;" nowrap="nowrap"><b>Total Price</b></td>
                                    </tr>
                                    <?php
                                        for($i=0;$i<count($orderItem);$i++){
                                        ?>
                                        <tr>
                                            <td style="padding-left:10px; padding-bottom:10px; padding-top:10px"><?=$orderItem[$i]['Product']['name']?></td>
                                            <td style="padding-left:10px; padding-bottom:10px; padding-top:10px"><?=$orderItem[$i]['OrderItem']['attribute_name']?></td>
                                            <td align="center" style="padding-bottom:10px; padding-top:10px"><?=$orderItem[$i]['OrderItem']['quantity']?></td>
                                            <td align="right" style="padding-right:20px; padding-bottom:10px; padding-top:10px">
                                                <?php echo CURRENCY_SYMBOL.number_format($orderItem[$i]['OrderItem']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?>
                                            </td>
                                            <td align="right" style="padding-right:20px; padding-bottom:10px; padding-top:10px">
                                                <?php echo CURRENCY_SYMBOL.number_format(($orderItem[$i]['OrderItem']['quantity']*$orderItem[$i]['OrderItem']['price']),2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                    ?>
                        </table></td></tr>
                         <tr><td><hr /></td></tr>
                        <tr>
                            <td  align="right" style="font-weight:bold; padding-right:20px; padding-top:5px;">
                                <b>SubTotal: <?php echo CURRENCY_SYMBOL.number_format($orderData['subtotal'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></b>
                            </td>
                        </tr>
                        <?php 
                            if($orderData['shipping_price']){
                            ?>  <tr>
                                <td  align="right" style="font-weight:bold; padding-right:20px; padding-top:5px;">
                                    Shipping (+): <?php echo CURRENCY_SYMBOL.number_format($orderData['shipping_price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?>
                                </td>
                            </tr>  
                            <?php 
                        }?>
                        <?php 
                            if($orderData['coupon_discount']){
                            ?>  <tr>
                                <td  align="right" style="font-weight:bold; padding-right:20px; padding-top:5px;">
                                    Coupon Discount (-): <?php echo CURRENCY_SYMBOL.number_format($orderData['coupon_discount'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?>
                                </td>
                            </tr>  
                            <?php 
                        }?>
                        <tr>
                            <td  align="right" style="font-weight:bold; padding-right:20px; padding-top:5px;">
                                <b>Total: <?php echo CURRENCY_SYMBOL.number_format($orderData['order_total'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td style="height:10px;"></td></tr>
            <tr>
                <td align="center" style="color:#A1A1A1; font-family:Georgia,Times,'Times New Roman',serif; font-size:10px; padding-bottom:8px; padding-left:40px; padding-right:40px; padding-top:12px;">                   
                    <p style="margin: 1em 0;">&copy;Copyright <?php echo date('Y');?>&nbsp;&nbsp;<a href="<?php echo SITE_URL;?>" style="color:#A1A1A1; text-decoration:underline; white-space:nowrap;" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a></p>
                </td>
            </tr>
        </table>
    </body>
</html>
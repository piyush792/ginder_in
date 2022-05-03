<?php
class OrderBaseComponent extends Component{  
    
    public function genrate_invoice($order_id)
    {
        $output = array();   
        $subtotal_without_discount=0;                                                
        $coupon_discount=0;
        $subtotal_after_discount=0;     
        $shipping_price=0;
        $vat_charges=0;
        $grand_total=0; 

        $this->Order = ClassRegistry::init('Order');
        $this->OrderItem = ClassRegistry::init('OrderItem');

        $orderList = $this->Order->find("all",array("fields"=>array('Order.*'),"conditions"=>array("Order.id"=>$order_id))); 
        
        $customer_email = $orderArr[0]['Order']['order_email']; 
        $customer_name = $orderList[0]['Order']['bill_firstname'].'&nbsp;'.$orderList[0]['Order']['bill_lastname']; 

        $shipping_billing_info ='<tr bgcolor="#ececec">
        <td valign="top" style="padding:10px;">'.$orderList[0]['Order']['ship_firstname'].'&nbsp;'.$orderList[0]['Order']['ship_lastname'].'
        <br/>
        '.$orderArr[0]['Order']['ship_address1'].'
        <br/>
        '.$orderArr[0]['Order']['ship_city'].'
        <br/>
        '.$orderArr[0]['Order']['ship_state'].'
        <br/>
        '.$orderArr[0]['Order']['ship_zip'].'
        <br/>
        '.$orderArr[0]['Order']['ship_country'].'                                
        </td>
        <td style="padding:10px;" valign="top">
        '.$orderArr[0]['Order']['bill_title'].$orderList[0]['Order']['bill_firstname'].'&nbsp;'.$orderList[0]['Order']['bill_lastname'].'
        <br/>
        '.$orderArr[0]['Order']['bill_address1'].'
        <br/>
        '.$orderArr[0]['Order']['bill_city'].'
        <br/>
        '.$orderArr[0]['Order']['bill_state'].'
        <br/>
        '.$orderArr[0]['Order']['bill_zip'].'
        <br/>
        '.$orderArr[0]['Order']['bill_country'].'                
        </td>                
        </tr>';

        $orderArr = $this->OrderItem->find("all",array("fields"=>array('OrderItem.*','Product.name',"Product.image"),
                                                            "order"=>'OrderItem.id Desc',
                                                             "joins"=>array(
                                                                            array('table'=>'products',
                                                                            'alias'=>'Product',
                                                                            'conditions'=>array('Product.id = OrderItem.product_id')
                                                                            )
                                                                          ),
                                                             "conditions"=>array("OrderItem.order_id"=>$order_id)
                                                            ));            

        $orderTR ='<tr>
        <td ><table cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; table-layout: fixed;" width="638">
        <tr>
        <td style="color:#666666; padding-left:10px; padding-bottom:5px; text-transform:uppercase;">Description</td>
        <td align="center" style="color:#666666; padding-bottom:5px; text-transform:uppercase;" width="80">Quantity</td>
        <td style="color:#666666;padding-right:30px; padding-bottom:5px; text-transform:uppercase;" width="80" align="right">Price</td>
        </tr>';

        for($i=0;$i<count($orderArr);$i++)
        {   
            $productName = ucfirst(strtolower($orderArr[$i]['Product']['name']));
            $orderTR .='<tr bgcolor="#ececec">
            <td style="padding-left:10px; padding-bottom:10px; padding-top:10px" > <table width="100%">
            <tr><td>'.$productName.'</td></tr>
            <tr><td><table '.$table_border.' width="80%">
            '.$product_detail.'</table></td></tr>
            </table></td>
            <td align="center" style="padding-bottom:10px; padding-top:10px">'.$orderArr[$i]['OrderItem']['quantity'].'</td>
            <td align="right" style="padding-right:20px; padding-bottom:10px; padding-top:10px">'.$symbole.number_format($orderArr[$i]['OrderItem']['price']*$convertion_rate,2,'.','').'</td>
            </tr>';
        }
        $orderTR .='</table></td></tr>';


        $subtotal_without_discount = $orderList[0]['Order']['subtotal']; 

        $coupon_discount = $orderList[0]['Order']['coupon_discount'];

        $subtotal_after_discount=  $subtotal_without_discount- $coupon_discount;

        $shipping_price = $orderList[0]['Order']['shipping_price']; 

        $vat_charges = $orderList[0]['Order']['tax'];

        $grand_total = $orderList[0]['Order']['order_total'];

        $output['without_discount']= $symbole.number_format($subtotal_without_discount*$convertion_rate, 2, '.', '');
        $output['order_total']= $symbole.number_format($subtotal_after_discount*$convertion_rate, 2, '.', '');
        $output['tax']= $symbole.number_format($vat_charges * $convertion_rate,2,'.','');
        $output['shipping_price']= $symbole.number_format($shipping_price*$convertion_rate, 2, '.', '');
        $output['grand_total']= $symbole.number_format($grand_total*$convertion_rate,2,'.','');



        if($orderArr[0]['Order']['coupon_discount']>0)
        {
            $output['coupon_discount']= $symbole.number_format($coupon_discount*$convertion_rate, 2, '.', '');

            $output['after_discount']= $symbole.number_format($subtotal_after_discount*$convertion_rate, 2, '.', '');
        }
        else
        {
            $output['coupon_discount']='';
            $output['after_discount']='';
        }
        $shipping_price=0;

        if($orderArr[0]['Order']['shipping_price']!='' || $orderArr[0]['Order']['shipping_price']>0)
        {
            $shipping_price =  '&pound; &nbsp;'.$orderArr[0]['Order']['shipping_price'];
        }
        else
        {
            $shipping_price =  '&pound; &nbsp; 0';
        }
        $output['customer_email']= $customer_email;
        $output['customer_name']= $customer_name;
        $output['customer_number']= $orderArr[0]['Order']['user_id'];
        $output['order_number']= $orderArr[0]['Order']['id'];
        $output['shipping_billing_info']= $shipping_billing_info;
        $output['orderTR']= $orderTR;           
        $output['order_number']= $order_number;
        $output['oreder_created']= $orderArr[0]['Order']['created'];
        return $output;

    }
}  
?>

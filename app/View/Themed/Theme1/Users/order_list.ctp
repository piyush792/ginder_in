<?php 
    $this->start('inline');
    echo $this->Html->css("siteStyle");
    $this->end();
?>
<div class="pagewrap">
    <nav>
        <?php echo $this->element('user_links'); ?>
        <div class="information">
            <h3>Recent Orders</h3> 

            <div class="body_content" style="min-height: 300px;"> 
                <table width="100%" height="100%" cellspacing="0" cellpadding="5" border="0">
                    <tbody>
                        <tr>
                            <td align="left" valign="top" class="XPSilverText">
                                <?php
                                    if(count($orderList) > 0){
                                    ?>
                                    <table cellspacing="1" cellpadding="6" border="0" align="left" width="100%" class="formtext">
                                        <tbody>
                                            <tr><td align="center" colspan="12"></td></tr>
                                            <tr bgcolor="#f2f2f2">
                                                <td><strong>Order#</strong></td>                           
                                                <td><strong>Order Date</strong></td>                                   
                                                <td><strong>Customer</strong></td>                                   
                                                <td><strong>Order Total</strong></td>
                                                <td><strong>Status</strong></td>
                                                <td><strong>Action</strong></td>                            
                                            </tr>
                                            <?php
                                                for($i=0;$i<count($orderList);$i++){
                                                    $customername = $orderList[$i]['Order']['bill_firstname']." ".$orderList[$i]['Order']['bill_lastname'];
                                                    if($orderList[$i]['Order']['order_status']==0)
                                                    $orderstatus = "Pending";
                                                    elseif($orderList[$i]['Order']['order_status']==1)
                                                    $orderstatus = "Processing";
                                                    elseif($orderList[$i]['Order']['order_status']==2)
                                                    $orderstatus = "Shipped";

                                                    echo "<tr>";
                                                    echo "<td>".$orderList[$i]['Order']['id']."</td>";
                                                    echo "<td>".$orderList[$i]['Order']['order_date']."</td>";
                                                    echo "<td>".$customername."</td>";                                                              
                                                    echo "<td>".CURRENCY_SYMBOL.number_format($orderList[$i]['Order']['order_total'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR)."</td>";                              
                                                    echo "<td>".$orderstatus."</td>";
                                                    echo "<td>".$this->Html->link('View',array('controller'=>'users', 'action'=>'order_detail', $orderList[$i]['Order']['id']),array());
                                                }
                                            ?>
                                            <tr>
                                                <td colspan="6"  nowrap="nowrap">
                                                    <div class="paginations">
                                                        <ul style="margin-left: 725px;">
                                                            <?php 
                                                                echo $this->Paginator->prev("",array('escape'=>false,'tag'=>'li'), null, array('class'=>'previous disabled','escape'=>false,'tag'=>'li'));
                                                                echo $this->Paginator->numbers(array('tag'=>'li','separator'=>'','ellipsis' =>'...','currentClass'=>'active'));
                                                                echo $this->Paginator->next("", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                                                            ?>
                                                        </ul>           
                                                    </div>          
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>        
                                    <?php
                                        }else{
                                        echo "There is no order placed by you.";
                                    }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>                
            </div>
        </div>

    </nav>
</div>
<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");

echo $this->Html->script("admin/jquery-1.8.3.min"); 
echo $this->Html->script("admin/jquery-ui-1.8.22.custom.min"); 


$direction = $this->Paginator->sortDir();
$image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
$key =$this->Paginator->sortKey();
$id_link  = ($key=='User.id')?$this->Html->image(SITE_URL."img/".$image):'';
$order_date  = ($key=='Order.order_date')?$this->Html->image(SITE_URL."img/".$image):''; 
$name  = ($key=='User.firstname')?$this->Html->image(SITE_URL."img/".$image):''; 
?>

<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Manage Orders</h3>
                    </div>
                    <div class="box-head">
                        <?php echo $this->Form->create("Order",array("type"=>"post","url"=>"/admin/orders/index")); ?>
                        <table width="100%" align="left" border="0">
                            <tr>
                                <td width="16%" align="left"><b>Start Date (click on box)</b>: </td>
                                <td align=left width="20%">
                                  <?php echo $this->Form->input("start_date",array("id"=>"start_date","class"=>"datepick","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?>
                                </td>
                                <td width="16%" align="center"><b>End Date (click on box)</b>:</td>
                                <td width="20%">
                                  <?php echo $this->Form->input("end_date",array("id"=>"end_date","class"=>"datepick","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?>                                    
                                </td>
                                <td align="left">
                                    <?php echo $this->Form->input("Submit",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false,'style'=>'margin-top:10px;'));?>&nbsp;
                                </td>
                            </tr>
                        </table>
                        <?php echo $this->Form->end();?>                   
                    </div>
                    
                    <div class="box-content box-nomargin">
                        <?php echo $this->Session->flash();?>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr bgcolor="#f2f2f2">
                                <td><strong> <?php echo $this->Paginator->sort('Order.id', 'Id'.$id_link,array('escape' => false)); ?>                                             </strong></td>                           
                                <td><strong><?php echo $this->Paginator->sort('Order.order_date', 'Order Date'.$order_date,array('escape' => false)); ?></strong></td>                                   
                                <td><strong><?php echo $this->Paginator->sort('User.firstname', 'Customer Name'.$name,array('escape' => false)); ?>        </strong></td>                                   
                                <td><strong>Order Total</strong></td>
                                <!--<td><strong>Status</strong></td>-->
                                <td><strong>Action</strong></td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    for($i=0;$i<count($orderList);$i++)
                                    {
                                        if($orderList[$i]['Order']['user_id']>0)
                                        $customername = @$orderList[$i]['Order']['firstname']." ".@$orderList[$i]['Order']['lastname'];
                                        else
                                        $customername = $orderList[$i][0]['firstname']." ".$orderList[$i]['Order']['lastname']." [Guest]";
                                        
                                        /*if($orderList[$i]['Order']['order_status']==0)
                                        $orderstatus = "Pending";
                                        elseif($orderList[$i]['Order']['order_status']==1)
                                        $orderstatus = "Processing";
                                        elseif($orderList[$i]['Order']['order_status']==2)
                                        $orderstatus = "Shipped";  */
                                        
                                        echo "<tr>";
                                        echo "<td>".$orderList[$i]['Order']['id']."</td>";
                                        echo "<td>".CakeTime::format('m/d/Y', $orderList[$i]['Order']['order_date'])."</td>";
                                        echo "<td>".$customername."</td>";                                                              
                                        echo "<td>".CURRENCY_SYMBOL.number_format($orderList[$i]['Order']['order_total'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR)."</td>";                              
                                        //echo "<td>".$orderstatus."</td>";
                                        echo "<td>".$this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/zoom.png"),array('controller'=>'orders', 'action'=>'view', $orderList[$i]['Order']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"View"));
                                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller'=>'orders', 'action'=>'delete', $orderList[$i]['Order']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this Order?");
                                        echo "</tr>";                            
                                    }
                                ?>

                            </tbody>
                        </table>        

                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-head">
                    <div class="dataTables_paginate paging_bootstrap pagination">
                        <ul>
                            <?php 
                                $arg1 = array();
                                $arg2 = array();
                                //take the named url
                                if(!empty($start_date))
                                $arg1 = array("start_date" =>$start_date);
                                //take the pass arguments
                                if(!empty($end_date))
                                $arg2 = array("end_date" => $end_date);
                                //merge named and pass
                                $args = array_merge($arg1,$arg2);
                                
                                echo $this->Paginator->first("First" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'first disabled','escape'=>false,'tag'=>'li'));
                                echo $this->Paginator->prev("&larr; Previous" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'prev disabled','escape'=>false,'tag'=>'li'));
                                echo '&nbsp;'.$this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active')); 
                                echo $this->Paginator->next("Next &rarr;", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                                echo $this->Paginator->last("Last", array('escape'=>false,'tag'=>'li'), null, array('class' => 'last disabled','escape'=>false,'tag'=>'li'));
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
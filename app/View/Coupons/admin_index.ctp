<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");

if($searchKey!=''){
    $this->Paginator->options(array('url' => array('search' => $searchKey)));    
}
?>
<div class="container-fluid">
<div class="content">
    <div class="row-fluid no-margin">
        <div class="span12">
            <ul class="quicktasks">
                <li>

                    <?php
                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/32/basket.png")."<span>Add Coupon</span>",array('controller' => 'coupons', 'action' => 'add'),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Add New Coupon"));
                    ?>
                </li>
            </ul>
        </div>
    </div>     
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <div class="box-head">
                    <h3>Manage Coupons</h3>
                </div>
                <div class="box-head">
                        <?php echo $this->Form->create("Coupon",array('type'=>'post'));?>
                        <table width="40%" align="left" border="0">
                            <tr>
                                <td align="left" width="20%"><?php echo $this->Form->input("searchKey",array("id"=>"searchKey","type"=>"text","label"=>false,"size"=>10,"div"=>false,'style'=>'margin-bottom: 0px;'));?></td>
                                <td align="left"><?php echo $this->Form->input("Search",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false));?></td>
                            </tr>
                        </table>
                        <?php echo $this->Form->end();?>                   
                    </div>
                <div class="box-content box-nomargin">
                    <?php echo $this->Session->flash();?>
                    <table class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <td align="left" width="5%"><strong>Coupon#</strong></td>
                                <td align="left" width="15%"><strong>Code</strong></td>
                                <td align="left" width="10%"><strong>Type</strong></td>
                                <td align="left" width="10%"><strong>Value</strong></td>
                                <td align="left" width="10%"><strong>From</strong></td>
                                <td align="left" width="10%"><strong>To</strong></td>
                                <td align="left" width="10%"><strong>Max Uses</strong></td>
                                <td align="left" width="10%"><strong>No. Used</strong></td>
                                <td align="left" width="10%"><strong>Status</strong></td>
                                <td align="left" width="10%"><strong>Action</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                for($i=0;$i<count($couponlist);$i++)
                                {
                                       if($couponlist[$i]['Coupon']['maximum_uses']=="0"){
                                        $percentageUses = "";
                                       }else{
                                            $percentageUses = " (".$couponlist[$i]['Coupon']['number_of_uses']*100/$couponlist[$i]['Coupon']['maximum_uses']."%)";
                                       }
                                   
                                    echo "<tr>";
                                    echo "<td>".$couponlist[$i]['Coupon']['id']."</td>";
                                    echo "<td>".$couponlist[$i]['Coupon']['code']."</td>";                                
                                    echo "<td>".$couponlist[$i]['Coupon']['coupon_type']."</td>";
                                    if($couponlist[$i]['Coupon']['coupon_value']=='$'){
                                        echo "<td>$".$couponlist[$i]['Coupon']['coupon_value']."</td>";    
                                    }else{
                                        echo "<td>".$couponlist[$i]['Coupon']['coupon_value']."</td>";    
                                    }
                                    
                                    echo "<td>".$couponlist[$i]['Coupon']['from_date']."</td>";
                                    echo "<td>".$couponlist[$i]['Coupon']['to_date']."</td>";
                                    echo "<td>".$couponlist[$i]['Coupon']['maximum_uses']."</td>";
                                    echo "<td>".$couponlist[$i]['Coupon']['number_of_uses'].$percentageUses."</td>";
                                    echo "<td>".(($couponlist[$i]['Coupon']['active'])==1 ? "Active":"Inactive")."</td>";     

                                    if($searchKey!='')
                                    {
                                        echo "<td>". $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller'=>'coupons', 'action'=>'edit', $couponlist[$i]['Coupon']['id'],'?'=>array('page'=>$page,'search'=>$searchKey)),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                                    }
                                    else
                                    {
                                        echo "<td>". $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller'=>'coupons', 'action'=>'edit', $couponlist[$i]['Coupon']['id'],'?'=>array('page'=>$page)),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                                    }
                                    echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller'=>'coupons', 'action'=>'delete', $couponlist[$i]['Coupon']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this Coupon?")."</td>"; 
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
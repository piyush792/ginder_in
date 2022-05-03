<?php echo $this->element("admin_header"); 
    echo $this->element("admin_dashboard"); 
    echo $this->element("admin_left");
    $direction = $this->Paginator->sortDir();
    $image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
    $key =$this->Paginator->sortKey();
    $id_link  = ($key=='Product.id')?$this->Html->image(SITE_URL."img/".$image):'';
    $name_link  = ($key=='Product.name')?$this->Html->image(SITE_URL."img/".$image):''; 
    $price_link  = ($key=='Product.price')?$this->Html->image(SITE_URL."img/".$image):''; 
    $qty_link  = ($key=='total_qty')?$this->Html->image(SITE_URL."img/".$image):''; 
    //$active_link  = ($key=='UserComment.active')?$this->Html->image(SITE_URL."img/".$image):''; 
?>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Top Orders By Products</h3>
                    </div>
                    <div class="box-content box-nomargin">
                        <?php echo $this->Session->flash();?> 
                        <?php
                            echo $this->Form->create("Order",array("type"=>"post","url"=>SITE_URL."admin/orders/top_order_product_report"));
                        ?>
                        <table width="100%" align="left" border="0">

                            <tr>
                                <td colspan="5">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="20%" align="right"><b>Start Date (click on box)</b>: </td>
                                <td align=left width="20%">
                                    <?php //echo $this->Form->input('start_date',array('label'=>false,'id'=>'start_date',"div"=>false,'size'=>40,"class"=>"input-square","value"=>$start_date));?>
                                     <?php
                                        echo $this->Form->input("start_date",array("id"=>"start_date","class"=>"datepick","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?>
                                </td>
                                <td width="20%" align="right"><b>End Date (click on box)</b>:</td>
                                <td width="20%">
                                 <?php
                                        echo $this->Form->input("end_date",array("id"=>"end_date","class"=>"datepick","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?>
                                    <?php //echo $this->Form->input('end_date',array('label'=>false,'id'=>'end_date',"div"=>false,'size'=>40,"class"=>"input-square","value"=>$end_date));?>                                    
                                </td>
                                <td align="left"><?php echo $this->Form->input("submit",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false));?>&nbsp;</td>
                            </tr>
                        </table>
                        <?php
                            echo $this->Form->end();

                        ?>                   

                        <table class='table table-striped table-bordered'>
                            <thead>

                                <tr bgcolor="#f2f2f2">
                                    <td><strong> <?php echo $this->Paginator->sort('Product.id', 'ProductId'.$id_link,array('escape' => false)); ?>                                             </strong></td>                           
                                    <td><strong><?php echo $this->Paginator->sort('Product.name', 'Name'.$name_link,array('escape' => false)); ?>        </strong></td>
                                    <td><strong>Seller Name</strong></td>
                                    <td><strong><?php 

                                        echo $this->Paginator->sort('total_qty', 'Total Qty'.$qty_link,array('escape' => false)); ?></strong></td>
                                    <td><strong><?php 

                                        echo $this->Paginator->sort('Product.price', 'Price'.$price_link,array('escape' => false)); ?></strong></td>
                                    <!-- <td><strong>Action</strong></td>-->
                            </tr></thead>
                            <tbody>
                                <?php

                                    for($i=0;$i<count($qtyorderList);$i++)
                                    {

                                        echo "<tr>";
                                        echo "<td>".$qtyorderList[$i]['Product']['id']."</td>";
                                        echo "<td>".$qtyorderList[$i]['Product']['name']."</td>";
                                        echo "<td>".$qtyorderList[$i][0]['seller_name']."</td>"; 
                                        echo "<td>".$qtyorderList[$i][0]['total_qty']."</td>"; 
                                        echo "<td>$".$qtyorderList[$i]['Product']['price']."</td>"; 
                                        /* echo "<td>".$this->Html->link("Export Report",array('controller' => 'orders', 'action' => 'export_report', $start_date,$end_date),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Export Report"))."</td>";*/

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
<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
?>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid no-margin">
            <div class="span12">
                <ul class="quicktasks">
                    <li>

                        <?php
                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/32/basket.png")."<span>Add New product</span>",array('controller' => 'products', 'action' => 'add'),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Add New Product"));
                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Products</h3>
                    </div>
                    <div class="box-head">
                        <?php
                            echo $this->Form->create("Product",array("type"=>"post"));
                        ?>
                        <table width="100%" align="left" border="0">
                            <tr>
                                <td width="20%" align="right" colspan="3" style="border-left:0px;"><b>Search</b>: &nbsp;&nbsp;</td>
                                <td align=left width="20%" style="border-left:0px;">
                                    <?php
                                        echo $this->Form->input("searchKey",array("id"=>"searchKey","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?>
                                </td>                                
                                <td align="left"  style="border-left:0px;"><?php echo $this->Form->input("submit",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false));?>&nbsp;</td>
                            </tr>
                        </table>
                        <?php
                            echo $this->Form->end();

                        ?>     
                    </div>
                    <div class="box-content box-nomargin">
                        <?php echo $this->Session->flash();?>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Id <?php
                                            //echo $this->Paginator->sort('ProductAttributes.id', 'Id'.$id_link,array('escape' => false))
                                    ?></th>
                                    <th>Name <?php 

                                           // echo $this->Paginator->sort('ProductAttributes.attribute_code', 'Name'.$name_link,array('escape' => false));                                
                                        ?>
                                    </th>
                                    <th> Active<?php 

                                        //echo $this->Paginator->sort('ProductAttributes.active', 'Active'.$price_link,array('escape' => false));?></th>
                                    <th>Created <?php 

                                       // echo $this->Paginator->sort('ProductAttributes.created', 'Created'.$price_link,array('escape' => false));?></th>
                                   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    for($i=0;$i<count($productList);$i++)
                                    {
                                        /*$cat_name =($productList[$i]['Category']['cat_name'])?$productList[$i]['Category']['cat_name']:'';      */
                                        echo "<tr>";
                                        echo "<td width='5%'>".$productList[$i]['ProductAttributes']['id']."</td>";
                                        echo "<td width='20%'>".$productList[$i]['ProductAttributes']['attribute_code']."</td>";                                               
                                        echo "<td width='30%' align='center'>".(($productList[$i]['ProductAttributes']['active'])==1 ? "Active":"Inactive")."</td>";
                                        echo "<td width='30%'>".$productList[$i]['ProductAttributes']['created']."</td>";  
                                        echo "<td class='actions_big' width='60%'><div class='btn-group'>";

                                        //echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/showreel.png"),array('controller' => 'product_videos', 'action' => 'index', $productList[$i]['Product']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Product Videos"));
                                       /* if($searchKey!='')
                                        {
                                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller' => 'products', 'action' => 'product_attributes_edit', $productList[$i]['ProductAttributes']['id'],'?'=>array('page'=>$page,'search'=>$searchKey)),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                                        }
                                        else
                                        {*/
                                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller' => 'products', 'action' => 'product_attributes_edit', $productList[$i]['ProductAttributes']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                                        //}

                                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller' => 'products', 'action' => 'product_attributes_delete', $productList[$i]['ProductAttributes']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this Product?");

                                        echo "</div></td></tr>";                            
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
                              /*  echo $this->Paginator->first("First" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'first disabled','escape'=>false,'tag'=>'li'));
                                echo $this->Paginator->prev("&larr; Previous" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'prev disabled','escape'=>false,'tag'=>'li'));

                                echo '&nbsp;'.$this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active')); 
                                echo $this->Paginator->next("Next &rarr;", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                                echo $this->Paginator->last("Last", array('escape'=>false,'tag'=>'li'), null, array('class' => 'last disabled','escape'=>false,'tag'=>'li'));
                           
                           */ ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
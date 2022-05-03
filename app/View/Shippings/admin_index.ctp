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
                        <h3>Shipping Methods</h3>
                    </div>
                    <div class="box-content box-nomargin">
                        <?php echo $this->Session->flash();?>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr bgcolor="#f2f2f2">
                                    <td><strong>Id</strong></td>
                                    <td><strong>Name</strong></td>
                                    <td><strong>Status</strong></td>
                                    <td><strong>Action</strong></td>
                            </tr></thead>
                            <tbody>
                                <?php
                                    for($i=0;$i<count($shipingList);$i++)
                                    {
                                        $block = ($shipingList[$i]['Shipping']['active'])==1 ? false :true;
                                        
                                        if($shipingList[$i]['Shipping']['ship_method']==1){
                                            $action='';
                                        }elseif($shipingList[$i]['Shipping']['ship_method']==2){
                                            $action='fedex';  
                                        }elseif($shipingList[$i]['Shipping']['ship_method']==3){
                                            $action='ups'; 
                                        }
                                        
                                        
                                        echo "<tr>";
                                        echo "<td>".$shipingList[$i]['Shipping']['id']."</td>";
                                        echo "<td>".$shipingList[$i]['Shipping']['ship_name']."</td>";                                
                                        echo "<td>".(($shipingList[$i]['Shipping']['active'])==1 ? "Active":"Inactive")."</td>";                                
                                        
                                        echo "<td>";
                                        if($block==true) {
                                            echo $this->Html->image(SITE_URL."img/icons/fugue/slash.png",array("class"=>"btn btn-mini tip","disabled"=>true));
                                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/check.png"),array('controller' => 'Shippings', 'action' => 'unblock', $shipingList[$i]['Shipping']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Active"),"Are you sure to unblock this Shipping?");
                                        }else{
                                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/slash.png"),array('controller' => 'Shippings', 'action' => 'block', $shipingList[$i]['Shipping']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Inactive"),"Are you sure to block this Shipping?");
                                            echo $this->Html->image(SITE_URL."img/icons/essen/16/check.png",array("class"=>"btn btn-mini tip","disabled"=>true));
                                        }
                                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller'=>'Shippings', 'action'=>$action, $shipingList[$i]['Shipping']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit")); 
                                       // echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller'=>'users', 'action'=>'delete', $userList[$i]['User']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this User?");
                                        echo "</td>"; 
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
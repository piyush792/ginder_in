<?php echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");

    $direction = $this->Paginator->sortDir();
    $image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
    $key =$this->Paginator->sortKey();
    $id_link  = ($key=='Rating.id')?$this->Html->image(SITE_URL."img/".$image):'';
    $email_link  = ($key=='Rating.description')?$this->Html->image(SITE_URL."img/".$image):''; 
    $active_link  = ($key=='Rating.active')?$this->Html->image(SITE_URL."img/".$image):''; 
?>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Reviews</h3>
                    </div>
                    <div class="box-content box-nomargin">
                    <?php echo $this->Session->flash();?>                    
                      
                        <table class='table table-striped table-bordered'>
   <thead>
                        <tr bgcolor="#f2f2f2">
                            <td><strong> <?php echo $this->Paginator->sort('Rating.id', 'Id'.$id_link,array('escape' => false)); ?>                                             </strong></td>                           
                            <td><strong><?php echo $this->Paginator->sort('Rating.description', 'Ratings'.$email_link,array('escape' => false)); ?>        </strong></td>
                            <td><strong><?php 

                                        echo $this->Paginator->sort('UserComment.active', 'Active'.$active_link,array('escape' => false)); ?></strong></td>
                            <td><strong>Action</strong></td>
                        </tr></thead>
                        <tbody>
                        <?php
                        
                            for($i=0;$i<count($commentList);$i++)
                            {
                                $block = ($commentList[$i]['Rating']['active'])==1 ? false :true;
                                echo "<tr>";
                                echo "<td>".$commentList[$i]['Rating']['id']."</td>";
                                echo "<td>".$commentList[$i]['Rating']['description']."</td>";
                                echo "<td>".(($commentList[$i]['Rating']['active'])==1 ? "Active":"Inactive")."</td>";                                
                             
                                echo "<td>".$this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller'=>'users', 'action'=>'comment_delete', $commentList[$i]['Rating']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this Review?");                                
                                
                                if($block==true) {
                                    echo $this->Html->image(SITE_URL."img/icons/fugue/slash.png",array("class"=>"btn btn-mini tip","disabled"=>true));
                                    echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/check.png"),array('controller' => 'users', 'action' => 'comment_unblock', $commentList[$i]['Rating']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Unblock"),"Are you sure to unblock this Review?");
                                }
                                else
                                {
                                    echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/slash.png"),array('controller' => 'users', 'action' => 'comment_block', $commentList[$i]['Rating']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Block"),"Are you sure to block this Review?");
                                    echo $this->Html->image(SITE_URL."img/icons/essen/16/check.png",array("class"=>"btn btn-mini tip","disabled"=>true));
                                }
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
<?php 
    echo $this->element("admin_header"); 
    echo $this->element("admin_dashboard"); 
    echo $this->element("admin_left");

    $direction = $this->Paginator->sortDir();
    $image =($direction=='asc')?'sort_asc.png':'sort_desc.png';  
    $key =$this->Paginator->sortKey();
    $id_link  = ($key=='Newsletter.id')?$this->Html->image(SITE_URL."img/".$image):'';
    $Newsletter_title_link   = ($key=='Newsletter.title')?$this->Html->image(SITE_URL."img/".$image):'';     
    $Newsletter_subject_link   = ($key=='Newsletter.subject')?$this->Html->image(SITE_URL."img/".$image):'';     
    $Newsletter_message_link   = ($key=='Newsletter.message')?$this->Html->image(SITE_URL."img/".$image):'';     
?>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid no-margin">
            <div class="span12">
                <ul class="quicktasks">
                    <li>

                        <?php
                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/32/project.png")."<span>Add New Newsletter</span>",array('controller' => 'Newsletters', 'action' => 'add'),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Add New Newsletter"));
                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head tabs">
                        <h3>Newsletters List</h3>

                    </div>
                    <div class="box-content box-nomargin">
                        <?php echo $this->Session->flash();?>
                        <!--<table class='table table-striped dataTable dataTable-noheader dataTable-nofooter table-bordered'>-->
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>                               
                                        <?php 
                                            echo $this->Paginator->sort('Newsletter.id', 'Id'.$id_link,array('escape' => false)); ?>
                                    </th>
                                    <th><?php 
                                        echo $this->Paginator->sort('Newsletter.title', 'Title'.$Newsletter_title_link,array('escape' => false)); ?></th>
                                    <th><?php 
                                        echo $this->Paginator->sort('Newsletter.subject', 'Subject'.$Newsletter_subject_link,array('escape' => false)); ?></th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    for($i=0;$i<count($NewsletterList);$i++)
                                    {
                                        echo "<tr>";
                                        echo "<td width='5%'>".$NewsletterList[$i]['Newsletter']['id']."</td>";
                                        echo "<td width='20%'>".$NewsletterList[$i]['Newsletter']['title']."</td>"; 
                                         echo "<td width='30%'>".$NewsletterList[$i]['Newsletter']['subject']."</td>";
                                          
                                                                   
                                        echo "<td width='30%' align='center'>".(($NewsletterList[$i]['Newsletter']['active'])==1 ? "Active":"Inactive")."</td>";           
                                        echo "<td class='actions_big' width='60%'><div class='btn-group'>";
                                        
                                          echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller' => 'newsletters', 'action' => 'edit', $NewsletterList[$i]['Newsletter']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                                        
                                             echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller' => 'newsletters', 'action' => 'delete', $NewsletterList[$i]['Newsletter']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this Newsletter.");
                                         echo "</div></td></tr>";
                                        
                                           // echo "</table></td></tr>";
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

<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");

$direction = $this->Paginator->sortDir();
$image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
$key =$this->Paginator->sortKey();
$title_link  = ($key=='Banner.title')?$this->Html->image(SITE_URL."img/".$image):'';
$sort_link  = ($key=='Banner.sort')?$this->Html->image(SITE_URL."img/".$image):''; 
$active_link  = ($key=='Banner.active')?$this->Html->image(SITE_URL."img/".$image):''; 
?>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid no-margin">
            <div class="span12">
                <ul class="quicktasks">
                    <li>

                        <?php
                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/32/basket.png")."<span>Add New Banner</span>",array('controller' => 'banners', 'action' => 'add'),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Add New Banner"));
                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Home Page Banners</h3>
                    </div>
                    <div class="box-content box-nomargin">
                        <?php echo $this->Session->flash();?>
                        <!--<table class='table table-striped dataTable dataTable-noheader dataTable-nofooter table-bordered'>-->
                        <!--<table class='table table-striped table-media table-bordered dataTable'>-->
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th>Preview</th>
                                    <th><?php echo $this->Paginator->sort('Banner.title', 'Title'.$title_link,array('escape' => false)); ?></th>
                                    <th><?php echo $this->Paginator->sort('Banner.sort', 'Sort'.$sort_link,array('escape' => false)); ?></th>
                                    <th><?php echo $this->Paginator->sort('Banner.active', 'Status'.$active_link,array('escape' => false)); ?></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    for($i=0;$i<count($bannerList);$i++)
                                    {
                                        $block = ($bannerList[$i]['Banner']['active'])==1 ? false :true;
                                        echo "<tr>";
                                        echo "<td class='table-image'>".$this->Html->link($this->Html->image(SITE_URL.HOME_BANNER_UPLOAD.$bannerList[$i]['Banner']['banner_image'],array("width"=>60,"height"=>60,"title"=>$bannerList[$i]['Banner']['title'])),SITE_URL.HOME_BANNER_UPLOAD.$bannerList[$i]['Banner']['banner_image'],array('escape' => false,"class"=>"preview fancy"))."</td>";
                                        echo "<td width='45%'>".$bannerList[$i]['Banner']['title']."</td>";                        
                                        echo "<td width='15%'>".$bannerList[$i]['Banner']['sort']."</td>";        

                                        echo "<td width='10%' align='center'>".$active = (($bannerList[$i]['Banner']['active'])==1 ? "Active" :"Inactive")."</td>";           
                                        echo "<td class='actions_big' width='13%'><div class='btn-group'>";

                                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller' => 'banners', 'action' => 'edit', $bannerList[$i]['Banner']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller' => 'banners', 'action' => 'delete', $bannerList[$i]['Banner']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this Banner?");

                                        if($block==true) {
                                            echo $this->Html->image(SITE_URL."img/icons/fugue/slash.png",array("class"=>"btn btn-mini tip","disabled"=>true));
                                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/check.png"),array('controller' => 'banners', 'action' => 'unblock', $bannerList[$i]['Banner']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Unblock"),"Are you sure to unblock this Banner?");
                                        }
                                        else
                                        {
                                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/slash.png"),array('controller' => 'banners', 'action' => 'block', $bannerList[$i]['Banner']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Block"),"Are you sure to block this Banner?");
                                            echo $this->Html->image(SITE_URL."img/icons/essen/16/check.png",array("class"=>"btn btn-mini tip","disabled"=>true));
                                        }

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

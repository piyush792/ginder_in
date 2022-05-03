<?php 
echo $this->element("admin_header");

$direction = $this->Paginator->sortDir();
$image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
$key =$this->Paginator->sortKey();
$id_link  = ($key=='Content.id')?$this->Html->image(SITE_URL."img/".$image):'';
$name_link  = ($key=='Content.name')?$this->Html->image(SITE_URL."img/".$image):'';     
$category_link  = ($key=='Content.category_type')?$this->Html->image(SITE_URL."img/".$image):''; 
$sort_link  = ($key=='Content.sort')?$this->Html->image(SITE_URL."img/".$image):''; 
$active_link  = ($key=='Content.active')?$this->Html->image(SITE_URL."img/".$image):''; 

if($searchKey!='')     
{
    $this->Paginator->options(array('url' => array('search' => $searchKey)));    
}
?>

<div class="clearfix"></div>
<div class="admin-middle-content">
  <div class='admin-side-menu' id="admin-sidemenu-ctrl"> <span class="glyphicon glyphicon-menu-hamburger"></span> <span class="txt-admin-side-menu">Side Menu</span> </div>
  <?php echo $this->element("admin_left"); ?> 
  <!-- Right Content start -->
  <div class="superadmin-adverts-wrapper"> 
    <!-- recent ads section start -->
    <section class="superadmin-recent-ads-wrapper">
      <header class="clearfix">
        <h2 class="section-heading">Web Page Management <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus">', array('controller' => 'contents', 'action' => 'add'),array('escape' => false,"class"=>"btn-add-action icon-space-left","title"=>"Add New Category"));?> </h2>
        <!-- <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div> --> 
      </header>
      <?php echo $this->Session->flash();?>
      <section class="table-grid-wrapper">
        <div class="box-head"> <?php echo $this->Form->create("Content",array('url'=>'index/','type'=>'post'));?>
          <table width="100%" align="left" border="0">
            <tr>
              <td align="left"><?php echo $this->Form->input("searchKey",array("id"=>"searchKey","type"=>"text","label"=>false,"size"=>10,"div"=>false,'class'=>'form-control'));?></td>
              <td align="left"><?php echo $this->Form->input("Search",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false));?></td>
            </tr>
          </table>
          <?php echo $this->Form->end();?> </div>
        <div class="box-content box-nomargin">
          <table class='table table-striped table-bordered'>
            <thead>
              <tr>
                <th><?php echo $this->Paginator->sort('Content.id', 'Id'.$id_link,array('escape' => false)); ?></th>
                <th><?php echo $this->Paginator->sort('Content.name', 'Page Name'.$name_link,array('escape' => false)); ?></th>
                <th><?php echo $this->Paginator->sort('Content.category_type', 'Footer Section'.$category_link,array('escape' => false)); ?></th>
                <th><?php echo $this->Paginator->sort('Content.sort', 'Sort'.$sort_link,array('escape' => false)); ?></th>
                <th><?php echo $this->Paginator->sort('Content.active', 'Status'.$active_link,array('escape' => false)); ?></th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                                    for($i=0;$i<count($contentList);$i++)
                                    {
                                        echo "<tr>";
                                        echo "<td>".$contentList[$i]['Content']['id']."</td>";
                                        echo "<td>".$contentList[$i]['Content']['name']."</td>";                                
                                        echo "<td>".(($contentList[$i]['Content']['category_type']==1)?'Information':'Site Features')."</td>";
                                        echo "<td>".$contentList[$i]['Content']['sort']."</td>";
                                        echo "<td>".(($contentList[$i]['Content']['active'])==1 ? "Active":"Inactive")."</td>";     

                                        if($searchKey!='')
                                        {
                                            echo "<td>". $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller'=>'contents', 'action'=>'edit', $contentList[$i]['Content']['id'],'?'=>array('page'=>$page,'search'=>$searchKey)),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                                        }
                                        else
                                        {
                                            echo "<td>". $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller'=>'contents', 'action'=>'edit', $contentList[$i]['Content']['id'],'?'=>array('page'=>$page)),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                                        }
                                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller'=>'contents', 'action'=>'delete', $contentList[$i]['Content']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this Page?")."</td>"; 
                                        echo "</tr>";                            
                                    }
                                ?>
            </tbody>
          </table>
        </div>
        <div class="pagination-wrapper">
          <ul class="pagination">
            <?php 
                                echo $this->Paginator->first("First" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'first disabled','escape'=>false,'tag'=>'li'));
                                echo $this->Paginator->prev("&larr; Previous" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'prev disabled','escape'=>false,'tag'=>'li'));

                                echo '&nbsp;'.$this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active')); 
                                echo $this->Paginator->next("Next &rarr;", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                                echo $this->Paginator->last("Last", array('escape'=>false,'tag'=>'li'), null, array('class' => 'last disabled','escape'=>false,'tag'=>'li'));
                            ?>
          </ul>
        </div>
      </section>
    </section>
    <!-- recent ads sectioin end --> 
  </div>
</div>
<!-- recent ads sectioin end --> 
<!-- Right Content end -->
</div>

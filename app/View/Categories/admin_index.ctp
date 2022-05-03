<?php 
echo $this->element("admin_header");

    $direction = $this->Paginator->sortDir();
    $image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
    $key =$this->Paginator->sortKey();
    $id_link  = ($key=='Category.id')?$this->Html->image(SITE_URL."img/".$image):'';
    $name_link  = ($key=='Category.name')?$this->Html->image(SITE_URL."img/".$image):''; 
    $active_link  = ($key=='Category.active')?$this->Html->image(SITE_URL."img/".$image):''; 
?>

<div class="clearfix"></div>
<div class="admin-middle-content">
    <div class='admin-side-menu' id="admin-sidemenu-ctrl"> <span class="glyphicon glyphicon-menu-hamburger"></span>
        <span class="txt-admin-side-menu">Side Menu</span> </div>

        <?php echo $this->element("admin_left"); ?>

    <!-- Right Content start -->
    <div class="superadmin-adverts-wrapper">
        <!-- recent ads section start -->
      <section class="superadmin-recent-ads-wrapper">
        <header class="clearfix">
          <h2 class="section-heading">Manage Categories
          <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus">', array('controller' => 'categories', 'action' => 'add'),array('escape' => false,"class"=>"btn-add-action icon-space-left","title"=>"Add New Category"));?>
          </h2>
          <!-- <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div> -->
        </header>        

        <section class="table-grid-wrapper">
        <?php 
            echo $this->Form->create('Category',array('id'=>'Category','url' => '/admin/categories/sort_menu','style' => 'text-align:center'));
        ?>
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th><?php echo $this->Paginator->sort('Category.id', 'Id'.$id_link,array('escape' => false)); ?></th>
                <th><?php echo $this->Paginator->sort('Category.name', 'Name'.$name_link,array('escape' => false)); ?></th>
                <th><?php echo $this->Paginator->sort('Category.active', 'Status'.$active_link,array('escape' => false)); ?></th>
                <th>Action</th>
                <th>Sort</th>
              </tr>
            </thead>
            
            <tbody>
            <?php
                for($i=0;$i<count($categoryList);$i++)
                {
                    echo "<tr>";
                    echo "<td  width='12%' data-title='ID'>".$categoryList[$i]['Category']['id']."</td>";
                    echo "<td width='64%' data-title='Category Name'>".$categoryList[$i]['Category']['name']."</td>";                                                       
                    echo "<td width='15%' data-title='Status'>".(($categoryList[$i]['Category']['active'])==1 ? "Active":"Inactive")."</td>";           
                    
                    echo "<td class='actions_big' data-title='Action' width='13%'><div class='btn-group'>";
                    echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller' => 'categories', 'action' => 'edit', $categoryList[$i]['Category']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                    echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller' => 'categories', 'action' => 'delete', $categoryList[$i]['Category']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this Category? It will delete all the association with products.");
                    echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/plus.png"),array('controller' => 'categories', 'action' => 'add', $categoryList[$i]['Category']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Add Subcategory"));
                    echo $this->Form->input("Category.$i.id", array("type" => "hidden", "id" => "id_$i", "value" =>$categoryList[$i]['Category']['id']));
                    echo "</div></td>";
                    
                    echo "<td width='13%' data-title='Sort'>".$this->Form->input('Category.'.$i.'.position',array('label'=>false,'div'=>false,'style'=>'width: 45px','id'=>'position_'.$i.'','size'=>2,'value'=>$categoryList[$i]['Category']['position']))."</td>";
                    echo "</tr>";     
                    
                    if(count($categoryList[$i]['SubCategory'] > 0))
                    {
                        echo "<tr><td colspan='5'><table width='100%' cellpadding='0' cellspacing='0' border='0'>";
                        for($j=0;$j<count($categoryList[$i]['SubCategory']);$j++)
                        {
                            echo "<tr>";
                            echo "<td width='1%' data-title=''></td>";
                            echo "<td width='6%' data-title='ID'>".$categoryList[$i]['SubCategory'][$j]['id']."</td>";
                            echo "<td width='55%' data-title='Category Name'>".$categoryList[$i]['SubCategory'][$j]['name']."</td>";
                            echo "<td width='14%' data-title='Status'>".(($categoryList[$i]['SubCategory'][$j]['active'])==1 ? "Active":"Inactive")."</td>";           
                            echo "<td width='13%' class='actions_big' data-title='Action'><div class='btn-group'>";
                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller' => 'categories', 'action' => 'edit', $categoryList[$i]['SubCategory'][$j]['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller' => 'categories', 'action' => 'delete', $categoryList[$i]['SubCategory'][$j]['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this Category? It will delete all the association with products.");
                            echo "</div></td>";
                            echo "<td width='13%'></td>";
                    
                            echo "</tr>";                      
                        }
                        echo "</table></td></tr>";
                    }
                }
            ?>                                
            </tbody>            
          </table>
          <div class="form-actions" align="right">
                <?php 
                echo $this->Form->input("Save",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary'));
                echo $this->Form->end();?>
          </div>
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
        </section>
      </section>
      <!-- recent ads sectioin end -->
    </div>  
</div>
    <!-- recent ads sectioin end -->
<!-- Right Content end -->
</div>

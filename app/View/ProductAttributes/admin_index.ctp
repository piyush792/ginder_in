<?php 
echo $this->element("admin_header");

$direction = $this->Paginator->sortDir();
$image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
$key =$this->Paginator->sortKey();
$id_link  = ($key=='ProductAttribute.id')?$this->Html->image(SITE_URL."img/".$image):'';
$name_link  = ($key=='ProductAttribute.attribute_code')?$this->Html->image(SITE_URL."img/".$image):'';     
$active_link  = ($key=='ProductAttribute.active')?$this->Html->image(SITE_URL."img/".$image):''; 
?>

<script>
    $(document).ready(function () {
      /* filter control start */
      $('#ctrl-filter').click(function () {
        $('#sidebar-filter').show();
        $('body').attr('style', 'overflow: hidden');
      });

      $('#sidebar-close, .filter-overlay').click(function () {
        $('#sidebar-filter').hide();
        $('body').removeAttr('style');
      });
    });
</script>
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
          <h2 class="section-heading">Manage Attributes
          <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus">', array('controller' => 'product_attributes', 'action' => 'add'),array('escape' => false,"class"=>"btn-add-action icon-space-left","title"=>"Add New Product"));?>
          </h2>
          <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div>
        </header>
        <section class="table-grid-wrapper">        
            <!-- Search Area Start -->        
            <div class="box">
                <div id="sidebar-filter" class="ad-filter-wrapper">
                    <div class='superadmin-filter-wrapper'>
                        <div class="heading-wrapper">
                            <header class="filter-heading">
                            <h2 class="section-heading">Filter</h2>
                            </header>
                            <div id="sidebar-close" class="superadmin-filter-close">
                            <button type="button" class="close"> <span aria-hidden="true">×</span> </button>
                            </div>
                        </div>            
                        <div class="box-content">
                            <?php echo $this->Form->create('ProductAttribute', array('type' => 'get','action'=>$action,'class' => 'form')); ?>
                            <fieldset>
                                <div class="row-fluid force-margin">
                                    
                                    <div class="form-group row">
                                        <label for="selectCategory" class="col-form-label">Keyword </label>
                                        <div class="col-sm-12 ctrl-field">
                                            <?php
                                            $keyword = isset($this->params['named']['keyword']) ? $this->params['named']['keyword'] : null;                                                
                                            echo $this->Form->input('keyword',array('label'=>false,"type"=>"text",'id'=>'keyword','name'=>'keyword',"value"=>$keyword,"div"=>false,"class"=>"form-control"));
                                            ?>    
                                        </div>
                                    </div>                                                   

                                    <div class="form-group row">
                                        <label for="selectCategory" class="col-form-label">Status </label>
                                        <div class="col-sm-12 ctrl-field">
                                            <?php 
                                                $status = isset($this->params['named']['active']) ? $this->params['named']['active'] : null; 
                                                echo $this->Form->input('active',array('label'=>false,'options'=>array(''=>'-Select Status-','1'=>'Active','0'=>'Inactive'),"class"=>"form-control",'selected'=>$status));
                                            ?>     
                                        </div>
                                    </div>

                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="form-actions">
                                                <?php echo $this->Form->input("Search",array('type'=>'submit','label'=>false,"div"=>false,'class'=>'btn btn-primary','title'=>'Search','style'=>'float:left;'));?>&nbsp;&nbsp;
                                                <button class="btn btn-primary"><a href='<?php echo $reset_button; ?>' style='text-decoration: none;'><span style='color: #fff;'>Reset</span></a></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>        
                            </fieldset>
                            <?php echo $this->Form->end();?>
                        </div>
                    </div>
                    <div class="filter-overlay"></div>
                </div>
            </div>
            <!-- Search Area -->
            <div class="clearfix">&nbsp;</div>
            <div>            
                <div class="box">
                    <div class="box-head">
                        <h3>Product Attributes List</h3>
                    </div>
                    <div class="box-content box-nomargin">
                        <?php echo $this->Session->flash();?>
                        <table class='table table-striped table-bordered'>
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('ProductAttribute.id', 'Id'.$id_link,array('escape' => false)); ?></th>
                                    <th><?php echo $this->Paginator->sort('ProductAttribute.attribute_code', 'Name'.$name_link,array('escape' => false)); ?></th>
                                    <th><?php echo $this->Paginator->sort('ProductAttribute.active', 'Status'.$active_link,array('escape' => false)); ?></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    for($i=0;$i<count($contentList);$i++)
                                    {
                                        echo "<tr>";
                                        echo "<td width='5%'>".$contentList[$i]['ProductAttribute']['id']."</td>";
                                        echo "<td width='30%'>".$contentList[$i]['ProductAttribute']['attribute_code']."</td>";                                
                                        echo "<td width='30%'>".(($contentList[$i]['ProductAttribute']['active'])==1 ? "Active":"Inactive")."</td>";     
                                        echo "<td width='25%'>";
                                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller'=>'product_attributes', 'action'=>'admin_edit', $contentList[$i]['ProductAttribute']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                                        echo $this->Html->link($this->Html->image("icons/fugue/cross.png"), array('controller' => 'product_attributes', 'action' => 'admin_delete', $contentList[$i]['ProductAttribute']['id']), array('escape' => false, "class" => "btn btn-mini tip", "title" => "Remove"), "Are you sure to delete?");
                                        echo $this->Html->link($this->Html->image("icons/essen/16/product.png"), array('controller' => 'product_attribute_values', 'action' => 'admin_index','post_attribute_id'=> $contentList[$i]['ProductAttribute']['id']), array('escape' => false, "class" => "btn btn-mini tip", "title" => "View Attribute Values"));
                                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/collaboration.png"),array('controller'=>'product_attributes', 'action'=>'admin_show_category', $contentList[$i]['ProductAttribute']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Show Attribute Category"));
                                        echo "</td>"; 
                                        echo "</tr>";                            
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
            </div>
        </section>
      </section>
      <!-- recent ads sectioin end -->
    </div>  
</div>
<!-- recent ads sectioin end -->
<!-- Right Content end -->
</div>

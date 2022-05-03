<?php 
echo $this->element("admin_header");

$direction = $this->Paginator->sortDir();
$image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
$key =$this->Paginator->sortKey();
$id_link  = ($key=='User.id')?$this->Html->image(SITE_URL."img/".$image):'';
$email_link  = ($key=='User.email')?$this->Html->image(SITE_URL."img/".$image):''; 
$firstname_link  = ($key=='User.firstname')?$this->Html->image(SITE_URL."img/".$image):''; 
$lastname_link  = ($key=='User.lastname')?$this->Html->image(SITE_URL."img/".$image):'';     
$active_link  = ($key=='User.active')?$this->Html->image(SITE_URL."img/".$image):''; 
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
          <h2 class="section-heading">Manage User Profiles <span class="badge badge-primary"><?php echo count($userList); ?></span></h2>
          <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div>
        </header>        

        <section class="table-grid-wrapper">
        <?php echo $this->Session->flash();?>
        
        <div class="row-fluid">
            <div class="span12">
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
                                <?php echo $this->Form->create("User",array('type'=>'get', 'action'=>$action));?>
                                <fieldset>
                                    <div class="row-fluid force-margin">
                                        <div class="form-group row">
                                            <label for="selectCategory" class="col-form-label">Keyword </label>
                                            <div class="col-sm-12 ctrl-field">
                                                <?php
                                                $keyword = isset($this->params['named']['keyword']) ? $this->params['named']['keyword'] : null;                                                
                                                echo $this->Form->input('keyword',array('label'=>false,"type"=>"text",'id'=>'keyword','name'=>'keyword',"placeholder"=>"Search for user, email, mobile...","value"=>$keyword,"div"=>false,"class"=>"form-control"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="selectCategory" class="col-form-label">City </label>
                                            <div class="col-sm-12 ctrl-field">
                                                <?php
                                                    $select_id = isset($this->params['named']['location']) ? $this->params['named']['location'] : null;
                                                    // echo $this->Form->input('product_category',array('label'=>false,'options'=>array(''=>'-Select One-',$cities),"class"=>"form-control",'selected'=>$select_id));
                                                    echo $this->Form->input('location', array('id'=>'citySearch','class' => "form-control custom-dropdown", 'style'=>'float:left', 'title' => __("City"), 'options'=>$cities, 'label' => false,'selected'=>$select_id, 'style'=>"width: 296px !important;"));
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
                                                    <?php echo $this->Form->input("Search",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary',"div"=>false,'title'=>'Search', 'style'=>'float:left;'));?>&nbsp;&nbsp;
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
                    <div class="box-content box-nomargin" style="padding-top:20px;">
                        <?php
                        if(count($userList)>0){
                            ?>
                            <table class='table table-striped table-bordered'>                     
                                    <tr bgcolor="#f2f2f2">
                                        <td><strong> <?php echo $this->Paginator->sort('User.id', 'Id'.$id_link,array('escape' => false));?></strong></td>                           
                                        <td><strong><?php echo $this->Paginator->sort('User.email', 'Email'.$email_link,array('escape' => false)); ?></strong></td>                                   
                                        <td><strong><?php echo $this->Paginator->sort('User.firstname', 'Firstname'.$firstname_link,array('escape'=>false));?></strong></td>                                   
                                        <td><strong><?php echo $this->Paginator->sort('User.lastname', 'Lastname'.$lastname_link,array('escape' => false));?></strong></td>
                                        <td><strong><?php echo $this->Paginator->sort('User.active', 'Status'.$active_link,array('escape' => false)); ?></strong></td>
                                        <td><strong>Action</strong></td>
                                    </tr>
                                <tbody>
                                    <?php
                                    for($i=0;$i<count($userList);$i++)
                                    {
                                        echo "<tr>";
                                        echo "<td>".$userList[$i]['User']['id']."</td>";
                                        echo "<td>".$userList[$i]['User']['email']."</td>";                                
                                        echo "<td>".$userList[$i]['User']['firstname']."</td>";                                
                                        echo "<td>".$userList[$i]['User']['lastname']."</td>";
                                        echo "<td>".(($userList[$i]['User']['active'])==1 ? "Active":"Inactive")."</td>";                                
                                        
                                        echo "<td>".$this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/edit.png"),array('controller'=>'users','action'=>'edit',$userList[$i]['User']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit")); 
                                        
                                        echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/cross.png"),array('controller'=>'users', 'action'=>'delete', $userList[$i]['User']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Remove"),"Are you sure to delete this User?");
                                        $block = ($userList[$i]['User']['active'])==1 ? false :true;
                                        if($block==true) {
                                            echo $this->Html->image(SITE_URL."img/icons/fugue/slash.png",array("class"=>"btn btn-mini tip","disabled"=>true));
                                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/essen/16/check.png"),array('controller'=>'users','action'=>'active',$userList[$i]['User']['id'],1),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Unblock"),"Are you sure to active this user?");
                                        }else{
                                            echo $this->Html->link($this->Html->image(SITE_URL."img/icons/fugue/slash.png"),array('controller' =>'users','action'=>'active',$userList[$i]['User']['id'],0),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Block"),"Are you sure to inactive this user?");
                                            echo $this->Html->image(SITE_URL."img/icons/essen/16/check.png",array("class"=>"btn btn-mini tip","disabled"=>true));
                                        } 
                                        echo "</td>"; 
                                        echo "</tr>"; 
                                    }
                                    ?>
                                </tbody>
                            </table> 
                            <?php
                            }else{
                                echo "<div class='alert alert-danger'>No Record Found</div>";
                            }
                            ?>
                    </div>
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
<script>
$(document).ready(function(){
    $("#citySearch").select2();
});
</script>
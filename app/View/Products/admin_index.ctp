<?php 
echo $this->element("admin_header");

$direction = $this->Paginator->sortDir();
$image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
$key =$this->Paginator->sortKey();
$id_link  = ($key=='Product.id')?$this->Html->image(SITE_URL."img/".$image):'';
$name_link  = ($key=='Product.name')?$this->Html->image(SITE_URL."img/".$image):''; 
$price_link  = ($key=='Product.price')?$this->Html->image(SITE_URL."img/".$image):'';
$cat_name_link  = ($key=='Category.name')?$this->Html->image(SITE_URL."img/".$image):'';
// if($searchKey!='')     
// {
//     $this->Paginator->options(array('url' => array('search' => $searchKey)));    
// } 
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
        <h2 class="section-heading">Recent Ads
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus">', array('controller' => 'products', 'action' => 'add'),array('escape' => false,"class"=>"btn-add-action icon-space-left","title"=>"Add New Products"));?>
        </h2>
        <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div>
      </header>

      <!-- <div class="box-head">
        <?php //echo $this->Form->create("Product",array('type'=>'post'));?>
        <table width="40%" align="left" border="0">
            <tr>
                <td align="left" width="32%"><?php //echo $this->Form->input("searchKey",array("id"=>"searchKey","type"=>"text","label"=>false,"size"=>10,"div"=>false,'style'=>'margin-bottom: 0px;'));?></td>
                <td align="left"><?php //echo $this->Form->input("Search",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false));?></td>
            </tr>
        </table>
        <?php //echo $this->Form->end();?>                   
      </div> -->

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
                                <?php echo $this->Form->create("Product",array('type'=>'get', 'action'=>$action, 'class' => 'form'));?>
                                <fieldset>
                                    <div class="row-fluid force-margin">
                                        <div class="form-group row">
                                            <label for="selectCategory" class="col-form-label">Keyword </label>
                                            <div class="col-sm-12 ctrl-field">
                                                <?php
                                                $keyword = isset($this->params['named']['keyword']) ? $this->params['named']['keyword'] : null;
                                                echo $this->Form->input('keyword',array('label'=>false,"type"=>"text",'id'=>'keyword','name'=>'keyword',"value"=>$keyword,"div"=>false,"class"=>"form-control", "placeholder"=>"Enter product name..."));
                                                // echo $this->Form->input("searchKey",array("id"=>"searchKey","type"=>"text","label"=>false,"div"=>false,"value"=>$searchKey,"class"=>"form-control"));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="selectCategory" class="col-form-label">Published By</label>
                                            <div class="col-sm-12 ctrl-field">
                                                <?php
                                                $contact_name = isset($this->params['named']['contact_name']) ? $this->params['named']['contact_name'] : null;
                                                echo $this->Form->input('contact_name',array('label'=>false,"type"=>"text",'id'=>'contact_name','name'=>'contact_name',"value"=>$contact_name,"div"=>false,"class"=>"form-control", "placeholder"=>"Search for published by..."));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="selectCategory" class="col-form-label">Product Category </label>
                                            <div class="col-sm-12 ctrl-field">
                                                <?php 
                                                    $select_id = isset($this->params['named']['product_category']) ? $this->params['named']['product_category'] : null;
                                                    echo $this->Form->input('product_category',array('label'=>false,'options'=>array(''=>'-Select One-',$catoptions),"class"=>"form-control",'selected'=>$select_id));
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

                </div>
            </div>
      </div>

    <div style="clear:both;">
    </div>
    
    <?php echo $this->Session->flash();?>
    <div class="card-deck"> 
        <?php
        for($i=0;$i<count($productList);$i++)
        {
            $block = ($productList[$i]['Product']['active'])==1 ? false :true;
            if($i % 5 == 0){
                echo "</div><div class='card-deck'>";
            }
            ?> 
            <div class="card">                   
                <?php
                    if(file_exists(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$productList[$i]['Product']['image']) && ($productList[$i]['Product']['image']<>"")){
                        echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$productList[$i]['Product']['image'], array('height' => '100px'));
                    }else{
                        echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . 'no_image.jpg', array('height' => '100'));
                    }
                ?>
                <div class="card-body">
                    <a class="card-title" href="#"><?=$productList[$i]['Product']['name'];?></a>                        
                    <div class="ctrl-edit">
                        <?php
                            echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>',array('controller' => 'products', 'action' => 'edit', $productList[$i]['Product']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
                        ?>
                    </div>
                </div>
            </div>                
        <?php
        }
        ?>
    </div>

    
    <div class="pagination-wrapper">
        <ul class="pagination">
            <?php 
                echo $this->Paginator->first("First", array('escape'=>false,'tag'=>'li'), null, array('class' => 'first disabled','escape'=>false,'tag'=>'li'));
                echo $this->Paginator->prev("&larr; Previous", array('escape'=>false,'tag'=>'li'), null, array('class' => 'prev disabled','escape'=>false,'tag'=>'li'));
                echo '&nbsp;'.$this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active')); 
                echo $this->Paginator->next("Next &rarr;", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                echo $this->Paginator->last("Last", array('escape'=>false,'tag'=>'li'), null, array('class' => 'last disabled','escape'=>false,'tag'=>'li'));
            ?>
        </ul>
    </div>
        
    </section>
    <!-- recent ads sectioin end --> 
    
    <!-- ad filter sidebar content start -->
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
        <div class="col-sm-12 col-lg-12 frm-mobtab-topbot clearfix">
          <label for="filter-advert-name" class="col-form-label">Ad Name</label>
          <div class="col-sm-12 ctrl-field">
            <input type="text" class="form-control" placeholder="Enter advert name">
          </div>
        </div>
        <div class="col-sm-12 col-lg-12 frm-mobtab-topbot clearfix">
          <label for="published-user" class="col-form-label">Published by user</label>
          <div class="col-sm-12 ctrl-field">
            <input type="text" class="form-control" placeholder="Enter user name">
          </div>
        </div>
        <div class="col-sm-12 col-lg-12 frm-mobtab-topbot clearfix">
          <label for="selectCategory" class="col-form-label">Category</label>
          <div class="col-sm-12 ctrl-field">
            <select class="form-control custom-dropdown">
              <option selected="">Select</option>
              <option value="Electronics &amp; Appliance"> Electronics &amp; Appliance</option>
              <option value="Home, Furniture &amp; Pets">Home, Furniture &amp; Pets</option>
              <option value="Jobs">Jobs</option>
              <option value="Service For Sale">Service For Sale</option>
              <option value="Reals Estate">Reals Estate</option>
              <option value="Matrimonial">Matrimonial</option>
              <option value="Chattisgarh"> Chattisgarh</option>
              <option value="Education &amp; Books">Education &amp; Books</option>
              <option value="Sports, Fitness &amp; Hobbies">Sports, Fitness &amp; Hobbies</option>
            </select>
          </div>
        </div>
        <div class="col-sm-12 col-lg-12 frm-mobtab-topbot clearfix">
          <label for="selectCategory" class="col-form-label">Sub-category</label>
          <div class="col-sm-12 ctrl-field">
            <select class="form-control custom-dropdown">
              <option selected="">Select Sub-category</option>
            </select>
          </div>
        </div>
        <div class="col-sm-12 col-lg-12 frm-mobtab-topbot clearfix">
          <label for="filter-advert-name" class="col-form-label">Published on</label>
          <div class="col-sm-12 ctrl-field">
            <input type="text" class="form-control date-control" placeholder="Select Date">
            <span class="glyphicon glyphicon-calendar date-control-icon"></span> </div>
        </div>
        <div class="col-sm-12 col-lg-12 frm-mobtab-topbot">
          <label for="selectSubCategory" class="col-form-label">Promoted Ad</label>
          <div class="col-sm-10 ctrl-field">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="promotedAd" name="promotedAd" value="Yes">
              <label class="custom-control-label" for="promotedAd">Yes</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="promotedAd2" name="promotedAd" value="No">
              <label class="custom-control-label" for="promotedAd2">No</label>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-lg-12 frm-mobtab-topbot">
          <label for="selectSubCategory" class="col-form-label">Ad Type</label>
          <div class="col-sm-10 ctrl-field">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="adType" name="adType" value="New">
              <label class="custom-control-label" for="adType">New</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="adType2" name="adType" value="Used">
              <label class="custom-control-label" for="adType2">Used</label>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-lg-12 frm-mobtab-topbot">
          <label for="selectSubCategory" class="col-form-label">Ad Status</label>
          <div class="col-sm-10 ctrl-field">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="adStatus" name="adStatus" value="Active">
              <label class="custom-control-label" for="adStatus">Active</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" id="adStatus2" name="adStatus" value="Disabled">
              <label class="custom-control-label" for="adStatus2">Disabled</label>
            </div>
          </div>
        </div>
        
        <!-- filter command button -->
        <div class="filter-cmd-btn-wrapper">
          <button class="cmd-btn cmd-btn-primary">Submit</button>
          <button class="cmd-btn cmd-btn-secondary">Reset</button>
        </div>
        <!-- filter command button --> 
        
      </div>
      <div class="filter-overlay"></div>
    </div>
    <!-- ad filter sidebar content end --> 
  </div>
  <!-- Right Content end -->
</div>
<?php //echo $this->element('sql_dump'); ?>
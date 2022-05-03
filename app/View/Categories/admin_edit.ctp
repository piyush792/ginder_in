<?php 
echo $this->element("admin_header");
?>
<script type="text/javascript">
    function formValidate()
    {
        if($("#name").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter Resource Type name</div>");
            return false;
        }    
    }
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
      <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to Category Lists', array('controller' => 'categories','action' => 'index'), array('escape' => false, 'class'=>'anchor-black header-anchor',"title"=>"Back to Categories")); ?>
        <header class="clearfix">
          <h2 class="section-heading">Edit Category</h2>
          <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div>
        </header>        

        <section class="table-grid-wrapper">        
            <div class="item-content-wrapper">
                <span id="error_msg"></span>
                <?php echo $this->Form->create('Category',array('id'=>'Category','url' => '','enctype' => 'multipart/form-data','class' => 'form-horizontal')); ?>
                
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Parent <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                        <?php echo $this->Form->input('parent_id',array('label'=>false,'id'=>'parent_id','options'=>array($catoptions),'class'=>'form-control',"div"=>false));?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Name <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                        <?php echo $this->Form->input('name',array('label'=>false,'id'=>'name',"div"=>false,'class'=>'form-control'));?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Status <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                        <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),"div"=>false,'class'=>'form-control'));?>
                    </div>
                </div>

                
                <div class="form-actions">
                    <?php echo $this->Form->input("Save",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));
                    ?>
                </div>
                <?php echo $this->Form->end();?>
            </div>
        </section>

      </section>
      <!-- recent ads sectioin end -->
    </div>  
</div>
<!-- recent ads sectioin end -->
<!-- Right Content end -->
</div>

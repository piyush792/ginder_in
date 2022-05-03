<?php 
echo $this->element("admin_header");
?>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    /*function formValidate()
    {
        <?php for ($i = 0; $i < count($languagesList); $i++) {  ?>       
            if($("#name_<?php echo $languagesList[$i]['Languages']['isocode'] ?>").val()=="")
            {
                $("#error_msg").html("<div class='alert alert-error'>Please enter name.</div>");
                $("#name_<?php echo $languagesList[$i]['Languages']['isocode'] ?>").focus();
                return false;
            }

            <?php } ?> 
        return true;
    }*/
    
    /*function attributeChange(Obj)
    {
      if(Obj.value == "<?php echo SITE_COLOR_ATTRIBUTE_CODE; ?>"){
          $('#color_code_div').show();
          document.getElementById('color_code').value = ""; 
      }else {
         $('#color_code_div').hide();
         document.getElementById('color_code').value = ""; 
      }  
    }*/
</script>
<?php
if($this->data['ProductAttributeValue']['attribute_id'] == 1) {
    $display = 'block';
    $color_code =  $this->data['ProductAttributeValue']['color_code'];
}else{
    $display = 'none'; 
    $color_code = ""; 
}
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
      <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span>Back to Attribute Value Lists', array('controller' => 'product_attribute_values','action' => 'index'), array('escape' => false, 'class'=>'anchor-black header-anchor',"title"=>"Back to Attributes Values")); ?>
        <header class="clearfix">
          <h2 class="section-heading">Edit Attribute Value</h2>
          <!-- <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div> -->
        </header>        

        <section class="table-grid-wrapper">        
            <div class="item-content-wrapper">                    
                <span id="error_msg"><?=$this->Session->flash();?></span>
                <?php echo $this->Form->create('ProductAttributeValue',array('id'=>'ProductAttributeValue','url' => '','class' => 'form-horizontal')); ?>
                    
                <div class="form-group row">
                    <label for="selectCategory" class="col-sm-2 col-form-label">Category <span class="required-field">*</span></label>
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                            <?php echo $this->Form->input('Category',array('label'=>false,'id'=>'category_id',"div"=>false,"size"=>"10",'class'=>'form-control'));?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="selectCategory" class="col-sm-2 col-form-label">Product Attribute <span class="required-field">*</span></label>
                        <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                            <?php echo $this->Form->input('attribute_id', array('label' => false, 'id' => 'attribute_id', 'options' => $ProductAttributesList, "div" => false,'class'=>'form-control', "default"=>$this->data['ProductAttributeValue']['attribute_id'],"onchange"=>'return attributeChange(this)')); ?>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label for="selectCategory" class="col-sm-2 col-form-label">Name <span class="required-field">*</span></label>
                        <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                            <?php echo $this->Form->input('name',array('label'=>false,'id'=>'name', 'type'=>'text', 'size'=>1,"class"=>"form-control"));?>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label for="selectCategory" class="col-sm-2 col-form-label">Sort Order </label>
                        <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                            <div class="input-mini">
                                <?php echo $this->Form->input('sort_order', array('label' => false, 'id' => 'sort_order', "div" => false, "class" => "form-control spinner ui-spinner-box",  'autocomplete' => "off")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="selectCategory" class="col-sm-2 col-form-label">Active</label>
                        <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                            <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),'class'=>'form-control'));?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <?php echo $this->Form->input("Save",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));?>
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

<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
?>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Product Upload</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"></span>
                        <?php echo $this->Form->create("Product",array('id'=>'product_upload',"url"=>"",'enctype' => 'multipart/form-data','class' =>'form-horizontal')); ?>
                        <div class="control-group">
                            <label for="basic" class="control-label">Product Csv File:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('csvfile',array('label'=>false,'type'=>'file','id'=>'csvfile')); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="basic" class="control-label" style="width: auto;">Product Attribute Csv File:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('attributecsvfile',array('label'=>false,'type'=>'file','id'=>'attributecsvfile')); ?>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <?php echo $this->Form->input("Upload",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));?>
                        </div>
                    <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
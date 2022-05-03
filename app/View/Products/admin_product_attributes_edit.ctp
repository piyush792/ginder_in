<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
//echo "<pre>";
//print_r($this->params);
?>
<?php echo $this->element("admin_header"); ?>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    function formValidate()
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
    }


</script>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3><?php echo $title_for_layout; ?></h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?=$this->Session->flash();?></span>
                        <?php echo $this->Form->create('ProductAttributes',array('id'=>'ProductAttributes','url' => 'product_attributes_edit','class' => 'form-horizontal')); ?>
                        <fieldset><legend>Edit</legend>

                            <?php //for ($i = 0; $i < count($languagesList); $i++) {  ?>       
                                <div class="control-group">
                                    <label for="basic" class="control-label">* Name:</label>
                                    <div class="controls">
                                        <?php echo $this->Form->input('attribute_code',array('label'=>false,'id'=>'attribute_code', 'value'=>$contentlpsListdata[0]['ProductAttributes']['attribute_code'], 'size'=>40,"class"=>"input-square"));?>
                                    </div>
                                </div>
                                <?php // } ?>

                            <div class="control-group">
                                <label for="basic" class="control-label">Sort Order:</label>
                                <div class="controls">
                                    <div class="input-mini">
                                        <?php echo $this->Form->input('sort_order', array('label' => false, 'id' => 'sort_order', "div" => false, "class" => "spinner ui-spinner-box",  'autocomplete' => "off")); ?>
                                    </div>

                                </div>
                            </div> 

                            <div class="control-group">
                                <label for="basic" class="control-label">Active:</label>
                                <div class="controls">
                                    <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),"class"=>"input-square"));?>
                                </div>
                            </div>
                            <div class="form-actions">
                                <?php echo $this->Form->input("Save",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));
                                echo $this->Form->input('id',array('label'=>false,'id'=>'id','type'=>'hidden','value'=>$this->params['pass'][0]  ))
                                ?>
                            </div>
                        </fieldset> 
                        <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
?>
<script type="text/javascript">
function formValidate()
{  
    if($("#title").val()=="")
    {
        $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter Banner name</div>");
        $("#name").focus();
        return false;
    }    
    else if($("#banner_hidden").val()=="" && $("#banner_image").val()=="")
    {   
        $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please Select Banner Image</div>");
        $("#description").focus();
        return false;    
    }    
   
    return true;
}
</script>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Edit Banner</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?=$this->Session->flash();?></span>
                        <?php echo $this->Form->create('Banner',array('id'=>'Banner','url' => '','enctype' => 'multipart/form-data','class' => 'form-horizontal')); ?>
                        <div class="control-group">
                            <label for="basic" class="control-label">* Title:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('title',array('label'=>false,'id'=>'title',"div"=>false,'size'=>40,"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">* Url Link:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('url_link',array('label'=>false,'id'=>'url_link',"div"=>false,'size'=>40,"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">* Banner Image:</label>
                            <div class="controls">
                                <div id="uniform-file2" class="uploader">
                                    <?php echo $this->Form->input('banner_image',array('label'=>false,'type'=>'file','id'=>'banner_image',"div"=>false,"class"=>"uniform","style"=>"opacity: 0;"));?> 
                                    <?php echo $this->Form->input('banner_hidden',array('label'=>false,'type'=>'hidden','id'=>'banner_hidden',"div"=>false,'value'=>$this->data['Banner']['banner_image']));?>
                                    <span class="filename" style="-moz-user-select: none;">No file selected</span>
                                    <span class="action" style="-moz-user-select: none;">Choose File</span>
                                </div>
                                <span class="alert alert-info" style="width: 400px">Supported File Types: jpg, jpeg, png, gif - <?php echo "Max File size:<b>".ini_get('upload_max_filesize');?></b></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                            <?php 
                            if(file_exists(WWW_ROOT.HOME_BANNER_UPLOAD.$this->data['Banner']['banner_image']) && ($this->data['Banner']['banner_image']<>"")){
                                //echo $this->Html->image(HOME_BANNER_UPLOAD.$this->data['Banner']['banner_image'], array('width' => '100px','height' => '100px'));
                                echo $this->Html->link($this->Html->image(SITE_URL.HOME_BANNER_UPLOAD.$this->data['Banner']['banner_image'],array("title"=>$this->data['Banner']['title'],"height"=>100,'width'=>100)),SITE_URL.HOME_BANNER_UPLOAD.$this->data['Banner']['banner_image'],array('escape' => false,"class"=>"preview fancy"));
                            }else{
                                echo "<img src='".SITE_URL.'/'.NO_IMAGE."' alt='' />";
                            }
                            ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="icon" class="control-label">Sort:</label>
                            <div class="controls">
                                <div class="input-prepend">
                                    <?php echo $this->Form->input('sort',array('label'=>false,'id'=>'sort',"div"=>false,"class"=>"input-square"));?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Active:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),"div"=>false,"class"=>"input-square")); //uniform?> 
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php echo $this->Form->input("Save",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));
                        ?>
                        </div>
                    <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
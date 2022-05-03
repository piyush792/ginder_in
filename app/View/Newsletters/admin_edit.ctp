
<?php 
    echo $this->element("admin_header"); 
    echo $this->element("admin_dashboard"); 
    echo $this->element("admin_left");
?>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode: "exact",
        elements  : "message",
        theme : "advanced",
        plugins : "safari,spellchecker,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        theme_advanced_buttons1 : "save,bold,italic,underline,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,cut,copy,paste,pastetext,pasteword,search,replace,bullist,numlist,outdent,indent,blockquote,undo,redo",
        theme_advanced_buttons2 : "link,unlink,anchor,cleanup,code,insertdate,inserttime,preview,forecolor,backcolor,tablecontrols,hr,removeformat,sub,sup,charmap",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_statusbar_location : "",        
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",
        height : "380"
    });

  function formValidate()
    {
        if($("#title").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter title.</div>");
            $("#title").focus();
            return false;
        }     
        if($("#subject").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter subject.</div>");
            $("#subject").focus();
            return false;
        }    
        if($("#message").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter message.</div>");
            $("#message").focus();
            return false;
        }    
        
        
    }
     function removeHTMLTags(htmlString)
    {
        if(htmlString){
            var mydiv = document.createElement("div");
            mydiv.innerHTML = htmlString;
            if (document.all) // IE Stuff
            {
                return mydiv.innerText;
            }    
            else // Mozilla does not work with innerText
            {
                return mydiv.textContent;
            }                            
        }
    }

</script>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Edit Newsletter</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?=$this->Session->flash();?></span>
                        <?php echo $this->Form->create('Newsletter',array('id'=>'newsletter','url' => '','class' => 'form-horizontal')); ?>
                        <fieldset>
                            <legend>Edit Newsletter</legend>
                        </fieldset>
                        <div class="control-group">
                            <label for="basic" class="control-label">* Title:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('title',array('label'=>false,'id'=>'title',"div"=>false,'size'=>40,"class"=>"input-square"));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">* Subject:</label>
                            <div class="controls">
                                 <?php echo $this->Form->input('subject',array('label'=>false,'id'=>'subject',"div"=>false,'size'=>40,"class"=>"input-square"));?>
                            </div>
                        </div>
 
                         <div class="control-group">
                            <label for="basic" class="control-label">* Message Body:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('message', array('id' => 'message')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Status:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),"div"=>false,"class"=>"uniform"));?>
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
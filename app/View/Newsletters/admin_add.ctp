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
         if(document.getElementById('title').value == "")
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">�</a><h4 class="alert-heading">Please enter Title.</h4></div>';
            document.getElementById('title').focus();
            return false;
        }

        if(document.getElementById('subject').value == "")
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">�</a><h4 class="alert-heading">Please enter subject.</h4></div>';
            document.getElementById('subject').focus();
            return false;
        }
        var i=removeHTMLTags(tinyMCE.get("message").getContent())
        try
        {
            i=i.replace(/^\s+|\s+$/g,"")
        }
        catch(oe)
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">�</a><h4 class="alert-heading">Please Enter Message body.</h4></div>';
            return false
        }
        i=i.replace(/^\s+|\s+$/g,"")
        if(i=="")
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">�</a><h4 class="alert-heading">Please Enter Message body.</h4></div>';
            return false
        }
        return true;
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
    
    
    function insertHTML(html)
    {
        tinyMCE.execInstanceCommand("content","mceInsertContent",false,html);
    }
</script>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Add New Newsletter</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?php echo $this->Session->flash(); ?></span>


                        <?php

                            if (!empty($this->request->params['pass'][0])) {
                                $title = $Newsletter[0]['Newsletter']['title'];
                                $subject = $Newsletter[0]['Newsletter']['subject'];
                                $message = $Newsletter[0]['Newsletter']['message'];
    
                            } else {
                                $title = "";
                                $subject = "";
                                $message = "";
                                
                            }
                            echo $this->Form->create('Newsletter', array('id' => 'newsletter', 'url' => '', 'class' => 'form-horizontal', 'inputDefaults' => array('label' => false, 'div' => false)));
                        ?>
                       
                        <div class="control-group">
                            <label for="basic" class="control-label">* Title:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('title', array('id' => 'title', "value" => $title)); ?>
                            </div>
                        </div>
                      
                        <div class="control-group">
                            <label for="basic" class="control-label">* Subject:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('subject', array('id' => 'subject', "value" => $subject)); ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="basic" class="control-label">* Message Body:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('message', array('id' => 'message', "value" => $message)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Status:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),"div"=>false,"class"=>"uniform"));?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn btn-primary', 'onclick' => 'return formValidate();')); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //echo $this->element("admin_footer"); ?>
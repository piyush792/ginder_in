<?php 
    echo $this->element("admin_header"); 
    echo $this->element("admin_dashboard"); 
    echo $this->element("admin_left");
?>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode: "exact",
        elements  : "content",
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
        if(document.getElementById('id').value == "")
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please select draft.</h4></div>';
            document.getElementById('id').focus();
            return false;
        }
        if(document.getElementById('from_email').value == "")
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please enter email address.</h4></div>';
            document.getElementById('from_email').focus();
            return false;
        }
        var reg=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        var email = document.getElementById('from_email').value;
        if(reg.test(email) == false)
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please enter valid email address.</h4></div>';
            document.getElementById('from_email').focus();
            return false;
        }
        if(document.getElementById('from_name').value == "")
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please enter name.</h4></div>';
            document.getElementById('from_name').focus();
            return false;
        }
        if(document.getElementById('subject').value == "")
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please enter subject.</h4></div>';
            document.getElementById('subject').focus();
            return false;
        }
        var i=removeHTMLTags(tinyMCE.get("content").getContent())
        try
        {
            i=i.replace(/^\s+|\s+$/g,"")
        }
        catch(oe)
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please Enter Message body.</h4></div>';
            return false
        }
        i=i.replace(/^\s+|\s+$/g,"")
        if(i=="")
        {
            document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">×</a><h4 class="alert-heading">Please Enter Message body.</h4></div>';
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
    
    function gotourl(id)
    {
        window.location.href =  '<?php echo SITE_URL ?>' + 'admin/email_templates/edit/'+id;
    }
    function insertHTML(html)
    {
        tinyMCE.execInstanceCommand("content","mceInsertContent",false,html);
    }
</script>

<div class="superadmin-adverts-wrapper">
  <div class="item-content">
          <div class="header-wrapper">
            <h2>Email Templates</h2>
          </div>
          <div class="item-content-wrapper"> <span id="error_msg"><?php echo $this->Session->flash(); ?></span>
            <?php
                           //
//                            if (!empty($this->request->params['pass'][0])) {
//                                $from_email = $emailTemplate[0]['EmailTemplate']['from_email'];
//                                $from_name = $emailTemplate[0]['EmailTemplate']['from_name'];
//                                $subject = $emailTemplate[0]['EmailTemplate']['subject'];
//                                $content = $emailTemplate[0]['EmailTemplate']['content'];
//                                $draft = $this->request->params['pass'][0];
//                            } else {
//                                $from_email = "";
//                                $from_name = "";
//                                $subject = "";
//                                $content = "";
//                                $draft = null;
//                            }
                          echo $this->Form->create('EmailTemplate', array('type' => 'post','class' => 'form-horizontal', 'inputDefaults' => array('label' => false, 'div' => false)));
                        ?>
            <div class="form-group row">
              <label for="basic" class="col-sm-2 col-form-label">Draft <span class="required-field">*</span></label>
              <div class="col-sm-12 col-lg-6 ctrl-field-adtitle"> <?php echo $this->Form->input('id', array('id' => 'id', 'options' => $draftNameList, 'empty' => 'Select Draft', 'onchange' => 'return gotourl(this.value);','selected' => !empty($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '', "class" => 'form-control')); ?> </div>
            </div>
            
            <div class="form-group row">
              <label for="basic" class="col-sm-2 col-form-label">From Email Address <span class="required-field">*</span></label>
              <div class="col-sm-12 col-lg-6 ctrl-field-adtitle"> <?php echo $this->Form->input('from_email', array('id' => 'from_email','class' => 'form-control')); ?> </div>
            </div>
            <div class="form-group row">
              <label for="basic" class="col-sm-2 col-form-label">From Name <span class="required-field">*</span></label>
              <div class="col-sm-12 col-lg-6 ctrl-field-adtitle"> <?php echo $this->Form->input('from_name', array('id' => 'from_name','class' => 'form-control')); ?> </div>
            </div>
            <div class="form-group row">
              <label for="basic" class="col-sm-2 col-form-label">Subject <span class="required-field">*</span></label>
              <div class="col-sm-12 col-lg-6 ctrl-field-adtitle"> <?php echo $this->Form->input('subject', array('id' => 'subject','class' => 'form-control')); ?> </div>
            </div>
            <div class="alert alert-block alert-info email-alert-info">
              <h4 class="alert-heading">Remark:</h4>
              Put these placeholders in email template body where you want the recipient to see the corresponding content.<br />
              <br />
              <?php 
                            if(!empty($this->request->data) && $this->request->data['EmailTemplate']['id'] == 1){ 
                            ?>
              <a href="javascript://" onclick="insertHTML('##first_name##');">##first_name##</a>, <a href="javascript://" onclick="insertHTML('##activation_link##');">##activation_link##</a>, <a href="javascript://" onclick="insertHTML('##user_id##');">##email_address##</a>, <a href="javascript://" onclick="insertHTML('##password##');">##password##</a>
              <?php
                           } 
                         ?>
            </div>
            <div class="form-group row">
              <label for="basic" class="col-sm-12 col-form-label">Message Body <span class="required-field">*</span></label>
              <div class="col-sm-12 col-lg-12"> <?php echo $this->Form->input('content', array('id' =>'content','class' => 'form-control')); ?> </div>
            </div>
            <div class="form-actions"> <?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn btn-primary', 'onclick' => 'return formValidate();')); ?> </div>
          </div>
  </div>
</div>
<?php //echo $this->element("admin_footer"); ?>

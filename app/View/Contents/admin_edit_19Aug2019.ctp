<?php 
echo $this->element("admin_header");
?>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    tinyMCE.init({
        mode: "exact",
        elements  : "description",
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
        if($("#name").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter page name.</div>");
            $("#name").focus();
            return false;
        }    
        else if($("#permalink").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter page link.</div>");
            $("#permalink").focus();
            return false;
        }    
        var i=removeHTMLTags(tinyMCE.get("description").getContent());
        if(i=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter page description.</div>");
            $("#description").focus();
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

<div class="clearfix"></div>
<div class="admin-middle-content">
    <div class='admin-side-menu' id="admin-sidemenu-ctrl"> <span class="glyphicon glyphicon-menu-hamburger"></span>
    <span class="txt-admin-side-menu">Side Menu</span> </div>

    <?php echo $this->element("admin_left"); ?>

    <!-- Right Content start -->
    <div class="superadmin-adverts-wrapper">
        <!-- recent ads section start -->
      
      <section class="superadmin-recent-ads-wrapper">
      <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to Web Page Lists', array('controller' => 'contents','action' => 'index'), array('escape' => false, 'class'=>'anchor-black header-anchor',"title"=>"Back to Users")); ?>
        <header class="clearfix">
          <h2 class="section-heading">Edit Web Page</h2>
          <!-- <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div> -->
        </header>        

        <section class="table-grid-wrapper">
        <span id="error_msg"><?=$this->Session->flash();?></span>
            
        <?php echo $this->Form->create('Content',array('id'=>'Content','url' => '','class' => 'form-horizontal')); ?>
        
        <div class="form-group row">
            <label for="basic" class="col-sm-2 col-form-label">Footer Section <span class="required-field">*</span></label>
            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                <?php 
                $content_category=array('1'=>'Information','2'=>'Site Features');
                foreach($content_category as $k=>$v){
                    $cat[$k]=$v;
                }
                echo $this->Form->input('category_type',array('label'=>false,'id'=>'category_type','options'=>array($cat),'type'=>'select',"div"=>false, "class"=> "form-control"));
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="basic" class="col-sm-2 col-form-label">Name <span class="required-field">*</span></label>
            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                <?php echo $this->Form->input('name',array('label'=>false,'id'=>'name','size'=>40,"class"=>"form-control"));?>
            </div>
        </div>
        <div class="form-group row">
            <label for="basic" class="col-sm-2 col-form-label">Permalink <span class="required-field">*</span></label>
            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                <?php echo $this->Form->input('permalink',array('label'=>false,'id'=>'permalink','size'=>40,"class"=>"form-control"));?>
            </div>
        </div>
        <div class="form-group row">
            <label for="basic" class="col-sm-2 col-form-label">Description <span class="required-field">*</span></label>
            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                <?php echo $this->Form->input('description',array('label'=>false,'type'=>'textarea','id'=>'description','rows'=>10,'cols'=>'50',"class"=>"form-control"));?>
            </div>
        </div>
        <div class="form-group row">
            <label for="basic" class="col-sm-2 col-form-label">Meta Title</label>
            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                <?php echo $this->Form->input('meta_title',array('label'=>false,'id'=>'meta_title','size'=>40,"class"=>"form-control"));?>
            </div>
        </div>
        <div class="form-group row">
            <label for="basic" class="col-sm-2 col-form-label">Meta Description</label>
            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                <?php echo $this->Form->input('meta_description',array('label'=>false,'type'=>'textarea','id'=>'meta_description','rows'=>5,'cols'=>'40',"class"=>"form-control"));?>
            </div>
        </div>
        <div class="form-group row">
            <label for="basic" class="col-sm-2 col-form-label">Meta Keywords</label>
            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                <?php echo $this->Form->input('meta_keywords',array('label'=>false,'type'=>'textarea','id'=>'meta_keywords','rows'=>5,'cols'=>'40',"class"=>"form-control"));?>
            </div>
        </div>
        <div class="form-group row">
            <label for="basic" class="col-sm-2 col-form-label">Sort</label>
            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                <?php echo $this->Form->input('sort',array('label'=>false,'id'=>'sort',"class"=>"form-control"));?>
            </div>
        </div>
        <div class="form-group row">
            <label for="basic" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),"class"=>"form-control"));?>
            </div>
        </div>
        <div class="form-group row">
            <?php echo $this->Form->input('pagecount',array('type'=>'hidden','label'=>false,'id'=>'pagecount',"div"=>false,'size'=>40,"class"=>"form-control","value"=>$pagecount));?>
            <?php 
                if($searchKey!='')
                {
                    echo $this->Form->input('searchKey',array('type'=>'hidden','label'=>false,'id'=>'searchKey',"div"=>false,'size'=>40,"class"=>"form-control","value"=>$searchKey));
                }
            ?>
            <?php echo $this->Form->input("Save",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));
            ?>
        </div>
        <?php echo $this->Form->end();?>
        </section>
      </section>
      <!-- recent ads sectioin end -->
    </div>  
</div>
<!-- recent ads sectioin end -->
<!-- Right Content end -->
</div>

<?php 
echo $this->element("admin_header");
?>
<script type="text/javascript" src="<?php echo SITE_URL;?>/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
   /* function formValidate()
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
      <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back to Attribute Value Lists', array('controller' => 'product_attribute_values','action' => 'index'), array('escape' => false, 'class'=>'anchor-black header-anchor',"title"=>"Back to Attribute Value Lists")); ?>
        <header class="clearfix">
          <h2 class="section-heading">Show Attribute Values Category</h2>
        </header>
        <section class="table-grid-wrapper">      
            <div class="item-content-wrapper">
                <div class="form-group row">
                    <div class="col-sm-12 col-lg-6 ctrl-field-adtitle">
                        <?php
                        $lists = "";
                        foreach($groupByCategory as $key=>$value){
                            $lists .= "<h5>".$key."</h5>";
                            $lists .= "<ul style='list-style-type: disc;'>";
                            foreach($value as $v){
                                $lists .= "<li>&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</li>";
                            }
                            $lists .= "</ul>";
                        }
                        echo $lists;
                        ?>
                    </div>
                </div>
            </div>
        </section>
      </section>
      <!-- recent ads sectioin end -->
    </div>  
</div>
<!-- recent ads sectioin end -->
<!-- Right Content end -->
</div>

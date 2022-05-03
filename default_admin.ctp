<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title_for_layout; ?></title>
<meta name="description" content="">
<!--<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">-->
<meta name="viewport" content="width=device-width">
<?php 
  echo $this->Html->css(array('bootstrap','bootstrap-responsive','uniform.default','bootstrap.datepicker','jquery.cleditor','jquery.plupload.queue','jquery.tagsinput',
                                'jquery.ui.plupload','chosen','jquery.fancybox')); 
    
  if ($this->Session->check('Auth.Admin.id')) {
      if ($this->Session->read("style") == "red") {
            echo $this->Html->css('red');
        } elseif ($this->Session->read("style") == "green") {
            echo $this->Html->css('green');
        } elseif ($this->Session->read("style") == "blue") {
            echo $this->Html->css('blue');
        } else {
            echo $this->Html->css('style');
        }
    } else {
        echo $this->Html->script(array('jquery'));
        echo $this->Html->css('style');
    }
    
?> 
<!--<style type="text/css">
    .pagination .disabled, .pagination .active  {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #DDDDDD;
        border-image: none;
        border-style: solid;
        border-width: 1px;
        float: left;
        line-height: 34px;
        padding: 0 14px;
        text-decoration: none;
        background-color: #F5F5F5;
        color: #999999;
        cursor: default;
        border-radius: 3px 0 0 3px;
    }
    .pagination .active {
        border-left: 0px;
    }
    .pagination .disabled {
        background-color: transparent;
    }
</style> -->
<script>
 var  SITE_URL='<?php echo SITE_URL;?>';
 jQuery.noConflict();
</script>

<?php 
echo $this->Html->script("jquery-1.8.3.min"); 
echo $this->Html->script(array('jquery', 'less', 'bootstrap.min', 'jquery.uniform.min', 'bootstrap.timepicker', 'bootstrap.datepicker', 'chosen.jquery.min', 'jquery.fancybox', 'plupload/plupload.full', 'plupload/jquery.plupload.queue/jquery.plupload.queue', 'jquery.cleditor.min', 'jquery.inputmask.min', 'jquery.tagsinput.min', 'jquery.mousewheel', 'jquery.dataTables.min', 'jquery.dataTables.bootstrap', 'jquery.textareaCounter.plugin', 'ui.spinner', 'jquery.form.js', 'jquery.validate.min.js', 'custom'));
?>
</head>

<body>
    <?php
    if ($this->Session->check('Auth.Admin.id')) {
    ?>
        <div class="style-toggler">
            <?php echo $this->Html->image('icons/fugue/color.png', array('alt' => "", 'class' => 'tip', 'title' => "Toggle style-switcher", 'data-placement' => "right")); ?>
        </div>
        <div class="style-switcher">
            <h3>Style-switcher</h3>
            <ul>
                <li><?php echo $this->Html->link("Default", array("controller" => "admins", "action" => "setstyle", "default")); ?></li>
                <li><?php echo $this->Html->link("Blue", array("controller" => "admins", "action" => "setstyle", "blue"), array("class" => "blue")); ?></li>
                <li><?php echo $this->Html->link("Green", array("controller" => "admins", "action" => "setstyle", "green"), array("class" => "green")); ?></li>
                <li><?php echo $this->Html->link("Red", array("controller" => "admins", "action" => "setstyle", "red"), array("class" => "red")); ?></li>
            </ul>
        </div>

    <?php
    }
    echo $this->fetch('content');
    ?>
    <?php  //echo $this->element('sql_dump'); ?>
  </body>
</html>
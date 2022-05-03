<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title_for_layout; ?></title>
<meta name="description" content="">
<!--<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">-->
<meta name="viewport" content="width=device-width">
<?php 
  echo $this->Html->css(array('uniform.default','bootstrap.min','bootstrap-grid.min','ginder-in-style','super-admin-module','fonts-glyphicon','jquery-ui','../plugins/font-awesome/css/font-awesome.min','select2.min', 'bootstrap.datepicker')); 
    
//echo $this->Html->script("jquery-1.8.3.min");
//echo $this->Html->script(array('jquery.min', 'jquery-ui.min', 'popper.min', 'bootstrap.min'));

echo $this->Html->script(array('jquery', 'jquery-ui.min', 'popper.min', 'bootstrap.min','bootstrap.timepicker', 'bootstrap.datepicker','custom'));
echo $this->Html->script("select2.min");

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
        //echo $this->Html->script(array('jquery'));
        echo $this->Html->css('style');
    }
    
?>

<script>
    $(document).ready(function () {

      /* Global Navigation on close click for resposnive design start*/
      $('.navbar-toggler').click(function () {
        $('body').addClass("fixedPosition");
      });

      $("#ctrl-navbar-close, .mobile-global-navbar-overlay").click(function () {
        $("#collapsibleNavbar").removeClass('show');
        $('body').removeClass("fixedPosition");
      });
      /* Global Navigation on close click for resposnive design end*/

      /* Mobile search control */
      $('#mobile-search-ctrl').hide();

      $('#SearchModal-MobTab').click(function () {
        $('#mobile-search-ctrl').show();
      });

      $("#mobile-search-close").click(function () {
        $('#mobile-search-ctrl').hide();
      });
      /* Mobile search control end */


      /* Mobile sidemenu control start */
      $('#admin-sidemenu-ctrl').click(function () {
        if ($(".admin-navigation-wrapper").is(":visible")) {
          $('.admin-navigation-wrapper').hide();
        } else {
          $('.admin-navigation-wrapper').show();
        }
      });
    });
  </script>
</head>
<body>
    <?php
    if ($this->Session->check('Auth.Admin.id')) {
    ?>
        <!-- <div class="style-toggler">
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
        </div> -->

    <?php
    }
    echo $this->fetch('content');
    ?>
    <?php  //echo $this->element('sql_dump'); ?>
  </body>
</html>
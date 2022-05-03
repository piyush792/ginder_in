<?php 
echo $this->element("admin_header");

$direction = $this->Paginator->sortDir();
$image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
$key =$this->Paginator->sortKey();
$id_link  = ($key=='User.id')?$this->Html->image(SITE_URL."img/".$image):'';
$email_link  = ($key=='User.email')?$this->Html->image(SITE_URL."img/".$image):''; 
$firstname_link  = ($key=='User.firstname')?$this->Html->image(SITE_URL."img/".$image):''; 
$lastname_link  = ($key=='User.lastname')?$this->Html->image(SITE_URL."img/".$image):'';     
$active_link  = ($key=='User.active')?$this->Html->image(SITE_URL."img/".$image):''; 
?>

<div class="clearfix"></div>
<div class="admin-middle-content">
    <div class='admin-side-menu' id="admin-sidemenu-ctrl"> <span class="glyphicon glyphicon-menu-hamburger"></span>
        <span class="txt-admin-side-menu">Side Menu</span> </div>

        <?php echo $this->element("admin_left"); ?>

    <!-- Right Content start -->
    <div class="superadmin-adverts-wrapper">
      <!-- recent ads section start -->
      <header class="clearfix">
        <h2 class="section-heading">Reports</h2>
      </header>
      <div class="tile-wrapper">
        <section class="tile-item">
          <header class="tile-header"> Posted Ads </header>
          <div class="tile-content">
            <div class="tile-text float-left col-sm-12 col-lg-6"><?php echo $postedListCounts; ?></div>
            <div class="tile-link float-left col-sm-12 col-lg-6">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span>', array('controller'=>'products','action'=>'admin_postedads'), array('escape' => false, 'class' => 'light')); ?>
            </div>
          </div>
        </section>

        <section class="tile-item">
          <header class="tile-header"> Promoted Ads </header>
          <div class="tile-content">
            <div class="tile-text float-left col-sm-12 col-lg-6"><?php echo $promotedListCounts; ?></div>
            <div class="tile-link float-left col-sm-12 col-lg-6">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span>', array('controller'=>'products','action'=>'admin_promotedads'), array('escape' => false, 'class' => 'light')); ?>
            </div>
          </div>
        </section>

        <section class="tile-item">
          <header class="tile-header"> Retail Users </header>
          <div class="tile-content">
            <div class="tile-text float-left col-sm-12 col-lg-6"><?php echo $retailUsersListCount; ?></div>
            <div class="tile-link float-left col-sm-12 col-lg-6">
                <?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span>', array('controller'=>'products','action'=>'admin_retailusers'), array('escape' => false, 'class' => 'light')); ?>
            </div>
          </div>
        </section>

        <section class="tile-item">
          <header class="tile-header"> Business Users </header>
          <div class="tile-content">
            <div class="tile-text float-left col-sm-12 col-lg-6"><?php echo $businessUsersListCount; ?></div>
            <div class="tile-link float-left col-sm-12 col-lg-6">
              <?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span>', array('controller'=>'products','action'=>'admin_businessusers'), array('escape' => false, 'class' => 'light')); ?>
            </div>
          </div>
        </section>

        <section class="tile-item">
          <header class="tile-header"> Spam Reports </header>
          <div class="tile-content">
            <div class="tile-text float-left col-sm-12 col-lg-6"><?php echo $spamReportsListCount; ?></div>
            <div class="tile-link float-left col-sm-12 col-lg-6">
              <?php echo $this->Html->link('<span class="glyphicon glyphicon-menu-right"></span>', array('controller'=>'reports','action'=>'admin_spam_reports'), array('escape' => false, 'class' => 'light')); ?>
            </div>
          </div>
        </section>

      </div>
    </div>
    <!-- Right Content end -->
</div>
    <!-- recent ads sectioin end -->
<!-- Right Content end -->
</div>

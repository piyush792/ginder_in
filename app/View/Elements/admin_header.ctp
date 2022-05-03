<!-- Mobile search modal start -->
<div id="mobile-search-ctrl" class="mobile-search-control"> <span id="mobile-search-close" class="glyphicon glyphicon-remove-circle"></span>
  <input type="search" placeholder="I am looking for..." class="field-search">
  <button class="btn-search"><img src="images/icon-search.png"></button>
</div>
<!-- Mobile search modal end -->

<header class="page-header container-fluid" style="padding-bottom: 10px;">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"> <span class="glyphicon glyphicon-menu-hamburger"></span>
    </button>
    <a href="index.html" class="brand-logo"><img class="site-logo" src="<?php echo SITE_URL; ?>img/brand-logo.png"></a>
    <div class="mobile-ctrl-header">
      <div class="search-wrapper">
        <div class="mobtab-search-bar">
          <div class="btn-search" id="SearchModal-MobTab"><span class="glyphicon glyphicon-search"></span></div>
        </div>
        <div class="desktop-search-bar">
          <input type="text" placeholder="Search for electronics, appliance, furniture, vehicles..." class="input-search">
          <button class="btn-search">Search</button>
        </div>
      </div>

      <ul style="list-style-type: none; float: right; padding: 0px;">        
        <li>
            <a href="<?=SITE_URL?>admin/logout">
                <?php echo $this->Html->image(SITE_URL."img/icons/fugue/control-power.png");?>
                Logout
            </a>
        </li>
    </ul>
    </div>
    
  </header>

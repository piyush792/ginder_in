<?php

echo $this->element("admin_header"); 
//$userType=$this->Session->read("userType");
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
                    <div class="tile-text float-left col-sm-12 col-lg-6">350</div>
                    <div class="tile-link float-left col-sm-12 col-lg-6"><a href="superadmin-manage-reports-postedads.html"><span
                                class="glyphicon glyphicon-menu-right"></span></a></div>
                </div>
            </section>

            <section class="tile-item">
                <header class="tile-header"> Promoted Ads </header>
                <div class="tile-content">
                    <div class="tile-text float-left col-sm-12 col-lg-6">450</div>
                    <div class="tile-link float-left col-sm-12 col-lg-6"><a href="superadmin-manage-reports-promotedads.html"><span
                                class="glyphicon glyphicon-menu-right"></span></a></div>
                </div>
            </section>

            <section class="tile-item">
                <header class="tile-header"> Retail Users </header>
                <div class="tile-content">
                    <div class="tile-text float-left col-sm-12 col-lg-6">350</div>
                    <div class="tile-link float-left col-sm-12 col-lg-6"><a href="superadmin-manage-reports-retailusers.html"><span
                                class="glyphicon glyphicon-menu-right"></span></a></div>
                </div>
            </section>

            <section class="tile-item">
                <header class="tile-header"> Business Users </header>
                <div class="tile-content">
                    <div class="tile-text float-left col-sm-12 col-lg-6">150</div>
                    <div class="tile-link float-left col-sm-12 col-lg-6"><a href="superadmin-manage-reports-businessusers.html"><span
                                class="glyphicon glyphicon-menu-right"></span></a></div>
                </div>
            </section>

        </div>
    </div>
    <!-- recent ads sectioin end -->

</div>
<!-- Right Content end -->
</div>

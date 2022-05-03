<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ginder</title>
        <link rel="shortcut icon" href="<?php echo SITE_URL; ?>img/ginder-favicon.png">
        <?php
            echo $this->Html->css(array('bootstrap.min','bootstrap-grid.min','ginder-in-style','jquery.bxslider','fonts-glyphicon','admin-module','select2.min'));
            echo $this->Html->script("modernizr");
            // echo $this->Html->script("jquery");
            // echo $this->Html->script("easing");
            echo $this->Html->script("main");
            echo $this->Html->script("jquery.min");
            echo $this->Html->script("select2.min");
            echo $this->Html->script("popper.min");
            echo $this->Html->script("bootstrap.min");
            echo $this->Html->script("jquery.bxslider");
            echo $this->Html->script("jquery.bxslider.min");
        ?>
        <script>
            // $(function(){
            //     $('.slideShow').bxSlider({mode:'horizontal',auto:true,infiniteLoop:true,pause:3500,speed:1250,pager:false,controls:true});
            // });

            $(document).ready(function () {
                if ($(window).width() > 1280) {
                    slider = $('.featuredbxslider').bxSlider({
                        slideWidth: 1200,
                        minSlides: 6,
                        maxSlides: 6,
                        slideMargin: 0,
                        responsive: true,
                        pager: false
                    });
                } else if ($(window).width() > 767) {
                    slider = $('.featuredbxslider').bxSlider({
                        slideWidth: 768,
                        minSlides: 3,
                        maxSlides: 3,
                        slideMargin: 0,
                        responsive: true,
                        pager: false
                    });
                } else {
                    slider = $('.featuredbxslider').bxSlider({
                        slideWidth: 500,
                        minSlides: 2,
                        maxSlides: 2,
                        slideMargin: 0,
                        responsive: true,
                        controls: false,
                        pager: false
                    });
                }

                $(".btn-favourite").click(function () {
                    $(this).children('span').addClass('glyphicon-star selected-favourite').removeClass('glyphicon-star-empty');
                });

                $('[data-toggle="tooltip"]').tooltip();

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
            });
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-K2DNHKVB4F"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-K2DNHKVB4F');
        </script>

        <?php
        echo $this->fetch('inline');
        ?>
    </head>

    <body>
        
        <!-- Header start -->
        <?php echo $this->element('header'); ?>
        <!-- Header end -->
        
        <!-- global navigation start -->
        <?php echo $this->element('navigation'); ?>
        <!-- global navigation end -->

        <div class="clearfix"></div>

        <!-- BEGIN content -->
        <?php echo $this->fetch('content'); ?>
        <!-- END content --> 

        <!-- footer section start -->
        <?php echo $this->element('footer'); ?>
        <!-- footer section end -->
        
        <!-- footer google adsense start -->
        <div class="adsense-wrapper">
            <div class="adsseos">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({
                        google_ad_client: "ca-pub-3446985642161249",
                        enable_page_level_ads: true
                    });
                </script>
            </div>
        </div>
        <!-- footer google adsense end -->

        <script>
            function newsletterformValidate() {
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (document.getElementById("subscriber_email").value == "")
                {
                    alert("Please Enter Your Email-id");
                    document.getElementById("subscriber_email").focus();
                    return false;
                }
                if (reg.test(document.getElementById("subscriber_email").value) == false) {
                    alert('Please Enter Valid Email-id');
                    document.getElementById("subscriber_email").focus();
                    return false;
                }
                return true;
            }
            function newsletterformValidate1() {
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

                if (document.getElementById("subscriber_email1").value == "")
                {
                    alert("Please Enter Your Email-id");
                    document.getElementById("subscriber_email1").focus();
                    return false;
                }
                if (reg.test(document.getElementById("subscriber_email1").value) == false) {
                    alert('Please Enter Valid Email-id');
                    document.getElementById("subscriber_email1").focus();
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>

<div class="modal fade" id="modalSpamReportForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <?php //echo $this->Form->create('User',array('id'=>'SpamReportForm','url'=>'/reports/spam_report/','type'=>'post'));?>
    <div class="modal-content">

    <div id="loader_report" style="display: none;">&nbsp;</div>
    <div id="reportMsg"></div>
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Report Spam</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-4">
          <label data-error="wrong" data-success="right" for="defaultForm-pass">Description</label>
          <i class="fas fa-lock prefix grey-text"></i>
          <textarea name="description" id="description" class="form-control validate"></textarea>          
        </div>
      </div>
      <!-- <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-default">Submit</button>
      </div> -->
      <div class="modal-footer d-flex justify-content-center">
       <?php echo $this->Form->button("submit",array('id'=>'submit', 'type'=>'button',"label"=>false,"div"=>false,'class'=>'button button-primary'));?>
      </div>
    </div>
    <?php //echo $this->Form->end(); ?>
  </div>
</div>

<section class="footer-wrapper">
    <section class="mega-footer">
        <header>
            <h2 class="section-heading">Search by Categories</h2>
        </header>
        <?php
            foreach($SubCategory_list as $keys=>$value){
            $key = explode('==', $keys);
        ?>
        <div class="row mega-footer-row">
            <div class="col-sm-12 col-lg-2 footer-menu-heading">
                <?php //echo $key[1]; ?>
                <?php echo $this->Html->link($key[1], array('controller' => 'products', 'action' => 'show_category', $key[0]), array('escape' => false));?>
            </div>
            <div class="col-sm-12 col-lg-10 footer-menu-item">
                <ul>
                    <?php
                    $i=1;
                    foreach($value as $k=>$v){
                        if($i < count($value)){
                            $span = "<span>|</span>";
                        }else{
                            $span = "";
                        }
                        echo '<li>'.$this->Html->link($v, array('controller' => 'products', 'action' => 'view', $k), array('escape' => false)).$span.'</li>';
                        $i++;
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php
            }
        ?>
    </section>
    <div class="footer-links-wrapper">
        <div class='col-sm-12 col-lg-3 footer-links'>
            <header>
                <h2 class="section-heading">Information</h2>
            </header>
            <ul>
                <?php
                    foreach($content_pages1 as $value){
                    ?>
                        <li><?php echo $this->Html->link($value['Content']['name'],SITE_URL.$value['Content']['permalink']);?></li>
                    <?php
                    }
                ?>
                <!-- <li><a href="#" data-toggle='modal' data-target='#modalSpamReportForm'>Report Spam</a></li> -->

            </ul>
        </div>
        <div class='col-sm-12 col-lg-3 footer-links' >
            <header>
                <h2 class="section-heading">Site Features</h2>
            </header>
            <ul>
                <?php
                    foreach($content_pages2 as $value){
                    ?>
                <li><?php echo $this->Html->link($value['Content']['name'],SITE_URL.$value['Content']['permalink']);?></li>
                    <?php
                    }
                ?>
            </ul>
        </div>
            <div class='col-sm-12 col-lg-3 footer-links' >
                <header>
                    <h2 class="section-heading">Follow us</h2>
                </header>
                <div>
                    <?php
                    if($social_linked['SocialLink']['facebook_status']==1){
                    ?>
                    <span><a href="<?php echo $social_linked['SocialLink']['facebook'];?>" target="_blank"><?php echo $this->Html->image(SITE_URL.'img/icon-facebook.png');?></a></span>
                    <?php
                    }
                    ?>
                    <?php
                    if($social_linked['SocialLink']['twitter_status']==1){
                    ?>
                    <span><a href="<?php echo $social_linked['SocialLink']['twitter'];?>" target="_blank"><?php echo $this->Html->image(SITE_URL.'img/icon-twitter.png');?></a></span>
                    <?php
                    }
                    ?>
                    <?php
                    if($social_linked['SocialLink']['pinterest_status']==1){
                    ?>
                    <span><a href="<?php echo $social_linked['SocialLink']['pinterest'];?>" target="_blank"><?php echo $this->Html->image(SITE_URL.'img/icon-pinterest.png');?></a></span>
                    <?php
                    }
                    ?>
                    <?php
                    if($social_linked['SocialLink']['instagram_status']==1){
                    ?>
                    <span><a href="<?php echo $social_linked['SocialLink']['instagram'];?>" target="_blank"><?php echo $this->Html->image(SITE_URL.'img/icon-instagram.png');?></a></span>
                    <?php
                    }
                    ?>    
                </div>
        </div>
    </div>
    <div class="footer-logo">
            <?php echo $this->Html->link($this->Html->image('/images/brand-logo.png'), '/', array('escape' => false)); ?>
    </div>
    <div class="footer-brand-location">
        <span><a href="http://ginder.com.au/">Australia</a></span>
        <span><a href="https://ginder.in/">India</a></span>
    </div>
    <div class="copy-right">All copyrights reserved @ 2016- Ginder - Local Classified Ads</div>
</section>

<?php
$cookie_name = "ginder_privacy_policy";
$cookie_value = '<a href="ginder-privacy-policy.html">Privacy and Cookie Policy</a>';
setcookie($cookie_name, $cookie_value, time() + (30 * 86400 * 30), "/"); //for 30 days
if(!isset($_COOKIE[$cookie_name])) {
?>
<section class="cookies-wrapper" id="cookies-policy">
    <div class="cookies-bg"></div>
    <div class="col-left">We use cookies at Ginder.in so we can provide content and advertising that's matters to you. You can find out more how cookies are used by clicking Cookie Settings. By using Ginder.in website, you're agreeing to the use of cookies. <a href="ginder-privacy-policy.html">Privacy and Cookie Policy</a>
    </div>
    <div class="col-right">
        <button id="accept-cookies-policy" class="btn btn-primary">I Accept</button>
    </div>
</section>
<?php
}
?>
<script>

    $('#submit').click(function(){    
        // var productID = $('#product_id').val();
        var description = $('#description').val();        
        $("#loader_report").show();
        if(description!=''){
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'reports', 'action' => 'spam_report')); ?>',
                type: "post",
                data: {description: description},
                success: function(data){
                    $("#loader_report").hide();
                    if(data=="No"){
                        $('#reportMsg').html('<div class="alert alert-danger">Product description is not matched!</div>');
                    }else{
                        $('#reportMsg').html('<div class="text-success">Report is send successfully!</div>');
                        // $('#LoginModal').hide();
                        // location.reload();
                        // top.location.href = 'users/profile';
                    }
                }
            });
        }else{
            $("#loader_report").hide();
            if($("#description").val()==""){
                $('#reportMsg').html('<div class="alert alert-danger">Please Enter Your description.</div>');
                $("#description").focus();
                return false;
            }
            return true;
        }
    });

    /*cookies policy start*/
	$('#accept-cookies-policy').click(function(){
        $('#cookies-policy').hide();
	});
	/*cookies policy end*/
    
</script>
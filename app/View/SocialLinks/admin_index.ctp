<?php
echo $this->element("admin_header");
?>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<div class="clearfix"></div>
<div class="admin-middle-content">
    <div class='admin-side-menu' id="admin-sidemenu-ctrl"> <span class="glyphicon glyphicon-menu-hamburger"></span>
        <span class="txt-admin-side-menu">Side Menu</span> </div>
        <?php echo $this->element("admin_left"); ?>
    <!-- Right Content start -->
    <div class="superadmin-adverts-wrapper">
        <!-- recent ads section start -->
        <section class="item-content">
            <header class="clearfix">
                <h2 class="section-heading">Manage Socail Links</h2>
            </header>
            <section  class="table-grid-wrapper">

                <?php echo $this->Form->create('SocialLink',array('id'=>'SocialLink','type'=>'post','url' => '','class'=>'form-social-links'));?>
                <table class="table">
                    <thead>        
                        <tr>
                            <th> Site Name </th>
                            <th> Web Link </th>
                            <th> Status </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-title='Site Name'> Facebook </td>
                            <td data-title='Web Link'>
                              <div class="col-sm-10">
                                  <?php echo $this->Form->input('facebook',array('id'=>'facebook','class'=>"required form-control", 'placeholder'=>'https://www.facebook.com', 'label'=>false, 'required'));?>
                              </div>
                            </td>
                            <td data-title='FacebookStatus'>
                                <?php
                                if(isset($this->request->data['SocialLink']['facebook_status']) && ($this->request->data['SocialLink']['facebook_status']==1))
                                  $className = "btn btn-sm btn-toggle active";
                                else                                      
                                  $className = "btn btn-sm btn-toggle activated";
                                ?>
                                <button type="text" id="facebookClick" class="<?=$className; ?>" data-toggle="button" aria-pressed="true" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                                <?php echo $this->Form->input('facebook_status',array('id'=>'facebook_val','class'=>"required form-control", 'type'=> 'hidden'));?>
                            </td>
                        </tr>
                        <tr>
                            <td data-title='Site Name'> Twitter </td>
                            <td data-title='Web Link'>
                              <div class="col-sm-10">
                              <?php echo $this->Form->input('twitter',array('id'=>'twitter','class'=>"required form-control", 'placeholder'=>'https://www.twitter.com', 'label'=>false, 'required'));?>
                              </div>
                            </td>
                            <td data-title='TwitterStatus'>
                                <?php
                                if(isset($this->request->data['SocialLink']['twitter_status']) && ($this->request->data['SocialLink']['twitter_status']==1))
                                  $className1 = "btn btn-sm btn-toggle active";
                                else                                      
                                  $className1 = "btn btn-sm btn-toggle activated";
                                ?>
                                <button type="text" id="twitterClick" class="<?=$className1; ?>" data-toggle="button" aria-pressed="true" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                                <?php echo $this->Form->input('twitter_status',array('id'=>'twitter_val','class'=>"required form-control", 'type'=> 'hidden'));?>
                            </td>
                        </tr>
                        <tr>
                            <td data-title='Site Name'> Pinterest </td>
                            <td data-title='Web Link'>
                              <div class="col-sm-10">
                                <?php echo $this->Form->input('pinterest',array('id'=>'pinterest','class'=>"required form-control", 'placeholder'=>'https://www.pinterest.com', 'label'=>false, 'required'));?>
                              </div>
                            </td>
                            <td data-title='PinterestStatus'>
                                <?php
                                if(isset($this->request->data['SocialLink']['pinterest_status']) && ($this->request->data['SocialLink']['pinterest_status']==1))
                                  $className2 = "btn btn-sm btn-toggle active";
                                else                                      
                                  $className2 = "btn btn-sm btn-toggle activated";
                                ?>
                                <button type="text" id="pinterestClick" class="<?=$className2; ?>" data-toggle="button" aria-pressed="true" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                                <?php echo $this->Form->input('pinterest_status',array('id'=>'pinterest_val','class'=>"required form-control", 'type'=> 'hidden'));?>
                            </td>
                        </tr> 
                        <tr>
                            <td data-title='Site Name'> Instagram </td>
                            <td data-title='Web Link'>
                              <div class="col-sm-10">
                                <?php echo $this->Form->input('instagram',array('id'=>'instagram','class'=>"required form-control", 'placeholder'=>'https://www.instagram.com', 'label'=>false, 'required'));?>
                              </div>
                            </td>
                            <td data-title='InstagramStatus'>
                                <?php
                                if(isset($this->request->data['SocialLink']['instagram_status']) && ($this->request->data['SocialLink']['instagram_status']==1))
                                  $className3 = "btn btn-sm btn-toggle active";
                                else                                      
                                  $className3 = "btn btn-sm btn-toggle activated";
                                ?>
                                <button type="text" id="instagramClick" class="<?=$className3; ?>" data-toggle="button" aria-pressed="true" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                                <?php echo $this->Form->input('instagram_status',array('id'=>'instagram_val','class'=>"required form-control", 'type'=> 'hidden'));?>
                            </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                          <div class="form-label-group">
                            <?php echo $this->Form->button("Save",array('id'=>'save', 'type'=>'submit',"label"=>false,"div"=>false,'class'=>'btn btn-secondary btn-save'));?>
                          </div>
                          </td>
                        </tr>
                    </tbody>  
                </table>
                <?php 
                echo $this->Form->end();
                ?>
            </section>
        </section>
        <!-- recent ads sectioin end --> 
    </div>
    <!-- Right Content end -->
</div>
<!-- recent ads sectioin end -->
<!-- Right Content end -->
</div>
<script>
   $('#facebookClick').click(function() {
      $(this).toggleClass('activated');
      if($(this).hasClass('activated')){
        document.getElementById("facebook_val").value="0";
      } else {
        document.getElementById("facebook_val").value="1";
      }
    });

    $('#twitterClick').click(function() {
      $(this).toggleClass('activated');
      if($(this).hasClass('activated')){
        document.getElementById("twitter_val").value="0";
      } else {
        document.getElementById("twitter_val").value="1";
      }
    });

    $('#pinterestClick').click(function() {
      $(this).toggleClass('activated');
      if($(this).hasClass('activated')){
        document.getElementById("pinterest_val").value="0";
      } else {
        document.getElementById("pinterest_val").value="1";
      }
    });

    $('#instagramClick').click(function() {
      $(this).toggleClass('activated');
      if($(this).hasClass('activated')){
        document.getElementById("instagram_val").value="0";
      } else {
        document.getElementById("instagram_val").value="1";
      }
    });

</script>
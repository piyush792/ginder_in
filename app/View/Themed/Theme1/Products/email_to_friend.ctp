<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Silverbliss</title>
        <?php
            echo $this->Html->css('style');
            echo $this->Html->css("popup");
            echo $this->Html->script("modernizr");
            echo $this->Html->script("jquery");
            echo $this->Html->script("easing");
            echo $this->Html->script("jquery.bxslider");
            echo $this->Html->script("main");
        ?>
        <script>
         function email_friend(){
              var frmData = jQuery('#EmailToFriend').serialize();
              var siteUrl= '<?php echo SITE_URL;?>';
              var param='<?php echo $this->request->params['pass'][0];?>';
              var url=siteUrl+"products/email_to_friend/"+param;
               jQuery.ajax({
                   type:'POST',
                        url: url,
                        data:frmData,
                        dataType:'text',
                        success:function(responseData){
                           var result = responseData;
                           jQuery('#emsg').html(result);     
                           jQuery("#econtent").hide();    
                        }
                    });
                
         }
         </script>
    </head>
    <body> 
        <div class="popup">
            <nav>
            <div class="cut"><p>CLOSE<a href="javascript:parent.closePopUp();"><?php echo $this->Html->image('cut.png',array('align'=>'right'));?></a></p></div>
            <h1>Email To Friend</h1>
            
            <div class="popupchackout">
                <div id="emsg"></div> 
                
                <?php echo $this->Form->create('Product',array('id'=>'EmailToFriend')); ?>
                <div id="econtent" style="display: block;">
                    <div class="sige">
                        <h4>Email Id:</h4>
                        <?php echo $this->Form->input('email_id',array('label'=>false,'id'=>'email_id','type'=>'textarea','rows'=>3,'cols'=>'40',"div"=>false));?>
                    </div>
                    <span>(Multiple Email-Id should be in comma seprated)</span>
                    <br />
                    <div class="sige">
                        <h4>Message</h4>
                        <?php echo $this->Form->input('message',array('label'=>false,'id'=>'message','type'=>'textarea','rows'=>3,'cols'=>'40',"div"=>false));?>        
                    </div>
                    <br /> 
                    <?php echo $this->Form->button("Send",array('type'=>'button','class'=>'blueBtn','label'=>false,'onclick'=>'email_friend();'));?> 
                </div>
                <?php echo $this->Form->end();?>
            </div>
        
        </nav>
        </div>
    </body>
</html>    
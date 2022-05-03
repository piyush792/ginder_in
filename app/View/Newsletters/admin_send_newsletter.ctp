<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
?>
<script type="text/javascript">
function formValidate()
{
    if(document.getElementById('users').value == "")
    {
        document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">�</a><h4 class="alert-heading">Please select atleast one user.</h4></div>';
        document.getElementById('users').focus();
        return false;
    }

    if(document.getElementById('newsletter').value == "")
    {
        document.getElementById('error_msg').innerHTML ='<div class="alert alert-block alert-danger"><a href="#" data-dismiss="alert" class="close">�</a><h4 class="alert-heading">Please select atleast one newsletter.</h4></div>';
        document.getElementById('newsletter').focus();
        return false;
    } 
}
</script>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Send Newsletter</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?php echo $this->Session->flash();?></span>
                        
                        <?php  echo $this->Form->create("Newsletter",array('id'=>'Newsletter',"url"=>"",'class' =>'form-horizontal')); ?>
                        <div class="control-group">
                            <label for="basic" class="control-label">Subscribers:</label>
                            <div class="controls">
                                <?php 
                                $subscriber=array();
                                foreach($subscriber_list as $k=>$v)
                                {
                                    $name = $v['NewsletterSubscriber']['subscriber_email'];
//                                    if($v['NewsletterSubscriber']['firstname'])
//                                    {
//                                      $name .= ' ('.$v['NewsletterSubscriber']['firstname'].' '.$v['NewsletterSubscriber']['lastname'].')'; 
//                                            
//                                    }
                                    $subscriber[$v['NewsletterSubscriber']['id']]=$name;
                                }
                                echo $this->Form->input('users',array('label'=>false,'id'=>'users','options'=>array($subscriber),'type'=>'select','multiple'=>'true',"div"=>false));
                                ?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label for="basic" class="control-label">Select Newsletters:</label>
                            <div class="controls">
                                <?php 
                                $news_letter=array();
                                foreach($newsletter as $k=>$v)
                                {
                                   $news_letter[$v['Newsletter']['id']]=$v['Newsletter']['title'];
                                }
                                echo $this->Form->input('newsletter',array('label'=>false,'id'=>'newsletter','options'=>array($news_letter),"div"=>false));
                                ?>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <?php echo $this->Form->input("Send",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));
                        ?>
                        </div>
                    <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

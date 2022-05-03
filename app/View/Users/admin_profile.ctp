<?php 
    echo $this->element("admin_header"); 
    echo $this->element("admin_dashboard"); 
    echo $this->element("admin_left");
?>
<script type="text/javascript">
    function formValidate()
    {
        if($("#personal_quote").val()=="")
        {
            $("#error_msg").html("<div class='alert alert-error'>Please enter Personal Quote.</div>");
            $("#personal_quote").focus();
            return false;
        }

        $("#error_msg").html('');
        return true;
    }
</script>

<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Users</h3>
                    </div>
                    <div class="box-content">
                        <span id="error_msg"><?=$this->Session->flash();?></span>

                        <?php echo $this->Form->create('UserProfile',array('id'=>'UserProfile','url' => '/admin/users/profile/'.$this->data['UserProfile']['id'],'enctype' => 'multipart/form-data','class' => 'form-horizontal')); ?>

                        <fieldset>
                            <legend>Profile Information</legend>
                        </fieldset>
                        <div class="control-group">
                            <label for="basic" class="control-label">Profile Picture:</label>
                            <div class="controls">
                                <div id="uniform-file2" class="uploader">
                                    <?php echo $this->Form->input('image',array('label'=>false,'type'=>'file','id'=>'image',"div"=>false,"class"=>"uniform","style"=>"opacity: 0;"));?>
                                    <span class="filename" style="-moz-user-select: none;">No file selected</span>
                                    <span class="action" style="-moz-user-select: none;">Choose File</span>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <?php 
                                     if(file_exists(WWW_ROOT.PROFILE_PHOTO_UPLOAD.$this->data['UserProfile']['image']) && ($this->data['UserProfile']['image']<>""))
                                    {
                                    echo $this->Html->image(PROFILE_PHOTO_UPLOAD.$this->data['UserProfile']['image'], array('width' => '100px','height' => '100px'));
                                    }
                                    else
                                    {
                                    echo "<img src='".SITE_URL.NO_IMAGE."' alt='' />";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Alias:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('alias',array('label'=>false,'id'=>'alias','size'=>40,"class"=>"input-square"));?>
                            </div>
                        </div>


                        <div class="control-group">
                            <label for="basic" class="control-label">Personal Quote:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('personal_quote',array('label'=>false,'id'=>'personal_quote','size'=>40));?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="basic" class="control-label">Subjects:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('subjects',array('label'=>false,'id'=>'subjects','options'=>array("K-12 Subjects"=>$k12_options,"University Discipline"=>$univ_options,"Adult Education"=>$adult_options),"div"=>false,"multiple"=>true,"size"=>"10","selected"=>$subjectArr));?>
                            </div>
                        </div>


                        <div class="control-group">
                            <label for="basic" class="control-label">Grades Taught:</label>
                            <div class="controls">
                            
                            <?php echo $this->Form->input('grades_taught', array('multiple' => 'checkbox', 'options' => $grades_taughtoptions, 'selected' => $selected,"div"=>false,"label"=>false)); ?>
                                
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Experience:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('experience',array('label'=>false,'type'=>'textarea','id'=>'experience','rows'=>10,"class"=>"span9 input-square","div"=>false));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Teaching Style:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('teach_style',array('label'=>false,'type'=>'textarea','id'=>'teach_style','rows'=>10,"class"=>"span9 input-square","div"=>false));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Honors/Awards:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('honors',array('label'=>false,'type'=>'textarea','id'=>'honors','rows'=>10,"class"=>"span9 input-square","div"=>false));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Own Education History:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('edu_history',array('label'=>false,'type'=>'textarea','id'=>'edu_history','rows'=>10,"class"=>"span9 input-square","div"=>false));?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="basic" class="control-label">Additional Bio Info:</label>
                            <div class="controls">
                                <?php echo $this->Form->input('bio_info',array('label'=>false,'type'=>'textarea','id'=>'bio_info','rows'=>10,"class"=>"span9 input-square","div"=>false));?>
                            </div>
                        </div>

                        <div class="form-actions">
                            <?php echo $this->Form->input("SAVE",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary','onclick'=>'return formValidate();'));
                            ?>
                        </div>
                        <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
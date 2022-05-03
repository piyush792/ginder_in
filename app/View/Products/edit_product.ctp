<script type="text/javascript">
    function formValidate()
    {
        if($("#category_id").val()==null)
        {
            /*$("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please select Type</div>");*/       
            $("#error_msg").css("display","block");
            $("#error_msg").html("Please select Type.");     
            $("#category_id").focus();
            return false;
        }  
        if($("#subjects").val()==null)
        {
            $("#error_msg").css("display","block");     
            /*$("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please select subject</div>");*/
            $("#error_msg").html("Please select subject.");     
            $("#subjects").focus();
            return false;
        }      
        if($("#name").val()=="")
        {
            /*            $("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter product name</div>");*/
            $("#error_msg").css("display","block");
            $("#error_msg").html("Please enter product name.");     
            $("#name").focus();
            return false;
        }
        else if($("#short_description").val()=="")
        {
            /*$("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter product short description</div>");*/
            $("#error_msg").css("display","block");
            $("#error_msg").html("Please enter product short description.");     
            $("#short_description").focus();
            return false;
        }            
        else if($("#description").val()=="")
        {
            /*$("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Please enter product description</div>");*/
            $("#error_msg").css("display","block");     
            $("#error_msg").html("Please enter product description.");     
            $("#description").focus();
            return false;
        }    
        else if($("#prices").val()=="" || $("#prices").val()<=0)
        {
            /*$("#error_msg").html("<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>Price should be greater than 0</div>");*/
            $("#error_msg").css("display","block");
            $("#error_msg").html("Price should be greater than 0.");
            $("#prices").focus();
            return false;
        }    

        return true;
    }
</script>
<!-- app/View/Users/register.ctp -->
<div class="contant_right FR">
<div class="no-margin-bottom detail_heading ">
    <h2 class="FL page_title">Edit Product</h2>
    <div class="clear"></div>
</div>
<div class="lessionform lession_container">    
    <?php if($msg!=""){?>
        <div id="error_msg" class="alert alert-error" > <?php echo $msg;?></div><br>   
        <?php }else{?>
        <div id="error_msg" class="alert alert-error" style="display:none;"></div><br>
        <?}      
    ?>
    <span id="error_msg"><?=$this->Session->flash();?></span>
    <?php echo $this->Form->create('Product',array('id'=>'Product','url' => SITE_URL.'products/Edit-Product/'.$id,'enctype' => 'multipart/form-data','class' => 'form-horizontal')); ?>
    <fieldset>      
    <?php echo $this->Form->input('id',array('label'=>false,'type'=>'hidden','id'=>'id'));?>   
        <label><span>*</span>Type of Resources:</label> <div class="form_element ddmultiple">          
            <?php echo $this->Form->input('Category',array('label'=>false,'id'=>'category_id',"div"=>false,"size"=>"10"));?>
        </div><div class="clear"></div>

        <label><span>*</span>Subjects:</label> <div class="form_element ddmultiple">
            <?php echo $this->Form->input('subjects',array('label'=>false,'id'=>'subjects','options'=>array("K-12 Subjects"=>$k12_options,"University Discipline"=>$univ_options,"Adult Education"=>$adult_options),"div"=>false,"multiple"=>true,"size"=>"10","selected"=>$subjectArr));?>             
        </div><div class="clear"></div>

        <label><span>*</span>Name:</label> <div class="form_element">
            <?php echo $this->Form->input('name',array('label'=>false,'id'=>'name',"div"=>false,'size'=>40,"class"=>"input-square"));?>
        </div><div class="clear"></div>

        <label><span>*</span>Short Description:</label> <div class="form_element ddmultiple123">
            <?php echo $this->Form->input('short_description',array('label'=>false,'type'=>'textarea','id'=>'short_description','rows'=>5,"class"=>"textarea11","data-max"=>"255","div"=>false));?>
        </div><div class="clear"></div>

        <label><span>*</span>Description:</label> <div class="form_element ddmultiple123">
            <?php echo $this->Form->input('description',array('label'=>false,'type'=>'textarea','id'=>'description','rows'=>10,"class"=>"textarea11","div"=>false));?>
        </div><div class="clear"></div>

        <label><span>*</span>Price:</label> <div class="form_element">
            <?php echo $this->Form->input('price',array('label'=>false,'id'=>'prices','type'=>'text',"div"=>false,'size'=>40,"class"=>"input-square"));?>
        </div><div class="clear"></div>

        <label><span></span>Discount Price:</label> <div class="form_element">
            <?php echo $this->Form->input('discount_price',array('label'=>false,'id'=>'discount_price','type'=>'text',"div"=>false,'size'=>40,"class"=>"input-square"));?>
        </div><div class="clear"></div>       


        <label>Active:</label> <div class="form_element dd">
            <?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive'),"div"=>false,"class"=>"select"));?>
        </div><div class="clear"></div>        

        <label><span></span>Product Image:</label> <div class="form_element nobg">
            <?php echo $this->Form->input('image',array('label'=>false,'type'=>'file','id'=>'image',"div"=>false,"class"=>"uniform"));?>        
        </div><div class="clear"></div>
        <label>&nbsp;</label> 
        <div class="form_element nobg" style="height:100px;">
            <?php                               
                if(file_exists(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['image']) && ($this->data['Product']['image']<>""))
                {
                    //echo PRODUCT_IMAGE_UPLOAD.$this->data['Product']['image'];
                    echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['image'], array('width' => '100px','height' => '100px'));
                }
                else
                {
                    echo "<img src='".SITE_URL.'/'.NO_IMAGE."' alt='' />";
                }
            ?>
        </div>
        <div class="clear"></div>

        <label><span></span>Sample Image1:</label> <div class="form_element nobg">            
            <?php echo $this->Form->input('sample_img1',array('label'=>false,'type'=>'file','id'=>'sample_img1',"div"=>false,"class"=>"uniform"));?> 

        </div><div class="clear"></div>

        <label>&nbsp;</label> 
        <div class="form_element nobg" style="height:100px;">
            <?php                               
                if(file_exists(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['sample_img1']) && ($this->data['Product']['sample_img1']<>""))
                {
                    //echo PRODUCT_IMAGE_UPLOAD.$this->data['Product']['image'];
                    echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['sample_img1'], array('width' => '81px','height' => '61px'));
                }
                else
                {
                    echo "<img src='".SITE_URL.'/'.NO_IMAGE."' alt='' />";
                }
            ?>
        </div>
        <div class="clear"></div>

        <label><span></span>Sample Image2:</label> <div class="form_element nobg">            
        <?php echo $this->Form->input('sample_img2',array('label'=>false,'type'=>'file','id'=>'sample_img2',"div"=>false,"class"=>"uniform"));?>
        </div><div class="clear"></div>
        
        <label>&nbsp;</label> 
        <div class="form_element nobg" style="height:100px;">
            <?php                               
                if(file_exists(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['sample_img2']) && ($this->data['Product']['sample_img2']<>""))
                {
                    //echo PRODUCT_IMAGE_UPLOAD.$this->data['Product']['image'];
                    echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['sample_img2'], array('width' => '81px','height' => '61px'));
                }
                else
                {
                    echo "<img src='".SITE_URL.'/'.NO_IMAGE."' alt='' />";
                }
            ?>
        </div>
        <div class="clear"></div>      

        <label><span></span>Sample Image3:</label> <div class="form_element nobg">            
            <?php echo $this->Form->input('sample_img3',array('label'=>false,'type'=>'file','id'=>'sample_img3',"div"=>false,"class"=>"uniform"));?>    

        </div><div class="clear"></div> 
        
        <label>&nbsp;</label> 
        <div class="form_element nobg" style="height:100px;">
             <?php                               
                                    if(file_exists(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['sample_img3']) && ($this->data['Product']['sample_img3']<>""))
                                    {
                                        //echo PRODUCT_IMAGE_UPLOAD.$this->data['Product']['image'];
                                        echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['sample_img3'], array('width' => '81px','height' => '61px'));
                                    }
                                    else
                                    {
                                        echo "<img src='".SITE_URL.'/'.NO_IMAGE."' alt='' />";
                                    }
                                ?>
        </div>
        <div class="clear"></div>      
        

        <label><span></span>Sample Image4:</label> <div class="form_element nobg">            
            <?php echo $this->Form->input('sample_img4',array('label'=>false,'type'=>'file','id'=>'sample_img4',"div"=>false,"class"=>"uniform"));?>     

        </div><div class="clear"></div> 
        
        <label>&nbsp;</label> 
        <div class="form_element nobg" style="height:100px;">
           <?php                               
                                    if(file_exists(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['sample_img4']) && ($this->data['Product']['sample_img4']<>""))
                                    {
                                        //echo PRODUCT_IMAGE_UPLOAD.$this->data['Product']['image'];
                                        echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$this->data['Product']['sample_img4'], array('width' => '81px','height' => '61px'));
                                    }
                                    else
                                    {
                                        echo "<img src='".SITE_URL.'/'.NO_IMAGE."' alt='' />";
                                    }
                                ?>
        </div>
        <div class="clear"></div>      

        <label><span></span>Product Preview:</label> <div class="form_element nobg">            
            <?php echo $this->Form->input('preview',array('label'=>false,'type'=>'file','id'=>'preview',"div"=>false,"class"=>"uniform"));?>

        </div><div class="clear"></div>
        
        <label>&nbsp;</label> 
        <div class="form_element nobg" style="height:100px;">
            <?php 
                                    if(file_exists(WWW_ROOT.PRODUCT_PREVIEW_UPLOAD.$this->data['Product']['preview']) && ($this->data['Product']['preview']<>""))
                                    {
                                        echo $this->Html->link($this->data['Product']['preview'],SITE_URL.PRODUCT_PREVIEW_UPLOAD.$this->data['Product']['preview'],array('target'=>"_blank",'escape' => false,"class"=>"btn btn-mini tip","title"=>"Product Preview"));
                                    }
                                ?>
        </div>
        <div class="clear"></div>      

        <label><span></span>Product File:</label> <div class="form_element nobg">            
            <?php echo $this->Form->input('prod_file',array('label'=>false,'type'=>'file','id'=>'file',"div"=>false,"class"=>"uniform"));?>

        </div><div class="clear"></div>
        
        <label>&nbsp;</label> 
        <div class="form_element nobg" style="height:100px;">
             <?php
                                    if(file_exists(WWW_ROOT.PRODUCT_FILE_UPLOAD.$this->data['Product']['prod_file']) && ($this->data['Product']['prod_file']<>""))
                                    {  
                                        echo $this->Html->link($this->data['Product']['prod_file'],SITE_URL.PRODUCT_FILE_UPLOAD.$this->data['Product']['prod_file'],array('target'=>"_blank",'escape' => false,"class"=>"btn btn-mini tip","title"=>"Product File"));
                                    }
                                ?>
        </div>
        <div class="clear"></div>      

        <label>&nbsp;</label><div class="form_element nobg">
            <?php echo $this->Form->end(array('type'=>'submit','class'=> 'button contact_submit','value'=>'Submit','id'=>'submit','name'=>'submit','onclick'=>'return formValidate();','div'=>false ));?>                            
        </div><div class="clear"></div>
    </fieldset>
</div>
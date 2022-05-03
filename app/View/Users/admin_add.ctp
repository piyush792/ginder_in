<?php echo $this->element("header_admin"); ?>
<script type="text/javascript">
function formValidate()
{
    if($("#name").val()=="")
    {
        $("#error_msg").html("Please enter product name");
        return false;
    }    
    else if($("#description").val()=="")
    {
        $("#error_msg").html("Please enter product description");
        return false;
    }    
    
    return true;
}
</script>
<table width="100%" height="100%" cellspacing="0" cellpadding="5" border="0">
    <tbody>
        <tr>
            <td valign="top" align="left" class="font15heading">

            </td>
        </tr>
        <tr><td valign="top" align="center" class="font15heading">Add New Product</td></tr>
        <tr><td valign="top" align="center" class="font15heading"><font face="arial" color="red" style="azimuth: center;font-weight:bold"><span id="error_msg"><?php echo $this->Session->flash();?></span></font></td></tr>
        <tr>
            <td align="left" valign="top" class="XPSilverText">
                <?php echo $this->Form->create('Product',array('id'=>'Product','url' => '/admin/products/add','enctype' => 'multipart/form-data','style' => 'text-align:center')); ?>
                <table cellspacing="1" cellpadding="6" border="0" align="left" width="100%" class="formtext">
                    <tbody>
                        <tr><td align="center"></td></tr>
                        <tr>
                            <td align="center">Name:</td>
                            <td><?php echo $this->Form->input('name',array('label'=>false,'id'=>'name','size'=>40));?></td>
                        </tr>
                        <tr>
                            <td align="center">Description:</td>
                            <td><?php echo $this->Form->input('description',array('label'=>false,'type'=>'textarea','id'=>'description','rows'=>10,'cols'=>'50'));?></td>
                        </tr>
                        <tr>
                            <td align="center">Price:</td>
                            <td><?php echo $this->Form->input('price',array('label'=>false,'id'=>'price'));?></td>
                        </tr>
                        <tr>
                            <td align="center">Status:</td>
                            <td><?php echo $this->Form->input('active',array('label'=>false,'id'=>'active','options'=>array('1'=>'Active','0'=>'Inactive')));?></td>
                        </tr>
                        <tr>
                            <td align="center">Image:</td>
                            <td><?php 
                                    echo $this->Form->input('image',array('label'=>false,'type'=>'file','id'=>'image'));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="left">
                                
                            </td>
                        </tr>
                    </tbody>
                </table>        
                <?php echo $this->Form->end(array('label'=>'','type'=>'image','src'=> SITE_URL.'/img/admin/b.save.gif','onclick'=>'return formValidate();'));?>
            </td>
        </tr>
        </tbody>
</table>                        
<?php echo $this->element("footer_admin"); ?>

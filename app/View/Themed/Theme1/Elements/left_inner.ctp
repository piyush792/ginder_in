<?php echo $this->Form->create('Product', array('url' =>'view/'.$this->request->params['pass'][0])); ?>
<div class="sitebar">
    <h4><?php echo $listCatname['Category']['name']; ?></h4>
    <?php
    if(count($listSubCat)>0){
    ?>
      <h2>SubCategorys</h2>
      <?php
        foreach($listSubCat as $value)
        {
           $checked = ($this->Session->read('arrFilter.Product.subcat_'.$value['Category']['id'])!=0) ? true : false;
           echo $this->Form->input('subcat_'.$value['Category']['id'],array('type'=>'checkbox','value'=>$value['Category']['id'],'label'=>false,'div' =>false,'checked'=>$checked))
      ?>   <label><?php echo $value['Category']['name'];?></label><br>
    <?php
        }
    }
    ?>
      
<?php
  foreach($leftArr as $values)
  {
 ?>   <h2><?php echo $values['name']?></h2>
      <?php
        foreach($values[$values['name']] as $newVal)
        {
           $checked = ($this->Session->read('arrFilter.Product.'.$values['name'].'_'.$newVal['id'])!=0) ? true : false;
           echo $this->Form->input($values['name'].'_'.$newVal['id'],array("type" => "checkbox",'value'=>$newVal['id'],'label' =>false,'div' =>false,'checked' =>$checked))
        ?>
           <label><?php echo ucfirst($newVal['name']);?></label><br>
       <?php 
        }
  }
?>
<h2>Price</h2>
<div class="noUiSlider" id="noUiSlider"></div><br><br>
<?php echo $this->Form->input('price_search',array('type'=>'hidden','label'=>false,'id'=>'price_search',"div"=>false,'size'=>40)); ?>
      
</div>

<?php
 echo $this->Form->end();
?>
<script>
    jQuery(document).ready(function(){
        jQuery(".sitebar input[type='checkbox']").click(function(){  
            var frmData = jQuery('#ProductSearchForm').serialize();
            jQuery.triggerProductsSearchForm(frmData);
        });
    });   
</script>
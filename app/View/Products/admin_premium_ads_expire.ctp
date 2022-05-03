<?php 
echo $this->element("admin_header");

$direction = $this->Paginator->sortDir();
$image =($direction=='asc')?'sort_asc.png':'sort_desc.png';
$key =$this->Paginator->sortKey();
$email_link  = ($key=='User.email')?$this->Html->image(SITE_URL."img/".$image):''; 
$firstname_link  = ($key=='OrderTransactions.firstname')?$this->Html->image(SITE_URL."img/".$image):''; 
$lastname_link  = ($key=='User.lastname')?$this->Html->image(SITE_URL."img/".$image):'';     
$active_link  = ($key=='User.active')?$this->Html->image(SITE_URL."img/".$image):''; 
?>

<script>
    $(document).ready(function () {
      /* filter control start */
      $('#ctrl-filter').click(function () {
        $('#sidebar-filter').show();
        $('body').attr('style', 'overflow: hidden');
      });

      $('#sidebar-close, .filter-overlay').click(function () {
        $('#sidebar-filter').hide();
        $('body').removeAttr('style');
      });
    });
</script>
<div class="clearfix"></div>
<div class="admin-middle-content">
    <div class='admin-side-menu' id="admin-sidemenu-ctrl"> <span class="glyphicon glyphicon-menu-hamburger"></span>
        <span class="txt-admin-side-menu">Side Menu</span> </div>
        <?php echo $this->element("admin_left"); ?>
    <!-- Right Content start -->
    <div class="superadmin-adverts-wrapper">
        <!-- recent ads section start -->
      <section class="superadmin-recent-ads-wrapper">
        <header class="clearfix">
          <h2 class="section-heading">Premium Ads Expired <span class="badge badge-primary"><?php echo count($productList); ?></span></h2>
          <!-- <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div> -->
        </header>        

        <section class="table-grid-wrapper">
        <?php echo $this->Session->flash();?>
        
        

        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-content box-nomargin" style="padding-top:20px;">
                        <?php
                        if(count($productList)>0){
                            ?>
                            <?php echo $this->Form->create('Product',array('id'=>'Product','class'=>'form-horizontal')); ?>
                            <table class='table table-striped table-bordered'>                     
                                <tr bgcolor="#f2f2f2">
                                    <td><strong>ID</strong></td>
                                    <td><strong>Category Name</strong></td>
                                    <td><strong>Product Name</strong></td>
                                    <!-- <td><strong>Contact Email</strong></td> -->
                                    <td><strong>Active</strong></td>
                                    <td><strong>Created</strong></td>
                                    <td><strong>Modified</strong></td>
                                    <td><strong>Expiry</strong></td>
                                </tr>
                                <tbody>
                                    <?php
                                    $id_holder = array();

                                    for($i=0;$i<count($productList);$i++)
                                    {
                                        echo "<input type='hidden' name='product_id[]' value= '".$productList[$i]['Product']['id']."' />";
                                        echo "<tr>";
                                        echo "<td>".$productList[$i]['Product']['id']."</td>";
                                        echo "<td>".$productList[$i]['Category']['cat_name']."</td>";
                                        echo "<td>".$productList[$i]['Product']['name']."</td>";
                                        // echo "<td>".$productList[$i]['User']['email']."</td>";
                                        echo "<td>".($productList[$i]['Product']['active']==1?'Active':'Inactive')."</td>";
                                        echo "<td>".date('m-d-Y', strtotime($productList[$i]['Product']['created']))."</td>";
                                        echo "<td>".date('m-d-Y', strtotime($productList[$i]['Product']['modified']))."</td>";
                                        echo "<td>".date('m-d-Y', strtotime($productList[$i]['0']['expiry_date']))."</td>";
                                        echo "</tr>";                                     
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="form-actions">
                                        <?php echo $this->Form->input("Disabled Featured Ads",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary',"div"=>false,'title'=>'Search', 'style'=>'float:left;'));?>&nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>
                            
                            <?php echo $this->Form->end();?>
                            <?php
                            }else{
                                echo "<div class='alert alert-danger'>No Any Premium Ads Found</div>";
                            }
                            ?>
                    </div>
                </div>
            </div>

            
        </div>
        

        </section>
      </section>
      <!-- recent ads sectioin end -->
    </div>  
</div>
    <!-- recent ads sectioin end -->
<!-- Right Content end -->
</div>
<script>
$(document).ready(function(){
    $("#citySearch").select2();
});
</script>
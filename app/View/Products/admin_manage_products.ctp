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
          <h2 class="section-heading">Manage Products <span class="badge badge-primary" id="productsRemained">
          <?php
          //echo count($productList); 
          echo $totalProducts; 
          ?>
          </span></h2>
          <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div>
        </header>        

        <section class="table-grid-wrapper">
        <?php echo $this->Session->flash();?>
        
        
        <div id="productDeleted"></div>

        <button class="btn-primary" href="javascript:void(0)" onclick="delete_all()">Delete</button>

        <div class="row-fluid">
            <div class="span12">
                <div class="box">

                <div id="sidebar-filter" class="ad-filter-wrapper">
                    <div class='superadmin-filter-wrapper'>
                        <div class="heading-wrapper">
                            <header class="filter-heading">
                            <h2 class="section-heading">Filter</h2>
                            </header>
                            <div id="sidebar-close" class="superadmin-filter-close">
                            <button type="button" class="close"> <span aria-hidden="true">×</span> </button>
                            </div>
                        </div>

                        <div class="box-content">
                            <?php 
                            echo $this->Form->create("Product",array('type'=>'get', 'action'=>$action, 'class' => 'form'));?>
                            <fieldset>
                                <div class="row-fluid force-margin">                                        

                                    <div class="form-group row">
                                        <label for="selectCategory" class="col-form-label">Start Date (click on box) </label>
                                        <div class="col-sm-12 ctrl-field">
                                        <?php echo $this->Form->input("start_date",array("id"=>"start_date","class"=>"datepick","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="selectCategory" class="col-form-label">End Date (click on box) </label>
                                        <div class="col-sm-12 ctrl-field">
                                        <?php echo $this->Form->input("end_date",array("id"=>"end_date","class"=>"datepick","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?>                                    
                                        </div>
                                    </div>
                                
                                    <div class="form-group row">
                                        <label for="selectCategory" class="col-form-label">Status </label>
                                        <div class="col-sm-12 ctrl-field">
                                            <?php 
                                                $status = isset($this->params['named']['active']) ? $this->params['named']['active'] : null; 
                                                echo $this->Form->input('active',array('label'=>false,'options'=>array(''=>'-Select Status-','1'=>'Active','0'=>'Inactive'),"class"=>"form-control",'selected'=>$status));
                                            ?>
                                        </div>
                                    </div>

                                    <!--<div class="form-group row">
                                    <label for="selectCategory" class="col-form-label">Product Type </label>
                                    <div class="col-sm-12 ctrl-field">
                                            <?php 
                                                //$status = isset($this->params['named']['fatured_product']) ? $this->params['named']['featured_product'] : null; 
                                                //echo $this->Form->input('featured_product',array('label'=>false,'options'=>array(''=>'-Select Type-','0'=>'Unpaid','1'=>'Paid'),"class"=>"form-control",'selected'=>$status));
                                            ?>
                                        </div>
                                    </div>-->

                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="form-actions">
                                                <?php echo $this->Form->input("Search",array('type'=>'submit','label'=>false,'class'=>'btn btn-primary',"div"=>false,'title'=>'Search', 'style'=>'float:left;'));?>&nbsp;&nbsp;
                                                <button class="btn btn-primary"><a href='<?php echo $reset_button; ?>' style='text-decoration: none;'><span style='color: #fff;'>Reset</span></a></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>        
                            </fieldset>
                            <?php echo $this->Form->end();?>
                        </div>
                    </div>
                    <div class="filter-overlay"></div>
                    </div>

                    <form method="post" id="frm">
                    <div class="box-content box-nomargin" style="padding-top:20px;">
                        <?php
                        if(count($productList)>0){
                            ?>
                            <table class='table table-striped table-bordered'>                     
                                <tr bgcolor="#f2f2f2">
                                    <!-- <td><strong><?php //echo $this->Paginator->sort('User.email', 'Email'.$id_link,array('escape' => false));?></strong></td> -->
                                    <!-- <td><strong><?php //echo $this->Paginator->sort('Product.name', 'Product Name'.$email_link,array('escape' => false)); ?></strong></td>                                    -->
                                    <td><input type="checkbox" id="delete" onclick="select_all()"></td>
                                    <td style="width:120px"><strong>ID</strong></td>
                                    <td style="width:150px"><strong>Name</strong></td>
                                    <td><strong>Price</strong></td>
                                    <!--<td><strong>Category</strong></td>                                   
                                    <td><strong>Product Contact</strong></td>-->
                                    <!-- <td><strong>Product Image</strong></td> -->
                                    <td><strong>Status</strong></td>
                                    <!-- <td><strong><?php //echo $this->Paginator->sort('OrderTransactions.payment_status', 'Payment Status'.$lastname_link,array('escape' => false));?></strong></td> -->
                                    <td><strong>Created</strong></td>
                                </tr>
                                <tbody>
                                    <?php
                                    for($i=0;$i<count($productList);$i++)
                                    {
                                        echo "<tr id='box".$productList[$i]['Product']['id']."'>";
                                        echo '<td><input type="checkbox" name="checkbox[]" value="'.$productList[$i]['Product']['id'].'" id="'.$productList[$i]['Product']['id'].'"></td>';
                                        echo "<td>". $productList[$i]['Product']['id']."</td>";
                                        echo "<td>".$productList[$i]['Product']['name']."</td>";
                                        echo "<td>".$productList[$i]['Product']['price']."</td>";
                                        //echo "<td>".$productList[$i]['Category']['cat_name']."</td>";
                                        //echo "<td>".$productList[$i]['ProductContact']['contact_name']."</td>";
                                        // echo "<td>".$productList[$i]['ProductImages']['product_image']."</td>";
                                        echo "<td>".($productList[$i]['Product']['active']==1 ? 'Active': 'Inactive')."</td>";
                                        echo "<td>".$productList[$i]['Product']['created']."</td>";
                                        echo "</tr>"; 
                                    }
                                    ?>
                                </tbody>
                            </table> 
                            <?php
                            }else{
                                echo "<div class='alert alert-danger'>No Record Found</div>";
                            }
                            ?>
                        </div>
                    </form>

                </div>
            </div>
            <div class="pagination-wrapper">
                <ul class="pagination">
                    <?php 
                        echo $this->Paginator->first("First" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'first disabled','escape'=>false,'tag'=>'li'));
                        echo $this->Paginator->prev("&larr; Previous" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'prev disabled','escape'=>false,'tag'=>'li'));
                        echo '&nbsp;'.$this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active')); 
                        echo $this->Paginator->next("Next &rarr;", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                        echo $this->Paginator->last("Last", array('escape'=>false,'tag'=>'li'), null, array('class' => 'last disabled','escape'=>false,'tag'=>'li'));
                    ?>
                </ul>
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

function select_all(){
    if($('#delete').prop("checked")){
        $('input[type=checkbox]').each(function(){
            $('#'+this.id).prop('checked', true)
            // console.log(this.id);
        });
    } else {
        $('input[type=checkbox]').each(function(){
            $('#'+this.id).prop('checked', false)
            // console.log(this.id);
        });
    }    
}

function delete_all(){
    // alert(val);
    // var dataSet = val;

    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array('controller' => 'products', 'action' => 'ajaxDeleteProduct')); ?>',        
        data: $('#frm').serialize(),
        success: function (result) {
            $('input[type=checkbox]').each(function(){
                if($('#'+this.id).prop("checked")){
                    $('#box'+this.id).remove();
                }
            });
            $('#productDeleted').html("<div class='alert alert-danger'>Product Deleted Successfully</div>");
            $('#productsRemained').html(result);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}
</script>
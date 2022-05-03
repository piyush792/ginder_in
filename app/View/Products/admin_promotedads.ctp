<?php
echo $this->Html->css(array('../plugins/bootstrap-table/bootstrap-table.min', '../plugins/bootstrap-table/bootstrap-table'));
echo $this->Html->script(array('../plugins/bootstrap-table/bootstrap-table.min', '../plugins/bootstrap-table/bootstrap-table', '../plugins/bootstrap-table/extensions/export/bootstrap-table-export', '../plugins/bootstrap-table/extensions/export/bootstrap-table-export.min', 'table-export'));

echo $this->element("admin_header");

if (count($productList) > 0)
{
    foreach ($productList as $data)
    {
        $results_grid[] = array(
            'product_name' => $data['Product']['name'],
            'product_price' => $data['Product']['price'],
            'product_active' => $data['Product']['active'],
            'product_created' => date('d-m-Y', strtotime($data['Product']['created'])),
            'parent_catname' => $data['ParentCategory']['parent_catname'],
            'sub_catname' => $data['Category']['cat_name'],
            'state_name' => $data['State']['name'],
            'city_name' => $data['City']['name'],
        );
    }
} else {
    $results_grid[] = array("No Data Available");
}
// pr($results_grid); exit;
?>

<div class="clearfix"></div>
<div class="admin-middle-content">
    <div class='admin-side-menu' id="admin-sidemenu-ctrl"> <span class="glyphicon glyphicon-menu-hamburger"></span>
        <span class="txt-admin-side-menu">Side Menu</span> </div>

        <?php echo $this->element("admin_left"); ?>

    <!-- Right Content start -->
    <div class="superadmin-adverts-wrapper">
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-arrow-left"></span>Back to Reports', array('controller' => 'reports','action' => 'index'), array('escape' => false, 'class'=>'anchor-black header-anchor',"title"=>"Back to Attributes")); ?>
        <!-- recent ads section start -->
      <section class="superadmin-recent-ads-wrapper">
        <header class="clearfix">
          <h2 class="section-heading">Promoted Ads (<?php echo count($productList); ?>)</h2>
          <!-- <div id="ctrl-filter" class="btn-controls float-right"><span class="glyphicon glyphicon-filter"></span></div> -->
        </header>

        <section class="table-grid-wrapper">
        <?php echo $this->Session->flash();?>
        
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-content box-nomargin">
                        <table id="demo-table1" class="display nowrap" data-toolbar="#demo-custom-toolbar" data-sort-name="id" data-sort-order="desc" data-pagination="true" data-show-export="true"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-height="400" data-page-list="[10, 25, 50, 100, All]">         
                            <thead>
                                <tr>
                                    <th data-field="product_name"  data-sortable="true" >Ad Title</th>
                                    <th data-field="" data-sortable="true">Transaction No</th>
                                    <th data-field="parent_catname" data-sortable="true" data-visible="true">Category</th>
                                    <th data-field="sub_catname" data-sortable="true" data-visible="true">Subcategory</th>
                                    <th data-field="product_created" data-sortable="true">Publish On</th>
                                    <th data-field="state_name" data-sortable="true">State</th>
                                    <th data-field="city_name" data-sortable="true">City</th>
                                </tr>
                            </thead>
                        </table>                        
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
 $(document).ready(function () {
    theTable = $('#demo-table1').bootstrapTable({
                bProcessing: true,
                bServerSide: true,
                pagination: true,
                showRefresh: true,
                showToggle: true,
                showColumns: true,
                search: true,
                pageSize: 100,
                striped: true,
                showFilter: true,
                data:<?php echo json_encode($results_grid); ?>
            });
});
</script>

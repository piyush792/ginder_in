<?php
echo $this->Html->css(array('../plugins/bootstrap-table/bootstrap-table.min', '../plugins/bootstrap-table/bootstrap-table'));
echo $this->Html->script(array('../plugins/bootstrap-table/bootstrap-table.min', '../plugins/bootstrap-table/bootstrap-table', '../plugins/bootstrap-table/extensions/export/bootstrap-table-export', '../plugins/bootstrap-table/extensions/export/bootstrap-table-export.min', 'table-export'));

echo $this->element("admin_header");

if (count($spamReportList) > 0)
{
    // echo "<pre>";
    // print_r($spamReportList);
    // exit;

    foreach ($spamReportList as $data)
    {
        $results_grid[] = array(
            'product_id' => $data['Product']['ProductID'],
            'product_name' => $data['Product']['ProductName'],
            'owner_name' => $data['ProductContact']['OwnerName'],
            'contact_name' => $data['SpamReport']['ContactName'],
            'contact_email' => $data['SpamReport']['ContactEmail'],
            'description' => $data['SpamReport']['Description'],
            'created' => $data['SpamReport']['Created']
        );
    }
} else {
    $results_grid[] = array("No Data Available");
}
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
          <h2 class="section-heading">Spam Reports (<?php echo count($spamReportList); ?>)</h2>
        </header>
        <section class="table-grid-wrapper">        
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-content box-nomargin">
                        <table id="demo-table1" class="display nowrap" data-toolbar="#demo-custom-toolbar" data-sort-name="id" data-sort-order="desc" data-pagination="true" data-show-export="true"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-height="400" data-page-list="[10, 25, 50, 100, All]">         
                            <thead>
                                <tr>
                                    <th data-field="contact_name"  data-sortable="true" >Contact Name</th>
                                    <th data-field="contact_email" data-sortable="true" data-visible="true">Contact Email</th>
                                    <th data-field="description" data-sortable="true" data-visible="true">Description</th>
                                    <th data-field="product_name" data-sortable="true">Product Name</th>
                                    <th data-field="owner_name" data-sortable="true">Published By</th>
                                    <th data-field="created" data-sortable="true">Date</th>
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

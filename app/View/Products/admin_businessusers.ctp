<?php
echo $this->Html->css(array('../plugins/bootstrap-table/bootstrap-table.min', '../plugins/bootstrap-table/bootstrap-table'));
echo $this->Html->script(array('../plugins/bootstrap-table/bootstrap-table.min', '../plugins/bootstrap-table/bootstrap-table', '../plugins/bootstrap-table/extensions/export/bootstrap-table-export', '../plugins/bootstrap-table/extensions/export/bootstrap-table-export.min', 'table-export'));

echo $this->element("admin_header");

// echo "<pre>";
// print_r($businessUsersList); exit;
if (count($businessUsersList) > 0)
{
    foreach ($businessUsersList as $data)
    {
        $results_grid[] = array(
            'user_name' => $data['users']['email'],
            'mobile' => $data['users']['mobile'],
            'product_created' => date('d-m-Y', strtotime($data['users']['created'])),
            'state_name' => $data['states']['state'],
            'city_name' => $data['cities']['city'],
            'posted_ads' => $data['0']['posted_ads'],
            'promoted_ads' => $data['0']['promoted_ads'],
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
          <h2 class="section-heading">Business Users (<?php echo count($businessUsersList); ?>)</h2>
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
                                    <th data-field="user_name"  data-sortable="true" >Username</th>
                                    <th data-field="posted_ads" data-sortable="true" data-visible="true">Posted Ads</th>
                                    <th data-field="promoted_ads" data-sortable="true" data-visible="true">Promoted Ads</th>
                                    <th data-field="product_created" data-sortable="true">Member Since</th>
                                    <th data-field="mobile" data-sortable="true">Mobile No.</th>
                                    <th data-field="city_name" data-sortable="true">Location</th>
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

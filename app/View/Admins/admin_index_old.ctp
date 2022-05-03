<?php 
echo $this->element("admin_header"); 
echo $this->element("admin_dashboard"); 
echo $this->element("admin_left");
?>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head tabs">
                        <h3><?php echo $msg;?></h3>
                    </div>
                    <!--<div class="box-content box-nomargin">
                     <table class='table table-striped table-bordered'>
                            <thead>
                                <tr style="height: 210px;">
                                    <td align="left" width="15%"><strong></strong></td>
                                </tr>
                            </thead>
                     </table>       
                     
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
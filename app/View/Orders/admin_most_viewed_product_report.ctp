<?php echo $this->element("admin_header"); 
    echo $this->element("admin_dashboard"); 
    echo $this->element("admin_left");    
?>
<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Most Viewed Products</h3>
                    </div>
                    <div class="box-content box-nomargin">
                        <?php echo $this->Session->flash();?>                                        

                        <table class='table table-striped table-bordered'>
                            <thead>

                                <tr bgcolor="#f2f2f2">
                                    <td><strong> ProductId</strong></td>                           
                                    <td><strong>Product Name</strong></td>
                                    <!--<td><strong>Customer Name</strong></td> -->                                   
                                    <td><strong>Price</strong></td>
                                    <td><strong>Total Viewed</strong></td>
                            </tr></thead>
                            <tbody>
                                <?php

                                    for($i=0;$i<count($qtyorderList);$i++)
                                    {

                                        echo "<tr>";
                                        echo "<td>".$qtyorderList[$i]['Product']['id']."</td>";
                                        echo "<td>".$qtyorderList[$i]['Product']['name']."</td>";                        
                                        echo "<td>$".$qtyorderList[$i]['Product']['price']."</td>"; 
                                        echo "<td>".$qtyorderList[$i]['Product']['viewed']."</td>";
                                        echo "</tr>"; 
                                    }
                                ?>

                            </tbody>
                        </table>        

                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-head">   
                <p>&nbsp;</p>
                </div>
            </div>
        </div>
    </div>    
</div>
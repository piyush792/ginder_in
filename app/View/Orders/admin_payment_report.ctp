<?php 
    echo $this->element("admin_header"); 
    echo $this->element("admin_dashboard"); 
    echo $this->element("admin_left"); 
    echo $this->Html->script("admin/jquery-1.8.0.min"); 
    echo $this->Html->script("admin/jquery-ui-1.8.23.custom.min");     
    //echo $this->Html->script("chart"); 
    echo $this->Html->css("ui-lightness/jquery-ui-1.8.23.custom"); 
    //echo $this->Html->css("chart"); 
?>

<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Quarterly Payment Report</h3>
                    </div>
                    <div class="box-content box-nomargin">

                        <?php echo $this->Session->flash(); ?>
                        <?php
                            echo $this->Form->create("Order",array("type"=>"post","url"=>SITE_URL."admin/orders/payment_report"));
                        ?>
                        <table width="100%" align="left" border="0">

                            <tr>
                                <td colspan="5">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="10%" align="right">Select Year: </td>
                                <td align=left width="25%">
                                    <?php
                                        echo $this->Form->input("year",array("id"=>"year","options"=>$optionsYear,"label"=>false,"div"=>false,"default"=>$year));?>  
                                </td>
                                <td width="10%" align="right">Qtr:</td>
                                <td width="25%"><?php
                                        $optionsQtr = array(""=>'--Qtr--');
                                        $optionsQtr['1']='Jan - Mar';
                                        $optionsQtr['2']='Apr - Jun';
                                        $optionsQtr['3']='Jul - Sep';
                                        $optionsQtr['4']='Oct - Dec';
                                        echo $this->Form->input("qtr",array("id"=>"qtr","options"=>$optionsQtr,"label"=>false,"div"=>false,"default"=>$qtr));?>
                                </td>
                                <td align="left"><?php echo $this->Form->input("submit",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false));?>&nbsp;</td>
                            </tr>
                        </table>
                        <?php
                            echo $this->Form->end();

                        ?>

                        <table class='table table-striped table-bordered'>
                            <?php echo $this->Form->create('Orders', array('action' => 'payment_report')); ?>
                            <?php
                                //echo $this->Form->create("PaymentReport",array("type"=>"post","url"=>SITE_URL."admin/orders/payment_report"));
                                ?>                                                       
                            <td><strong>Seller Id</strong></td>                           
                            <td><strong>Seller Name</strong></td>                           
                            <td><strong>Total Order Amount</strong></td>
                            <td><strong>Total Amount Due</strong></td>                                   
                            <td><strong>Total Amount Paid</strong></td>                            
                            <thead>
                            </thead>
                            <tbody>

                                <?php
                                    //print_r($qtyorderList);
                                    $total_amount_paid =0;
                                    $total_amount_due =0;
                                    $total_amount =0;
                                    for($i=0;$i<count($qtyorderList);$i++)
                                    {
                                        if($i==0)
                                        {
                                            $idAr = $qtyorderList[$i]['User']['id'];
                                        }
                                        else
                                        {
                                            $idAr .= ','.$qtyorderList[$i]['User']['id'];
                                        }
                                        $total_amount = $qtyorderList[$i][0]['total'];
                                        $total_amount_due = $qtyorderList[$i]['PaymentReport']['total_amount_due'];
                                        $commission_perc = $qtyorderList[$i]['MembershipPackage']['commission'];
                                        $total_amount_paid = $qtyorderList[$i]['PaymentReport']['total_amount_paid'];

                                        if($commission_perc!='' )
                                        {                                           
                                            $commission = ($total_amount*$commission_perc)/100;
                                        }
                                        else
                                        {
                                            $commission =0;
                                        }
                                        if($total_amount_due==0 && $commission>0)
                                        {
                                            $total_amount_due =$commission;
                                        }
                                        $seller_Id = $qtyorderList[$i]['User']['id'];
                                        $customername = $qtyorderList[$i][0]['seller_name'];

                                        echo "<tr>";
                                        echo "<td><input type='checkbox' value='".$seller_Id."' name='seller[]' id='chk_".$seller_Id."' onclick='hide_getpaid(".$seller_Id.");'>&nbsp;".$seller_Id."<input type='hidden' id='commission_".$seller_Id."' name='commission_".$seller_Id."' value='".$commission."'></td>";                               
                                        echo "<td>".$customername."<input type='hidden' id='name_".$seller_Id."' name='name_".$seller_Id."' value='".$customername."'></td>";                                                              
                                        echo "<td>$".$total_amount."<input type='hidden' id='total_".$seller_Id."' name='total_".$seller_Id."' value='".$total_amount."'></td>";                              
                                        echo "<td>$".$total_amount_due."<input type='hidden' id='due_".$seller_Id."' name='due_".$seller_Id."' value='".$total_amount_due."'></td>";  
                                        if($commission == $total_amount_paid)
                                        {
                                            echo "<td>$".$total_amount_paid."<br><input type='hidden' id='tot_paid_".$seller_Id."' name='tot_paid_".$seller_Id."' value='".$total_amount_paid."'></td>";                                
                                        }  
                                        else
                                        {
                                            echo "<td>$".$total_amount_paid."&nbsp;&nbsp;
                                            <input type='hidden' id='tot_paid_".$seller_Id."' name='tot_paid_".$seller_Id."' value='".$total_amount_paid."'>
                                            <a href='javascript:void(0);' onclick='show_getpaid(".$seller_Id.");'>Pay</a><br><div id='due_payment_".$seller_Id."' style='display:none;'>$<input type='text' id='amount_to_pay_".$seller_Id."' name='amount_to_pay_".$seller_Id."' value='' onblur='validate_payment(".$seller_Id.");'></div></td>";                                  
                                        }                            


                                        echo "</tr>";                            
                                    }
                                ?>
                                <? $rawCount = count($qtyorderList);
                                    if($rawCount>0)
                                    {

                                    ?>
                                    <tr><td colspan="5">
                                            <input type='hidden' id='qtrYear' name='qtrYear' value='<?php echo $qtr."##".$year;?>'>
                                    <?php echo $this->Form->input("submit",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false));?></td></tr>
                                    <? }else{?>
                                    <tr><td colspan="5">
                                            <?php echo "No report generated for this quarter.";?>
                                    </td></tr>

                                    <?php }?>
                            </tbody>
                            <?php echo $this->Form->end(); ?>

                        </table>  


                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">
  $.noConflict();
  // Code that uses other library's $ can follow here.
</script>
<script type="text/javascript">
    function show_getpaid(ids)
    {
        var divid ='#due_payment_'+ids;
        var dueid ='#due_'+ids;
        var amountpay ='#amount_to_pay_'+ids;
        var chkid ='#chk_'+ids;
        $(divid).css("display","block");
        $(amountpay).val($(dueid).val());
        $(chkid).attr('checked', true);
    }
    function hide_getpaid(ids)
    {
        var divid ='#due_payment_'+ids;
        var amountpay ='#amount_to_pay_'+ids;
        var chkid ='#chk_'+ids;
        $(divid).css("display","none");
        $(amountpay).val(0);
        $(chkid).attr('checked', false);
    }
    function validate_payment(ids)
    {
        var divid ='#due_payment_'+ids;
        var dueid ='#due_'+ids;
        var amountpay ='#amount_to_pay_'+ids;
        var payment =100*$(amountpay).val();
        var due =100*$(dueid).val();
        if(payment>due)
        {
            alert("You are entered over payment.");
        }

    }
</script>
        

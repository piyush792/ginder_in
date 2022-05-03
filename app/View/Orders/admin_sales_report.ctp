<?php 
    echo $this->element("admin_header"); 
    echo $this->element("admin_dashboard"); 
    echo $this->element("admin_left"); 
    echo $this->Html->script("admin/jquery-1.8.0.min"); 
    echo $this->Html->script("admin/jquery-ui-1.8.23.custom.min"); 
    echo $this->Html->script("chart"); 
    echo $this->Html->css("ui-lightness/jquery-ui-1.8.23.custom"); 
    echo $this->Html->css("chart"); 
?>
<script type="text/javascript">

    <?php
        $wkdata = "[";
        for($i=0;$i<count($dataArr);$i++)
        {
            $key = CakeTime::format('Y-m-d', $sdate." +$i days");    
            $wkdata.="{ sales:'".$dataArr[$i]['Total']."', date:'".$key."'},";            
        }
        $wkdata = substr($wkdata,0,strlen($wkdata)-1);

        $wkdata.="]";

        echo $wkdata;
    ?>

    data1= <?=$wkdata?>;

    //alert(data2);


    window.onload = function(){
        var barChart1 =  new dhtmlXChart({
            view:"line",
            container:"chart1",
            value:"#sales#",
            color: "#66ccff",
            label:"#sales#",
            width:40,
            gradient:"3d",
            border:true,
            tooltip:{
                template:"#sales#"
            },
            xAxis:{
                title:"Sales (Daily)",
                template:"#date#"
            },
            yAxis:{
                start:0,
                end:<?=$max?>,
                step:<?=$avg?>,
                title:"Sales"
            }
        });
        barChart1.parse(data1,"json");

        <?php
            $wkdata2 = "[";
            for($i=0;$i<count($dataArr2);$i++)
            {
                $key = CakeTime::format('M', $syear." +$i month");    
                $wkdata2.="{ sales:'".$dataArr2[$i]['Total']."', month:'".$key."'},";            
            }
            $wkdata2 = substr($wkdata2,0,strlen($wkdata2)-1);

            $wkdata2.="]";

            //echo "wkdata2: ".$wkdata2;
            ?>

        data2= <?=$wkdata2?>;

        //alert(data2);

        var barChart2 =  new dhtmlXChart({
            view:"line",
            container:"chart2",
            value:"#sales#",
            color: "#66ccff",
            label:"#sales#",
            width:15,
            gradient:"3d",
            border:true,

            xAxis:{
                title:"Sales (Monthly)",
                template:"#month#"
            },
            yAxis:{
                start:0,
                end:<?=$max2?>,
                step:<?=$avg2?>,
                title:"Sales"
            }
        });
        barChart2.parse(data2,"json");
    }

    

</script>

<div class="container-fluid">
    <div class="content">
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-head">
                        <h3>Sales Report</h3>
                    </div>
                    <div class="box-content box-nomargin">

                        <?php echo $this->Session->flash(); ?>
                        <table width="90%" align="center">
                        <tr>
                        <td>
                        <?php
                            echo $this->Form->create("Order",array("type"=>"post","url"=>""));
                        ?>
                        <table width="100%" align="left" border="0">
                            <tr>
                                <td colspan="2"><h4 align="left">Daily/Weekly Report</h4></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="10%">Select Date:</td>
                                <td align=left width="35%">
                                    <?php
                                        echo $this->Form->input("sdate",array("id"=>"sdate","class"=>"datepick","type"=>"text","label"=>false,"readonly"=>false,"width"=>"100px","size"=>10,"div"=>false));?><span class="add-on"><i class="icon-calendar"></i></span>
                                </td>
                                <td align="left"><?php echo $this->Form->input("submit",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false));?>&nbsp;</td>
                            </tr>
                        </table>
                        <?php
                            echo $this->Form->end();
                        ?>
                        <table border="0" width="100%" class="formtext">
                            <tr>
                                <td width="50%"><b>Total Weekly Sales: $<?=number_format($totalweekly,2,'.','')?></b></td>
                                <td align="center" width="50%" style="padding-right:50px;"><? echo $this->Html->link("View Detail",array("controller"=>"orders","action"=>"index",$sdate,$edate));?></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div id="chart1" style="width:650px;height:300px;border:1px solid #A4BED4;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                    
                        <?php
                            // MONTHLY REPORT START
                            ?>          

                        <?php
                            echo $this->Form->create("Order",array("type"=>"post","url"=>SITE_URL."admin/orders/sales_report"));
                        ?>
                        <table width="100%" align="left" border="0">
                            <tr>
                                <td colspan="3"><h4 align="left">Monthly Report</h4></td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="10%">Select Year: </td>
                                <td align=left width="35%">
                                    <?php
                                        echo $this->Form->input("year",array("id"=>"year","options"=>$optionsYear,"label"=>false,"div"=>false,"default"=>$year));?>  
                                </td>
                                <td align="left"><?php echo $this->Form->input("submit",array("type"=>"submit","class"=>"btn btn-primary","label"=>false,"div"=>false));?>&nbsp;</td>
                            </tr>
                        </table>
                        <?php
                            echo $this->Form->end();
                        ?>
                        <table border="0" width="100%" class="formtext">
                            <tr>
                                <td width="50%"><b>Total Yearly Sales: $<?=number_format($totalyearly,2,'.','')?></b></td>
                                <td align="center" width="50%"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div id="chart2" style="width:650px;height:300px;border:1px solid #A4BED4;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>

                        </td>
                        </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
        

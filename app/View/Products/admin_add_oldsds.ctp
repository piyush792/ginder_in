<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<link href="css/bipimain.css" rel="stylesheet" type="text/css" />

<style>
    .jqx-splitter-panel{
        overflow:auto !important;
    }

    .ul-class-style{
        text-indent: 0;
        background-color: transparent;
        border: 0px solid transparent;
        list-style: none;
        padding: 0px;
        margin: 0px;
        float: none;
        overflow: hidden;
        left: 100%;
        color: inherit;
        right: 0;
        text-align: left;
        cursor: pointer;
        text-decoration: none;
        outline: none;
    }
</style>
<?php
include("inc/config.php");
include('inc/auth.php');
$url = $_SERVER["REQUEST_URI"];
$url_arr = parse_url($url);
$url_query = $url_arr['query'];
if (isset($_GET['tPie_Chart']))
    $search_label = "Search Indication";
if (isset($_GET['dPie_Chart']))
    $search_label = "Search Development Phase";
if (isset($_GET['pPie_Chart']))
    $search_label = "Search Platform";
if (isset($_GET['anPie_Chart']))
    $search_label = "Search Antibody Type";
if (isset($_GET['oPie_Chart']))
    $search_label = "Search Origin";
if (isset($_GET['orgPie_Chart']))
    $search_label = "Search Organization";
if (isset($_GET['tarPie_Chart']))
    $search_label = "Search Target";
?>
<div>
    <table width="100%" border="0" align="center" cellpadding="6" cellspacing="6">
        <tr>
            <td><?php include("mem_header_bii.php"); ?></td>
        </tr>
        <tr>
            <td align="left">
                <div id="">

                    <div style="float: left; width: 20%; padding: 12px;">
                        <div style="border: none;" id=''>                            
                            <h2>Biologics Dashboard</h2>
                            <ul>
                                <li id=" " item-expanded='true' style="list-style: none; padding-bottom: 14px;">
                                    <span item-title="true"> <span><a class="ul-class-style" href="bipi_navigation.php?tPie_Chart=tPie_Chart" >THERAPEUTIC AREA</a></span></span>
                                </li>
                                <li id=" "  item-expanded='true' style="list-style: none; padding-bottom: 14px;">
                                    <span item-title="true"> <span><a class="ul-class-style" href="bipi_navigation.php?dPie_Chart=dPie_Chart" >DEVELOPMENT PHASE</a></span></span>
                                </li>
                                <li id=" " item-expanded='true' style="list-style: none; padding-bottom: 14px;">
                                    <span item-title="true"> <span><a class="ul-class-style" href="bipi_navigation.php?pPie_Chart=pPie_Chart" >PLATFORM</a></span></span>
                                </li>
                                <li id=" " item-expanded='true' style="list-style: none; padding-bottom: 14px;">
                                    <span item-title="true"> <span><a class="ul-class-style" href="bipi_navigation.php?anPie_Chart=anPie_Chart" > ANTIBODY TYPE </a></span></span></span>
                                </li>
                                <li id=" " item-expanded='true' style="list-style: none; padding-bottom: 14px;">
                                    <span item-title="true"> <span><a class="ul-class-style" href="bipi_navigation.php?oPie_Chart=oPie_Chart" >ORIGIN</a></span></span>
                                </li>
                                <li id=" " item-expanded='true' style="list-style: none; padding-bottom: 14px;">
                                    <span item-title="true"> <span><a class="ul-class-style" href="bipi_navigation.php?orgPie_Chart=orgPie_Chart" >ORGANIZATION</a></span></span>
                                </li>
                                <li id=" " item-expanded='true' style="list-style: none; padding-bottom: 14px;">
                                    <span item-title="true"> <span><a class="ul-class-style" href="bipi_navigation.php?tarPie_Chart=tarPie_Chart" >TARGET</a></span></span>
                                </li>                                    
                            </ul>
                        </div>
                    </div>

                    <div id="ContentPanel" style="float: right; width: 80%;border-left: 2px solid #B0B0B0;">
                        <div class="container-fluid"><br/>
                            <div class="search_word">                               
                                <input type="text" placeholder="<?php echo $search_label; ?>" name="search_word" id="search_word" class="search_word">
                                <button onclick="searchdata();" class="search_word" >Search <i class="fa fa-search"></i></button>
                            </div>

                            <div class="row">

                                <div class="col-md-12" style="margin-top:20px;">
                                    <div class="row" id="datalist"></div>
                                    <div class="row">
                                        <div class="custom-accordion" >
                                            <!------------------------------------------------------>
                                            <?php
                                            if (isset($_REQUEST['tPie_Chart'])) {

                                                $sql_ta = "SELECT DISTINCT THERAPEUTIC_AREA as therapeutic_area FROM `bipi_data` WHERE PRODUCT_ID NOT IN (2979,2678,3968,3964,3784,3609,2883,3073,772,4571,3070,3071,3911,3513,4836,2770,4835) order by THERAPEUTIC_AREA";
                                                $result_ta = mysql_query($sql_ta);
                                                while ($row_ta = mysql_fetch_array($result_ta)) {
                                                    ?>		
                                            <div class="panel panel-primary custom-accordion">

                                                <div class="panel-heading"><?php echo $row_ta['therapeutic_area']; ?> 
                                                    <sup>
                                                                <?php
                                                                $sql_ind = "SELECT COUNT( PRIMARY_CLINICAL_INDICATION ) AS TOTAL
FROM bipi_data WHERE  `THERAPEUTIC_AREA` =  '" . $row_ta['therapeutic_area'] . "' order by THERAPEUTIC_AREA ";
                                                                $result_ind = mysql_query($sql_ind);
                                                                while ($rowind = mysql_fetch_array($result_ind)) {

                                                                    $total1 = $rowind['TOTAL'];
                                                                    ?>    
                                                        <span class="badge badge-pill badge-primary"><?php echo $total1; ?></span></sup>
                                                            <?php }
                                                            ?> 
                                                </div>							
                                                <div class="panel-body custom-acc-content">
                                                            <?php
                                                            $query = "SELECT `PRIMARY_CLINICAL_INDICATION` AS indication,COUNT(*) AS TOTAL FROM bipi_data WHERE `THERAPEUTIC_AREA`=
   '" . $row_ta['therapeutic_area'] . "' GROUP BY PRIMARY_CLINICAL_INDICATION ORDER BY PRIMARY_CLINICAL_INDICATION,TOTAL DESC";
                                                            $result = mysql_query($query);
                                                            while ($row = mysql_fetch_array($result)) {
                                                                $ind = $row["indication"];
                                                                $total = $row["TOTAL"];
                                                                ?>
                                                    <div class="new-CircleBox">
                                                        <p><a href="ontadetailsdev_new.php?st=fr&THERAPEUTIC_AREA=<?php echo $row_ta['therapeutic_area']; ?>&PRIMARY_CLINICAL_INDICATION=<?php echo $ind; ?>"> <?php echo $ind . " (" . $total . ")"; ?></a></p>
                                                    </div>
                                                            <?php }
                                                            ?>
                                                    <div class="clearfix"></div>							
                                                    <button class="btn btn-primary btn-xs moreBtn">More</button>
                                                    <button class="btn btn-primary btn-xs lessBtn">Less</button>
                                                </div>
                                            </div>
                                                    <?php
                                                }
                                            }
                                            ?>

                                            <!------------------------------------------------------>
                                            <?php
                                            if (isset($_REQUEST['dPie_Chart'])) {

                                                $sql_dev = "SELECT DISTINCT HIGHEST_DEVELOPMENT_PHASE as HIGHEST_DEVELOPMENT_PHASE FROM `bipi_data` 
                                                    WHERE PRODUCT_ID NOT IN (2979,2678,3968,3964,3784,3609,2883,3073,772,4571,3070,3071,3911,3513,4836,2770,4835) order by HIGHEST_DEVELOPMENT_PHASE";
                                                $result_dev = mysql_query($sql_dev);
                                                while ($row_dev = mysql_fetch_array($result_dev)) {
                                                    ?>		
                                            <div class="panel panel-primary custom-accordion">

                                                <div class="panel-heading"><?php echo $row_dev['HIGHEST_DEVELOPMENT_PHASE']; ?> 
                                                    <sup>
                                                                <?php
                                                                $sql_ind = "SELECT COUNT(HIGHEST_DEVELOPMENT_PHASE) AS TOTAL FROM bipi_data WHERE  `HIGHEST_DEVELOPMENT_PHASE` =  '" . $row_dev['HIGHEST_DEVELOPMENT_PHASE'] . "'  ";
                                                                $result_ind = mysql_query($sql_ind);
                                                                while ($rowind = mysql_fetch_array($result_ind)) {

                                                                    $total1 = $rowind['TOTAL'];
                                                                    ?>    
                                                        <span class="badge badge-pill badge-primary"><?php echo $total1; ?></span></sup>
                                                            <?php }
                                                            ?> 
                                                </div>							
                                                <div class="panel-body custom-acc-content">
                                                            <?php
                                                            $query = "SELECT `PRIMARY_CLINICAL_INDICATION` AS indication,COUNT(*) AS TOTAL FROM bipi_data WHERE `HIGHEST_DEVELOPMENT_PHASE`= '" . $row_dev['HIGHEST_DEVELOPMENT_PHASE'] . "' GROUP BY PRIMARY_CLINICAL_INDICATION ORDER BY PRIMARY_CLINICAL_INDICATION,TOTAL DESC";
                                                            $result = mysql_query($query);
                                                            while ($row = mysql_fetch_array($result)) {
                                                                $ind = $row["indication"];
                                                                $total = $row["TOTAL"];
                                                                ?>
                                                    <div class="new-CircleBox">
                                                        <p><a href="ontadetailsdev_new.php?st=fr&HIGHEST_DEVELOPMENT_PHASE=<?php echo $row_dev['HIGHEST_DEVELOPMENT_PHASE']; ?>&PRIMARY_CLINICAL_INDICATION=<?php echo $ind; ?>"> <?php echo $ind . " (" . $total . ")"; ?></a></p>
                                                    </div>
                                                            <?php }
                                                            ?>
                                                    <div class="clearfix"></div>							
                                                    <button class="btn btn-primary btn-xs moreBtn">More</button>
                                                    <button class="btn btn-primary btn-xs lessBtn">Less</button>
                                                </div>
                                            </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <!---------------------------------------------------------------------------------------------> 
                                            <?php
                                            if (isset($_REQUEST['pPie_Chart'])) {
                                                $sql_plateform = "SELECT DISTINCT PLATFORM_CLASS as PLATFORM_CLASS , COUNT(PRODUCT_ID) as tacnt  FROM  bipi_data WHERE  PRODUCT_ID NOT IN (2979,2678,3968,3964,3784,3609,2883,3073,772,4571,3070,3071,3911,3513,4836,2770,4835) AND (PLATFORM_CLASS NOT IN ('', '') AND  PLATFORM_CLASS NOT LIKE '%To be updated%')  GROUP BY PLATFORM_CLASS ORDER BY 2 DESC";
                                                $result_plateform = mysql_query($sql_plateform);
                                                while ($row_plateform = mysql_fetch_array($result_plateform)) {
                                                    ?>		
                                            <div class="panel panel-primary custom-accordion">

                                                <div class="panel-heading"><?php echo $row_plateform['PLATFORM_CLASS']; ?> 
                                                    <sup>
                                                                <?php
                                                                $sql_ind = "SELECT COUNT(PLATFORM_CLASS) AS TOTAL FROM bipi_data WHERE  `PLATFORM_CLASS` =  '" . $row_plateform['PLATFORM_CLASS'] . "'  ";
                                                                $result_ind = mysql_query($sql_ind);
                                                                while ($rowind = mysql_fetch_array($result_ind)) {

                                                                    $total1 = $rowind['TOTAL'];
                                                                    ?>    
                                                        <span class="badge badge-pill badge-primary"><?php echo $total1; ?></span></sup>
                                                            <?php }
                                                            ?> 
                                                </div>							
                                                <div class="panel-body custom-acc-content">
                                                            <?php
                                                            $query = "SELECT `PRIMARY_CLINICAL_INDICATION` AS indication,COUNT(*) AS TOTAL FROM bipi_data WHERE `PLATFORM_CLASS`= '" . $row_plateform['PLATFORM_CLASS'] . "' GROUP BY PRIMARY_CLINICAL_INDICATION ORDER BY PRIMARY_CLINICAL_INDICATION,TOTAL DESC";
                                                            $result = mysql_query($query);
                                                            while ($row = mysql_fetch_array($result)) {
                                                                $ind = $row["indication"];
                                                                $total = $row["TOTAL"];
                                                                ?>
                                                    <div class="new-CircleBox">
                                                        <p><a href="ontadetailsdev_new.php?st=fr&PLATFORM_CLASS=<?php echo $row_plateform['PLATFORM_CLASS']; ?>&PRIMARY_CLINICAL_INDICATION=<?php echo $ind; ?>"> <?php echo $ind . " (" . $total . ")"; ?></a></p>
                                                    </div>
                                                            <?php }
                                                            ?>
                                                    <div class="clearfix"></div>							
                                                    <button class="btn btn-primary btn-xs moreBtn">More</button>
                                                    <button class="btn btn-primary btn-xs lessBtn">Less</button>
                                                </div>
                                            </div>
                                                    <?php
                                                }
                                            }

                                            if (isset($_REQUEST['anPie_Chart'])) {
                                                $sql_antibody = "SELECT TRIM(bd.ANTIBODY_TYPE) AS ANTIBODY_TYPE, count(1) as tacnt FROM bipi_data bd WHERE bd.PRODUCT_ID NOT IN (2979,2678,3968,3964,3784,3609,2883,3073,772,4571,3070,3071,3911,3513,4836,2770,4835) AND bd.ANTIBODY_TYPE NOT IN ('', '') group by bd.ANTIBODY_TYPE  order by 2  ";

                                                //   $sql_plateform = "SELECT DISTINCT PLATFORM_CLASS as PLATFORM_CLASS , COUNT(PRODUCT_ID) as tacnt  FROM  bipi_data WHERE (PLATFORM_CLASS NOT IN ('', '') AND  PLATFORM_CLASS NOT LIKE '%To be updated%')  GROUP BY PLATFORM_CLASS ORDER BY 2 DESC";
                                                $result_antibody = mysql_query($sql_antibody);
                                                while ($row_antibody = mysql_fetch_array($result_antibody)) {
                                                    ?>		
                                            <div class="panel panel-primary custom-accordion">

                                                <div class="panel-heading"><?php echo $row_antibody['ANTIBODY_TYPE']; ?> 
                                                    <sup>
                                                                <?php
                                                                $sql_ind = "SELECT COUNT(TRIM(bd.ANTIBODY_TYPE)) AS TOTAL FROM bipi_data bd WHERE  `ANTIBODY_TYPE` =  '" . $row_antibody['ANTIBODY_TYPE'] . "'  ";
                                                                $result_ind = mysql_query($sql_ind);
                                                                while ($rowind = mysql_fetch_array($result_ind)) {
                                                                    $total1 = $rowind['TOTAL'];
                                                                    ?>    
                                                        <span class="badge badge-pill badge-primary"><?php echo $total1; ?></span></sup>
                                                            <?php } ?> 
                                                </div>							
                                                <div class="panel-body custom-acc-content">
                                                            <?php
                                                            $query = "SELECT `PRIMARY_CLINICAL_INDICATION` AS indication,COUNT(*) AS TOTAL FROM bipi_data WHERE `ANTIBODY_TYPE`= '" . $row_antibody['ANTIBODY_TYPE'] . "' GROUP BY PRIMARY_CLINICAL_INDICATION ORDER BY PRIMARY_CLINICAL_INDICATION,TOTAL DESC";
                                                            $result = mysql_query($query);
                                                            while ($row = mysql_fetch_array($result)) {
                                                                $ind = $row["indication"];
                                                                $ind1 = urlencode($row["indication"]);
                                                                $total = $row["TOTAL"];
                                                                ?>
                                                    <div class="new-CircleBox">
                                                        <p><a href="ontadetailsdev_new.php?st=fr&ANTIBODY_TYPE=<?php echo $row_antibody['ANTIBODY_TYPE']; ?>&PRIMARY_CLINICAL_INDICATION=<?php echo $ind1; ?>"> <?php echo $ind . " (" . $total . ")"; ?></a></p>
                                                    </div>
                                                            <?php }
                                                            ?>
                                                    <div class="clearfix"></div>							
                                                    <button class="btn btn-primary btn-xs moreBtn">More</button>
                                                    <button class="btn btn-primary btn-xs lessBtn">Less</button>
                                                </div>
                                            </div>
                                                    <?php
                                                }
                                            }

                                            if (isset($_REQUEST['oPie_Chart'])) {
                                                $sql_origin = "SELECT bd.ORIGIN AS ORIGIN , count(1) as tacnt FROM bipi_data bd WHERE 
                                                   bd.PRODUCT_ID NOT IN (2979,2678,3968,3964,3784,3609,2883,3073,772,4571,3070,3071,3911,3513,4836,2770,4835) AND bd.ORIGIN NOT IN ('', '')  group by bd.ORIGIN ORDER BY count(1) ASC";

                                                $result_origin = mysql_query($sql_origin);
                                                while ($row_origin = mysql_fetch_array($result_origin)) {
                                                    ?>		
                                            <div class="panel panel-primary custom-accordion">

                                                <div class="panel-heading"><?php echo $row_origin['ORIGIN']; ?> 
                                                    <sup>
                                                                <?php
                                                                $sql_ind = "SELECT COUNT(TRIM(bd.ORIGIN)) AS TOTAL FROM bipi_data bd WHERE  `ORIGIN` =  '" . $row_origin['ORIGIN'] . "'  ";
                                                                $result_ind = mysql_query($sql_ind);
                                                                while ($rowind = mysql_fetch_array($result_ind)) {
                                                                    $total1 = $rowind['TOTAL'];
                                                                    ?>    
                                                        <span class="badge badge-pill badge-primary"><?php echo $total1; ?></span></sup>
                                                            <?php } ?> 
                                                </div>							
                                                <div class="panel-body custom-acc-content">
                                                            <?php
                                                            $query = "SELECT `PRIMARY_CLINICAL_INDICATION` AS indication,COUNT(*) AS TOTAL FROM bipi_data WHERE `ORIGIN`= '" . $row_origin['ORIGIN'] . "' GROUP BY PRIMARY_CLINICAL_INDICATION ORDER BY PRIMARY_CLINICAL_INDICATION,TOTAL DESC";
                                                            $result = mysql_query($query);
                                                            while ($row = mysql_fetch_array($result)) {
                                                                $ind =  $row["indication"];
                                                                $ind1 =  urlencode($row["indication"]);
                                                                $total = $row["TOTAL"];
                                                                ?>
                                                    <div class="new-CircleBox">
                                                        <p><a href="ontadetailsdev_new.php?st=fr&ORIGIN=<?php echo $row_origin['ORIGIN']; ?>&PRIMARY_CLINICAL_INDICATION=<?php echo $ind1; ?>"> <?php echo $ind . " (" . $total . ")"; ?></a></p>
                                                    </div>
                                                            <?php }
                                                            ?>
                                                    <div class="clearfix"></div>							
                                                    <button class="btn btn-primary btn-xs moreBtn">More</button>
                                                    <button class="btn btn-primary btn-xs lessBtn">Less</button>
                                                </div>
                                            </div>
                                                    <?php
                                                }
                                            }

                                            if (isset($_REQUEST['orgPie_Chart'])) {
                                                $sql_ORGANIZATIONBroad = "SELECT DISTINCT (ORGANIZATIONBroad) FROM bipi_data WHERE PRODUCT_ID NOT IN (2979,2678,3968,3964,3784,3609,2883,3073,772,4571,3070,3071,3911,3513,4836,2770,4835) GROUP BY ORGANIZATIONBroad ORDER BY ORGANIZATIONBroad ASC ";
                                                $result_ORGANIZATIONBroad = mysql_query($sql_ORGANIZATIONBroad);
                                                while ($row_ORGANIZATIONBroad = mysql_fetch_array($result_ORGANIZATIONBroad)) {
                                                    ?>		
                                            <div class="panel panel-primary custom-accordion">

                                                <div class="panel-heading"><?php echo $row_ORGANIZATIONBroad['ORGANIZATIONBroad']; ?> 
                                                    <sup>
                                                                <?php
                                                                $sql_ind = "SELECT COUNT(TRIM(ORGANIZATIONBroad)) AS TOTAL FROM bipi_data bd WHERE  `ORGANIZATIONBroad` =  '" . $row_ORGANIZATIONBroad['ORGANIZATIONBroad'] . "'  ";
                                                                $result_ind = mysql_query($sql_ind);
                                                                while ($rowind = mysql_fetch_array($result_ind)) {
                                                                    $total1 = $rowind['TOTAL'];
                                                                    ?>    
                                                        <span class="badge badge-pill badge-primary"><?php echo $total1; ?></span></sup>
                                                            <?php } ?> 
                                                </div>							
                                                <div class="panel-body custom-acc-content">
                                                            <?php
                                                            $query = "SELECT `PRIMARY_CLINICAL_INDICATION` AS indication,COUNT(*) AS TOTAL FROM bipi_data WHERE `ORGANIZATIONBroad`= '" . $row_ORGANIZATIONBroad['ORGANIZATIONBroad'] . "' GROUP BY PRIMARY_CLINICAL_INDICATION ORDER BY PRIMARY_CLINICAL_INDICATION,TOTAL DESC";
                                                            $result = mysql_query($query);
                                                            while ($row = mysql_fetch_array($result)) {
                                                                $ind = $row["indication"];
                                                                $total = $row["TOTAL"];
                                                            $org = mysql_real_escape_string($_GET['ORGANIZATIONBroad']);
                                                                ?>
                                                    <div class="new-CircleBox">
                                                        <p><a href="ontadetailsdev_new.php?st=fr&ORGANIZATIONBroad=<?php echo urlencode($row_ORGANIZATIONBroad['ORGANIZATIONBroad']); ?>&PRIMARY_CLINICAL_INDICATION=<?php echo $ind; ?>"> <?php echo $ind . " (" . $total . ")"; ?></a></p>
                                                    </div>
                                                            <?php }
                                                            ?>
                                                    <div class="clearfix"></div>							
                                                    <button class="btn btn-primary btn-xs moreBtn">More</button>
                                                    <button class="btn btn-primary btn-xs lessBtn">Less</button>
                                                </div>
                                            </div>
                                                    <?php
                                                }
                                            }

                                            if (isset($_REQUEST['tarPie_Chart'])) {
      $sql_target = "SELECT DISTINCT ta, SUM( cnt1 ) FROM ( SELECT b1.TARGET_ANTIGEN1 ta, COUNT( 1 ) cnt1 FROM bipi_data b1 WHERE ( b1.PRODUCT_ID NOT IN (2979,2678,3968,3964,3784,3609,2883,3073,772,4571,3070,3071,3911,3513,4836,2770,4835) AND  b1.TARGET_ANTIGEN1 NOT IN ('',  '')) GROUP BY b1.TARGET_ANTIGEN1
UNION DISTINCT SELECT b2.TARGET_ANTIGEN2 ta, COUNT( 1 ) cnt1 FROM bipi_data b2 WHERE b2.PRODUCT_ID NOT IN (2979,2678,3968,3964,3784,3609,2883,3073,772,4571,3070,3071,3911,3513,4836,2770,4835) AND ( b2.TARGET_ANTIGEN2 NOT IN ('',  ''))
GROUP BY b2.TARGET_ANTIGEN2  )q1 GROUP BY ta ORDER BY SUM( cnt1 ) DESC ";
                                                $result_target = mysql_query($sql_target);
                                                while ($row_target = mysql_fetch_array($result_target)) {
                                                   // echo print_r($row_target);  
                                                    ?>		
                                            <div class="panel panel-primary custom-accordion">

                                                <div class="panel-heading"><?php if($row_target['ta'] === "0"){ echo "None"; } else { echo $row_target['ta'];} ?> 
                                                    <sup>
                                                                <?php
                                                               $sql_ind = "select  count(sum(cnt1)) as TOTAL from (
     SELECT b1.TARGET_ANTIGEN1 ta,count(1) cnt1 FROM  bipi_data b1 where b1.TARGET_ANTIGEN1='" . $row_target['ta'] . "' AND (b1.TARGET_ANTIGEN1 NOT IN ('', ''))  group by b1.TARGET_ANTIGEN1
     UNION DISTINCT SELECT b2.TARGET_ANTIGEN2 ta, count(1) cnt1 FROM  bipi_data b2 WHERE b1.TARGET_ANTIGEN2='" . $row_target['ta'] . "' AND (b2.TARGET_ANTIGEN2 NOT IN ('', '')  ) GROUP by b2.TARGET_ANTIGEN2
      ) q1 group by ta order by sum(cnt1) DESC";
                                                                $result_ind = mysql_query($sql_ind);
                                                                while ($rowind = mysql_fetch_array($result_ind)) {
                                                                    $total1 = $rowind['TOTAL'];
                                                                    ?>    
                                                        <span class="badge badge-pill badge-primary"><?php echo $total1; ?></span></sup>
                                                            <?php } ?> 
                                                </div>							
                                                <div class="panel-body custom-acc-content">
                                                            <?php
      $query_target = "SELECT DISTINCT  `PRIMARY_CLINICAL_INDICATION` as indication, COUNT( TARGET_ANTIGEN1 )as TOTAL1 , COUNT( TARGET_ANTIGEN2 ) as TOTAL2
FROM  `bipi_data` WHERE (`TARGET_ANTIGEN1` LIKE  '%".$row_target['ta']."%' AND (TARGET_ANTIGEN1 NOT IN ('','')) OR (`TARGET_ANTIGEN2` LIKE  '%".$row_target['ta']."%' AND TARGET_ANTIGEN2 NOT IN ('',  '')))
GROUP BY  `PRIMARY_CLINICAL_INDICATION`";                                 $result_tar = mysql_query($query_target);
                                                            while ($row = mysql_fetch_array($result_tar)) {
                                                                        $ind = $row["indication"]; 
                                                                       $total1 =   $row['TOTAL1'];
                                                                       $total2 =   $row['TOTAL2'];
                                                               ?>               
                                                    <div class="new-CircleBox">                                                                   
                                                        <p> <?php echo $ind; ?>
                                                            <a href="ontadetailsdev_new.php?st=fr&TARGET_ANTIGEN1=<?php echo $row_target['ta']; ?>&PRIMARY_CLINICAL_INDICATION=<?php echo $ind; ?>"> <?php echo  "TARGET ANTIGEN (" . $total1 . ")"; ?></a>
                                                            <!--<a href="ontadetailsdev_new.php?st=fr&TARGET_ANTIGEN2=<?php echo $row_target['ta']; ?>&PRIMARY_CLINICAL_INDICATION=<?php echo $ind; ?>"> <?php echo  "TARGET_ANTIGEN2 (" . $total2 . ")"; ?></a>-->
                                                        </p>
                                                    </div>
                                                            <?php  }
                                                                                                                        ?>
                                                    <div class="clearfix"></div>							
                                                    <button class="btn btn-primary btn-xs moreBtn">More</button>
                                                    <button class="btn btn-primary btn-xs lessBtn">Less</button>
                                                </div>
                                            </div>
                                                    <?php
                                                }
                                            }
                                            ?>     
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </td>
        </tr>
    </table>
</div>

<section><?php include("footer.php"); ?></section>
<script type="text/javascript">

    $(document).ready(function () {
        $(".lessBtn").hide();

        $(".moreBtn").click(function () {

            $(this).parent().css({height: "auto", overflow: "auto"});

            $(this).hide();
            $(this).next().show();

        })
        $(".lessBtn").click(function () {
            $(this).parent().css({height: "120px", overflow: "hidden"});
            $(this).hide();
            $(this).prev().show();
            window.scrollTo(0, 0);
        })
    })
</script>
<script type="text/javascript">

    function searchdata() {
        var str_div = "";
        var keyword = $("#search_word").val();
        var query_type = '<?php echo $url_query; ?>';
        //  alert(keyword);
        $.ajax({
            type: "GET",
            url: 'bipi_datalist.php?search_data=' + keyword + "&" + query_type,
            success: function (response)
            {
                // alert(response);
                $("#datalist").html('<div class="custom-accordion" >' + response + '</div>');
            }

            //  document.getElementById("datalist").innerHTML = 
        });
    }
</script>
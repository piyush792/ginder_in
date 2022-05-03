<div class="contant_right normal FR">
<div class="no-margin-bottom detail_heading">
    <h2 class="FL page_title"><?php echo $mode;?>&nbsp;List</h2>
    <div class="clear"></div>
</div>

<div>&nbsp;</div>


<?php echo $this->Session->flash();?>

<div class="clear"></div>

<div class="category_list">
<ul>
<!-- product List block--->
<?php 
   
    if($mode=='Subject')
    {
        for($i=0;$i<count($subjectList);$i++)
        {
            $subject_id = $subjectList[$i]['Subject']['id'];
            $subject_name = $subjectList[$i]['Subject']['name'];
        ?>
        <li >
        <a href="<?php echo SITE_URL;?>products/view/Subject:<?php echo $subject_name;?>"><?php echo $subject_name;?></a>
        
        </li>
        <?php if(count($subjectList[$i]['children'] > 0))
            {
                for($j=0;$j<count($subjectList[$i]['children']);$j++)
                {
                    $subject_id_c = $subjectList[$i]['children'][$j]['Subject']['id'];
                    $subject_name_c = $subjectList[$i]['children'][$j]['Subject']['name'];
                ?>
                <li >
               
                &nbsp;&nbsp;<a href="<?php echo SITE_URL;?>products/view/Subject:<?php echo $subject_name_c;?>"><?php echo $subject_name_c;?></a>
                
                </li>
                <?php 
                }
            }
        }
    }
    else
    {
        for($i=0;$i<count($categoryList);$i++)
        {
            $type_id = $categoryList[$i]['Category']['id'];
            $type_name = $categoryList[$i]['Category']['name'];
        ?>
        <li >
        
        <a href="<?php echo SITE_URL;?>products/view/Type:<?php echo $type_id;?>"><?php echo $type_name;?></a>
      
        </li>
        <?php if(count($categoryList[$i]['children'] > 0))
            {
                for($j=0;$j<count($categoryList[$i]['children']);$j++)
                {
                    $type_id_c = $categoryList[$i]['children'][$j]['Category']['id'];
                    $type_name_c = $categoryList[$i]['children'][$j]['Category']['name'];
                ?>

                <li >
               
                &nbsp;&nbsp;<a href="<?php echo SITE_URL;?>products/view/Type:<?php echo $type_id_c;?>"><?php echo $type_name_c;?></a>
                
                </li>
                <?php 
                }
            }
        } 
    }



?>



</ul>
</div>    
                                <div class="clear"></div>
<!-- product List block // --->
                                
                                
                                 <div>&nbsp;</div>
                             </div>

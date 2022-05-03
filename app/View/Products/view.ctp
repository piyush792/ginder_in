<?php //echo $this->Html->css('bootstrap');
    echo $this->Html->css('rating');
    echo $this->Html->script(array('behavior.js','rating.js')); 

?>
<div class="breadcrumb">
    <div align="left" class="FL"><img src="<?php echo SITE_URL;?>images/breadcrumb_01.png"></div>
    <div class="FL"><?php echo $navigation;?></div>
    <div align="right" class="FR"><img src="<?php echo SITE_URL;?>images/breadcrumb_04.png"></div>
    <div class="clear"></div>
</div>
<div class="no-margin-bottom detail_heading">
    <h2 class="FL"><?php if($keyword!=''){
                echo 'Search Result for:&nbsp;'.$keyword;
            }
            else
            {
                echo $headline;  
            }
    ?></h2>
    <div class="clear"></div>
</div>  

<?php if(count($productList) > 0)
    { ?>
    <div class="pagination_container">
        <div align="left" class="FL"><label class="FL sort">Sort:</label>
            <span class="FL ddsort">
                <?php echo $this->Form->input('sort_product',array('label'=>false,'class'=>'select select_sort','title'=>'Select one','id'=>'sortOrder','options'=>$sortArr,"selected"=>$sort_selected,"div"=>false));?>                        

            </span>
            <div class="clear"></div>
        </div>
        <div align="right" class="FR">       
            <div class="dataTables_paginate paging_bootstrap pagination">

                <ul>
                    <?php 
                        //$this->Paginator->options(array('url' => $this->request->params['named']));

                        echo $this->Paginator->first("First" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'first disabled','escape'=>false,'tag'=>'li'));
                        echo $this->Paginator->prev("&larr; Previous" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'prev disabled','escape'=>false,'tag'=>'li'));

                        echo '&nbsp;'.$this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active')); 
                        echo $this->Paginator->next("Next &rarr;", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                        echo $this->Paginator->last("Last", array('escape'=>false,'tag'=>'li'), null, array('class' => 'last disabled','escape'=>false,'tag'=>'li'));
                    ?>
                </ul>           
            </div>
        </div>
        <div class="clear"></div>
    </div>


    <div class="product product_list vertical">
        <ul>
        <!-- product List block--->
        <?php 
            //echo "<pre>";   
            // print_r($productList);
            // print_r($subjectsList); 
            if(count($productList) > 0)
            { 
                for($i=0;$i<count($productList);$i++)
                {
                    $subject="";
                    $subjectIdArr = explode(',',$productList[$i]['Product']['subjects']);
                    // echo "count".count($subjectIdArr);       
                    for($j=0;$j<count($subjectIdArr);$j++)
                    {
                        if($j==0)
                        {
                            $subject =  $subjectsList[$subjectIdArr[$j]];
                        }
                        else
                        {
                            $subject .= ','.$subjectsList[$subjectIdArr[$j]]; 
                        }        
                    }

                    if($productList[$i]['Product']['price'] > $productList[$i]['Product']['discount_price'] && $productList[$i]['Product']['price']!=0 && $productList[$i]['Product']['discount_price']!=0)
                    {
                        $product_price = $productList[$i]['Product']['discount_price'];
                        $price = '<div class="product_list_price_descount">$'.$productList[$i]['Product']['price'].'</div>
                        <div class="price">$'.$productList[$i]['Product']['discount_price'].'</div>';
                    }
                    elseif($productList[$i]['Product']['price']!=0)
                    {
                        $product_price = $productList[$i]['Product']['price'];
                        $price = '<div class="price">$'.$productList[$i]['Product']['price'].'</div>';  
                    }


                    //print_r($subjects);
                ?>
                <li class="hline">
                <div class="FL _blocks">
                <?php 

                    $image_exist = PRODUCT_IMAGE_UPLOAD.$productList[$i]['Product']['image'];

                    if(file_exists($image_exist) && $productList[$i]['Product']['image']!='')
                    {?>

                    <a href="<?php echo SITE_URL."/products/detail/".$productList[$i]['Product']['id'];?>"><?php echo$this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$productList[$i]['Product']['image'],array('width'=>'140','height'=>'115'));?></a>
                    <?php }else{?>
                    <a href="<?php echo "/products/detail/".$productList[$i]['Product']['id'];?>"><?php echo$this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg',array('width'=>'140','height'=>'115'));?></a>

                    <?php }?>
                </div>
                <div class="FR list_desc">
                <h2><!--<a href="#"><?php //echo $productList[$i]['Product']['name'];?></a>-->
                <?php  echo $this->Html->link($productList[$i]['Product']['name'],"/products/detail/".$productList[$i]['Product']['id']);?>
                </h2>

                <p>
                    <?php 
                        if($productList[$i]['Product']['short_description']!=''){
                            if(strlen($productList[$i]['Product']['short_description']) > 200)
                            {
                                echo $short_desc = substr($productList[$i]['Product']['short_description'],0,197).'...';
                            }
                            else
                            {
                                echo $productList[$i]['Product']['short_description'];  
                            }

                        }

                    ?>
                </p>
                <div class="FL list_attribute">
                    <label>By:</label><span class="FL"><?php if($productList[$i]['Product']['short_description']!=''){
                                echo $productList[$i]['User']['firstname'].' '.$productList[$i]['User']['lastname'];
                    }?></span><div class="clear"></div>
                    <label>Subject:</label><span class="FL"><?php echo $subject;?></span><div class="clear"></div>
                    <label>Level(s):</label><span class="FL"><?php echo $productList[$i]['Product']['grade_level'];?></span><div class="clear"></div>
                    <!-- <label>Duration:</label><span class="FL">Lifelong Tool</span><div class="clear"></div>-->
                    <label>Type:</label><span class="FL"><?php echo $productList[$i]['Category']['cat_name'];?></span><div class="clear"></div>
                    <div class="votes votenow"><?php 
                            $product_id =$productList[$i]['Product']['id'];
                        echo $rateArr[$product_id];?><span> <?php echo $voteArr[$product_id]['votes_total'];?> votes</span></div>
                </div>


                <div class="FR list_cart" style="position:relative;">

                    <!--<div style="brorder:1px solid green;position:absolute; top:-15px; width:100px; text-align:center;text-decoration: line-through; color:#FF3366;">$1000.00</div>
                    <div class="price"><span>$</span><?php //echo ($productList[$i]['Product']['price']);?></div>  
                    -->
                    <?php echo $price;?>
                    <?php //echo $this->Form->button("Add to Cart",array('type'=>'button','class'=>'add_to_cart button'));?>
                    <?php echo $this->Form->button("Add to Cart",array('type'=>'button','onclick'=>"addtocartform('".$productList[$i]['Product']['id']."','".$product_price."');",'class'=>'add_to_cart button'));?>
                    <div class="download digital">Digital Download</div>
                </div>
                <div class="clear"></div>   
            </div>    
            <div class="clear"></div> 
            </li>
            <?php }
        }
    ?>
    </ul>
    </div>
    <div class="pagination_container">
        <div align="left" class="FL"><label class="FL sort">Sort:</label>
            <span class="FL ddsort">
                <?php echo $this->Form->input('sort_product',array('label'=>false,'class'=>'select select_sort','title'=>'Select one','id'=>'sortOrderdown','options'=>$sortArr,"selected"=>$sort_selected,"onchange"=>"applyfilters('sort', this.value)","div"=>false));?>                        
            </span>
            <div class="clear"></div>
        </div>
        <div align="right" class="FR">       
            <div class="dataTables_paginate paging_bootstrap pagination">

                <ul>
                    <?php 
                        //$this->Paginator->options(array('url' => $this->request->params['named']));

                        echo $this->Paginator->first("First" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'first disabled','escape'=>false,'tag'=>'li'));
                        echo $this->Paginator->prev("&larr; Previous" , array('escape'=>false,'tag'=>'li'), null, array('class' => 'prev disabled','escape'=>false,'tag'=>'li'));

                        echo '&nbsp;'.$this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active')); 
                        echo $this->Paginator->next("Next &rarr;", array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                        echo $this->Paginator->last("Last", array('escape'=>false,'tag'=>'li'), null, array('class' => 'last disabled','escape'=>false,'tag'=>'li'));
                    ?>
                </ul>           
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <?php }else{?>
    <div class="product product_list vertical">     
        There is no result found for selected criteria.
    </div>
    <?php }?>
<script src="<?php echo SITE_URL;?>js/jquery-1.4.1.min.js"></script>
<?php
    echo $this->Form->create("Product",array("id"=>"Product",'type'=>'post','url'=>'/shopping_carts/addtocart'));
    echo $this->Form->input("product_id",array('type'=>'hidden','id'=>'product_id'));
    echo $this->Form->input("price",array('type'=>'hidden','id'=>'price'));
    echo $this->Form->input("quantity",array('type'=>'hidden','id'=>'quantity','value'=>"1"));
    echo $this->Form->end();
?>
<script type="text/javascript">
    function addtocartform(id,price){
        $('#product_id').val(id);
        $('#price').val(price);
        $('#Product').submit();
    }

</script>
<script>
    $(document).ready(function(){        
        var url = '<?php echo $Url;?>';

        var paging = '<?php echo PAGING;?>';
        var SearchLink = '<?php echo $SearchLink;?>';
        var sort_link = '<?php echo $sort_link;?>';
        var count = '<?php echo count($productList);?>';  
        var page=''; 
        if(count > paging)
        {
            page ='/page:1'; 
        }
        if(SearchLink!="" && sort_link!='')
        {
            url=url+SearchLink;
            //url=url+SearchLink+sort_link;
        }
        else if(sort_link!='')
        {
            url=url+SearchLink+sort_link;  
        }

        $('#sortOrder').change(function() {        

            switch ($('#sortOrder option:selected').val()) {        
                case 'Alphabetical':
                url += page+'/sort:name/direction:asc/';
                break;             
                case 'Most-Recently-Posted':
                url += page+'/sort:modified/direction:desc/';
                break;
                case 'Price-Asc':
                url += page+'/sort:price/direction:asc/';
                break;
                case 'Price-Desc':
                url += page+'/sort:price/direction:desc/';
                break;
                default : url += page+'/sort:name/direction:asc/';
            }
            window.location = url;
        });

        $('#sortOrderdown').change(function() {        

            switch ($('#sortOrderdown option:selected').val()) {        
                case 'Alphabetical':
                url += page+'/sort:name/direction:asc/';
                break;             
                case 'Most-Recently-Posted':
                url += page+'/sort:modified/direction:desc/';
                break;
                case 'Price-Asc':
                url += page+'/sort:price/direction:asc/';
                break;
                case 'Price-Desc':
                url += page+'/sort:price/direction:desc/';
                break;
                default : url += page+'/sort:name/direction:asc/';
            }
            window.location = url;
        });
    });
</script>
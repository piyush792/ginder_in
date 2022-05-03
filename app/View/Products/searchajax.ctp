<?php 
if(count($productListArray)>0)
{ 
?>      <div class="sortPanel clear">
            <ul class="sortList FL">
            
                                <li><a <?php if($this->params['url']['order']== 'newest') { echo "class='active'";} ?> href="<?php echo SITE_URL.'products/view/'.$key[0].'?order=newest' ?>">Newest</a></li>
                                <li><a <?php if($this->params['url']['order']== 'highest_price') { echo "class='active'";} ?>  href="<?php echo SITE_URL.'products/view/'.$key[0].'?order=highest_price' ?>">Highest Price</a></li>
                                <li><a <?php if($this->params['url']['order']== 'lowest_price') { echo "class='active'";} ?> href="<?php echo SITE_URL.'products/view/'.$key[0].'?order=lowest_price' ?>">Lowest Price</a></li>
                                <li class="noBD"><a  <?php if($this->params['url']['order']== 'customer_rating') { echo "class='active'";} ?> href="<?php echo SITE_URL.'products/view/'.$key[0].'?order=customer_rating' ?>">Customer Rating</a></li>                               
                            </ul>
                <!--<?php 
                    if(count($listCatname) > 0)
                    {
                        if(count($Cat_name)>0)
                        {
                        ?><li><a href="<?php echo SITE_URL.'products/view/'.$listCatname[0]['Categories']['id']?>"><?php echo $listCatname[0]['Categories']['name'];?></a></li>      
                        <?php 
                        }else
                        {
                        ?><li class="noBD"><a href="<?php echo SITE_URL.'products/view/'.$listCatname[0]['Categories']['id']?>"><?php echo $listCatname[0]['Categories']['name'];?></a></li>               <?php
                        }
                    } 
                    if(count($Cat_name)>0)
                    { 
                    ?>
                    <li class="noBD"><a href="<?php echo SITE_URL.'products/view/'.$Cat_name[0]['Categories']['id']?>"><?php echo $Cat_name[0]['Categories']['name'];?></a></li>
                    <?php 
                    } 
                ?>
            </ul>         -->
            <ul class="pager FR">
                <?php 
                    //$this->Paginator->options(array('url' => $this->request->params['named']));
                    //   echo $this->Paginator->first($this->Html->image(SITE_URL."img/listing-pager-first.png"), array('escape'=>false,'tag'=>'li'), null, array('class' => 'first disabled','escape'=>false,'tag'=>'li'));
                    echo $this->Paginator->prev($this->Html->image(SITE_URL."img/listing-pager-first.png"), array('escape'=>false,'tag'=>'li'), null, array('class' => 'prev disabled','escape'=>false,'tag'=>'li'));
                    echo '&nbsp;'.$this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active')); 
                    echo $this->Paginator->next($this->Html->image(SITE_URL."img/listing-pager-next.png"), array('escape'=>false,'tag'=>'li'), null, array('class' => 'next disabled','escape'=>false,'tag'=>'li'));
                    // echo $this->Paginator->last($this->Html->image(SITE_URL."img/listing-pager-next.png"), array('escape'=>false,'tag'=>'li'), null, array('class' => 'last disabled','escape'=>false,'tag'=>'li'));
                ?>
            </ul>           
        </div>
        <div class="listArea clear">
            <ul>
                <!-- product List block--->
            <?php 
                if(count($productListArray) > 0)
                {
                    for($i=0;$i<count($productListArray);$i++)
                    {
                        if($productListArray[$i]['Products']['discount'] < $productListArray[$i]['Products']['price'] && $productListArray[$i]['Products']['price']!=0)
                        {
                            $product_price = $productListArray[$i]['Products']['price'];
                            $price = '<span class="price"><em>$'.$productListArray[$i]['Products']['price'].'</em>$'.$productListArray[$i]['Products']['discount'].'</span>';  
                            $percentage=100-(($productListArray[$i]['Products']['discount']/$productListArray[$i]['Products']['price'])*100);
                        
                        }elseif($productListArray[$i]['Products']['price']!=0)
                        {
                            $product_price = $productListArray[$i]['Products']['price'];
                            $price = '<span class="price"><em>$'.$productListArray[$i]['Products']['price'].'</em></span>';  
                        }
              ?>
                   <div class="listItem">
                    <?php 
                        if($productListArray[$i]['Products']['discount']!='0')
                        {
                        ?>
                            <strong><img src="<?php echo SITE_URL;?>img/sale-banner-small.png" alt=""></strong>  
                        <?php 
                        }elseif($productListArray[$i]['Products']['new_product']!='0'){
                        ?>
                            <strong><img src="<?php echo SITE_URL;?>img/new-banner-small.png" alt=""></strong>
                        <?php 
                        }
                    ?>
                    <a href="<?php echo SITE_URL."products/detail/".$productListArray[$i]['Products']['id'];?>">
                    <!--<a href="#">--> 
                        <?php
                            $image_exist = PRODUCT_IMAGE_UPLOAD.$productListArray[$i]['Products']['image'];
                            if(file_exists($image_exist) && $productListArray[$i]['Products']['image']!='')
                            echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$productListArray[$i]['Products']['image'],array('width'=>'216','height'=>'179'));
                            else
                            echo $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.'no_image.jpg',array('width'=>'216','height'=>'179'));
                        ?>
                        <span class="productName"><?php  echo $productListArray[$i]['Products']['name']?></span>
                        <?php
                            if($productListArray[$i]['Products']['discount']!='0')
                            {
                                echo $price;
                            }else{
                            ?>
                            <span class="price2">$<?php echo $product_price;?></span>
                            <?php 
                            }
                            if($productListArray[$i]['Products']['discount']>0)
                            {
                            ?><small>Take an Additional <?php echo round($percentage);?>% Off!</small>
                            <?php 
                            }
                        ?>
                    </a>
                </div>
                <?php }
                }
            ?>
         </ul>

</div>
 
</div>
</div>
<?php 
}else{
?>
<div class="listingMain">There is no result found for selected criteria.</div>
<?php 
}
?>
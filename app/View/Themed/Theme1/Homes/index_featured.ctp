<?php 
$count_featuredList=count($featuredList);
for ($i = 0; $i < $count_featuredList; $i++) {
    ?>
    <li>
        <div class="listItem">
            <a href="<?php echo SITE_URL."products/detail/".$featuredList[$i]['Product']['id'];?>">
                <?php
                $image_exist = PRODUCT_IMAGE_UPLOAD . $featuredList[$i]['Product']['image'];
                if (file_exists($image_exist) && $featuredList[$i]['Product']['image'] != '')
                    echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . $featuredList[$i]['Product']['image'], array('width' => '196', 'height' => '196'));
                else
                    echo $this->Html->image(SITE_URL . PRODUCT_IMAGE_UPLOAD . 'no_image.jpg', array('width' => '196', 'height' => '196'));
                ?>
            </a>
            <p><?php echo $featuredList[$i]['Product']['name']; ?><p>
            <h4><?php echo CURRENCY_SYMBOL.number_format($featuredList[$i]['Product']['price'],2,DECIMAL_SEPARATOR,THOUSAND_SEPARATOR);?></h4>
       </div> 
    </li>
    <?php
}

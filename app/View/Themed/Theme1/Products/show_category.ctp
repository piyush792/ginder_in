<div class="clearfix"></div>
<div class="middle-content-advert static-page">
  <div class="static-page-content-wrapper">
    <h1 class="page-title"><?php echo $categoryName['Category']['name'];?></h1>
    <div class="page-content">
      <div class="subcategory-card-wrapper">
          <?php
            if (!empty($parent_category)) {
                foreach ($parent_category as $key => $values) {
                    $link = $key."/".$categoryName['Category']['name'];
                    echo '<div class="subcategory-item"><a href="'.SITE_URL.'products/view/'.$link.'">'.$values.'</a></div>';
                }
            }
            ?>
      </div>
    </div>
  </div>
</div>
<?php //echo $this->element('sql_dump'); ?>

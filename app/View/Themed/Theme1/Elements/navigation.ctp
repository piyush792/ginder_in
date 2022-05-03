<div class="global-navbar collapse" id="collapsibleNavbar">
    <div class="mobile-global-navbar-overlay"></div>
    <div id="ctrl-navbar-close" class="navbar-close"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="navbar-highres-wrapper">
        <div class="navbar-items-wrapper">
            <?php
            // echo "len: ".$urlPositionLength;
            // echo "<pre>";
            // print_r($selectedCategoryName);
            // print_r($SubCategory_list); exit;
            if($urlPositionLength<=6){
                $activeNav = "active-nav";
            }else{
                $activeNav = "";
            }
            ?>
            <?php echo $this->Html->link("Home", '/', array('escape' => false, "class"=>"".$activeNav.""));?>
            <?php
            foreach($SubCategory_list as $keys=>$value){
                
                //explode the key to spli the id and name
                $key = explode('==', $keys);
                if(!empty($selectedCategoryName) && count($selectedCategoryName)>0){
                    if($key[1] == $selectedCategoryName['c2']['name']){
                        $activeNav = "active-nav";
                    }else{
                        $activeNav = "";
                    }
                    $activeNav = "";
                }else{
                    $activeNav = "";
                }
            ?>
                <div class="global-navbar-dropdown <?php //echo $activeNav; ?>">
                    <div class="dropbtn">
                        <?php echo $this->Html->link($key[1], array('controller' => 'products', 'action' => 'show_category', $key[0]), array('escape' => false, "class"=>"".$activeNav.""));?>
                        <?php //echo $key[1]; ?>
                        <?php //echo $this->Html->link("Home", '/', array('escape' => false, "class"=>"".$activeNav.""));?>
                        <i class="fa fa-caret-down"></i>
                    </div>
                
                    <div class="global-navbar-dropdown-content">
                        <div class="header">
                            <h2>
                                <?php echo $key[1]; ?>
                                <?php //echo $this->Html->link($key[1], array('controller' => 'products', 'action' => 'show_category', $key[0]), array('escape' => false));?>
                            </h2>
                        </div>                        
                        <div class="row">                            
                            <?php
                            $i=0;
                            foreach($value as $k=>$v){
                                if($i % 9 ==0)
                                {
                                    echo '</div>';
                                    echo '<div class="column">';
                                    echo '</ul>';
                                    echo '<ul>';
                                }

                                $link = $k."/".$key[1];
                                // $link = myUrlEncode($link1);
                                echo '<li><a href="'.SITE_URL.'products/view/'.$link.'">'.$v.'</a></li>';
                                // echo '<li>'.$this->Html->link($v, array('controller' => 'products', 'action' => 'view', $link), array('escape' => false)).'</li>';
                                $i++;                                        
                            }
                            // echo '</ul>';
                            // echo '</div>';
                            ?>                                    
                        </div>                        
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
// function myUrlEncode($string) {
//     $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
//     $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
//     return str_replace($entities, $replacements, urlencode($string));
// }
?>
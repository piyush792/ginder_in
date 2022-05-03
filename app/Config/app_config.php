<?php
if ($_SERVER['HTTP_HOST']=='localhost') {
   @define("SITE_URL", "http".($_SERVER['SERVER_PORT']==443?'s':'')."://" . $_SERVER['HTTP_HOST'] . "/");  
}else{
    @define("SITE_URL", "http".($_SERVER['SERVER_PORT']==443?'s':'')."://" . $_SERVER['HTTP_HOST'] . "/");
}

define("SITE_NAME","GINDER");
define("ADMIN_TITLE","Administrating Panel for ".SITE_NAME);

define("PRODUCT_IMAGE_UPLOAD","media/product_images/");
define('PRODUCT_BIG_WIDTH',381);
define('PRODUCT_BIG_HEIGHT',360);
define('PRODUCT_THUMB_WIDTH',196);
define('PRODUCT_THUMB_HEIGHT',196);

define("HOME_BANNER_UPLOAD","media/banner_images/");

define("PAGING",50);    
define("CURRENCY_SYMBOL",'Rs');
define("DECIMAL_SEPARATOR",'.');
define("THOUSAND_SEPARATOR",',');
define("NO_IMAGE","noimage.gif");
define("PRODUCT_FILE_UPLOAD","media/product_file/");

define("EMAIL_REGEX", '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i');
define("PASSWORD_HASH_METHOD",'sha1');
define("SIZE_ID",1);

// FACEBOOK CONFIGURATION
define('FACEBOOK_API_ID','1420890111467545');
define('FACEBOOK_SECRET','b7d9b7ce930505ba3c0ad9e5dfc7789d');
define('FACEBOOK_APP_NAME','GinderApp');
define('FACEBOOK_APP_CANVAS_URL','http://apps.facebook.com/1420890111467545/');  
?>

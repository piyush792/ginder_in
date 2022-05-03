<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class AppController extends Controller {
   public $helpers = array('Html', 'Form', 'Js', 'Cache', 'Session');
   public $components = array('DebugKit.Toolbar','Auth','Session','RequestHandler', 'Cookie');
   var $uses = array("Product","ShoppingCart","Category","ProductAttribute","ProductAttributeValue","Content","State","City","SocialLink");
    
   function beforeFilter() {
        parent::beforeFilter();
        
        if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {
            $this->layout = 'default_admin';
            $this->Auth->authenticate = array('Form' => array('userModel' => 'Admin', 'fields' => array('username' => 'username', 'password' => 'password'), 'scope' => array('Admin.status' => 1)));
            $this->Auth->authorize = array('Controller');
            $this->Auth->loginAction = array('admin' => true, 'controller' => 'admins','action' => 'login');
            $this->Auth->loginRedirect = array('admin' => true, 'controller' => 'admins','action' => 'index');
            AuthComponent::$sessionKey = "Auth.Admin";
            $this->set('title_for_layout', ADMIN_TITLE);
       
        }else{
            $this->theme = 'theme1';
            $this->Auth->authenticate = array('Form' => array('userModel'=>'User','fields'=> array('username'=>'email','password'=>'password'),'scope'=>array('User.active'=>1)));
            $this->Auth->authorize = array('Controller');
            $this->Auth->loginAction = array('controller' => 'homes','action' => 'index');
            // $this->Auth->loginRedirect = array('controller'=>'homes','action'=>'index');
            $this->Auth->logoutRedirect = '/';            
            /////////////////////////////////////
            //search the product in header
            $keyword="";
            $state="";
            $this->set("keyword", $keyword);
            $this->set("state", $state);
            //End here
           
            //MAIN CATEGORIES LIST
            $parent_category = $this->Category->find("list", array("fields" => 'id, name', "conditions" =>array("active"=>1,"parent_id"=>0) , "order" => "position ASC"));
            $this->set("parent_category",$parent_category);
            
            // CHECK FOR SUBCATEGORY
            if (!empty($parent_category)) {
                foreach ($parent_category as $key => $values) {
                    $SubCategory_list[$key."==".$values] = $this->Category->find('list', array('fields' => array('Category.id', 'Category.name'), 'conditions' => array('Category.parent_id' => $key)));
                }
            }
            $this->set("SubCategory_list",$SubCategory_list);

            // SITE PAGES
            $content_pages1=$this->Content->find('all', array('conditions'=>array('Content.active'=>1,'Content.category_type'=>1),'order'=>'Content.sort ASC'));
            $content_pages2=$this->Content->find('all', array('conditions' =>array('Content.active'=>1,'Content.category_type'=>2),'order'=>'Content.sort ASC'));
            $this->set('content_pages1', $content_pages1);
            $this->set('content_pages2', $content_pages2);
            
            
            // CART ITEMS
            $carttotal = 0;
            if($this->Session->read("sessionid")!="") {
                $carttotal = $this->ShoppingCart->find("count", array("conditions"=>array("ShoppingCart.session_id='".$this->Session->read("sessionid")."'")));
                $this->set("total_cart_item",$carttotal);
            }else{
                $this->set("total_cart_item", $carttotal);
            }

            /// State LIST START
            $state = $this->State->find('all',array('fields'=>array('State.id','State.name'), 'order'=>array('State.name ASC')));
            $totalState=count($state);        
            $stateList=array();
            $stateList[]='Select State';
            for($i=0;$i<$totalState;$i++){
                $stateList[$state[$i]['State']['id']] = $state[$i]['State']['name']; 
            }
            $this->set('states',$stateList);

            /// City LIST START
            $city = $this->City->find('all',array('fields'=>array('City.id','City.name'), 'order'=>array('City.name ASC')));
            $totalCity=count($city);        
            $cityList=array();
            $cityList[]='Select City';
            for($i=0;$i<$totalCity;$i++){
                $cityList[$city[$i]['City']['id']] = $city[$i]['City']['name']; 
            }
            $this->set('cities',$cityList);


            //Start to facebook login
            require_once 'facebook-php-sdk/autoload.php';
            // $appId = '2393999827344571'; //Facebook App ID
            // $appSecret = 'dba6a80b9c704cbc07026ce874e0c5b4'; //Facebook App Secret
            
            $appId = '485073262288746'; //Facebook App ID
            $appSecret = 'c1b92dcaddc2ee8e6e4a079a67abe247'; //Facebook App Secret

            // $redirectURL = 'http://localhost/ginder/users/registration?facebook=1'; //Callback URL for localhost
            $redirectURL = 'https://ginder.in/users/registration?facebook=1'; //Callback URL for live
            $fbPermissions = array('email');  //Optional permissions

            $fb = new Facebook(array(
                'app_id' => $appId,
                'app_secret' => $appSecret,
                'default_graph_version' => 'v2.2',
            ));
            // Get redirect login helper
            $helper = $fb->getRedirectLoginHelper();

            $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
            // echo "url: ".$loginURL;
            // Render facebook login button
            $output = '<a href="' . htmlspecialchars($loginURL) . '"><button class="icon-facebook-signup"><img src="' . SITE_URL . 'theme/theme1/images/icon-facebook-login.png"> Facebook Account</button></a>';
            
            $this->set('output', $output);
            //end here to facebook login

            ########## Google Settings.. Client ID, Client Secret #############
            if (!isset($_REQUEST['facebook'])) {
            $google_client_id = '710177811137-o4uof092e1rl8a1qbpgm7ubu1nhr41tg.apps.googleusercontent.com';
            $google_client_secret = 'Nlx7557vg6-3BSWZYiLnRi6G';
            $google_redirect_url = 'https://ginder.in/users/registration'; //http://localhost/google-login/
            $google_developer_key = 'AIzaSyCNjJLK3iE0sGT0KA-KvwDnL4l6LvuHS7k';

            //include google api files
            require_once 'src/Google_Client.php';
            require_once 'src/contrib/Google_Oauth2Service.php';

            $gClient = new Google_Client();
            $gClient->setApplicationName('Login to localhost');
            $gClient->setClientId($google_client_id);
            $gClient->setClientSecret($google_client_secret);
            $gClient->setRedirectUri($google_redirect_url);
            $gClient->setDeveloperKey($google_developer_key);

            $google_oauthV2 = new Google_Oauth2Service($gClient);

            $authUrl = $gClient->createAuthUrl();
            if (isset($authUrl)) { //user is not logged in, show login button
                $this->set('authUrl', $authUrl);
            }
           }
           
            //Share at link in details page
            $social_linked = $this->SocialLink->find('first', array('conditions' => array('SocialLink.id' => 1)));
            $this->set("social_linked", $social_linked);

            //Show the selected category name and underline the category name
            $urls = Router::url( $this->here, true);
            $urls = explode("/", $urls);
            $urlPositionLength = count($urls);
            $this->set("urlPositionLength", $urlPositionLength);
            // echo "len: ".$urlPositionLength;
            
            if($urlPositionLength > 8){
                $urlPositionId = $urls[$urlPositionLength-2];
                $urlPageName = $urls[$urlPositionLength-3];
                
                if($urlPageName=="view"){
                    $selectedCategoryName = $this->Category->find('first', array(
                        'fields' => array('c2.name'),
                        'joins' => array(
                            array(
                                'table' => 'categories',
                                'alias' => 'c2',
                                'type' => 'INNER',
                                'conditions' => array('c2.id=Category.parent_id'),
                            )
                        ),
                        'conditions' => array('Category.id'=>$urlPositionId, 'Category.active' => 1)
                    ));
                    $this->set("selectedCategoryName", $selectedCategoryName);
                }else if($urlPageName=="detail"){
                    $selectedCategoryName = $this->Category->find('first', array(
                        'fields' => array('c2.name'),
                        'joins' => array(
                            array(
                                'table' => 'categories',
                                'alias' => 'c2',
                                'type' => 'INNER',
                                'conditions' => array('c2.id=Category.parent_id'),
                            ),
                            array(
                                'table' => 'categories_products',
                                'alias' => 'cp',
                                'type' => 'INNER',
                                'conditions' => array('cp.category_id=Category.id'),
                            ),
                        ),
                        'conditions' => array('cp.product_id'=>$urlPositionId, 'Category.active' => 1)
                    ));
                    $this->set("selectedCategoryName", $selectedCategoryName);
                }                
            }else{
                $this->set("selectedCategoryName", "");                
            }
            //End to Show the selected category name
            
         }
    }
    
    public function isAuthorized($user = null) {
        return true;
    }

    public function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return $sec . "_" . ($usec * 100000000);
    }
    
    public function _get_rand_id($length) {
        if ($length > 0) {
            $rand_id = "";
            for ($i = 1; $i <= $length; $i++) {
                mt_srand((double) microtime() * 1000000);
                $num = mt_rand(1, 36);
                $rand_id.=$num;
            }
        }
        return $rand_id;
    }
  
}
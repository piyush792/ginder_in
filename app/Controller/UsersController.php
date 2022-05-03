<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('CakeTime', 'Utility');

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class UsersController extends AppController {
    public $components = array('Captcha', 'Image');
    public $uses = array('User','EmailTemplate','Country','State','City','WishList','NewsletterSubscriber','Order','OrderItem','ProductImage','ProductContact', 'ProductAttributeRelation', 'CategoriesProduct', 'Category', 'ProductTransaction');
    
    public function beforeFilter(){
        parent::beforeFilter();
        if ((isset($this->params['prefix']) && ($this->params['prefix'] == 'admin'))) {
            // $this->Auth->allow("admin_getCity");
        }else{
            $this->Auth->allow("registration","activate","get_captcha","login","logouts","forgot_password");
        }        
    }        
       
    public function admin_searchurl()
    {
        $searchStr = "";
        if(isset($this->params['named']['sort']) && $this->params['named']['sort'] != "" && isset($this->params['named']['direction']) && $this->params['named']['direction'] != "")
        {
            $searchStr.= '/sort:'.$this->params['named']['sort'].'/direction:'.$this->params['named']['direction'];
        }

        if(isset($this->params['url']['active']) && $this->params['url']['active'] !="")
        {
            $searchStr.= '/active:'.$this->params['url']['active'];
        }

        if(isset($this->params['url']['created']) && $this->params['url']['created'] !="")
        {
            list($month,$day,$year) =  split('/',$this->params['url']['created']);
            $searchStr.= '/created:'.date($year.'-'.$month.'-'.$day);
        }
        if(isset($this->params['url']['keyword']) && $this->params['url']['keyword'] !="")
        {
            $searchStr.= '/keyword:'.$this->params['url']['keyword'];
        }
        if(isset($this->params['url']['location']) && $this->params['url']['location'] !="")
        {
            $searchStr.= '/location:'.$this->params['url']['location'];
        }
        $this->redirect('/admin/users/index'.$searchStr);
    }

    public function admin_index(){

        // echo "<pre>";
        // print_r($_GET);
        // exit;
        if(isset($this->params['named']['sort']) && $this->params['named']['sort'] != "" && isset($this->params['named']['direction']) && $this->params['named']['direction'] != "")
        {
            $action = 'searchurl/sort:'.$this->params['named']['sort'].'/direction:'.$this->params['named']['direction'];
        }else{
            $action =  'searchurl';
        }
        $this->set(compact("action"));

        $this->set("reset_button",$this->params->base.'/'.$this->params['prefix'].'/'.$this->params['controller'].'/index');

        $condition_search = '';
        $condition_search_location = '';
        $condition_search_status = '';
        
        if(isset($this->params['named']['keyword'])){
            $searchKey = $this->params['named']['keyword'];
            $condition_search = array('OR' => array('User.email LIKE' => '%' . $searchKey . '%', 'User.firstname LIKE' => '%' . $searchKey . '%', 'User.lastname LIKE' => '%' . $searchKey . '%', 'User.mobile LIKE' => '%' . $searchKey . '%'));
        }
        if(isset($this->params['named']['location'])){
            $searchKey = $this->params['named']['location'];
            $condition_search_location = array('AND' => array('User.city' => $searchKey));
        }
        if(isset($this->params['named']['active'])){
            $searchKey = $this->params['named']['active'];
            $condition_search_status = array('AND' => array('User.active' => $searchKey));
        }
      
        $this->paginate = array('User' => array('all','fields'=>array('User.id,User.email,User.firstname,User.lastname,User.active'),'limit'=>PAGING,'order' =>array('User.id '=>'DESC')));
        $userList = $this->paginate('User',array($condition_search, $condition_search_location, $condition_search_status));
        $this->set("userList",$userList);

        /// City LIST START
        $city = $this->City->find('all',array('fields'=>array('City.id','City.name'), 'order'=>array('City.name ASC')));
        $totalCity=count($city);
        $cityList=array();
        $cityList['']='Select City';
        for($i=0;$i<$totalCity;$i++){
            $cityList[$city[$i]['City']['id']] = $city[$i]['City']['name']; 
        }
        $this->set('cities',$cityList);

    }
    
    public function admin_edit($id=null){
        
        if($this->request->is('post')){
            $this->User->id=$id; 
            $fieldList = array('firstname','lastname','address','phone','mobile','city','state','zipcode','country','active','newsletter');
            
            if(!empty($this->request->data["User"]['password'])){
                 $fieldList[]='password';
                 $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
            }
            
            if ($this->User->save($this->request->data,false,$fieldList)){               
                // ADD ENTRY IN NEWSLETTER START
                $check_subscriber = $this->NewsletterSubscriber->find('first',array('fields'=>array('NewsletterSubscriber.id','NewsletterSubscriber.is_subscribed'),'conditions'=>array('NewsletterSubscriber.subscriber_email'=>$this->request->data['User']['email'])));
                $num = count($check_subscriber);
                if($num>0){
                    $fieldList = array('firstname','lastname','is_subscribed');
                    $this->request->data['NewsletterSubscriber']['firstname']=$this->request->data['User']['firstname'];
                    $this->request->data['NewsletterSubscriber']['lastname']=$this->request->data['User']['lastname'];
                    $this->request->data['NewsletterSubscriber']['is_subscribed']=$this->request->data['User']['newsletter'];
                    $this->NewsletterSubscriber->id=$check_subscriber['NewsletterSubscriber']['id'];
                    $this->NewsletterSubscriber->save($this->request->data,false,$fieldList);
                }
                // ADD ENTRY IN NEWSLETTER END
                
                $this->Session->setFlash('<div class="alert alert-info">User updated successfully.</div>');
                $this->redirect('/admin/users/');
            }else{
                $this->Session->setFlash('<div class="alert alert-error">User not updated, Please, try again.</div>');
                $this->redirect('/admin/users/');
            }
        }
        
        $this->request->data = $this->User->find("first",array("conditions"=>array("id"=>$id)));
        /// COUNTRY LIST START
        $country = $this->Country->find('all',array('fields'=>array('Country.id','Country.name'),'order'=>array('Country.name ASC')));
        $TotalCountry=count($country);
        $countryList=array();
        $countryList[]='Select Country';
        for($i=0;$i<$TotalCountry;$i++){
            $countryList[$country[$i]['Country']['name']] = $country[$i]['Country']['name']; 
        }
        $this->set('countries',$countryList);  
        /// COUNTRY LIST END

        /// State LIST START
        $state = $this->State->find('all',array('fields'=>array('State.id','State.name'),'order'=>array('State.name ASC')));
        $totalState=count($state);        
        $stateList=array();
        $stateList[]='Select State';
        for($i=0;$i<$totalState;$i++){
            $stateList[$state[$i]['State']['id']] = $state[$i]['State']['name']; 
        }
        $this->set('states',$stateList);

        /// City LIST START
        $city = $this->City->find('all',array('fields'=>array('City.id','City.name'), 'conditions'=>array('City.state_id'=>$this->request->data['User']['state']), 'order'=>array('City.name ASC')));
        $totalCity=count($city);
        $cityList=array();
        $cityList[]='Select City';
        for($i=0;$i<$totalCity;$i++){
            $cityList[$city[$i]['City']['id']] = $city[$i]['City']['name']; 
        }
        $this->set('cities',$cityList);
    }
    
    public function admin_delete($id=null){
        
        if($this->User->delete($id)){
            $this->Session->setFlash('<div class="alert alert-info">User successfully deleted!</div>'); 
            $this->redirect("/admin/users/");
        }else{
            $this->Session->setFlash('<div class="alert alert-info">User Not deleted, Please try again!</div>'); 
            $this->redirect("/admin/users/");
        }
    }
    
    public function admin_active($id=null,$active=null){
        $this->User->id=$id;
        if($this->User->saveField("active",$active)){
            $this->Session->setFlash('<div class="alert alert-info">User status updated successfully!</div>'); 
            $this->redirect("/admin/users/");
        }else{
            $this->Session->setFlash('<div class="alert alert-info">User status not updated, Please try again!</div>'); 
            $this->redirect("/admin/users/");
        }
    }
    
    public function registration(){

        $this->autoLayout = false;
        $this->autoRender = false;

        #################### Start facebook login ####################

        if (!session_id()) {
            session_start();
        }
        
        require_once 'facebook-php-sdk/autoload.php';
        // $appId = '2393999827344571'; //Facebook App ID
        // $appSecret = 'dba6a80b9c704cbc07026ce874e0c5b4'; //Facebook App Secret

        $appId = '485073262288746'; //Facebook App ID
        $appSecret = 'c1b92dcaddc2ee8e6e4a079a67abe247'; //Facebook App Secret
        // $redirectURL = 'http://localhost/ginder/users/registration?facebook=1'; //Callback URL for localhost
        $redirectURL = 'https://ginder.in/users/registration?facebook=1'; //Callback URL for live

        /* $appId = '1836075916642929'; //Facebook App ID
          $appSecret = '353e5b95a79d5f0ddf12ef5166b7b5a6'; //Facebook App Secret
          $redirectURL = 'http://beatechexpert.in/users/registration?facebook=1'; //Callback URL */

        $fbPermissions = array('email');  //Optional permissions

        $fb = new Facebook(array(
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.2',
        ));
        // Get redirect login helper
        $helper = $fb->getRedirectLoginHelper();

        if (isset($_GET['state'])) {
            $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }

        if (isset($_REQUEST['facebook'])) {
            // Try to get access token
            try {
                if (isset($_SESSION['facebook_access_token'])) {
                    $accessToken = $_SESSION['facebook_access_token'];
                } else {
                    $accessToken = $helper->getAccessToken();
                }
            } catch (FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        }
        // echo "access token: ".$accessToken; exit;

        if (isset($accessToken)) {
            if (isset($_SESSION['facebook_access_token'])) {
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            } else {
                // Put short-lived access token in session
                $_SESSION['facebook_access_token'] = (string) $accessToken;
                // OAuth 2.0 client handler helps to manage access tokens
                $oAuth2Client = $fb->getOAuth2Client();
                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                // Set default access token to be used in script
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }

            // Redirect the user back to the same page if url has "code" parameter in query string
            if (isset($_GET['code'])) {
                //header('Location: ./');
            }

            // Getting user facebook profile info
            try {
                $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
                $fbUserProfile = $profileRequest->getGraphNode()->asArray();
            } catch (FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                session_destroy();
                // Redirect user back to app login page
                header("Location: ./");
                exit;
            } catch (FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            // Get logout url            

            if (isset($_REQUEST['reset'])) {
                //$logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL . 'logout.php');
                $this->set('msg', 'Logout');
                //unset($_SESSION['token']);
                $this->Session->delete($accessToken);
                //Destroy entire session
                session_destroy();
                $this->redirect($this->Auth->logout());
            }

            // Render facebook profile data
            if (!empty($fbUserProfile['id'])) {

                // echo "<pre>";
                // print_r($fbUserProfile);
                // exit;

                $user_id = $fbUserProfile['id'];
                $email = $fbUserProfile['email'];
                $first_name = $fbUserProfile['first_name'];
                $last_name = $fbUserProfile['last_name'];

                $result = $this->User->find('count', array('conditions' => array('fbid' => $user_id)));
                if ($result > 0) {
                    //$msg = 'Welcome back ' . $user_names[0] . '!<br />'; //$msg .= '&nbsp;Email: ' . $email . '<br />';                        
                } else {
                    $this->User->query("INSERT INTO users (fbid, firstname, lastname, email, active, created, modified) VALUES ($user_id, '$first_name', '$last_name', '$email', 1, NOW(), NOW())");
                }
                $userEmail = $this->User->find('first', array('conditions' => array('User.email' => $email))); //get the user id and name in users table

                $this->Auth->login($userEmail['User']);

                $this->Session->write("userId", $userEmail['User']['id']);
                $this->Session->write("userName", $userEmail['User']['firstname']);
                $this->Session->write("cartstep", 2);
                $this->redirect("/homes/index");
                exit();
                //$output .= '<br/>Logout from <a href="' . $logoutURL . '">Facebook</a>';
            } else {
                $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
                $this->set('output', $output);
                $this->redirect("/homes/index");
                exit();
            }
        }
        #################### End facebook login ####################

        ########## Google Settings.. Client ID, Client Secret #############

        
        if (!isset($_REQUEST['facebook'])) {
            // $google_client_id = '433895544038-8ft63rfa9itmmjra2i3flgnd71vmmj5g.apps.googleusercontent.com';
            // $google_client_secret = 'zMYZtEHkezzi3cm7BMJ94YlZ';
            // $google_redirect_url = 'https://ginder.in/revamp_by_gautam/users/registration'; //http://localhost/google-login/
            // $google_developer_key = 'AIzaSyC6cd0UAq06soiNYOlZxq041y0UBg2aSLE';
            
            $google_client_id = '710177811137-o4uof092e1rl8a1qbpgm7ubu1nhr41tg.apps.googleusercontent.com';
            $google_client_secret = 'Nlx7557vg6-3BSWZYiLnRi6G';
            $google_redirect_url = 'https://ginder.in/users/registration'; //http://localhost/google-login/
            $google_developer_key = 'AIzaSyCNjJLK3iE0sGT0KA-KvwDnL4l6LvuHS7k';

        //include google api files
        require_once 'src/Google_Client.php';
        require_once 'src/contrib/Google_PlusService.php';
        require_once 'src/contrib/Google_Oauth2Service.php';

        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to localhost');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);

        $google_oauthV2 = new Google_Oauth2Service($gClient);

        //   //If user wish to log out, we just unset Session variable
        if (isset($_REQUEST['reset'])) {
            $this->set('msg', 'Logout');
            //unset($_SESSION['token']);
            $this->Session->delete('token');
            $gClient->revokeToken();
            //Destroy entire session
            session_destroy();
            //header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
            $this->redirect($this->Auth->logout());
        }

        //Redirect user to google authentication page for code, if code is empty.
        //Code is required to aquire Access Token from google
        //Once we have access token, assign token to session variable
        //and we can redirect user back to page and login.
        if (isset($_REQUEST['code'])) {
            $gClient->authenticate($_REQUEST['code']);
            $this->Session->write('token', $gClient->getAccessToken());
            $this->redirect(filter_var($google_redirect_url, FILTER_SANITIZE_URL), null, false);
            // header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
            return;
        }

        if ($this->Session->read('token')) {
            $gClient->setAccessToken($this->Session->read('token'));
        }

        if ($gClient->getAccessToken()) {
            //Get user details if user is logged in
            $user = $google_oauthV2->userinfo->get();
            //   echo "<pre>";
            //   print_r($user); exit;
            $user_id = $user['id'];
            $user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            //$profile_url = filter_var($user['link'], FILTER_VALIDATE_URL);
            $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);
            $personMarkup = "$email<div><img src='$profile_image_url?sz=50'></div>";
            $this->Session->write('token', $gClient->getAccessToken());
        } else {
            //get google login url
            $authUrl = $gClient->createAuthUrl();
        }

        if (isset($authUrl)) { //user is not logged in, show login button
            $this->set('authUrl', $authUrl);
        } else { // user logged in                    
            $result = $this->User->find('count', array('conditions' => array('google_id' => $user_id)));

            $user_names = explode(" ", $user_name);
            if ($result > 0) {
                //$msg = 'Welcome back ' . $user_names[0] . '!<br />'; //$msg .= '&nbsp;Email: ' . $email . '<br />';                        
            } else {
                $this->User->query("INSERT INTO users (google_id, firstname, lastname, email, active, created, modified) VALUES ($user_id, '$user_names[0]', '$user_names[1]', '$email', 1, NOW(), NOW())");
            }
            $userEmail = $this->User->find('first', array('conditions' => array('User.email' => $email))); //get the user id and name in users table

            $this->Auth->login($userEmail['User']);
            $this->Session->write("userId", $userEmail['User']['id']);
            $this->Session->write("userName", $userEmail['User']['firstname']);
            $this->redirect("/homes/index");
            exit();
        }
      }
      ################ End here to google login  ##########################


        if ($this->request->is('post')) {
            $msg = "";
            if(empty($this->request->data['reg_email']) || !preg_match(EMAIL_REGEX, $this->request->data['reg_email'])) {
                $msg ='<span style="color: #FF0000;">Please Enter Valid Email.</span>';
            }elseif(empty($this->request->data['reg_password'])) {
                $msg ='<span style="color: #FF0000;">Please Enter Password.</span>';
            }            

            if ($msg == ""){

                $this->request->data["User"]['email'] = $this->request->data['reg_email'];
                $this->request->data["User"]['password'] = $this->request->data['reg_password'];

                $pass = $this->request->data['User']['password'];
                $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
                $this->request->data['User']['activation_key'] = Security::hash($this->microtime_float(),PASSWORD_HASH_METHOD,true);
                $this->request->data['User']['active'] = 1;

                $user_data = $this->User->find('first', array('conditions' => array('email' => $this->request->data["User"]["email"])));
                
                if (!empty($user_data)) {
                    // $this->Session->setFlash('<span style="color: #00ABE7;">Your account has been already created but is Inactive, Please activate your account by email sent to you for activation !</span>');
                    echo "already_exist";
                } else {
                    $fields = array('email','password','activation_key','active');
                    
                    if ($this->User->save($this->request->data,false,$fields)){

                        $user_data = $this->User->find('first', array('conditions' => array('email' => $this->request->data["User"]["email"])));
                
                        if ($this->Auth->login($user_data['User'])) {
                            $this->Session->write("userId",$this->Auth->User('id'));
                            $this->Session->write("userName",$this->Auth->User('firstname'));
                            $this->Session->write("cartstep",2);
                        }

                        if ($_SERVER['HTTP_HOST']!='localhost') {
                            $email_template = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' =>1)));
                            if(empty($email_template)){
                                echo "No";
                                $this->Session->setFlash('<span style="color: #FF0000;">Email Template Doesn\'t exist !</span>');
                            }else{
                                $email = new CakeEmail();
                                $email->from(array($email_template['EmailTemplate']['from_email'] => $email_template['EmailTemplate']['from_name']));
                                $email->to(array($this->request->data['User']['email'] => $this->request->data['User']['email']));
                                $email->emailFormat('html');
                                $email->subject($email_template['EmailTemplate']['subject']);
                                $description = $email_template['EmailTemplate']['content'];
                                $description = str_replace('##first_name##', 'User', $description);
                                $description = str_replace('##email_address##', $this->request->data['User']['email'], $description);
                                $description = str_replace('##password##',$pass, $description);
                                // $description = str_replace('##activation_link##', '<a href="' . SITE_URL . 'users/activate/' . $this->request->data['User']['activation_key'] . '/' . $this->User->id . '">' . __('Click Here') . '</a>', $description);
                                //echo $description; exit;
                                if($email->send($description))
                                {
                                    echo "yes";
                                }else{
                                    echo "No";
                                    // $this->Session->setFlash($msg);
                                }
                            }
                        }
                    }
                }
            } else {
                // $this->Session->setFlash($msg);
                echo "no";
            }
        }
        

        // if ($this->request->is('post')){

        //     $this->autoLayout = false;
        //     $this->autoRender = false;

        //     if(empty($this->request->data)){
        //         require_once 'faceconn/facebook.php';
        //         require_once 'faceconn/faceconn/faceconn.php';
        //         $facebook = new Facebook(AppConfig::GetKeyArray());
        //         $facebookUser = $facebook->getUser();
        //         $loggedUser = $facebook->api($facebookUser);
               
        //         if (!empty($loggedUser['id'])) {
        //             $this->User->recursive = -1;
        //             $user_data = $this->User->findByFbid($loggedUser['id']);
        //             if (!empty($user_data)) {
        //                 if ($user_data['User']['active']==1) {
        //                     if ($this->Auth->login($user_data['User'])) {
        //                         $this->Session->write("userId",$this->Auth->User('id'));
        //                         $this->Session->write("userName",$this->Auth->User('firstname'));
        //                         $this->Session->write("cartstep",2);  
        //                         $this->redirect("/users/index");
        //                     }
        //                 }else{
        //                     $this->Session->setFlash('<span style="color: #00ABE7;">Your account has been already created but is Inactive, Please activate your account by email sent to you for activation !</span>');
        //                 }
        //             }else{
        //                 $this->request->data['User']['fbid'] = @$loggedUser['id'];
        //                 $this->request->data['User']['email'] = @$loggedUser['email'];
        //                 $this->request->data['User']['firstname'] = @$loggedUser['first_name'];
        //                 $this->request->data['User']['lastname'] = @$loggedUser['last_name'];
        //             }
        //         }
        //     }else{
        //         $msg = "";
        //         if(empty($this->request->data['reg_email']) || !preg_match(EMAIL_REGEX, $this->request->data['reg_email'])) {
        //             $msg ='<span style="color: #FF0000;">Please Enter Valid Email.</span>';
        //         }elseif(empty($this->request->data['reg_password'])) {
        //             $msg ='<span style="color: #FF0000;">Please Enter Password.</span>';
        //         }

        //         if ($msg == ""){

        //             $this->request->data["User"]['email'] = $this->request->data['reg_email'];
        //             $this->request->data["User"]['password'] = $this->request->data['reg_password'];

        //             $pass = $this->request->data['User']['password'];
        //             $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
        //             $this->request->data['User']['activation_key'] = Security::hash($this->microtime_float(),PASSWORD_HASH_METHOD,true);
        //             $this->request->data['User']['active'] = 1;

        //             $user_data = $this->User->find('first', array('conditions' => array('email' => $this->request->data["User"]["email"])));
                    
        //             if (!empty($user_data)) {
        //                 // $this->Session->setFlash('<span style="color: #00ABE7;">Your account has been already created but is Inactive, Please activate your account by email sent to you for activation !</span>');
        //                 echo "already_exist";
        //             } else {
        //                 $fields = array('email','password','activation_key','active');
                        
        //                 if ($this->User->save($this->request->data,false,$fields)){

        //                     $user_data = $this->User->find('first', array('conditions' => array('email' => $this->request->data["User"]["email"])));
                    
        //                     if ($this->Auth->login($user_data['User'])) {
        //                         $this->Session->write("userId",$this->Auth->User('id'));
        //                         $this->Session->write("userName",$this->Auth->User('firstname'));
        //                         $this->Session->write("cartstep",2);
        //                     }

        //                     if ($_SERVER['HTTP_HOST']!='localhost') {
        //                         // $email_template = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' =>1)));
        //                         // $email = new CakeEmail();
        //                         // $email->from(array($email_template['EmailTemplate']['from_email'] => $email_template['EmailTemplate']['from_name']));
        //                         // $email->to(array($this->request->data['User']['email'] => $this->request->data['User']['email']));
        //                         // $email->emailFormat('html');
        //                         // $email->subject($email_template['EmailTemplate']['subject']);
        //                         // $description = $email_template['EmailTemplate']['content'];
        //                         // // $description = str_replace('##first_name##', $this->request->data['User']['firstname'], $description);
        //                         // $description = str_replace('##email_address##', $this->request->data['User']['email'], $description);
        //                         // $description = str_replace('##password##',$pass, $description);
        //                         // // $description = str_replace('##activation_link##', '<a href="' . SITE_URL . 'users/activate/' . $this->request->data['User']['activation_key'] . '/' . $this->User->id . '">' . __('Click Here') . '</a>', $description);
        //                         // $email->send($description);
        //                     }
        //                     // $this->redirect('/users/registration/');
        //                     echo "yes";
        //                 }
        //             }
        //         } else {
        //             // $this->Session->setFlash($msg);
        //             echo "no";
        //         }
        //     }
        // }

        

        // $country = $this->Country->find('all',array('fields'=>array('Country.id','Country.name'),'order'=>array('Country.name ASC')));
        // $TotalCountry=count($country);
        // $countryList=array();
        // $countryList[]='Select Country';
        // for($i=0;$i<$TotalCountry;$i++){
        //     $countryList[$country[$i]['Country']['name']] = $country[$i]['Country']['name']; 
        // }
        // $this->set('countryList',$countryList);  
    }
    
    public function activate($key,$user_id){
        $this->autoLayout = false;
        $this->autoRender = false;
        $user = $this->User->findByIdAndActivationKey($user_id,$key);
        if (!empty($user['User']['id'])) {
            $data = array();
            $data['User']['active']=1;
            $data['User']['activation_key']='';
            $data['User']['id']=$user['User']['id'];
            if($this->User->save($data)) {
                
                // ADD ENTRY IN NEWSLETTER START
                $fieldList = array('subscriber_email','is_subscribed','firstname','lastname');
                $this->request->data['NewsletterSubscriber']['subscriber_email']=$user['User']['email'];
                $this->request->data['NewsletterSubscriber']['firstname']=$user['User']['firstname'];
                $this->request->data['NewsletterSubscriber']['lastname']=$user['User']['lastname'];
                $this->request->data['NewsletterSubscriber']['is_subscribed']=$user['User']['newsletter'];
                $this->NewsletterSubscriber->save($this->request->data,false,$fieldList);
                // ADD ENTRY IN NEWSLETTER END
                
                $this->Session->setFlash('<span style="color: #00ABE7;">Your account has been activated successfully, Please login below !</span>');
            }else{
                $this->Session->setFlash('<span style="color: #FF0000;">Your account couldn\'t be activated, Please try again !</span>');
            }
        } else{
            $this->Session->setFlash('<span style="color: #FF0000;">The activation link bas been expired !</span>');
        }
        $this->redirect('/users/registration/');
    }
    
    public function get_captcha(){
        $this->autoLayout = false;
        $this->autoRender = false;
        $this->Captcha->generate_image();
    }
    
    public function login(){
        if($this->request->is('post')){
        
            $this->autoLayout = false;
            $this->autoRender = false;

           if($this->request->data){
                $msg = ""; 
                if(empty($this->request->data['login_email']) || !preg_match(EMAIL_REGEX, $this->request->data['login_email'])) {
                    $msg ='<span style="color: #FF0000;">Please Enter Valid Email.</span>';
                }elseif(empty($this->request->data['login_password'])) {
                    $msg ='<span style="color: #FF0000;">Please Enter Password.</span>';
                }                
                if($msg==""){
                    $this->request->data["User"]['email'] = $this->request->data['login_email'];
                    $this->request->data["User"]['password'] = $this->request->data['login_password'];
                    
                    if($this->Auth->login()){
                      $this->Session->write("userId",$this->Auth->User('id'));
                      $this->Session->write("userName",$this->Auth->User('firstname'));
                      $this->Session->write("cartstep",2);
                      echo "yes";
                      //$this->redirect("/users/index");
                     }else{
                        // $this->Session->setFlash('<span style="color: #FF0000;">Incorrect username or password OR You are an inactive user !</span>');
                        echo "No";
                    }
                }else{
                    $this->Session->setFlash($msg);
                    echo "No";
                }
                //$this->redirect('/users/registration/');
            }
        }else{
            $this->redirect('index');
        }
    }
    
    public function logouts(){
        
        //check for FB login, if yes then delete that session
        // require_once 'faceconn/facebook.php';
        // require_once 'faceconn/faceconn/faceconn.php';
        // $facebook = new Facebook(AppConfig::GetKeyArray());
        // $facebookUser = $facebook->getUser();
        // if($facebookUser) {
        //     $facebook->destroySession();  
        // }

        $this->Session->delete('userId');
        $this->Session->delete('userName');
        $this->Session->destroy();
        //$this->Session->setFlash('<span style="color: #00ABE7;">You have successfully logged out !</span>');
        $this->redirect($this->Auth->logout());
    }
    
    public function forgot_password(){

        $this->autoLayout = false;
        $this->autoRender = false;
        
        if ($this->request->is('post') && !empty($this->request->data)) {
            if (!preg_match(EMAIL_REGEX, $this->request->data['forgot_email'])) {
                echo "No";
            }elseif ($this->User->find('count', array('conditions' => array('email' => $this->request->data['forgot_email']))) == 0){
                echo "No";
            } else {
                $user = $this->User->find('first', array('conditions' => array('email' => $this->request->data['forgot_email'])));
                $new_pass = $this->_get_rand_id(8);
                $this->User->id = $user['User']['id'];

                if ($this->User->saveField('password', Security::hash($new_pass,PASSWORD_HASH_METHOD,true))) {
                    if($_SERVER['HTTP_HOST']!='localhost'){
                        $email_template = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' =>2)));
                        if(empty($email_template)){
                            echo "No";
                        }else{
                            $email = new CakeEmail();
                            $email->from(array($email_template['EmailTemplate']['from_email'] => $email_template['EmailTemplate']['from_name']));
                            $email->to(array($user['User']['email'] => $user['User']['firstname'] . ' ' . $user['User']['lastname']));
                            $email->emailFormat('html');
                            $email->subject($email_template['EmailTemplate']['subject']);
                            $description = $email_template['EmailTemplate']['content'];

                            $description = str_replace('##first_name##', 'User', $description);
                            $description = str_replace('##email_address##', $user['User']['email'], $description);
                            $description = str_replace('##password##', $new_pass, $description);
                            if($email->send($description)){
                                echo "yes";
                            }else{
                                echo "No";
                            }
                        }
                    }
                }else{
                    $this->Session->setFlash('<span style="color: #FF0000;">Password not Reset, Please try again !</span>');
                }
            }
        }
    }
     
    public function index_olds(){
        
        $user_id=$this->Session->read("userId");
        
        if ($this->request->is('post')){
            
            $this->request->data["User"]['id']=$user_id;
            $fieldList = array('firstname','lastname','address','phone','mobile','city','state','zipcode','country','newsletter');
          
            if(!empty($this->request->data["User"]['password'])){
                 $fieldList[]='password';
                 $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
            }
            
            if ($this->User->save($this->request->data,false,$fieldList)){
                
                // ADD ENTRY IN NEWSLETTER START
                $check_subscriber = $this->NewsletterSubscriber->find('first',array('fields'=>array('NewsletterSubscriber.id','NewsletterSubscriber.is_subscribed'),'conditions'=>array('NewsletterSubscriber.subscriber_email'=>$this->request->data['User']['email'])));
                $num = count($check_subscriber);
                if($num>0){
                    $fieldList = array('firstname','lastname','is_subscribed');
                    $this->request->data['NewsletterSubscriber']['firstname']=$this->request->data['User']['firstname'];
                    $this->request->data['NewsletterSubscriber']['lastname']=$this->request->data['User']['lastname'];
                    $this->request->data['NewsletterSubscriber']['is_subscribed']=$this->request->data['User']['newsletter'];
                    $this->NewsletterSubscriber->id=$check_subscriber['NewsletterSubscriber']['id'];
                    $this->NewsletterSubscriber->save($this->request->data,false,$fieldList);
                }
                // ADD ENTRY IN NEWSLETTER END
                
                $this->Session->setFlash('<span style="color: #00ABE7;">Account Updated successfully!</span>');
                $this->redirect('/users/index/');
            }else{
                $this->Session->setFlash('<span style="color: #FF0000;">Account Not Updated, Please try again!</span>');
                $this->redirect('/users/index/');
            }
            
        }
        
        $this->request->data = $this->User->find("first",array("conditions"=>array("id"=>$user_id)));
        
        /// COUNTRY LIST START
        $country = $this->Country->find('all',array('fields'=>array('Country.id','Country.name'),'order'=>array('Country.name ASC')));
        $TotalCountry=count($country);
        $countryList=array();
        $countryList[]='Select Country';
        for($i=0;$i<$TotalCountry;$i++){
            $countryList[$country[$i]['Country']['name']] = $country[$i]['Country']['name']; 
        }
        $this->set('countries',$countryList);  
        /// COUNTRY LIST END
    }
    
    public function shipping_billing(){
        
        $user_id=$this->Session->read("userId");
        
        if ($this->request->is('post')){
            
            $this->request->data["User"]['id']=$user_id;
            $fieldList = array('ship_firstname','ship_lastname','ship_address','ship_phone','ship_mobile','ship_city','ship_state','ship_zipcode','ship_country',
                               'bill_firstname','bill_lastname','bill_address','bill_phone','bill_mobile','bill_city','bill_state','bill_zipcode','bill_country' );
          
            if ($this->User->save($this->request->data,false,$fieldList)){
                
                $this->Session->setFlash('<span style="color: #00ABE7;">Shipping And Billing Updated successfully!</span>');
                $this->redirect('/users/shipping_billing/');
            }else{
                $this->Session->setFlash('<span style="color: #FF0000;">Shipping And Billing Not Updated, Please try again!</span>');
                $this->redirect('/users/shipping_billing/');
            }
            
        }
        
        $this->request->data = $this->User->find("first",array("conditions"=>array("id"=>$user_id)));
        /// COUNTRY LIST START
        $country = $this->Country->find('all',array('fields'=>array('Country.id','Country.name'),'order'=>array('Country.name ASC')));
        $TotalCountry=count($country);
        $countryList=array();
        $countryList[]='Select Country';
        for($i=0;$i<$TotalCountry;$i++){
            $countryList[$country[$i]['Country']['name']] = $country[$i]['Country']['name']; 
        }
        $this->set('countries',$countryList);  
        /// COUNTRY LIST END
    }
    
    public function wishlist(){
      $user_id = $this->Session->read('userId');
      
      $wishlist_products = $this->Product->find('all', 
                            array("fields" => array('Product.id','Product.article_no','Product.name','Product.image','Product.description','Product.price','Product.price_actual,WishList.id','WishList.attribute_name'),
                            'joins' => array(array(
                                       'table' => 'wish_lists',
                                        'alias' => 'WishList',
                                        'type' => 'INNER',
                                        'conditions' => array('WishList.product_id = Product.id',
                                                              'WishList.user_id'=> $user_id
                                                            )
                                        )
                                    ),
                                    "conditions" => array("Product.active" => 1)
                                 )
                           );
     $this->set("wishlist_products",$wishlist_products);
    }
    
    public function wishlist_delete($id=null){
        if($this->WishList->delete($id)){
            $this->Session->setFlash('<span style="color: #00ABE7;">Product is successfully deleted from your Wishlist !</span>'); 
            $this->redirect("/users/wishlist/");
        }else{
            $this->Session->setFlash('<span style="color: #FF0000;">Product not deleted, Please try again !</span>'); 
            $this->redirect("/users/wishlist/");
        }
    }
    
    public function order_list(){
        $this->paginate=array('Order'=>array('all','fields'=>array('Order.id','Order.order_date','Order.order_total','Order.order_status','Order.bill_firstname','Order.bill_lastname'), "conditions" => array("user_id" => $this->Session->read("userId")),'limit' =>PAGING, 'order'=>array('Order.created'=>"DESC")));
        $orderList = $this->paginate('Order');
        $this->set("orderList", $orderList);
    }
    
    public function order_detail($id=null){
        $orderData = $this->Order->find("first", array("conditions" => array("Order.id"=>$id)));
        
        $this->OrderItem->bindModel(array('belongsTo' => array('Product')));
        $orderItem = $this->OrderItem->find("all", array("fields" => array("OrderItem.*","Product.name"),"conditions"=>array("order_id" => $id)));
        
        $this->set("orderData", $orderData['Order']);
        $this->set("orderItem", $orderItem);
    }

    public function post_an_ad(){

        $user_id=$this->Session->read("userId");

        //Start to paytm payment redirect
        if(isset($_POST['ORDERID']) && isset($_POST['MID']))
        {
            require_once 'config_paytm.php';
            require_once 'encdec_paytm.php';
            
            $paytmChecksum = "";
            $paramListNew = array();
            $isValidChecksum = "FALSE";

            $paramListNew = $_POST;
            $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

            //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
            $isValidChecksum = verifychecksum_e($paramListNew, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

            if($isValidChecksum == "TRUE") {
                echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
                if ($_POST["STATUS"] == "TXN_SUCCESS") {
                    //Process your transaction here as success transaction.
                    //Verify amount & order id received from Payment gateway with your application's order id and amount.
                    //Update query should be here

                    //featured_product column should be active

                    $orderID = explode('-', $_POST['ORDERID']);
                    $fieldList = array('featured_product');                    
                    $this->request->data['Product']['id'] = $orderID[0];
                    $this->request->data['Product']['featured_product'] = 1;
                    $this->Product->save($this->request->data, false, $fieldList);

                    //paytm transaction added in the database
                    $fieldListTransaction = array('product_id', 'user_id', 'transaction_id', 'transaction_amount', 'bank_txn_id', 'bank_name', 'gateway_name', 'created');
                    $this->request->data['ProductTransaction']['product_id'] = $orderID[0];
                    $this->request->data['ProductTransaction']['user_id'] = $user_id;
                    $this->request->data['ProductTransaction']['transaction_id'] = $_POST['TXNID'];
                    $this->request->data['ProductTransaction']['transaction_amount'] = $_POST['TXNAMOUNT'];
                    $this->request->data['ProductTransaction']['bank_txn_id'] = $_POST['BANKTXNID'];
                    $this->request->data['ProductTransaction']['bank_name'] = $_POST['BANKNAME'];
                    $this->request->data['ProductTransaction']['gateway_name'] = $_POST['GATEWAYNAME'];
                    $this->request->data['ProductTransaction']['created'] = $_POST['TXNDATE'];
                    $this->ProductTransaction->save($this->request->data, false, $fieldListTransaction);

                    $this->Session->setFlash("<div class='alert alert-info'>Transaction status is success and product added successfully.</div>");
                    $this->redirect("/users/index");
                } else {
                    $this->Session->setFlash("<div class='alert alert-info'>Transaction status is failure.</div>");
                    $this->redirect("/users/index");
                }

                if (isset($_POST) && count($_POST)>0 )
                {
                    foreach($_POST as $paramName => $paramValue) {
                            echo "<br/>" . $paramName . " = " . $paramValue;
                    }
                }
            } else {
                //Process transaction as suspicious.
                $this->Session->setFlash("<div class='alert alert-info'>Checksum mismatched</div>");
                $this->redirect("/users/post_an_edit/".$_POST['ORDERID']);
            }
        }
        //End here for payment redirect

        if($this->request->is('post')){
            // echo "<pre>";
            // print_r($this->request->data);
            // exit;
            
            $this->Product->bindModel(array('hasAndBelongsToMany' => array("Category")), false);
            if (!empty($this->request->data)) {
                $fieldList = array('user_id','name', 'description', 'price', 'price_option', 'new_product', 'active', 'Category.name as cat_name');

                $msg = "";
                ////////////////////// ADD PRODUCT IMAGES START ////////////////////////////
                if (!empty($this->request->data["Product"]["image"]['name'])) {
                    if ($this->Image->set_paths(WWW_ROOT . PRODUCT_IMAGE_UPLOAD, WWW_ROOT . PRODUCT_IMAGE_UPLOAD, WWW_ROOT . PRODUCT_IMAGE_UPLOAD . '/thumbnail/')) {
                        $this->request->data['Product']['image'] = $this->Image->upload_image('Product.image');
                        if ($this->request->data['Product']['image'] != "" && $this->request->data['Product']['image'] != false) {
                            $this->Image->thumb(WWW_ROOT . PRODUCT_IMAGE_UPLOAD . $this->request->data['Product']['image'], WWW_ROOT . PRODUCT_IMAGE_UPLOAD . "thumbnail/", PRODUCT_THUMB_WIDTH, PRODUCT_THUMB_HEIGHT);
                            $this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->request->data['Product']['image'],WWW_ROOT.PRODUCT_IMAGE_UPLOAD."large/",PRODUCT_BIG_WIDTH,PRODUCT_BIG_HEIGHT);
                            $fieldList[] = 'image';
                        } else {
                            $msg = 'Product image wrong file type.';
                        }
                    }
                }  ////////////////////// ADD PRODUCT IMAGES END //////////////////////////// 

                if ($msg == "") {
                    $this->request->data['Product']['user_id'] = $user_id;
                    if ($this->Product->save($this->request->data, false, $fieldList)) {
                        $pro_id = $this->Product->id;

                        ////////////////////// ADD GALLERY IMAGES START ////////////////////////////
                        foreach ($this->request->data['ProductImage'] as $key => $value) {
                            if ($value['product_image']['name'] != "" && $value['product_image']['error'] == UPLOAD_ERR_OK) {
                                $file_name = $this->microtime_float() . $value['product_image']['name'];
                                if (move_uploaded_file($value['product_image']['tmp_name'], WWW_ROOT . PRODUCT_IMAGE_UPLOAD . $file_name)) {
                                    if ($this->Image->set_paths(WWW_ROOT . PRODUCT_IMAGE_UPLOAD, WWW_ROOT . PRODUCT_IMAGE_UPLOAD)) {
                                        $this->Image->thumb(WWW_ROOT . PRODUCT_IMAGE_UPLOAD . $file_name, WWW_ROOT . PRODUCT_IMAGE_UPLOAD . "thumbnail/", PRODUCT_THUMB_WIDTH, PRODUCT_THUMB_HEIGHT);
                                        $this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$file_name,WWW_ROOT.PRODUCT_IMAGE_UPLOAD."large/",PRODUCT_BIG_WIDTH,PRODUCT_BIG_HEIGHT);
                                    }
                                    $this->request->data['ProductImage'][$key]['product_id'] = $pro_id;
                                    $this->request->data['ProductImage'][$key]['product_image'] = $file_name;
                                } else {
                                    unset($this->request->data['ProductImage'][$key]);
                                }
                            } else {
                                unset($this->request->data['ProductImage'][$key]);
                            }
                        }

                        if (count($this->request->data['ProductImage']) > 0) {
                            $this->ProductImage->saveAll($this->request->data['ProductImage']);
                        }   
                        ////////////////////// ADD GALLERY IMAGES END ////////////////////////////

                        if (count($this->request->data['ProductContact']) > 0) {
                            $this->request->data['ProductContact']['product_id'] = $pro_id;
                            $this->ProductContact->save($this->request->data['ProductContact']);
                        }   
                        ////////////////////// ADD CONTACT DETAILS FOR PRODUCT END ////////////////////////////

                        // ADD ATTRIBUTES FOR PRODUCT START/////////////////
                        if (isset($this->request->data['attributes']) && count($this->request->data['attributes']) > 0) {
                            foreach ($this->request->data['attributes'] as $key => $value) {
                                if (count($value) > 0) {
                                    foreach ($value as $attribute_value_id) {
                                        $this->ProductAttributeRelation->create();
                                        $attrdata['ProductAttributeRelation']['product_id'] = $pro_id;
                                        $attrdata['ProductAttributeRelation']['attribute_id'] = $key;
                                        $attrdata['ProductAttributeRelation']['attribute_value_id'] = $attribute_value_id;
                                        $this->ProductAttributeRelation->save($attrdata);
                                    }
                                }
                            }
                        } // ADD ATTRIBUTES FOR PRODUCT END/////////////////


                        //Get Paytm payment details when we choose featured product
                        if(isset($this->request->data['Product']['featured_product']) && ($this->request->data['Product']['featured_product']==1)){
                            //Start to paytm payment
                            require_once 'config_paytm.php';
                            require_once 'encdec_paytm.php';

                            $ORDER_ID = $pro_id."-".$this->request->data['Product']['ORDER_ID'];
                            $CUST_ID = $user_id;
                            $INDUSTRY_TYPE_ID = 'Retail';
                            $CHANNEL_ID = 'WEB';
                            $TXN_AMOUNT = $this->request->data['Product']['transaction_amount'];

                            // Create an array having all required parameters for creating checksum.
                            $paramList["MID"] = PAYTM_MERCHANT_MID;
                            $paramList["ORDER_ID"] = $ORDER_ID;
                            $paramList["CUST_ID"] = $CUST_ID;
                            $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
                            $paramList["CHANNEL_ID"] = $CHANNEL_ID;
                            $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
                            $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

                            // $paramList["CALLBACK_URL"] = "http://localhost/ginder/users/post_an_ad"; //Callback URL for localhost
                            $paramList["CALLBACK_URL"] = 'https://ginder.in/users/post_an_ad'; //Callback URL for live

                            //Here checksum string will return by getChecksumFromArray() function.
                            $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);                        
                            ?>
                            <center><h1>Please do not refresh this page...</h1></center>
                            <form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
                                <table border="1">
                                    <tbody>
                                    <?php
                                    foreach($paramList as $name => $value) {
                                        echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
                                    }
                                    ?>
                                    <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
                                    </tbody>
                                </table>
                                <script type="text/javascript">
                                    document.f1.submit();
                                </script>
                            </form>
                            <?php
                            //End here paytm payment details
                        } else{
                            $this->Session->setFlash("<div class='alert alert-info'>Product added successfully.</div>");                        
                            $this->redirect("/users/index");
                        }
                    } else {
                        $this->Session->setFlash("<div class='alert alert-error'>Product could not be added.</div>");
                    }
                }
                $this->Session->setFlash("<div class='alert alert-error'>" . $msg . "</div>");
            }

            $parent_id=0;
            $catlist = $this->Category->find("all",array("fields"=>array("id","name"),"conditions"=>array("parent_id"=>0,"active"=>1),"order"=>"Category.name"));
            // $catoptions = array("0"=>"--Select--");
            for($i=0;$i<count($catlist);$i++)
            {
                $catoptions[$catlist[$i]['Category']['id']] = $catlist[$i]['Category']['name'];
            }
            $this->set("catoptions",$catoptions);
            // $this->set("parent_id",$parent_id); 
            
        }
        $loggedInUserDetails = $this->User->find("first",array("conditions"=>array("id"=>$user_id)));
        $this->set("loggedInUserDetails",$loggedInUserDetails); // get the UserDetails
        
        // echo "<pre>";
        // print_r($loggedInUserDetails);

        $parent_id=0;
        $catlist = $this->Category->find("all",array("fields"=>array("id","name"),"conditions"=>array("parent_id"=>0,"active"=>1),"order"=>"Category.name"));
        // $catoptions = array("0"=>"--Select--");
        for($i=0;$i<count($catlist);$i++)
        {
            $catoptions[$catlist[$i]['Category']['id']] = $catlist[$i]['Category']['name'];
        }
        $this->set("catoptions",$catoptions);
        // $this->set("parent_id",$parent_id);

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
        $city = $this->City->find('all',array('fields'=>array('City.id','City.name'), 'conditions'=>array('City.state_id'=>$loggedInUserDetails['User']['state']), 'order'=>array('City.name ASC')));
        $totalCity=count($city);
        $cityList=array();
        $cityList[]='Select City';
        for($i=0;$i<$totalCity;$i++){
            $cityList[$city[$i]['City']['id']] = $city[$i]['City']['name']; 
        }
        $this->set('cities',$cityList);
        
    }

    public function ajaxSubcategories() {
        $this->autoRender = false;
        // $this->loadModel('Subcategories');        
        
        // $catId = $this->params->query['catId'];
        $catId = $this->request->data['catId'];
        $category_id = $catId;
        // echo "id: ".$this->params->query['catId'];
        $subcategories = $this->Category->find("all",array("fields"=>array("id","name"),"conditions"=>array("parent_id"=>$category_id,"active"=>1),"order"=>"Category.name"));        
        $data = '<option value="0"> --Select --</option>';
        foreach($subcategories as $subcategory) {
            $data .= '<option value="'.$subcategory['Category']['id'].'">'.$subcategory['Category']['name'].'</option>';
        }
        // print_r($data);
        // exit;
        echo $data;
    }

    public function getAttributeLists() { //ATTRIBUTES LIST START///////////////////////////////////
        $this->autoRender = false;
        // $this->loadModel('Subcategories');        
        
        $catId = $this->request->data['catId'];
        $category_id = $catId;
         
        $AttributesArray = $this->ProductAttribute->find('all', array(
            'fields' => array('ProductAttribute.id', 'ProductAttribute.attribute_code', 'ProductAttributeValue.id', 'ProductAttributeValue.name', 'ProductAttributeValue.color_code', 'ProductAttributeValue.attribute_id'),
            'joins' => array(array(
                    'table' => 'categories_product_attributes',
                    'alias' => 'cpa',
                    'type' => 'INNER',
                    'conditions' => array('cpa.product_attribute_id=ProductAttribute.id'),
                    ),
                    array(
                        'table' => 'product_attribute_values',
                        'alias' => 'ProductAttributeValue',
                        'type' => 'INNER',
                        'conditions' => array('ProductAttributeValue.attribute_id=ProductAttribute.id'),
                        'order' => 'ProductAttributeValue.sort_order'
                    ),
                    array(
                        'table' => 'categories_product_attribute_values',
                        'alias' => 'cpav',
                        'type' => 'INNER',
                        'conditions' => array('cpav.product_attribute_value_id=ProductAttributeValue.id'),
                    )
            ),
            'conditions' => array('cpa.category_id'=>$category_id, 'cpav.category_id'=>$category_id, 'ProductAttribute.active' => 1, 'ProductAttributeValue.active' => 1),
            'order' => 'ProductAttribute.sort_order',
        ));

        $ProductAttributes = array();
        foreach ($AttributesArray as $values) {
            $id = $values['ProductAttribute']['id'];
            $ProductAttributes[$id] = array(
                'id' => $id,
                'name' => $values['ProductAttribute']['attribute_code']
            );
            foreach ($AttributesArray as $newVal) {
                if ($id == $newVal['ProductAttributeValue']['attribute_id']) {
                    $ProductAttributes[$id][$values['ProductAttribute']['attribute_code']][$newVal['ProductAttributeValue']['id']] = array(
                        'id' => $newVal['ProductAttributeValue']['id'],
                        'name' => $newVal['ProductAttributeValue']['name']
                    );
                }
            }
        }

        $data='';        
        $attribute_value=array();
        if(count($ProductAttributes)>0){
            foreach($ProductAttributes as $value)
            {
                $attribute_id=$value['id']; 
                if(!empty($value[$value['name']])){
                    $data .= '<div class="col-sm-12 col-lg-4 frm-mobtab-topbot">';                
                    $data .= '<label for="selectCategory" class="col-form-label">'.$value['name'].':</label>';
                    $data .= '<div class="col-sm-10 ctrl-field">';
                    $data .= '<select class="form-control" name="attributes['.$attribute_id.'][]" id="attributes_'.$attribute_id.'">';
                    foreach($value[$value['name']] as $val){
                        $attribute_value[$val['id']]=ucfirst($val['id']);
                        $data .= '<option value="'.$attribute_value[$val['id']].'">'.ucfirst($val['name']).'</option>';
                    }
                    $data .= '</select></div>';
                    $data .= '</div>';
                }
                unset($attribute_value);
            }
        }
        echo $data;
    }

    public function index(){
        
        $user_id=$this->Session->read("userId");
        
        // $condition_search = '';
        $condition_search = array('Product.user_id' => $user_id);
        // $searchKey = '';
        $page = 1;

        // if (!empty($this->request->data)) {
        //     if ($this->request->data['Product']['searchKey'] != '') {
        //         $searchKey = $this->request->data['Product']['searchKey'];
        //         $condition_search = array('OR' => array('Product.name LIKE' => '%' . $searchKey . '%', 'Product.description LIKE' => '%' . $searchKey . '%'));
        //     } elseif ($this->request->params['named']['search'] != '') {
        //         $searchKey = $this->request->params['named']['search'];
        //         $condition_search = array('OR' => array('Product.name LIKE' => '%' . $searchKey . '%', 'Product.description LIKE' => '%' . $searchKey . '%'));
        //     }
        // }

        $fieldArr = array('Product.id', 'Product.name', 'Product.price', 'Product.price_option', 'Product.image', 'Product.active', 'Category.name as cat_name');
        $conditions = array("conditions" => array($condition_search),
            'limit' => PAGING,
            'fields' => $fieldArr,
            'order' => 'Product.id DESC',
            'group' => 'Product.id',
            "joins" => array(
                array('table' => 'categories_products',
                    'alias' => 'CategoryProduct',
                    'type' => 'LEFT',
                    'conditions' => array('CategoryProduct.product_id = Product.id')),
                array('table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'LEFT',
                    'conditions' => array('Category.id = CategoryProduct.category_id')
                )
        ));

        $this->paginate = $conditions;
        $productList = $this->paginate('Product');

        $this->set("page", $page);
        $this->set("productList", $productList);
        // $this->set("searchKey", $searchKey);

        //Get the attributes values
        $AttributesArray = array();
        $indexSection = "";
        for($i=0;$i<count($productList);$i++){
            $product_id = $productList[$i]['Product']['id'];
            
            $indexSection .= "<section class='admin-adverts-item'>";
            $indexSection .= "<div class='advert-image'>";

            if(file_exists(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$productList[$i]['Product']['image']) && ($productList[$i]['Product']['image']<>"")){
                // $indexSection .= $this->Html->image(SITE_URL.PRODUCT_IMAGE_UPLOAD.$productList[$i]['Product']['image'], array('height' => '100px'));
                $indexSection .= "<img src='".SITE_URL.PRODUCT_IMAGE_UPLOAD."".$productList[$i]['Product']['image']."' style='height: 100px';>";
            }else{
                // $indexSection .= $this->Html->image(SITE_URL.NO_IMAGE, array('height' => '100px'));
                $indexSection .= "<img src='".SITE_URL . PRODUCT_IMAGE_UPLOAD . 'no_image.jpg'."' style='height: 100px';>";
            }

            $indexSection .= "</div>";            
            $indexSection .= "<div class='advert-details-wrapper'>"; 
            $indexSection .= "<div class=\"advert-title col-lg-11 float-left\">".$productList[$i]['Product']['name']."</div>";
            $indexSection .= "<div class=\"advert-edit-wrapper col-lg-1 float-right\">";
            // $indexSection .= $this->Html->link('<span class="advert-edit-ctrl glyphicon glyphicon-pencil"></span>',array('controller' => 'users', 'action' => 'post_an_edit', $productList[$i]['Product']['id']),array('escape' => false,"class"=>"btn btn-mini tip","title"=>"Edit"));
            $indexSection .= "<a href='post_an_edit/".$productList[$i]['Product']['id']."'><span class=\"advert-edit-ctrl glyphicon glyphicon-pencil\"></span></a>";
            $indexSection .= "</div>";            
            $indexSection .= "<section class=\"product-attribute-wrapper\">";
            $indexSection .= "<ul class=\"admin-product-attribute-content\">";
                
            $AttributesArray = $this->ProductAttribute->find('all', array(
                'fields' => array('ProductAttribute.id', 'ProductAttribute.attribute_code', 'ProductAttributeValue.id', 'ProductAttributeValue.name', 'ProductAttributeValue.attribute_id'),
                'joins' => array(array(
                    'table' => 'product_attribute_relations',
                    'alias' => 'par',
                    'type' => 'INNER',
                    'conditions' => array('par.attribute_id=ProductAttribute.id'),
                    ),
                    array(
                        'table' => 'product_attribute_values',
                        'alias' => 'ProductAttributeValue',
                        'type' => 'INNER',
                        'conditions' => array('ProductAttributeValue.id=par.attribute_value_id'),
                        'order' => 'ProductAttributeValue.sort_order'
                    )
                ),
                'conditions' => array('par.product_id'=>$product_id),
                'group' => 'ProductAttribute.id'
            ));

            for($j=0;$j<count($AttributesArray);$j++)
            {                                
                $indexSection .= "<li class=\"attribute-item\">";
                $indexSection .= "<div class=\"attribute-label\"><strong>".$AttributesArray[$j]['ProductAttribute']['attribute_code'].":</strong></div>";
                $indexSection .= "<div class=\"attribute-value\">".$AttributesArray[$j]['ProductAttributeValue']['name']."</div>";
                $indexSection .= "</li>";            
            }

            $indexSection .= "<li class=\"attribute-item\">";
            $indexSection .= "<div class=\"attribute-label\"><strong>Price:</strong></div>";
            $indexSection .= "<div class=\"attribute-value\">";
            $indexSection .= "<span class=\"product-price\">Rs. ".$productList[$i]['Product']['price']."</span>";
            
            $indexSection .= "&nbsp;<span class=\"price-tag\">";
            if($productList[$i]['Product']['price_option']==0){
                $indexSection .= "Fixed";
            }else if($productList[$i]['Product']['price_option']==1){
                $indexSection .= "Negotiable";
            }else if($productList[$i]['Product']['price_option']==2){
                $indexSection .= "Contact Me";            }
            
            $indexSection .= "</span>";

            $indexSection .= "</div>";
            $indexSection .= "</li>";
            $indexSection .= "</ul>";
            $indexSection .= "</section>";
            $indexSection .= "</div>";
            $indexSection .= "</section>";            

            // $this->set("AttributesArray", $AttributesArray);
            // echo "<pre>";
            // print_r($AttributesArray);           
        }
        // echo $indexSection;
        $this->set("indexSection", $indexSection);

    }

    public function post_an_edit($product_id = NULL){
    
        $user_id=$this->Session->read("userId");
        
        //Start to paytm payment redirect
        if(isset($_POST['ORDERID']) && isset($_POST['MID']))
        {
            // echo "<pre>";
            // print_r($_POST);
            // exit;

            require_once 'config_paytm.php';
            require_once 'encdec_paytm.php';
            
            $paytmChecksum = "";
            $paramListNew = array();
            $isValidChecksum = "FALSE";

            $paramListNew = $_POST;
            $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

            //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application's MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
            $isValidChecksum = verifychecksum_e($paramListNew, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

            if($isValidChecksum == "TRUE") {
                echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
                if ($_POST["STATUS"] == "TXN_SUCCESS") {
                    //Process your transaction here as success transaction.
                    //Verify amount & order id received from Payment gateway with your application's order id and amount.
                    //Update query should be here

                    //featured_product column should be active
                    $fieldList = array('featured_product');
                    $orderID = explode("-", $_POST['ORDERID']);
                    
                    $this->request->data['Product']['id'] = $orderID[0];
                    $this->request->data['Product']['featured_product'] = 1;
                    $this->Product->save($this->request->data, false, $fieldList);

                    //paytm transaction added in the database
                    $fieldListTransaction = array('product_id', 'user_id', 'transaction_id', 'transaction_amount', 'bank_txn_id', 'bank_name', 'gateway_name', 'created');
                    $this->request->data['ProductTransaction']['product_id'] = $orderID[0];
                    $this->request->data['ProductTransaction']['user_id'] = $user_id;
                    $this->request->data['ProductTransaction']['transaction_id'] = $_POST['TXNID'];
                    $this->request->data['ProductTransaction']['transaction_amount'] = $_POST['TXNAMOUNT'];
                    $this->request->data['ProductTransaction']['bank_txn_id'] = $_POST['BANKTXNID'];
                    $this->request->data['ProductTransaction']['bank_name'] = $_POST['BANKNAME'];
                    $this->request->data['ProductTransaction']['gateway_name'] = $_POST['GATEWAYNAME'];
                    $this->request->data['ProductTransaction']['created'] = $_POST['TXNDATE'];
                    $this->ProductTransaction->save($this->request->data, false, $fieldListTransaction);

                    $this->Session->setFlash("<div class='alert alert-info'>Transaction status is success and product updated successfully.</div>");
                    $this->redirect("/users/post_an_edit/".$_POST['ORDERID']);
                } else {
                    $this->Session->setFlash("<div class='alert alert-info'>Transaction status is failure.</div>");
                    $this->redirect("/users/post_an_edit/".$_POST['ORDERID']);
                }

                if (isset($_POST) && count($_POST)>0 )
                {
                    foreach($_POST as $paramName => $paramValue) {
                            echo "<br/>" . $paramName . " = " . $paramValue;
                    }
                }
            } else {
                //Process transaction as suspicious.
                $this->Session->setFlash("<div class='alert alert-info'>Checksum mismatched</div>");
                $this->redirect("/users/post_an_edit/".$_POST['ORDERID']);
            }
        }
        //End here for payment redirect

        $searchKey = "";
        $pagecount = "";
        
        $this->Product->bindModel(array('hasAndBelongsToMany' => array("Category")), false);

        $productContacts = $this->ProductContact->find('all', array('conditions' => array('ProductContact.product_id' => $product_id)));
        $this->set("productContacts", $productContacts);
        
        $product_detail = $this->Product->findById($product_id);

        if (!empty($this->request->data)) {
            $fieldList = array('user_id','name', 'description', 'price', 'price_option', 'new_product', 'active', 'Category.name as cat_name');

            $this->Product->id = $product_id;
            $msg = "";
            ////////////////////// ADD PRODUCT IMAGES START ////////////////////////////
            if (!empty($this->request->data["Product"]["image"]['name'])) {
                $image_path = WWW_ROOT . PRODUCT_IMAGE_UPLOAD . $product_detail['Product']['image'];
                $image_path2 = WWW_ROOT . PRODUCT_IMAGE_UPLOAD . '/thumbnail/' . $product_detail['Product']['image'];
                $image_path3 = WWW_ROOT.PRODUCT_IMAGE_UPLOAD.'/large/'.$product_detail['Product']['image'];
                if(file_exists($image_path) && file_exists($image_path2) && file_exists($image_path3)){   
                // if (file_exists($image_path) && file_exists($image_path2)) {
                    @unlink($image_path);
                    @unlink($image_path2);
                    @unlink($image_path3);
                }

                if ($this->Image->set_paths(WWW_ROOT . PRODUCT_IMAGE_UPLOAD, WWW_ROOT . PRODUCT_IMAGE_UPLOAD, WWW_ROOT . PRODUCT_IMAGE_UPLOAD . '/thumbnail/')) {
                    $this->request->data['Product']['image'] = $this->Image->upload_image('Product.image');
                    if ($this->request->data['Product']['image'] != "" && $this->request->data['Product']['image'] != false) {
                        $this->Image->thumb(WWW_ROOT . PRODUCT_IMAGE_UPLOAD . $this->request->data['Product']['image'], WWW_ROOT . PRODUCT_IMAGE_UPLOAD . "thumbnail/", PRODUCT_THUMB_WIDTH, PRODUCT_THUMB_HEIGHT);
                        $this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->request->data['Product']['image'],WWW_ROOT.PRODUCT_IMAGE_UPLOAD."large/",PRODUCT_BIG_WIDTH,PRODUCT_BIG_HEIGHT);
                        $fieldList[] = 'image';
                    } else {
                        $msg = 'Product image wrong file type.';
                    }
                }
            }  ////////////////////// ADD PRODUCT IMAGES END //////////////////////////// 

            if ($msg == "") {
                $this->request->data['Product']['user_id'] = $user_id;
                if ($this->Product->save($this->request->data, false, $fieldList)) {
                    // $pro_id = $this->Product->id;
                    $product_id = $this->Product->id;

                    $this->ProductContact->deleteAll(array('ProductContact.product_id' => $product_id));     
                    if (count($this->request->data['ProductContact']) > 0) {
                        $this->request->data['ProductContact']['product_id'] = $product_id;
                        $this->ProductContact->save($this->request->data['ProductContact']);
                    }
                    ////////////////////// ADD CONTACT DETAILS FOR PRODUCT END ////////////////////////////

                    // ADD ATTRIBUTES FOR PRODUCT START/////////////////
                    $this->ProductAttributeRelation->deleteAll(array('ProductAttributeRelation.product_id' => $product_id));
                    
                    if (isset($this->request->data['attributes']) && count($this->request->data['attributes']) > 0) {
                        foreach ($this->request->data['attributes'] as $key => $value) {
                            if (count($value) > 0) {
                                foreach ($value as $attribute_value_id) {
                                    $this->ProductAttributeRelation->create();
                                    $attrdata['ProductAttributeRelation']['product_id'] = $product_id;
                                    $attrdata['ProductAttributeRelation']['attribute_id'] = $key;
                                    $attrdata['ProductAttributeRelation']['attribute_value_id'] = $attribute_value_id;
                                    $this->ProductAttributeRelation->save($attrdata);
                                }
                            }
                        }
                    } // ADD ATTRIBUTES FOR PRODUCT END/////////////////

                    //Get Paytm payment details when we choose featured product
                    if(isset($this->request->data['Product']['featured_product']) && ($this->request->data['Product']['featured_product']==1)){
                        //Start to paytm payment
                        require_once 'config_paytm.php';
                        require_once 'encdec_paytm.php';

                        $ORDER_ID = $product_id ."-".$this->request->data['Product']['ORDER_ID'];
                        $CUST_ID = $user_id;
                        $INDUSTRY_TYPE_ID = 'Retail';
                        $CHANNEL_ID = 'WEB';
                        $TXN_AMOUNT = $this->request->data['Product']['transaction_amount'];

                        // Create an array having all required parameters for creating checksum.
                        $paramList["MID"] = PAYTM_MERCHANT_MID;
                        $paramList["ORDER_ID"] = $ORDER_ID;
                        $paramList["CUST_ID"] = $CUST_ID;
                        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
                        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
                        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
                        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

                        // $paramList["CALLBACK_URL"] = "http://localhost/ginder/users/post_an_edit/".$product_id; //Callback URL for localhost
                        $paramList["CALLBACK_URL"] = 'https://ginder.in/users/post_an_edit/'.$product_id; //Callback URL for live

                        //Here checksum string will return by getChecksumFromArray() function.
                        $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);                        
                        ?>
                        <center><h1>Please do not refresh this page...</h1></center>
                        <form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
                            <table border="1">
                                <tbody>
                                <?php
                                foreach($paramList as $name => $value) {
                                    echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
                                }
                                ?>
                                <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
                                </tbody>
                            </table>
                            <script type="text/javascript">
                                document.f1.submit();
                            </script>
                        </form>
                        <?php
                        //end here payment details
                    } else{
                        $this->Session->setFlash("<div class='alert alert-info'>Product is updated successfully.</div>");
                        $this->redirect("/users/post_an_edit/".$product_id);
                    }
                } else {
                    $this->Session->setFlash("<div class='alert alert-error'>Product could not be added.</div>");
                }
            }
            $this->Session->setFlash("<div class='alert alert-error'>" . $msg . "</div>");
        }

        $this->request->data = $product_detail;
        $this->set('product_detail', $product_detail);

        $loggedInUserDetails = $this->User->find("first",array("conditions"=>array("id"=>$user_id)));
        $this->set("loggedInUserDetails",$loggedInUserDetails); // get the UserDetails
        
        $parent_id=0;
        $catlist = $this->Category->find("all",array("fields"=>array("id","name"),"conditions"=>array("parent_id"=>0,"active"=>1),"order"=>"Category.name"));
        // $catoptions = array("0"=>"--Select--");
        for($i=0;$i<count($catlist);$i++)
        {
            $catoptions[$catlist[$i]['Category']['id']] = $catlist[$i]['Category']['name'];
        }        
        $this->set("catoptions",$catoptions);

        $selectedCategory = $this->CategoriesProduct->find('all', array(
            'fields' => array('Category.parent_id', 'CategoriesProduct.category_id'),
            'joins' => array(array(
                'table' => 'categories',
                'alias' => 'Category',
                'type' => 'INNER',
                'conditions' => array('Category.id=CategoriesProduct.category_id'),
                )
            ),
            'conditions' => array('CategoriesProduct.product_id'=>$product_id)
        ));
        $this->set("selectedCategory", $selectedCategory[0]['Category']['parent_id']);

        $category_list = $this->Category->find("threaded", array("conditions" => array("Category.parent_id" => $selectedCategory[0]['Category']['parent_id'])));
        $categories = array();
        for ($i = 0; $i < count($category_list); $i++) {
            $categories[$category_list[$i]['Category']['id']] = $category_list[$i]['Category']['name'];
            for ($j = 0; $j < count($category_list[$i]['children']); $j++) {
                $categories[$category_list[$i]['children'][$j]['Category']['id']] = '---' . $category_list[$i]['children'][$j]['Category']['name'];
            }
        }
        $this->set('categories', $categories);
        $this->set('pagecount', $pagecount);
        $this->set('searchKey', $searchKey);

        //ATTRIBUTES LIST///////////////////////////////////
        $category_id = $selectedCategory[0]['CategoriesProduct']['category_id'];
        $AttributesArray = $this->ProductAttribute->find('all', array(
            'fields' => array('ProductAttribute.id', 'ProductAttribute.attribute_code', 'ProductAttributeValue.id', 'ProductAttributeValue.name', 'ProductAttributeValue.attribute_id'),
            'joins' => array(array(
                    'table' => 'categories_product_attributes',
                    'alias' => 'cpa',
                    'type' => 'INNER',
                    'conditions' => array('cpa.product_attribute_id=ProductAttribute.id'),
                    ),
                    array(
                        'table' => 'product_attribute_values',
                        'alias' => 'ProductAttributeValue',
                        'type' => 'INNER',
                        'conditions' => array('ProductAttributeValue.attribute_id=ProductAttribute.id'),
                        'order' => 'ProductAttributeValue.sort_order'
                    ),
                    array(
                        'table' => 'categories_product_attribute_values',
                        'alias' => 'cpav',
                        'type' => 'INNER',
                        'conditions' => array('cpav.product_attribute_value_id=ProductAttributeValue.id'),
                    )
            ),
            'conditions' => array('cpa.category_id'=>$category_id, 'cpav.category_id'=>$category_id, 'ProductAttribute.active' => 1, 'ProductAttributeValue.active' => 1),
            'order' => 'ProductAttribute.sort_order',
        ));

        $ProductAttributes = array();
        foreach ($AttributesArray as $values) {
            $id = $values['ProductAttribute']['id'];
            $ProductAttributes[$id] = array(
                'id' => $id,
                'name' => $values['ProductAttribute']['attribute_code']
            );
            foreach ($AttributesArray as $newVal) {
                if ($id == $newVal['ProductAttributeValue']['attribute_id']) {
                    $ProductAttributes[$id][$values['ProductAttribute']['attribute_code']][$newVal['ProductAttributeValue']['id']] = array(
                        'id' => $newVal['ProductAttributeValue']['id'],
                        'name' => $newVal['ProductAttributeValue']['name']
                    );
                }
            }
        }
        // echo "<pre>";
        // print_r($ProductAttributes);
        $this->set("ProductAttributes", $ProductAttributes);

        $Selected_Attributes = $this->ProductAttributeRelation->find('list', array('fields' => array('ProductAttributeRelation.id', 'ProductAttributeRelation.attribute_value_id'), 'conditions' => array('ProductAttributeRelation.product_id' => $product_id)));
        $this->set('Selected_Attributes', $Selected_Attributes);
        // echo "<pre>";
        // print_r($Selected_Attributes);

        $galleryimage = $this->ProductImage->find('all', array('conditions' => array('ProductImage.product_id' => $product_id)));
        $this->set("galleryimage", $galleryimage);

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
        $city = $this->City->find('all',array('fields'=>array('City.id','City.name'), 'conditions'=>array('City.state_id'=>$productContacts[0]['ProductContact']['state']), 'order'=>array('City.name ASC')));
        $totalCity=count($city);
        $cityList=array();
        $cityList[]='Select City';
        for($i=0;$i<$totalCity;$i++){
            $cityList[$city[$i]['City']['id']] = $city[$i]['City']['name']; 
        }
        $this->set('cities',$cityList);
    }

    function imageUpdate($product_id = NULL) {
        $this->set('product_id', $product_id);
        
        // echo "<pre>";
        // print_r($this->request->data);
        // exit;
        if (!empty($this->request->data)) {
            $product_id = $this->request->data['Product']['product_id'];

            ////////////////////// ADD BRANCH IMAGES START ////////////////////////////
            foreach ($this->request->data['ProductImage'] as $key => $value) {
                if ($value['product_image']['name'] != "" && $value['product_image']['error'] == UPLOAD_ERR_OK) {
                    $file_name = $this->microtime_float() . $value['product_image']['name'];
                    if (move_uploaded_file($value['product_image']['tmp_name'], WWW_ROOT . PRODUCT_IMAGE_UPLOAD . $file_name)) {
                        if ($this->Image->set_paths(WWW_ROOT . PRODUCT_IMAGE_UPLOAD, WWW_ROOT . PRODUCT_IMAGE_UPLOAD)) {
                            $this->Image->thumb(WWW_ROOT . PRODUCT_IMAGE_UPLOAD . $file_name, WWW_ROOT . PRODUCT_IMAGE_UPLOAD . "thumbnail/", PRODUCT_THUMB_WIDTH, PRODUCT_THUMB_HEIGHT);
                            $this->Image->thumb(WWW_ROOT . PRODUCT_IMAGE_UPLOAD . $file_name, WWW_ROOT . PRODUCT_IMAGE_UPLOAD . "large/", PRODUCT_BIG_WIDTH, PRODUCT_BIG_HEIGHT);
                        }
                        $this->request->data['ProductImage'][$key]['product_id'] = $product_id;
                        $this->request->data['ProductImage'][$key]['product_image'] = $file_name;
                    } else {
                        unset($this->request->data['ProductImage'][$key]);
                    }
                } else {
                    unset($this->request->data['ProductImage'][$key]);
                }
            }
            if (count($this->request->data['ProductImage']) > 0) {
                $this->ProductImage->saveAll($this->request->data['ProductImage']);

                $this->Session->setFlash("<div class='alert alert-info'>Product image updated successfully.</div>");
                $this->redirect("/users/post_an_edit/" . $product_id);
            }   ////////////////////// ADD BRANCH IMAGES END ////////////////////////////            
        }

        if (empty($this->request->data['ProductImage'][0]['product_image']['name'])) {
            $this->Session->setFlash("<div class='alert alert-danger'>Please Choose gallery image!</div>");
            $this->redirect("/users/post_an_edit/" . $product_id);
        }
    }

    function galleryimage_delete($id = NULL) {
        $this->autoLayout = false;
        $this->autoRender = false;
        $galleryimage_detail = $this->ProductImage->find('first', array('conditions' => array('ProductImage.id' => $id)));
        $image_path = WWW_ROOT . PRODUCT_IMAGE_UPLOAD . $galleryimage_detail['ProductImage']['product_image'];
        $image_path2 = WWW_ROOT . PRODUCT_IMAGE_UPLOAD . '/thumbnail/' . $galleryimage_detail['ProductImage']['product_image'];
        //$image_path3 = WWW_ROOT.PRODUCT_IMAGE_UPLOAD.'/large/'.$galleryimage_detail['ProductImage']['product_image'];
        //if(file_exists($image_path) && file_exists($image_path2) && file_exists($image_path3))
        if (file_exists($image_path) && file_exists($image_path2)) {
            @unlink($image_path);
            @unlink($image_path2);
            //@unlink($image_path3); 

            if ($this->ProductImage->delete($id)) {
                $this->Session->setFlash("<div class='alert alert-error'>Product Gallery Image Deleted Successfully.</div>");
                $this->redirect("/users/post_an_edit/" . $galleryimage_detail['ProductImage']['product_id']);
            } else {
                $this->Session->setFlash("Product Gallery Image Can't Deleted, Please Try Again !.");
                $this->redirect("/users/post_an_edit/" . $galleryimage_detail['ProductImage']['product_id']);
            }
        } else {
            $this->Session->setFlash("<div class='alert alert-error'>Product Gallery Image Not Found.</div>");
            $this->redirect("/users/post_an_edit/" . $galleryimage_detail['ProductImage']['product_id']);
        }
    }

    /* User profile update */
    public function profile(){
        $user_id=$this->Session->read("userId");

        if ($this->request->is('post')){
            $this->request->data["User"]['id']=$user_id;
            $fieldList = array('firstname','mobile','state','city','zipcode','fbid');
          
            // if(!empty($this->request->data["User"]['password'])){
            //      $fieldList[]='password';
            //      $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
            // }
            
            if ($this->User->save($this->request->data,false,$fieldList)){
                
                // ADD ENTRY IN NEWSLETTER START
                // $check_subscriber = $this->NewsletterSubscriber->find('first',array('fields'=>array('NewsletterSubscriber.id','NewsletterSubscriber.is_subscribed'),'conditions'=>array('NewsletterSubscriber.subscriber_email'=>$this->request->data['User']['email'])));
                // $num = count($check_subscriber);
                // if($num>0){
                //     $fieldList = array('firstname','lastname','is_subscribed');
                //     $this->request->data['NewsletterSubscriber']['firstname']=$this->request->data['User']['firstname'];
                //     $this->request->data['NewsletterSubscriber']['lastname']=$this->request->data['User']['lastname'];
                //     $this->request->data['NewsletterSubscriber']['is_subscribed']=$this->request->data['User']['newsletter'];
                //     $this->NewsletterSubscriber->id=$check_subscriber['NewsletterSubscriber']['id'];
                //     $this->NewsletterSubscriber->save($this->request->data,false,$fieldList);
                // }
                // ADD ENTRY IN NEWSLETTER END
                
                $this->Session->setFlash("<div class='alert alert-info'>Account Updated successfully!</div>");
                $this->redirect('/users/profile/');
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Account Not Updated, Please try again!</div>");
                $this->redirect('/users/index/');
            }
            
        }        
        $this->request->data = $this->User->find("first",array("conditions"=>array("id"=>$user_id)));
       
        /// State LIST START
        $state = $this->State->find('all',array('fields'=>array('State.id','State.name'),'order'=>array('State.name ASC')));
        $totalState=count($state);        
        $stateList=array();
        $stateList[]='Select State';
        for($i=0;$i<$totalState;$i++){
            $stateList[$state[$i]['State']['id']] = $state[$i]['State']['name']; 
        }
        $this->set('states',$stateList);

        /// City LIST START
        $city = $this->City->find('all',array('fields'=>array('City.id','City.name'), 'conditions'=>array('City.state_id'=>$this->request->data['User']['state']), 'order'=>array('City.name ASC')));
        $totalCity=count($city);
        $cityList=array();
        $cityList[]='Select City';
        for($i=0;$i<$totalCity;$i++){
            $cityList[$city[$i]['City']['id']] = $city[$i]['City']['name']; 
        }
        $this->set('cities',$cityList);
    }
    /* user profile update end */

    /* user profile password changed */
    public function change_password(){
        $user_id=$this->Session->read("userId");

        if ($this->request->is('post')){

            $this->request->data["User"]['id']=$user_id;            
            $fieldList = array();
          
            if(!empty($this->request->data["User"]['password'])){
                 $fieldList[]='password';
                 $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
            
                if ($this->User->save($this->request->data,false,$fieldList)){                
                    $this->Session->setFlash("<div class='alert alert-info'>Password Updated successfully!</div>");
                    $this->redirect('/users/change_password/');
                }else{
                    $this->Session->setFlash("<div class='alert alert-warning'>Password Not Updated, Please try again!</div>");
                    $this->redirect('/users/change_password/');
                }
            }else{
                $this->Session->setFlash("<div class='alert alert-warning'>Please enter the Password!</div>");
                $this->redirect('/users/change_password/');
            }
        }        
        $this->request->data = $this->User->find("first",array("conditions"=>array("id"=>$user_id)));
    }
    /* user profile password changed end */

    public function getCity(){
        $this->autoLayout = false;
        $this->autoRender = false;
        $cityLists = '';
        if($this->request->data){
            $stateId = $this->request->data['stateId'];            
            /// City LIST START
            $city = $this->City->find('all',array('fields'=>array('City.id','City.name','City.state_id'), 'conditions'=>array('City.state_id'=>$stateId), 'order'=>array('City.name ASC')));

            $totalCity=count($city);
            $cityLists .= '<option value=0>Select City</option>';
            for($i=0;$i<$totalCity;$i++){
                $cityList[$city[$i]['City']['id']] = $city[$i]['City']['name'];
                $cityLists .= '<option value='.$city[$i]['City']['id'].'>'.$city[$i]['City']['name'].'</option>';
            }
            echo $cityLists;
        }
    }
    /* End get city list on basis of state*/

    public function admin_getCity(){
        $this->autoLayout = false;
        $this->autoRender = false;
        $cityLists = '';
        if($this->request->data){
            $stateId = $this->request->data['stateId'];            
            /// City LIST START
            $city = $this->City->find('all',array('fields'=>array('City.id','City.name','City.state_id'), 'conditions'=>array('City.state_id'=>$stateId), 'order'=>array('City.name ASC')));

            $totalCity=count($city);
            $cityLists .= '<option value=0>Select City</option>';
            for($i=0;$i<$totalCity;$i++){
                $cityList[$city[$i]['City']['id']] = $city[$i]['City']['name'];
                $cityLists .= '<option value='.$city[$i]['City']['id'].'>'.$city[$i]['City']['name'].'</option>';
            }
            echo $cityLists;
        }
    }
    /* End get city list on basis of state*/

    public function my_favourite($cat_id = null) {
        $user_id=$this->Session->read("userId");
        //my favourite ads
        $fieldArr = array('DISTINCT Product.id', 'Product.name', 'Product.price', 'Product.image');
        $options = array("conditions" => array('Wishlists.user_id='.$user_id, 'Product.active' => 1, 'Category.active' => 1),
            'limit' => 10,
            'fields' => $fieldArr,
            'order' => 'Product.name ASC',
            "joins" => array(
                array('table' => 'wish_lists',
                    'alias' => 'Wishlists',
                    'type' => 'INNER',
                    'conditions' => array('Wishlists.product_id = Product.id')),
                array('table' => 'categories_products',
                    'alias' => 'CategoriesProduct',
                    'type' => 'INNER',
                    'conditions' => array('CategoriesProduct.product_id = Product.id')),
                array('table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array('Category.id = CategoriesProduct.category_id')
                )
        ));
        $this->paginate = array('Product' => $options);        
        $myFavouriteList = $this->paginate('Product');
        // echo "<pre>";
        // print_r($myFavouriteList);        
        $this->set("myFavouriteList", $myFavouriteList);
    }

} // END OF CLASS
?>
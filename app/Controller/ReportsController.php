<?php
    Class ReportsController extends AppController {
        var $name = "Reports";
        var $uses = array("Content","CompanyInfo","User", "SpamReport");
        public $components = array('Email');

        public function beforeFilter() {
            parent::beforeFilter();
            if(isset($this->params['admin'])){
            }else{
                $this->Auth->allow("index", "spam_report");
            }
        }

        public function admin_index()
        {
            // $state = $this->State->find('all',array('fields'=>array('State.id','State.name'), 'order'=>array('State.name ASC')));
            // $totalState=count($state); 

            //Posted Lists count
            $postedListCount = $this->Product->find("all",array("fields"=>array("id","name"),"conditions"=>array("active"=>1)));
            $this->set("postedListCounts", count($postedListCount));
            
            //Promoted lists count
            $promotedListCount = $this->Product->find("all",array("fields"=>array("id","name"),"conditions"=>array("featured_product"=>1,"active"=>1)));
            $this->set("promotedListCounts", count($promotedListCount));

            //Retail Users lists count
            $sql = "SELECT User.id FROM users User INNER JOIN products Product ON User.id = Product.user_id group by Product.user_id";
            $retailUsersListCount = $this->User->query($sql);
            $this->set("retailUsersListCount", count($retailUsersListCount));

            //Business Users lists count
            $sql = "SELECT User.id FROM users User INNER JOIN products Product ON User.id = Product.user_id group by Product.user_id";
            $businessUsersListCount = $this->User->query($sql);
            $this->set("businessUsersListCount", count($businessUsersListCount));

            //Spam Reports lists count
            $sql = "SELECT SpamReport.id FROM spam_reports SpamReport INNER JOIN products Product ON SpamReport.product_id = Product.id";
            $spamReportsListCount = $this->SpamReport->query($sql);
            $this->set("spamReportsListCount", count($spamReportsListCount));
        }

        public function admin_spam_reports() {
            try {
                $sql = "SELECT Product.id as ProductID, Product.name as ProductName, ProductContact.name as OwnerName, SpamReport.contact_name as ContactName, SpamReport.contact_email as ContactEmail, SpamReport.description as Description, SpamReport.created as Created FROM spam_reports SpamReport 
                    LEFT JOIN products Product ON SpamReport.product_id = Product.id
                    LEFT JOIN product_contacts ProductContact ON ProductContact.product_id = Product.id 
                    WHERE Product.active= 1";
                    // echo $sql; exit;
                $spamReportList = $this->Product->query($sql);
            }catch (Exception $ex) {
                echo 'Caught Exception ' . $ex->getMessage();
            }
            $this->set("spamReportList", $spamReportList);
        }

        public function spam_report(){
            if($this->request->is('post')){
                // echo "<pre>";
                // print_r($this->request->data);
                // exit;

                $this->autoLayout = false;
                $this->autoRender = false;

                if($this->request->data){
                    $msg = ""; 
                    if(empty($this->request->data['description'])) {
                        $msg ='<span style="color: #FF0000;">Please Enter Description.</span>';
                    }               
                    if($msg==""){
                        $this->request->data["Report"]['description'] = $this->request->data['description'];
                        if($this->request->data["Report"]['description']!="")
                        {
                        // if($this->Auth->login()){
                        //   $this->Session->write("userId",$this->Auth->User('id'));
                        //   $this->Session->write("userName",$this->Auth->User('firstname'));
                        //   $this->Session->write("cartstep",2);
                        //   echo "yes";
                        //  }
                            echo "yes";
                        }else{
                            echo "No";
                        }

                        // if($_SERVER['HTTP_HOST']!='localhost'){
                        //     $email_template = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' =>6)));
                        //     if(empty($email_template)){
                        //         $this->Session->setFlash('<span style="color: #FF0000;">Email Template Doesn\'t exist !</span>');
                        //     }else{
                        //         $email = new CakeEmail();
                        //         $email->from(array($email_template['EmailTemplate']['from_email'] => $email_template['EmailTemplate']['from_name']));
                        //         $email->to(array($user['User']['email'] => $user['User']['firstname'] . ' ' . $user['User']['lastname']));
                        //         $email->emailFormat('html');
                        //         $email->subject($email_template['EmailTemplate']['subject']);
                        //         $description = $email_template['EmailTemplate']['content'];
                        //         $description = str_replace('##user_name##', $user['User']['firstname'].' '.$user['User']['lastname'], $description);
                        //         $description = str_replace('##email_address##', $user['User']['email'], $description);
                        //         $description = str_replace('##password##', $new_pass, $description);
                        //         $email->send($description);
                        //         $this->Session->setFlash('<span style="color: #00ABE7;">Password has heen Reset And Emailed to your Email Id !</span>');        
                        //     }
                        // }

                    }else{
                        $this->Session->setFlash($msg);
                        echo "No";
                    }
                    //$this->redirect('/users/registration/');
                }

            }
        }
        
    }
?>

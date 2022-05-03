<?php

App::uses('CakeTime', 'Utility');
App::uses('CakeEmail', 'Network/Email');

Class CronjobsController extends AppController {

    var $name = "Cronjobs";
    var $uses = array("Product", "Category", "User","ProductImage", "EmailTemplate", "ProductContact","State","City", "SocialLink", "SpamReport", "VisiterCount", "OrderTransactions");
    var $components = array("Captcha", 'Image', "ZipLocator");  //"File"
    var $helpers = array("Paginator");

    public function beforeFilter() {
        parent::beforeFilter();
        if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {
        } else {
            $this->Auth->allow("premium_ads_expire", "premium_ads_reminder_mail", 'unpaid_ads_expire', 'unpaid_ads_reminder_mail');
        }
    }

    public function premium_ads_expire() {

        $this->autoLayout=false;
        $this->autoRender=false;

        //All premium ads are disabled when the products are expired        
        $fieldArr = array('Product.id', 'Product.name');
        $conditions = array("conditions" => array(array('AND' => array('Product.featured_product' => 1, 'Product.active' => 1, "DATE_ADD(`Product`.`modified`, INTERVAL 2 MONTH) <= now()"))),
            'limit' => 1000,
            'fields' => $fieldArr,
            'order' => 'Product.modified DESC',
            'group' => 'Product.id',
            "joins" => array(
            array('table' => 'categories_products',
                'alias' => 'CategoryProduct',
                'type' => 'LEFT',
                'conditions' => array('CategoryProduct.product_id = Product.id'))
        ));
        $this->paginate = $conditions;
        $productList = $this->paginate('Product');
        // echo "Hello";
        // echo "<pre>";
        // print_r($productList);
        // exit;
        // $this->set("productList", $productList);

        if(count($productList) > 0){
            foreach($productList as $key=>$value){
                // echo "<pre>";
                // print_r($value);

                $product_id = $value['Product']['id'];
                $this->request->data['Product'][$key]['featured_product'] = 0;
                $this->request->data['Product'][$key]['modified'] = date("Y-m-d H:i:s");
                $this->request->data['Product'][$key]['id'] = $product_id;
            }
            // echo "<pre>";
            // print_r($this->request->data['Product']);
            // exit;
            
            $this->Product->saveAll($this->request->data['Product']);
            // $this->Session->setFlash("<div class='alert alert-info'>All Premium ads are disabled successfully.</div>");
            // $this->redirect("/admin/products/premium_ads_expire");
            // exit;
            
            // $this->set(compact('crons'));
            // $this->set('_serialize', ['crons']);  
        }
    }

    public function premium_ads_reminder_mail() {
        //All premium ads are disabled when the products are expired

        $this->autoLayout=false;
        $this->autoRender=false;

        $currentDate = date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));
        $fiveDaysBeforeDate = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));

        // echo "five days before date: ".$fiveDaysBeforeDate;
        // echo "currentDate: ".$currentDate;

        $fieldArr = array('Product.id', 'Product.name');
        $conditions = array("conditions" => array('AND' => array('Product.featured_product' => 1, 'Product.active' => 1, "CURDATE() between DATE_SUB(DATE_ADD(`Product`.`modified`, INTERVAL 2 MONTH), INTERVAL 5 DAY) and DATE_ADD(`Product`.`modified`, INTERVAL 2 MONTH)")),
            'limit' => 1000,
            'fields' => $fieldArr,
            'order' => 'Product.modified DESC',
            'group' => 'Product.id',
            "joins" => array(
                array('table' => 'categories_products',
                    'alias' => 'CategoryProduct',
                    'type' => 'LEFT',
                    'conditions' => array('CategoryProduct.product_id = Product.id')),
        ));
        $this->paginate = $conditions;
        $productList = $this->paginate('Product');

        // echo "<pre>";
        // print_r($productList);
        // exit;
        if(count($productList) > 0){
            foreach($productList as $key=>$value){
                $product_id = $value['Product']['id'];
                // echo $product_id; exit;

                $email_template = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' => 9)));
                if (empty($email_template)) {
                    $mess = '<span style="color: #FF0000;">Email Template Doesn\'t exist !</span>';
                } else {
                    $sql = "SELECT Product.id, Product.name, DATE_ADD(`Product`.`modified`, INTERVAL 2 MONTH) as 'expiry_date', ProductContact.name contact_name, ProductContact.email contact_email FROM products Product
                    LEFT JOIN product_contacts ProductContact ON ProductContact.product_id = Product.id 
                    WHERE Product.id= ".$product_id;
                    // echo $sql;
                    $productOwnerDetails = $this->Product->query($sql);
                    
                    $ownerName = $productOwnerDetails[0]['ProductContact']['contact_name'];
                    $ownerEmail = $productOwnerDetails[0]['ProductContact']['contact_email'];
                    // $ownerName = "piyush";
                    // $ownerEmail = "piyush.sri.79@gmail.com";

                    $productId = $productOwnerDetails[0]['Product']['id'];
                    $productName = $productOwnerDetails[0]['Product']['name'];
                    $product_expiry = $productOwnerDetails[0][0]['expiry_date'];

                    $productLink = SITE_URL . 'users/post_an_edit/'.$productId;

                    $email = new CakeEmail();
                    $email->to(array($ownerEmail=> $ownerName));
                    $email->from(array($email_template['EmailTemplate']['from_email'] => $email_template['EmailTemplate']['from_name']));
                    $email->emailFormat('html');
                    $email->subject($email_template['EmailTemplate']['subject']);
                    $description = $email_template['EmailTemplate']['content'];
                    $description = str_replace('##product_owner##', $ownerName, $description);
                    $description = str_replace('##product_expiry##', $product_expiry, $description);
                    $description = str_replace('##click_here##', '<a href="' . $productLink . '">' . __('Click Here') . '</a>', $description);
                    // echo "<br/>".$description; exit;
                    if($email->send($description))
                    {
                        echo "mail sends successfully";
                        // $this->Session->setFlash('<span style="color: #00ABE7;">>Mail sent to all the users</span>');
                    }else{
                        echo "No mail send";
                        // $this->Session->setFlash($msg);
                    }
                }
                // exit;
            }
        }
    }
    
    public function unpaid_ads_expire() {
        //All premium ads are disabled when the products are expired        
        $fieldArr = array('Product.id', 'Product.name');
        $conditions = array("conditions" => array(array('AND' => array('Product.featured_product' => 0, 'Product.active' => 1, "DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) <= now()"))),
            'limit' => 50000,
            'fields' => $fieldArr,
            'order' => 'Product.id DESC',
            'group' => 'Product.id',
            "joins" => array(
            array('table' => 'categories_products',
                'alias' => 'CategoryProduct',
                'type' => 'LEFT',
                'conditions' => array('CategoryProduct.product_id = Product.id'))
        ));

        $this->paginate = $conditions;
        $productListUnpaid = $this->paginate('Product');
        // echo "<pre>";
        // print_r($productListUnpaid);
        // exit;

        if(count($productListUnpaid) > 0){
            foreach($productListUnpaid as $key=>$value)
            {
                $product_id = $value['Product']['id'];
                $this->request->data['Product'][$key]['active'] = 0;
                $this->request->data['Product'][$key]['modified'] = date("Y-m-d H:i:s");
                $this->request->data['Product'][$key]['id'] = $product_id;                
            }

            $this->Product->saveAll($this->request->data['Product']);
            //     $this->Session->setFlash("<div class='alert alert-info'>All Recent ads are deactived successfully.</div>");
            //     $this->redirect("/admin/products/premium_ads_expire");
            //     exit;
            // $this->set(compact('crons'));
            // $this->set('_serialize', ['crons']);  
        }        
    }

    public function unpaid_ads_reminder_mail() {
        //All premium ads are disabled when the products are expired
        $currentDate = date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));
        $fiveDaysBeforeDate = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));

        // echo "five days before date: ".$fiveDaysBeforeDate;
        // echo "currentDate: ".$currentDate;

        $fieldArr = array('Product.id', 'Product.name');
        // $conditions = array("conditions" => array(array('AND' => array('Product.featured_product' => 0, 'Product.active' => 1, "DATE_ADD(`Product`.`modified`, INTERVAL 1 MONTH) < now()"))),
        // $conditions = array("conditions" => array('AND' => array('Product.featured_product' => 0, 'Product.active' => 1, "DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) >= '$fiveDaysBeforeDate' AND DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) <= '$currentDate'")),
        $conditions = array("conditions" => array('AND' => array('Product.featured_product' => 0, 'Product.active' => 1, "CURDATE() between DATE_SUB(DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY), INTERVAL 5 DAY) and DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY)")),
            'limit' => 5000,
            'fields' => $fieldArr,
            'order' => 'Product.id DESC',
            'group' => 'Product.id',
            "joins" => array(
            array('table' => 'categories_products',
                'alias' => 'CategoryProduct',
                'type' => 'LEFT',
                'conditions' => array('CategoryProduct.product_id = Product.id'))
        ));

        $this->paginate = $conditions;
        $productListReminder = $this->paginate('Product');

        if(count($productListReminder) > 0){
            foreach($productListReminder as $key=>$value){
                $product_id = $value['Product']['id'];

                $email_template = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' => 9)));
                if (empty($email_template)) {
                    $mess = '<span style="color: #FF0000;">Email Template Doesn\'t exist !</span>';
                } else {
                    $sql = "SELECT Product.id, Product.name, DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) as 'expiry_date', ProductContact.name contact_name, ProductContact.email contact_email FROM products Product
                    LEFT JOIN product_contacts ProductContact ON ProductContact.product_id = Product.id 
                    WHERE Product.id= ".$product_id;
                    // echo $sql; exit;
                    $productOwnerDetails = $this->Product->query($sql);
                    // echo "<pre>";
                    // print_r($productOwnerDetails);
                    // exit;
                    $ownerName = $productOwnerDetails[0]['ProductContact']['contact_name'];
                    $ownerEmail = $productOwnerDetails[0]['ProductContact']['contact_email'];
                    $productId = $productOwnerDetails[0]['Product']['id'];
                    $productName = $productOwnerDetails[0]['Product']['name'];
                    $product_expiry = $productOwnerDetails[0][0]['expiry_date'];

                    $productLink = SITE_URL . 'users/post_an_edit/'.$productId;

                    $email = new CakeEmail();
                    $email->to(array($ownerEmail=> $ownerName));
                    $email->from(array($email_template['EmailTemplate']['from_email'] => $email_template['EmailTemplate']['from_name']));                    
                    $email->emailFormat('html');
                    $email->subject($email_template['EmailTemplate']['subject']);
                    $description = $email_template['EmailTemplate']['content'];
                    $description = str_replace('##product_owner##', $ownerName, $description);
                    $description = str_replace('##product_expiry##', $product_expiry, $description);
                    $description = str_replace('##click_here##', '<a href="' . $productLink . '">' . __('Click Here') . '</a>', $description);
                    // echo "<br/>".$description; exit;
                    if($email->send($description))
                    {
                        echo "Mail send successfully";
                    }else{
                        echo "No mail send";
                    }
                }
            }
            // exit;
        }
    }
}

// END OF CLASS
?>
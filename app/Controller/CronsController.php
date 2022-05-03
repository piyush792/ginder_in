<?php

App::uses('CakeTime', 'Utility');
App::uses('CakeEmail', 'Network/Email');

Class CronsController extends AppController {

    var $name = "Crons";
    var $uses = array("Product", "Category", "User","ProductImage", "EmailTemplate", "ProductContact","State","City", "SocialLink", "SpamReport", "VisiterCount", "OrderTransactions");
    var $components = array("Captcha", 'Image', "ZipLocator");  //"File"
    var $helpers = array("Paginator");

    public function beforeFilter() {
        parent::beforeFilter();
        if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {
        } else {
            $this->Auth->allow("premium_ads_reminder_mail", 'unpaid_ads_expire', 'unpaid_ads_reminder_mail');
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
        echo "Hello22";
        echo "<pre>";
        print_r($productList);
        exit;
        $this->set("productList", $productList);

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

    public function premium_ads_reminder_mail() {

        // echo "<pre>";
        // print_r($this->request->data['product_id']);
        // exit;
        //All premium ads are disabled when the products are expired

        $currentDate = date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));
        $fiveDaysBeforeDate = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));

        // echo "five days before date: ".$fiveDaysBeforeDate;
        // echo "currentDate: ".$currentDate;

        if(isset($this->request->data['product_id'])){
            if ($_SERVER['HTTP_HOST'] == 'localhost') {                
                foreach($this->request->data['product_id'] as $key=>$value)
                {
                    echo "<pre>";
                    print_r($this->request->data['product_id']);

                    echo "<br/>productId: ".$value;
                    // exit;

                    $email_template = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' => 9)));
                    if (empty($email_template)) {
                        $mess = '<span style="color: #FF0000;">Email Template Doesn\'t exist !</span>';
                    } else {

                        $sql = "SELECT Product.id, Product.name, DATE_ADD(`Product`.`modified`, INTERVAL 2 MONTH) as 'expiry_date', ProductContact.name contact_name, ProductContact.email contact_email FROM products Product
                        LEFT JOIN product_contacts ProductContact ON ProductContact.product_id = Product.id 
                        WHERE Product.id= ".$value;
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

                        // $email = new CakeEmail();
                        // $email->to(array($ownerEmail=> $ownerName));
                        // $email->from(array($email_template['EmailTemplate']['from_name'] => $email_template['EmailTemplate']['from_email']));
                        // $email->emailFormat('html');
                        // $email->subject($email_template['EmailTemplate']['subject']);
                        $description = $email_template['EmailTemplate']['content'];
                        $description = str_replace('##product_owner##', $ownerName, $description);
                        $description = str_replace('##product_expiry##', $product_expiry, $description);
                        $description = str_replace('##click_here##', '<a href="' . $productLink . '">' . __('Click Here') . '</a>', $description);
                        // echo "<br/>".$description; exit;
                        if($email->send($description))
                        {
                            echo "yes";
                            $this->Session->setFlash('<span style="color: #00ABE7;">>Mail sent to all the users</span>');
                        }else{
                            echo "No";
                            $this->Session->setFlash($msg);
                        }
                    }
                }
                // exit;
            }
        }

        $fieldArr = array('Product.id', 'Product.name', 'Product.created', 'Product.modified', "DATE_ADD(`Product`.`modified`, INTERVAL 2 MONTH) as 'expiry_date'", 'Product.active', 'Category.name as cat_name', 'User.email as email');
        $conditions = array("conditions" => array('AND' => array('Product.featured_product' => 1, 'Product.active' => 1, "DATE_ADD(`Product`.`modified`, INTERVAL 2 MONTH) >= '$fiveDaysBeforeDate' AND DATE_ADD(`Product`.`modified`, INTERVAL 2 MONTH) <= '$currentDate'")),
            'limit' => 1000,
            'fields' => $fieldArr,
            'order' => 'Product.modified DESC',
            'group' => 'Product.id',
            "joins" => array(
                array('table' => 'categories_products',
                    'alias' => 'CategoryProduct',
                    'type' => 'LEFT',
                    'conditions' => array('CategoryProduct.product_id = Product.id')),
                array('table' => 'users',
                    'alias' => 'User',
                    'type' => 'LEFT',
                    'conditions' => array('User.id = Product.user_id')),
                array('table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'LEFT',
                    'conditions' => array('Category.id = CategoryProduct.category_id')
                )
        ));

        $this->paginate = $conditions;
        $productList = $this->paginate('Product');

        // echo "<pre>";
        // print_r($productList);
        // exit;
        // $this->set("page", $page);
        $this->set("productList", $productList);        
    }
    
    public function unpaid_ads_expire() {

        // echo "<pre>";
        // print_r($this->request->data['product_id']);
        // exit;
        //All premium ads are disabled when the products are expired
        if(isset($this->request->data['product_id'])){
            foreach($this->request->data['product_id'] as $key=>$value)
            {
                // echo "<pre>";
                // print_r($this->request->data['product_id']);
                $product_id = $value;
                // echo "<br/>productId: ".$value;
                $this->request->data['Product'][$value]['active'] = 0;
                $this->request->data['Product'][$value]['modified'] = date("Y-m-d H:i:s");
                $this->request->data['Product'][$value]['id'] = $product_id;                
            }
            if($this->Product->saveAll($this->request->data['Product'])){
                $this->Session->setFlash("<div class='alert alert-info'>All Recent ads are deactived successfully.</div>");
                $this->redirect("/admin/products/premium_ads_expire");
                exit;
            }
        }

        $fieldArr = array('Product.id', 'Product.name', 'Product.created', 'Product.modified', "DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) as 'expiry_date'", 'Product.active', 'Category.name as cat_name', 'User.email as email');
        $conditions = array("conditions" => array(array('AND' => array('Product.featured_product' => 0, 'Product.active' => 1, "DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) <= now()"))),
            'limit' => 1000,
            'fields' => $fieldArr,
            'order' => 'Product.id DESC',
            'group' => 'Product.id',
            "joins" => array(
                array('table' => 'categories_products',
                    'alias' => 'CategoryProduct',
                    'type' => 'LEFT',
                    'conditions' => array('CategoryProduct.product_id = Product.id')),
                array('table' => 'users',
                    'alias' => 'User',
                    'type' => 'LEFT',
                    'conditions' => array('User.id = Product.user_id')),
                array('table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'LEFT',
                    'conditions' => array('Category.id = CategoryProduct.category_id')
                )
        ));

        $this->paginate = $conditions;
        $productList = $this->paginate('Product');

        // echo "<pre>";
        // print_r($productList);
        // exit;
        // $this->set("page", $page);
        $this->set("productList", $productList);
        
    }

    public function unpaid_ads_reminder_mail() {

        // echo "<pre>";
        // print_r($this->request->data['product_id']);
        // exit;
        //All premium ads are disabled when the products are expired
        $currentDate = date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));
        $fiveDaysBeforeDate = date('Y-m-d', strtotime('-5 days', strtotime(date('Y-m-d'))));

        // echo "five days before date: ".$fiveDaysBeforeDate;
        // echo "currentDate: ".$currentDate;

        if(isset($this->request->data['product_id'])){

            if ($_SERVER['HTTP_HOST'] == 'localhost') {
                
                foreach($this->request->data['product_id'] as $key=>$value)
                {
                    // echo "<pre>";
                    // print_r($this->request->data['product_id']);

                    // echo "<br/>productId: ".$value;
                    // exit;                    

                    $email_template = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' => 9)));
                    if (empty($email_template)) {
                        $mess = '<span style="color: #FF0000;">Email Template Doesn\'t exist !</span>';
                    } else {

                        $sql = "SELECT Product.id, Product.name, DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) as 'expiry_date', ProductContact.name contact_name, ProductContact.email contact_email FROM products Product
                        LEFT JOIN product_contacts ProductContact ON ProductContact.product_id = Product.id 
                        WHERE Product.id= ".$value;
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

                        // $email = new CakeEmail();
                        // $email->to(array($ownerEmail=> $ownerName));
                        // $email->from(array($email_template['EmailTemplate']['from_name'] => $email_template['EmailTemplate']['from_email']));
                        // $email->emailFormat('html');
                        // $email->subject($email_template['EmailTemplate']['subject']);
                        $description = $email_template['EmailTemplate']['content'];
                        $description = str_replace('##product_owner##', $ownerName, $description);
                        $description = str_replace('##product_expiry##', $product_expiry, $description);
                        $description = str_replace('##click_here##', '<a href="' . $productLink . '">' . __('Click Here') . '</a>', $description);
                        // echo "<br/>".$description; exit;
                        if($email->send($description))
                        {
                            echo "yes";
                            $this->Session->setFlash('<span style="color: #00ABE7;">Mail sent to all the users</span>');
                        }else{
                            echo "No";
                            $this->Session->setFlash($msg);
                        }
                    }
                }
                // exit;
            }
        }

        $fieldArr = array('Product.id', 'Product.name', 'Product.created', 'Product.modified', "DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) as 'expiry_date'", 'Product.active', 'Category.name as cat_name', 'User.email as email');
        // $conditions = array("conditions" => array(array('AND' => array('Product.featured_product' => 0, 'Product.active' => 1, "DATE_ADD(`Product`.`modified`, INTERVAL 1 MONTH) < now()"))),
        $conditions = array("conditions" => array('AND' => array('Product.featured_product' => 0, 'Product.active' => 1, "DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) >= '$fiveDaysBeforeDate' AND DATE_ADD(`Product`.`modified`, INTERVAL 28 DAY) <= '$currentDate'")),
            'limit' => 1000,
            'fields' => $fieldArr,
            'order' => 'Product.id DESC',
            'group' => 'Product.id',
            "joins" => array(
                array('table' => 'categories_products',
                    'alias' => 'CategoryProduct',
                    'type' => 'LEFT',
                    'conditions' => array('CategoryProduct.product_id = Product.id')),
                array('table' => 'users',
                    'alias' => 'User',
                    'type' => 'LEFT',
                    'conditions' => array('User.id = Product.user_id')),
                array('table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'LEFT',
                    'conditions' => array('Category.id = CategoryProduct.category_id')
                )
        ));

        $this->paginate = $conditions;
        $productList = $this->paginate('Product');

        // echo "<pre>";
        // print_r($productList);
        // exit;
        // $this->set("page", $page);
        $this->set("productList", $productList);
        
    }
}

// END OF CLASS
?>
<?php
  App::uses('Sanitize', 'Utility');  
  App::uses('CakeEmail', 'Network/Email');
  class ShoppingCartsController extends AppController {
    var $name = 'ShoppingCarts';
    var $uses = array('ShoppingCart','Product','ProductAttribute','ProductAttributeValue','ProductAttributeRelation','Country','User','Order','OrderItem','Coupon','ShoppingCoupon');
    
    public function beforeFilter() {
        parent::beforeFilter();
        if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {
        }else{
            $this->Auth->allow("addtocart",'view','delete','login');
        }
    }
   
    public function addtocart(){
        $this->autoLayout=false;
        $this->autoRender=false;
        
        Sanitize::paranoid($this->request->data);
       
        $sessionid = $this->Session->read("sessionid"); // Check if we have an active cart, if there is no one set, then lets create one.
        if($this->Session->read("sessionid")==""){
            $sessionid = session_id();
            $this->Session->write("sessionid",$sessionid);
        }else{
            $sessionid = $this->Session->read("sessionid");
        }
        
        if($this->request->data['Product']['quantity']=="" || $this->request->data['Product']['quantity']<=0)
        $qty = 1;
        else
        $qty = $this->request->data['Product']['quantity'];
        
        // SET ATTRIBUTES VALUE START
        $attribute_name='';
        foreach($this->request->data['attributes'] as $key=>$value){
           $attr_name = $this->ProductAttribute->find("first",array("fields"=>array("ProductAttribute.id","ProductAttribute.attribute_code"),"conditions"=>array("ProductAttribute.id"=>$key)));  
           $attr_val_name = $this->ProductAttributeValue->find("first",array("fields"=>array("ProductAttributeValue.id","ProductAttributeValue.name"),"conditions"=>array("ProductAttributeValue.id"=>$value)));  
            
           $attribute_name .=ucfirst($attr_name['ProductAttribute']['attribute_code']).':'.ucfirst($attr_val_name['ProductAttributeValue']['name']).', '; 
        }
        $attribute_name = substr($attribute_name, 0, -2);
        $attribute_id = implode(',',array_keys($this->request->data['attributes']));
        $attribute_value_id = implode(',',$this->request->data['attributes']);
        // SET ATTRIBUTES VALUE END
        
        $cart_data = array();
        $cart_data['ShoppingCart'] = array();
        $cart_data['ShoppingCart']['session_id'] = $sessionid;
        $cart_data['ShoppingCart']['product_id'] = $this->request->data['Product']['product_id'];
        $cart_data['ShoppingCart']['price'] = $this->request->data['Product']['price'];
        $cart_data['ShoppingCart']['quantity'] = $qty;
        $cart_data['ShoppingCart']['attribute_id'] = $attribute_id;
        $cart_data['ShoppingCart']['attribute_value_id'] = $attribute_value_id;
        $cart_data['ShoppingCart']['attribute_name'] = $attribute_name;
        
        $product_id = $this->request->data['Product']['product_id'];
       
        $chkdata = $this->ShoppingCart->find("all",array("fields"=>array("ShoppingCart.id","ShoppingCart.quantity"),"conditions"=>array("session_id"=>$sessionid,"product_id"=>$product_id,"attribute_name"=>$attribute_name),"limit"=>1));
        if(count($chkdata)<=0){
            $this->ShoppingCart->save($cart_data);
        }else{
            $this->ShoppingCart->id = $chkdata[0]['ShoppingCart']['id'];
            //$qty+=$chkdata[0]['ShoppingCart']['quantity'];
            $cart_data['ShoppingCart']['quantity']=$qty;      
            $this->ShoppingCart->save($cart_data);
        }
        if(!empty($this->request->data['Product']['from_popup']))
        $this->redirect("/shopping_carts/view/1");
        else
        $this->redirect("/shopping_carts/view");
    }
    
    public function delete($id=null){
        $this->autoRender=false;
        $this->autoLayout=false;
        if(is_numeric($id))
        $this->ShoppingCart->delete($id);   
        $this->redirect("/shopping_carts/view");
    }
    
    public function view($flag=null){
        
        $sessionid = $this->Session->read("sessionid");
        $joins = array(
                    array(
                    'table' => 'products',
                    'alias' => 'Product',
                    'type' => 'INNER',
                    'conditions' => array (
                    'Product.id = ShoppingCart.product_id'
                    ))
                 );
        $cartlist=$this->ShoppingCart->find("all",array('joins' => $joins,"fields"=>array('ShoppingCart.*','Product.id','Product.name','Product.image','Product.article_no'),"conditions"=>array("ShoppingCart.session_id"=>$sessionid)));
        $this->set("cartlist",$cartlist);
        $this->set("popupflag",$flag);
        
        // MANAGE COUPON START
        $couponlist=array();
        $coupondata=$this->ShoppingCoupon->find("first",array("conditions"=>array("ShoppingCoupon.session_id"=>$sessionid)));
        if(count($coupondata)>0){
            $couponlist=$this->Coupon->find("first",array("conditions"=>array("Coupon.id"=>$coupondata['ShoppingCoupon']['coupon_id'])));
            $this->set("ShoppingCoupon_id",$coupondata['ShoppingCoupon']['id']);
        }
        $this->set("couponlist",$couponlist);    
        // MANAGE COUPON END
        
        echo "id: ".$this->Session->read('cartstep');
        if(AuthComponent::user('id')){
            $user_id=$this->Session->read("userId");
             
            $user_detail = $this->User->find("first",array("conditions"=>array("id"=>$user_id)));
            
            if($this->Session->read('cartstep')==2){
                $this->request->data['User']['ship_firstname'] = ($user_detail['User']['ship_firstname'])?$user_detail['User']['ship_firstname']:$user_detail['User']['firstname'];
                $this->request->data['User']['ship_lastname'] = ($user_detail['User']['ship_lastname'])?$user_detail['User']['ship_lastname']:$user_detail['User']['lastname'];
                $this->request->data['User']['ship_address'] = ($user_detail['User']['ship_address'])?$user_detail['User']['ship_address']:$user_detail['User']['address'];
                $this->request->data['User']['ship_phone'] = ($user_detail['User']['ship_phone'])?$user_detail['User']['ship_phone']:$user_detail['User']['phone'];
                $this->request->data['User']['ship_mobile'] = ($user_detail['User']['ship_mobile'])?$user_detail['User']['ship_mobile']:$user_detail['User']['mobile'];
                $this->request->data['User']['ship_city'] = ($user_detail['User']['ship_city'])?$user_detail['User']['ship_city']:$user_detail['User']['city'];
                $this->request->data['User']['ship_state'] = ($user_detail['User']['ship_state'])?$user_detail['User']['ship_state']:$user_detail['User']['state'];
                $this->request->data['User']['ship_zipcode'] = ($user_detail['User']['ship_zipcode'])?$user_detail['User']['ship_zipcode']:$user_detail['User']['zipcode'];
                $this->request->data['User']['ship_country'] = ($user_detail['User']['ship_country'])?$user_detail['User']['ship_country']:$user_detail['User']['country'];
            
            }elseif($this->Session->read('cartstep')==3){
                if($user_detail['User']['ship_check']==1){
                    $this->request->data['User']['bill_firstname']=$user_detail['User']['ship_firstname'];
                    $this->request->data['User']['bill_lastname']=$user_detail['User']['ship_lastname'];
                    $this->request->data['User']['bill_address']=$user_detail['User']['ship_address'];
                    $this->request->data['User']['bill_phone']=$user_detail['User']['ship_phone'];
                    $this->request->data['User']['bill_mobile']=$user_detail['User']['ship_mobile'];
                    $this->request->data['User']['bill_city']=$user_detail['User']['ship_city'];
                    $this->request->data['User']['bill_state']=$user_detail['User']['ship_state'];
                    $this->request->data['User']['bill_zipcode']=$user_detail['User']['ship_zipcode'];
                    $this->request->data['User']['bill_country']=$user_detail['User']['ship_country'];
                    $this->request->data['User']['ship_check']=$user_detail['User']['ship_check'];
                }else{
                   $this->request->data=$user_detail; 
                }
            }
            
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
             
        }else{
            $this->Session->write("cartstep",1);
        }
        
        
    }
    
    public function login(){
        $this->autoLayout = false;
        $this->autoRender = false;
        if($this->request->is('post')){
           if($this->request->data){
                $msg = ""; 
                if(empty($this->request->data["User"]['login_email']) || !preg_match(EMAIL_REGEX, $this->request->data["User"]['login_email'])) {
                    $msg ='<span style="color: #FF0000;">Please Enter Valid Email.</span>';
                }elseif(empty($this->request->data["User"]['login_password'])) {
                    $msg ='<span style="color: #FF0000;">Please Enter Password.</span>';
                }
                
                if($msg==""){
                    $this->request->data["User"]['email'] = $this->request->data["User"]['login_email'];
                    $this->request->data["User"]['password'] = $this->request->data["User"]['login_password'];
                    if($this->Auth->login()){
                      $this->Session->write("userId",$this->Auth->User('id'));
                      $this->Session->write("userName",$this->Auth->User('firstname'));  
                      $this->Session->write("cartstep",2);
                      $this->redirect("/shopping_carts/view/");
                     }else{
                        $this->Session->setFlash('<span style="color: #FF0000;">Incorrect username or password OR You are an inactive user !</span>');
                    }
                }else{
                    $this->Session->setFlash($msg);
                }
                $this->redirect('/shopping_carts/view/');
            }
        }
        $this->redirect('/shopping_carts/view/');    
    }
    
    public function shipping_detail_edit(){
      $this->autoLayout = false;
      $this->autoRender = false;
      $this->Session->write("cartstep",2);
      $this->redirect('/shopping_carts/view/');  
    }
    
    public function shipping_detail(){
        $this->autoLayout = false;
        $this->autoRender = false;
        
        if($this->request->is('post')){
            $user_id=$this->Session->read("userId");
            $this->request->data["User"]['id']=$user_id;
            
            $fieldList = array('ship_firstname','ship_lastname','ship_address','ship_phone','ship_mobile','ship_city','ship_state','ship_zipcode','ship_country','ship_check');
            if ($this->User->save($this->request->data,false,$fieldList)){
                $this->Session->write("shipping_price",$this->request->data["shipping_price"]);
                $this->Session->write("cartstep",3);
            }    
        }
        $this->redirect('/shopping_carts/view/');
    }
    
    public function payment_billing(){
        $this->autoLayout = false;
        $this->autoRender = false;
        
        if($this->request->is('post')){
            $user_id=$this->Session->read("userId");
            $this->request->data["User"]['id']=$user_id;
            
            $fieldList = array('ship_firstname','ship_lastname','ship_address','ship_phone','ship_mobile','ship_city','ship_state','ship_zipcode','ship_country','ship_check');
            if ($this->User->save($this->request->data,false,$fieldList)){
                $this->Session->write("cartstep",3);
                //$this->Session->setFlash('<span style="color: #00ABE7;">Account Updated successfully!</span>');
                $this->redirect('/shopping_carts/view/');
            }else{
                //$this->Session->setFlash('<span style="color: #FF0000;">Account Not Updated, Please try again!</span>');
                $this->redirect('/shopping_carts/view/');
            }
        }else{
            $this->redirect('/shopping_carts/view/');  
        }
    }
    
    public function order_payment(){
       $this->autoLayout = false;
       $this->autoRender = false;
       
       if($this->request->is('post')){
            
           $user_id=$this->Session->read("userId");
            $this->request->data["User"]['id']=$user_id;
            
            $fieldList = array('bill_firstname','bill_lastname','bill_address','bill_phone','bill_mobile','bill_city','bill_state','bill_zipcode','bill_country');
            if ($this->User->save($this->request->data,false,$fieldList)){
                
                $OrderTotalShipping=$this->request->data["User"]['shipping_price'];
                $OrderTotalTax=0.00;
                $handlingcost=0.00;
                $orderdiscount=0.00;
                $txn_id = '1234567890';
                $phpsession_id = $this->Session->read("sessionid");
                
                $userlist = $this->User->read(false,$user_id);
                
                $cartlist = $this->ShoppingCart->find("all",array("conditions"=>array("session_id"=>$phpsession_id)));
                
                $SubTotal = 0;
                if(count($cartlist)>0){
                    for($i=0;$i<count($cartlist);$i++){
                        $TempOrderProdNum=$cartlist[$i]['ShoppingCart']['product_id'];
                        $TempOrderQty=$cartlist[$i]['ShoppingCart']['quantity'];
                        $TempOrderPrice=$cartlist[$i]['ShoppingCart']['price'];
                        $SubTotal = $SubTotal + ( $TempOrderPrice * $TempOrderQty);
                    }
                }
                $orderstatus      = 0;
                $OrderTotal = ($SubTotal + $OrderTotalShipping);
                
                
                
                $orderData = array();
                $orderData['Order']['user_id']  = $user_id;
                $orderData['Order']['order_date'] = date("Y-m-d");
                
                if(count($userlist['User'])> 0){
                    $orderData['Order']['order_email'] = $userlist['User']['email'];
                    $orderData['Order']['bill_firstname'] = $userlist['User']['bill_firstname'];
                    $orderData['Order']['bill_lastname'] = $userlist['User']['bill_lastname'];
                    $orderData['Order']['bill_address1'] = $userlist['User']['bill_address'];
                    $orderData['Order']['bill_address2'] = '';
                    $orderData['Order']['bill_city'] = $userlist['User']['bill_city'];
                    $orderData['Order']['bill_state'] = $userlist['User']['bill_state'];
                    $orderData['Order']['bill_zip'] = $userlist['User']['bill_zipcode'];
                    $orderData['Order']['bill_phone'] = $userlist['User']['bill_phone'];
                    $orderData['Order']['bill_country'] = $userlist['User']['bill_country'];
                    $orderData['Order']['ship_firstname'] = $userlist['User']['ship_firstname'];
                    $orderData['Order']['ship_lastname'] = $userlist['User']['ship_lastname'];
                    $orderData['Order']['ship_address1'] = $userlist['User']['ship_address'];
                    $orderData['Order']['ship_address2'] = '';
                    $orderData['Order']['ship_city'] = $userlist['User']['ship_city'];
                    $orderData['Order']['ship_state'] = $userlist['User']['ship_state'];
                    $orderData['Order']['ship_zip'] = $userlist['User']['ship_zipcode'];
                    $orderData['Order']['ship_phone'] = $userlist['User']['ship_phone'];
                    $orderData['Order']['ship_country'] = $userlist['User']['ship_country'];
                }
                
                // CKECK FOR COUPON START
                $coupon=$this->ShoppingCoupon->find("first",array("conditions"=>array("ShoppingCoupon.session_id"=>$phpsession_id)));
                if(count($coupon)>0){
                     $discount_amount=0;
                     $couponlist=$this->Coupon->find("first",array("conditions"=>array("Coupon.id"=>$coupon['ShoppingCoupon']['coupon_id'])));
                     if(count($couponlist)>0){
                         
                         if($couponlist['Coupon']['code']!=''){
                            $coupon_value = $couponlist['Coupon']['coupon_value'];
                            if($couponlist['Coupon']['coupon_type']=='%'){
                                $discount_amount = ($SubTotal*$coupon_value)/100;
                            }elseif($couponlist['Coupon']['coupon_type']=='$'){
                            $discount_amount = $coupon_value;
                            }
                         }
                        $orderData['Order']['coupon_code'] = $couponlist['Coupon']['code']; 
                        $orderData['Order']['coupon_type'] = $couponlist['Coupon']['coupon_type'];
                        $orderData['Order']['coupon_value']= $couponlist['Coupon']['coupon_value'];
                        $orderData['Order']['coupon_discount']= $discount_amount;
                        $OrderTotal-=$discount_amount;
                    
                        $this->Coupon->id=$couponlist['Coupon']['id'];
                        $this->Coupon->saveField("number_of_uses",$couponlist['Coupon']['number_of_uses']+1);    
                     }    
                }
                // CKECK FOR COUPON END
                
                $orderData['Order']['subtotal'] = $SubTotal;
                $orderData['Order']['order_total'] = $OrderTotal;
                $orderData['Order']['tax'] = $OrderTotalTax;
                $orderData['Order']['shipping_price'] = $OrderTotalShipping;
                $orderData['Order']['handling_price'] = $handlingcost;
                $orderData['Order']['order_discount'] = $orderdiscount;
                $orderData['Order']['txn_id'] = $txn_id;
                $orderData['Order']['ip'] = $this->request->clientIp();
                
                
                
                $this->Order->save($orderData);
                $order_id = $this->Order->id;
                if($order_id>0){
                    foreach($cartlist as $k=>$v){
                        $this->OrderItem->create();
                        $orderitems=array('OrderItem'=>array('order_id'=>$order_id,
                                                             'product_id'=>$v['ShoppingCart']['product_id'],
                                                             'quantity'=>$v['ShoppingCart']['quantity'],
                                                             'price'=>$v['ShoppingCart']['price'],
                                                             'attribute_id'=>$v['ShoppingCart']['attribute_id'],
                                                             'attribute_value_id'=>$v['ShoppingCart']['attribute_value_id'],
                                                             'attribute_name'=>$v['ShoppingCart']['attribute_name']
                                                             ) );
                        $this->OrderItem->save($orderitems);
                        
                        // MANAGE INVENTORY START
                        $attribute_ids = explode(',',$v['ShoppingCart']['attribute_id']);
                        $attribute_value_ids = explode(',',$v['ShoppingCart']['attribute_value_id']);
                        $attribute_relations = array_combine($attribute_ids, $attribute_value_ids);    
                        $attribute_valueId =$attribute_relations[SIZE_ID]; // SElECTED VALUE FOR SIZE
                        $ProductAttributeDetail = $this->ProductAttributeRelation->find("first",
                                                array("conditions"=>array("ProductAttributeRelation.product_id"=>$v['ShoppingCart']['product_id'],
                                                                           "ProductAttributeRelation.attribute_id"=>SIZE_ID,
                                                                           "ProductAttributeRelation.attribute_value_id"=>$attribute_valueId)));
                        
                        if(count($ProductAttributeDetail)>0){
                           $fieldList = array('quantity');            
                           $this->ProductAttributeRelation->id=$ProductAttributeDetail['ProductAttributeRelation']['id'];                                                                                
                           $attrdata['ProductAttributeRelation']['quantity']=$ProductAttributeDetail['ProductAttributeRelation']['quantity']-$v['ShoppingCart']['quantity'];
                           $this->ProductAttributeRelation->save($attrdata,false,$fieldList);
                        }
                        // MANAGE INVENTORY END
                    }
                    
                    /**SENT EMAILS***************************************************************************/
                    $emailaddress=$userlist['User']['email'];
                    $name=$userlist['User']['firstname'].' '.$userlist['User']['lastname'];
                    $this->send_order_mail($order_id,$emailaddress,$name);
                    /****************************************************************************************/
                     
                    //remove the content from the Temp Table
                    $this->ShoppingCart->deleteAll(array('ShoppingCart.session_id' => $phpsession_id),false);
                    $this->ShoppingCoupon->deleteAll(array('ShoppingCoupon.session_id' => $phpsession_id),false);
                    $this->Session->write("cartstep",2);
                    $this->Session->delete("shipping_price");
                }
                
                $this->redirect("/shopping_carts/success");
            }else{
                $this->redirect('/shopping_carts/view/');
            }
        }else{
            $this->redirect('/shopping_carts/view/');  
        }
       
    }
    
    public function success(){
    }
    
    public function send_order_mail($order_id=null,$email_address=null,$name=null)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        
        $orderData = $this->Order->find("first", array("conditions" => array("Order.id"=>$order_id)));
        
        $this->OrderItem->bindModel(array('belongsTo' => array('Product')));
        $orderItem = $this->OrderItem->find("all", array("fields" => array("OrderItem.*","Product.name"),"conditions"=>array("order_id" => $order_id)));
        
        $site_name='Ginger';
        $from_email='orders@ginger.com';            
        $Email = new CakeEmail();
        $Email->template('order_template');
        $Email->emailFormat('html');
        $Email->to($email_address,$name);
        $Email->from($from_email,$site_name);
        $Email->subject('Order Details');
        $Email->viewVars(array('orderData' => $orderData['Order'],
                                'orderItem' => $orderItem
                                )
                         );                
        
        if($_SERVER['HTTP_HOST']!='localhost'){
            $Email->send(); 
        }
    }
    
    public function coupon_apply(){
       if($this->request->is('post'))
       {
           if($this->request->data['ShoppingCart']['coupon_code']){
               $now = date('Y-m-d');
               $coupon_code = $this->request->data['ShoppingCart']['coupon_code'];
               $condition = array("Coupon.code"=>$coupon_code,"Coupon.active"=>1,"Coupon.from_date <="=>$now,"Coupon.to_date >="=>$now,'OR'=>array(array('Coupon.maximum_uses > Coupon.number_of_uses','Coupon.maximum_uses > 0'),'Coupon.maximum_uses'=>0));
               $coupon_data = $this->Coupon->find("first",array("fields"=>array("Coupon.*"),"conditions"=>$condition));
               if(count($coupon_data)>0){
                 if($this->Session->read("sessionid")==""){
                    $sessionid = session_id();
                    $this->Session->write("sessionid",$sessionid);
                 }else{
                    $sessionid = $this->Session->read("sessionid");
                 }  
                 $fieldList = array('session_id','coupon_id');
                 $couponData = array();
                 $couponData['ShoppingCoupon']['session_id']= $sessionid;
                 $couponData['ShoppingCoupon']['coupon_id'] = $coupon_data['Coupon']['id'];
                 $this->ShoppingCoupon->save($couponData,false,$fieldList);
                 $this->Session->setFlash("<span style='color:#FF0000;'>COUPON APPLIED SUCCESSFULLY</span>");
              }else{
                 $this->Session->setFlash("<span style='color:#FF0000;'>INVALID COUPON</span>"); 
              }
       
            $this->Session->write("cartstep",3);
            $this->redirect('/shopping_carts/view/');    
         }else{
            $this->Session->write("cartstep",3);
            $this->redirect('/shopping_carts/view/');
         } 
    }
   }
   
   public function coupon_remove($id=null){
        $this->autoRender=false;
        $this->autoLayout=false;
        if(is_numeric($id))
        $this->ShoppingCoupon->delete($id);   
        $this->Session->setFlash("<span style='color:#FF0000;'>COUPON REMOVED SUCCESSFULLY</span>");
        $this->Session->write("cartstep",3);
        $this->redirect('/shopping_carts/view/');
    } 
}
?>
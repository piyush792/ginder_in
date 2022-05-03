<?php
    App::uses('Sanitize', 'Utility');  

    Class WishListsController extends AppController
    {
        var $name = "WishLists";
        var $uses = array("WishList","Product");
        public $components = array('Search',"DropDown");

        function beforeFilter() {
            parent::beforeFilter();
            if(isset($this->params['admin']))
            {
                $this->Auth->allow("index","admin_delete","admin_add","admin_edit","admin_searchurl");
                $this->set('title_for_layout', $this->name);
            }
            else
            {
                $this->Auth->allow("index","delete","addtocart","addtowishlist");
            }
        }



        function index()
        {

            // $user_id = $this->Session->read('userId');
            //  $wishlist_detail = $this->WishList->find("all",array("fields"=>array("WishList.id","WishList.product_id"),"conditions"=>array("WishList.active"=> 1)));
            //  $wishlist_detail = $this->WishList->find('all', array('conditions'=> array('active'=>1)));                
           
            $this->paginate = array(
            'WishList' => array(
            'limit' => PAGING,
            'order' => array('WishList.id DESC'),
            'fields' => array('WishList.id','WishList.product_id','WishList.active','WishList.attribute_name','WishList.created','Product.id','Product.image','Product.name','Product.price','Product.discount'),
            'joins' => array(
            array(
            'table' => 'products',
            'alias' => 'Product',
            'type' => 'INNER',
            'conditions' => array('Product.id=WishList.product_id')
            //'conditions' => array('Product.id=WishList.product_id','WishList.user_id'=>1)
            )
            )
            )
            );

            //  $conditions = array('WishList.user_id'=>1);
            $WishList = $this->paginate('WishList' ,$conditions);  
            $totalitems = count($WishList);      
            //     print_r($WishList);
            //  exit;            



            $this->set("totalitems",$totalitems);
            $this->set("WishList",$WishList);



        }

        function addtocart()
        {
            //  print_r($this->request->data);
            // exit;
            if($this->request->data['product_id']!='')  
            $product_id=$this->request->data[product_id];

            $wishlist_chk = $this->WishList->find("all",array("fields"=>array("WishList.id","WishList.product_id"),"conditions"=>array("WishList.product_id"=>$product_id)));
            //$wishlist_chk = $this->WishList->find("all",array("fields"=>array("WishList.id","WishList.product_id"),"conditions"=>array("WishList.product_id"=>$product_id,"WishList.user_id"=> 1)));
            if(count($wishlist_chk)>0)   {
                Sanitize::paranoid($this->request->data);

                $sessionid = $this->Session->read("sessionid");
                //  $wishlist_detail = $this->WishList->find("all",array("fields"=>array("WishList.attribute_id","WishList.attribute_value_id","WishList.attribute_name"),"conditions"=>array("WishList.product_id"=>$product_id,"WishList.user_id"=> 1)));
                $wishlist_detail = $this->WishList->find("all",array("fields"=>array("WishList.attribute_id","WishList.attribute_value_id","WishList.attribute_name"),"conditions"=>array("WishList.product_id"=>$product_id)));


                $product_price= $this->Product->find("all",array("fields"=>array("Product.price","Product.discount"),"conditions"=>array("Product.id"=>$product_id)));                     

                if($product_price[0]['Product']['discount']>0 && $product_price[0]['Product']['discount']< $product_price[0]['Product']['price'])
                // if($product_price[0]['Product']['discount']>0)
                {
                    $price = $product_price[0]['Product']['discount'];   

                }
                else{

                    $price = $product_price[0]['Product']['price'];
                }

                if($this->Session->read("sessionid") == "")
                {
                    $this->Session->write("sessionid",session_id());
                    $sessionid = session_id();
                }
                else
                {
                    $sessionid = $this->Session->read("sessionid");
                }

                $cart_data = array();


                if($this->request->data['Product']['quantity']=="" || $this->request->data['Product']['quantity']<=0)
                {
                    $qty = 1;
                }
                else
                {
                    $qty = $this->request->data['Product']['quantity'];
                }

                $attribute_id=$wishlist_detail[0][WishList][attribute_id];
                $attribute_value_id=$wishlist_detail[0][WishList][attribute_value_id];   
                $attribute_name= $wishlist_detail[0][WishList][attribute_name];

                $cart_data['ShoppingCart'] = array();
                $cart_data['ShoppingCart']['session_id'] = $sessionid;
                $cart_data['ShoppingCart']['product_id'] =$product_id;
                $cart_data['ShoppingCart']['price'] = $price;
                $cart_data['ShoppingCart']['quantity'] = $qty;
                $cart_data['ShoppingCart']['attribute_id'] = $attribute_id;
                $cart_data['ShoppingCart']['attribute_value_id'] = $attribute_value_id;
                $cart_data['ShoppingCart']['attribute_name'] = $attribute_name;


                $chkdata = $this->ShoppingCart->find("all",array("fields"=>array("ShoppingCart.id","ShoppingCart.quantity"),"conditions"=>array("session_id"=>$sessionid,"product_id"=>$product_id),"limit"=>1));

                $cartdataArr = $chkdata;

                if(count($cartdataArr) <= 0)
                {

                    $this->ShoppingCart->save($cart_data);
                }
                else
                {
                    $cartdata['ShoppingCart'] = array();
                    $this->ShoppingCart->id = $cartdataArr[0]['ShoppingCart']['id'];
                    $qty+=$cartdataArr[0]['ShoppingCart']['quantity'];
                    $cartdata['ShoppingCart']['quantity']=$qty;      

                    $this->ShoppingCart->save($cartdata,false,array("quantity"));
                }

                $this->redirect("/cart");

            }

        }


        function addtowishlist()
        {
            // print_r($this->request->data);
            // exit; 

            Sanitize::paranoid($this->request->data);

            $sessionid = $this->Session->read("sessionid");

            if($this->Session->read("sessionid") == "")
            {
                $this->Session->write("sessionid",session_id());
                $sessionid = session_id();
            }
            else
            {
                $sessionid = $this->Session->read("sessionid");
            }


            $cart_data = array();





            $attribute_size1= $this->request->data[attributename][0];
            $attribute_size= explode("|",$attribute_size1);


            $attribute_color1=$this->request->data[attributename][1];
            $attribute_color= explode("|",$attribute_color1);




            $attribute_id=$attribute_color[0]."," .$attribute_size[0];
            $attribute_value_id=$attribute_color[1]."," .$attribute_size[1];
            $attribute_name=$attribute_color[3].":" .$attribute_color[2]."," .$attribute_size[3].":" .$attribute_size[2];


            $cart_data['WishList'] = array();
            // $cart_data['WishList']['session_id'] = $sessionid;
            $cart_data['WishList']['product_id'] = $this->request->data['product_id'];
            $cart_data['WishList']['attribute_id'] = $attribute_id;
            $cart_data['WishList']['attribute_value_id'] = $attribute_value_id;
            $cart_data['WishList']['attribute_name'] = $attribute_name;


            $product_id = $this->request->data['product_id'];
            $chkdata = $this->WishList->find("all",array("fields"=>array("WishList.id"),"conditions"=>array("product_id"=>$product_id,"attribute_name"=>$attribute_name),"limit"=>1));
            $cartdataArr = $chkdata;
            if(count($cartdataArr) <= 0)
            {

                $this->WishList->save($cart_data);

                $this->redirect("/wishlists/index");
            }
            else
            {
                $this->Session->setFlash("<div class='alert alert-error'>This Product Already exist in Wishlist.</div>");    
                $this->redirect("/wishlists/index/");


            }
        }
        function delete($id=null)
        {
            $this->autoRender=false;
            $this->autoLayout=false;

            if(!is_numeric($id))
            {
                $this->redirect('/wishlists/index');
            }
            $this->WishList->delete($id);

            $this->redirect("/wishlists/index");
        }

    }
?>
<?php
App::uses('CakeTime', 'Utility');

Class OrdersController extends AppController {
    var $name = "Orders";
    var $uses = array("Order","OrderItem","User","ShoppingCart","Product");
    public $components = array('Email','OrderBase','GlobalFunction');
   
    public function beforeFilter() {
        parent::beforeFilter();
        if(isset($this->request->params['admin'])){
        }else{
            $this->Auth->allow("");
        }
    }

    public function admin_index($start_date=null,$end_date=null)
    {
        if($this->request->data){
          if($this->request->data['Order']['start_date']!="")
          $start_date = date("Y-m-d",strtotime($this->request->data['Order']['start_date']));
          if($this->request->data['Order']['end_date']!="")
          $end_date = date("Y-m-d",strtotime($this->request->data['Order']['end_date']));
        
        }elseif(@$this->params['named']['start_date']!="" || @$this->params['named']['end_date']!=""){
          if($this->params['named']['start_date']!="") 
          $start_date = $this->params['named']['start_date'];
          if($this->params['named']['end_date']!="")
          $end_date = $this->params['named']['end_date'];
        }
       
        $this->Order->bindModel(array("belongsTo"=>array("User")));
        $fields = array('Order.id','Order.user_id','Order.order_date','Order.order_total','Order.order_status','Order.bill_firstname as firstname','Order.bill_lastname as lastname');  
        
        if($start_date!=null && $end_date != null){
            $this->paginate = array('Order' => array('all', 'limit' => PAGING, 'fields'=>$fields, 'conditions'=>array('Order.order_date BETWEEN ? AND ?' => array($start_date,$end_date)), 'order' => array('Order.created' => "Desc")));
        }elseif($start_date!="" && $end_date==""){
            $this->paginate = array('Order' => array('all', 'limit' => PAGING, 'fields'=>$fields, 'conditions'=>array('Order.order_date >= ?' => array($start_date)), 'order' => array('Order.created' => "Desc")));
        }elseif($start_date=="" && $end_date!=""){
            $this->paginate = array('Order' => array('all', 'limit' => PAGING, 'fields'=>$fields, 'conditions'=>array('Order.order_date <= ?' => array($end_date)), 'order' => array('Order.created' => "Desc")));
        }else{
           
            $this->paginate = array('Order' => array('all', 'limit' => PAGING, 'fields'=>$fields,'order' => array('Order.created' => "Desc")));
        }

        $orderList = $this->paginate('Order');
        
        $this->set("orderList",$orderList);   
        $this->set("start_date",$start_date);
        $this->set("end_date",$end_date);
    }

    public function admin_view($id=null)
    {
        if($this->request->data)
        {
            $item_processed = 0;
            $all_shipped = 1;
            foreach($this->request->data['status'] as $key=>$val){
                if($val==1 || $val==2){
                    if($val == 2)
                    $item_processed = 1;
                    
                    if($val == 1)
                    $all_shipped = 0;
                }elseif($val == 0){
                    $all_shipped = 0;
                }
            }

            if($item_processed==1){
                $this->Order->id = $this->request->data['OrderItem']['order_id'];
                
                if($all_shipped)
                $this->Order->saveField("order_status","2");
                else
                $this->Order->saveField("order_status","1");
            }
            
            foreach($this->request->data['status'] as $key=>$val){
                $orderItemdata['status'] = $val;
                $this->OrderItem->id = $key;
                $this->OrderItem->saveField("status",$val);
                
            }
            $this->Session->setFlash("<div class='alert alert-info'>Order Status Updated Successfully</div>");
        }

        $this->Order->bindModel(array('belongsTo' => array('User')));
        $orderData = $this->Order->read(false,$id);
        
        if(count($orderData['Order'])<=0){
            $this->redirect("/admin/orders/");
        }
     
        $this->OrderItem->bindModel(array('belongsTo' => array('Product')));
        $orderItem = $this->OrderItem->find("all",array("fields"=>array("OrderItem.*","Product.name"),"conditions"=>array("order_id"=>$id)));
      
        $this->set("id",$id);   
        $this->set("orderData",$orderData['Order']);   
        $this->set("userData",$orderData['User']);
        $this->set("orderItem",$orderItem);   
    }

    public function admin_delete($id=null)
    {
        $this->autoLayout=false;
        $this->autoRender=false;

        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No Order id selected for deletion.</div>"); 
            $this->redirect("/admin/");
        }

        $this->Order->bindModel(array('hasMany'=>array("OrderItem"=>array('dependent'=>true))),false);
        if($this->Order->delete($id))
        $this->Session->setFlash("<div class='alert alert-info'>Order is deleted successfully.</div>"); 
        else
        $this->Session->setFlash("<div class='alert alert-error'>Order could not be deleted.</div>"); 
      
        $this->redirect("/admin/orders/index");
    }
    
}
?>
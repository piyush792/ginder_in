<?php
Class  ShippingsController  extends AppController {
    var $name = "Shippings";
    var $uses = array("Shipping","User");
    public $components = array('Email','GlobalFunction');

    public function beforeFilter() {
        parent::beforeFilter();
        
        if(isset($this->params['admin'])){
        }else{
            $this->Auth->allow("");
        }
    }
   
    public function admin_index()
    {
        $this->paginate = array('Shipping' => array('all', 'limit' => PAGING, 'fields'=>array('Shipping.id,Shipping.ship_method,Shipping.ship_name,Shipping.active')));
        $shipingList = $this->paginate('Shipping');
      
        $this->set("shipingList",$shipingList);
    }  
    
    
    
    public function admin_ups($id=NULL)
    {
        if ($this->request->isPost()){
            
            if($this->Shipping->save($this->request->data,false,array("pickup_method","package_method","delivery_method","handling_fee"))){
                $this->Session->setFlash("<div class='alert alert-info'>Ups Install successfully.</div>");
                $this->redirect("/admin/Shippings/");
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Ups  not Install.</div>");
                $this->redirect("/admin/Shippings/");
            } 
       }
       $this->request->data = $this->Shipping->findById($id);      
    }
    
    public function admin_fedex($id=NULL)
    {
        if ($this->request->isPost()){
            
            if($this->Shipping->save($this->request->data,false,array("FedExAccountNumber","FedExMeterNumber","pickup_method","package_method","delivery_method","FedExPayorType","FedExServer","handling_fee","FedExWeightUnits"))){
                $this->Session->setFlash("<div class='alert alert-info'>FedEx Install successfully.</div>");
                $this->redirect("/admin/Shippings/");
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>FedEx  not Install.</div>");
                $this->redirect("/admin/Shippings/");
            } 
         }
         $this->request->data = $this->Shipping->findById($id);      
    }

    public function admin_block($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        
        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No shipping is selected for block.</div>"); 
            $this->redirect("/admin/");
        }
        
        $this->Shipping->id = $id;
        $this->Shipping->set("active","0");

       
        if($this->Shipping->save()){   
            $this->Session->setFlash("<div class='alert alert-info'>This Shipping is blocked successfully.</div>"); 
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>The Shipping could not be blocked.</div>"); 
        }
        $this->redirect("/admin/Shippings/");
    } 

    public function admin_unblock($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
      
        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No shipping is selected for unblock.</div>"); 
            $this->redirect("/admin/Shippings/");
        }

        $this->Shipping->id = $id;
        $this->Shipping->set("active","1");
       
        if($this->Shipping->save()){   
            $this->Shipping->updateAll(
                array('Shipping.active' => "0"),
                array('Shipping.id !='.$id)  
            );
            $this->Session->setFlash("<div class='alert alert-info'>This shipping is unblocked successfully.</div>"); 
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>The shipping could not be unblocked.</div>"); 
        }
        
        $this->redirect("/admin/Shippings");
    }
}            
?>
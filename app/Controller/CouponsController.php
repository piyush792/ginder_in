<?php
Class CouponsController extends AppController {
    var $name = "Coupons";
    var $uses = array("Coupon");
   
    public function beforeFilter() {
        parent::beforeFilter();
        if(isset($this->params['admin'])){
        }else{
            $this->Auth->allow("");
        }
    }

    public function admin_index()
    {
        $searchKey='';
        $page='';
        $condition_search=array();
        if($this->request->is('post')){

            if($this->request->data['Coupon']['searchKey']!=''){
                $searchKey = $this->request->data['Coupon']['searchKey'];
                $condition_search = array('OR'=>array('Coupon.code LIKE'=>'%'.$searchKey.'%'));
            }elseif($this->params['named']['search']!=''){
                $searchKey = $this->params['named']['search'];
                $condition_search = array('OR'=>array('Coupon.code LIKE'=>'%'.$searchKey.'%'));
            }
        }

        $this->paginate = array('Coupon' => array('all', 'limit' => PAGING,'order'=> array('Coupon.id'=>'DESC')));  
        $couponlist = $this->paginate('Coupon',$condition_search);
        $this->set("couponlist",$couponlist);     
        
        $page=(@$this->params['named']['page']!='')?@$this->params['named']['page']:1;                
        $this->set("page",$page);            
        $this->set("searchKey",$searchKey);         
    }     

    public function admin_add()
    {
        
        if($this->request->is('post')){
            $msg="";

            if(empty($this->request->data["Coupon"]["code"])){
                $msg='Please Enter Coupon Code';
            }elseif ($this->Coupon->find('count', array('conditions' => array('Coupon.code' => $this->request->data['Coupon']['code']))) > 0) {
                $msg ='Coupon Code Already Exists.</span>';
            }elseif(empty($this->request->data["Coupon"]["coupon_type"])){
                $msg='Please Select Coupon Type';
            }elseif(empty($this->request->data["Coupon"]["coupon_value"])){
                $msg='Please Enter Coupon Value';
            }
                                
            if($msg==""){                        
                if($this->Coupon->save($this->request->data)){
                    $this->Session->setFlash("<div class='alert alert-info'>Coupon is added successfully.</div>");
                    $this->redirect("/admin/coupons/");
                }else{
                    $this->Session->setFlash("<div class='alert alert-error'>Coupon could not be added.</div>");
                    $this->redirect("/admin/coupons/");
                } 
            }else{
                $this->Session->setFlash($msg);
            }
        }
    }   

    public function admin_edit($id=NULL)
    {
        if(!empty($this->request->data)){

            $msg = "";
            if(empty($this->request->data["Coupon"]["code"])){
                $msg='Please Enter Coupon Code';
            }elseif(empty($this->request->data["Coupon"]["coupon_type"])){
                $msg='Please Select Coupon Type';
            }elseif(empty($this->request->data["Coupon"]["coupon_value"])){
                $msg='Please Enter Coupon Value';
            }

            if($msg==""){
               $this->Coupon->id = $id;
               if($this->Coupon->save($this->request->data)){
                    $this->Session->setFlash("<div class='alert alert-info'>Coupon is updated successfully.</div>");
               }else{
                    $this->Session->setFlash("<div class='alert alert-error'>Coupon could not be updated.</div>");
               }
               $this->redirect("/admin/coupons/index/"); 
            }
        }
        $this->request->data=$this->Coupon->read(false,$id);
    }  

    public function admin_delete($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No Coupon Id selected for deletion.</div>"); 
            $this->redirect("/admin/coupons/");
        }

        if($this->Coupon->delete($id)){   
            $this->Session->setFlash("<div class='alert alert-info'>Coupon is deleted successfully.</div>"); 
            $this->redirect("/admin/coupons/");
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Coupon could not be deleted.</div>"); 
            $this->redirect("/admin/coupons/");
        }
    }

}
?>
<?php
class AdminsController extends AppController {
    public $uses = array("Admin");
    
     public function beforeFilter() {
        parent::beforeFilter();
        if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {
            $this->Auth->allow(array('admin_login'));
        }
    }
   
    public function admin_login() {
        if ($this->request->is('post')){
            if ($this->Auth->login()){
                // return $this->redirect($this->Auth->redirect());
                return $this->redirect("/admin/reports/index");
            }else{
                $this->Session->setFlash(__('Username or password is incorrect'));
            }
        }
    }
   
    public function admin_index() {
        $this->set('msg', 'Welcome to Admin Area.');
    }

    public function admin_logout() {
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }
    Public function admin_setstyle($style)        
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        
        $this->Session->write("style",$style);
        $this->redirect($this->referer());
    }
    
    function admin_change_password()
    {   
        if(!empty($this->request->data) && $this->Auth->user("id"))
        {
            $this->Admin->id = $this->Auth->user("id");
            
            if(empty($this->request->data['Admin']['password']))
            {
                $this->Session->setFlash("Please Enter New Password.");
            }
            elseif(empty($this->request->data['Admin']['confirm_password']))
            {
                $this->Session->setFlash("Please Re-enter New Password.");
            }
            elseif($this->request->data['Admin']['confirm_password']!=$this->request->data['Admin']['password'])
            {
                $this->Session->setFlash("Password Doesn't Match.");
            }
            else
            {
                $fieldList = array("password");
                $this->request->data['Admin']['password']=AuthComponent::password($this->request->data['Admin']['password']);
                if($this->Admin->save($this->request->data,false,$fieldList)) 
                {
                    $this->Session->setFlash("<div class='alert alert-info'>Password Changed Successfully.</div>");
                }
                else
                {
                    $this->Session->setFlash("<div class='alert alert-error'>Password Not Changed, Please Try Again!</div>");
                }                  
            }
        }
    }
    
}
?>

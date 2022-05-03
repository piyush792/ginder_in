<?php
Class NewslettersController extends AppController {
    var $name = "Newsletters";
    var $uses = array("Newsletter","NewsletterSubscriber",'CompanyInfo');
    public $components = array('Email','GlobalFunction');

    public function beforeFilter() {
        parent::beforeFilter();
        if(isset($this->params['admin'])){
        }else{
            $this->Auth->allow("add_subscriber","send_mail","success");
        }
    }
    
    public function admin_index()
    {
        $searchKey='';
        $condition_search=array();
        if ($this->request->is('post')){
            if($this->request->data['Newsletter']['searchKey']!='')
            {
                $searchKey = $this->request->data['Newsletter']['searchKey'];
                $condition_search = array('OR'=>array('Newsletter.title LIKE'=>'%'.$searchKey.'%','Coupon.subject LIKE'=>'%'.$searchKey.'%'));
            }elseif($this->params['named']['search']!=''){
                $searchKey = $this->params['named']['search'];
                $condition_search = array('OR'=>array('Coupon.title LIKE'=>'%'.$searchKey.'%','Coupon.subject LIKE'=>'%'.$searchKey.'%'));
            }

        }    
        $page=(@$this->params['named']['page']!='')?$this->params['named']['page']:1;                
        $this->paginate = array('Newsletter' => array('all', 'limit' => PAGING,'order' => array('Newsletter.sort'=>'asc')));  
        $NewsletterList = $this->paginate('Newsletter',$condition_search);
        
        $this->set("page",$page);            
        $this->set("NewsletterList",$NewsletterList);     
        $this->set("searchKey",$searchKey);         
    }     

    public function admin_add()
    {
        if ($this->request->is('post')){
            
            $msg="";
            if(empty($this->request->data["Newsletter"]["title"])){
                $msg="Title cannot be empty.";
            }elseif(empty($this->request->data["Newsletter"]["subject"])){
                $msg="subject cannot be empty.";
            }elseif(empty($this->request->data["Newsletter"]["message"])){
                $msg="message cannot be empty.";
            }                    

            if($msg=="")
            {
                $conditions = array("conditions"=>array("Newsletter.title"=>$this->request->data["Newsletter"]["title"]));
                $count = $this->Newsletter->find('count',$conditions);
                if($count>0){
                    $this->Session->setFlash("<div class='alert alert-error'>Data already exist.</div>");                            
                }else{
                    if($this->Newsletter->save($this->request->data)){
                        $this->Session->setFlash("<div class='alert alert-info'>Data added successfully.</div>");
                        $this->redirect("/admin/newsletters/");
                    }else{
                        $this->Session->setFlash("<div class='alert alert-error'>Data could not be added.</div>");
                        $this->redirect("/admin/newsletters/");
                    } 
                }

            }else{
                $this->Session->setFlash($msg);
            }
        }
   }   

  
    public function admin_edit($id=NULL)
    {
        if(!$id || !is_numeric($id)){
            $this->Session->setFlash('Invalid Newsletter Id');
            $this->redirect('/admin/newsletters');
        }
        
        $this->Newsletter->id = $id;
        $searchKey="";
        $pagecount='';
        if(!empty($this->request->data)){
            
            $searchKey = $this->request->data['Newsletter']['searchKey'];
            $pagecount = $this->request->data['Newsletter']['pagecount'];     

            $msg = "";
            if(empty($this->request->data["Newsletter"]["title"])){
                $msg="Title cannot be empty.";
            }elseif(empty($this->request->data["Newsletter"]["subject"])){
                $msg="Subject cannot be empty.";
            }elseif(empty($this->request->data["Newsletter"]["message"])){
                $msg="Message cannot be empty.";
            }                    
            
            if($msg == ""){
                $conditions  = array("conditions"=>array("Newsletter.title"=>$this->request->data["Newsletter"]["title"],"Newsletter.id"=> "<>'".$this->Newsletter->id."'"));
               
                $count = $this->Newsletter->find('count',$conditions);
                if($count>0){
                    $this->Session->setFlash("<div class='alert alert-error'>Title already exist.</div>");
                    $msg="Title already exist.";
                }else{
                    if($this->Newsletter->save($this->request->data)){
                        $this->Session->setFlash("<div class='alert alert-info'>Newsletter is updated successfully.</div>");
                        if($searchKey!=''){
                            $this->redirect("/admin/newsletters/index/page:".$pagecount."/search:".$searchKey);
                        }else{
                            $this->redirect("/admin/newsletters/index/page:".$pagecount);
                        }
                    }else{
                        $this->Session->setFlash("<div class='alert alert-error'>Newsletter could not be updated.</div>");
                    } 
                }

            }
        }

        $pagecount=(@$this->params['named']['page']!='')?$this->params['named']['page']:1;
        $searchKey=(@$this->params['named']['search']!='')?$this->params['named']['search']:'';
        $this->set("pagecount",$pagecount);
        $this->set("searchKey",$searchKey);

        $this->data=$this->Newsletter->read(false,$id);
    }  
    
    public function admin_delete($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No Newsletter Id selected for deletion.</div>");
            $this->redirect("/admin/Newsletters/");
        }
        if($this->Newsletter->delete($id)){
            $this->Session->setFlash("<div class='alert alert-info'>Newsletter is deleted successfully.</div>");
            $this->redirect("/admin/Newsletters/");
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Newsletter could not be deleted.</div>");
            $this->redirect("/admin/Newsletters/");
        }
    }
    
    
    public function admin_send_newsletter() 
    {
        if ($this->request->is('post')){         
            
            $fromname='silverbliss admin';
            $fromemail='admin@silverbliss.com';

            $newsletter_id = $this->request->data['Newsletter']['newsletter'];
            $newsletter = $this->Newsletter->find("all",array("fields"=>array("Newsletter.subject","Newsletter.message"),"conditions"=>array("Newsletter.id"=>$newsletter_id)));             
            $subject=$newsletter[0]['Newsletter']['subject'];
            $message=$newsletter[0]['Newsletter']['message']; 

            $users=$this->request->data['Newsletter']['users'];
            foreach($users as $value)
            {
                $subscriberdetails = $this->NewsletterSubscriber->find("all",array("conditions"=>array("NewsletterSubscriber.id"=>$value)));             
                $subscribername=$subscriberdetails[0]['NewsletterSubscriber']['firstname'];
                $emailto=$subscriberdetails[0]['NewsletterSubscriber']['subscriber_email']; 
                $this->Email->from = $fromname.'<'.$fromemail.'>';
                $this->Email->to=$emailto;
                $this->Email->sendAs='html';
                $this->Email->subject = $subject;
                $email_template = "Hello ".$subscribername.",<br />";
                $email_template.= $message;
                $this->Email->send($email_template);
            }

            $this->Session->setFlash("Successfully Mail Sent.");
            $this->redirect('/admin/newsletters/send_newsletter');
        }

     $subscriber_list=$this->NewsletterSubscriber->find('all', array('conditions'=> array('NewsletterSubscriber.is_subscribed'=>1))); 
     $newsletter=$this->Newsletter->find('all', array('conditions'=> array('Newsletter.active'=>1))); 
     $this->set("subscriber_list",$subscriber_list);
     $this->set("newsletter",$newsletter);
  }
  
    public function add_subscriber()
    {
        if($this->request->is('post'))
        {
            $check_subscriber = $this->NewsletterSubscriber->find('first',array('fields'=>array('NewsletterSubscriber.id','NewsletterSubscriber.is_subscribed'),'conditions'=>array('NewsletterSubscriber.subscriber_email'=>$this->request->data['NewsletterSubscriber']['subscriber_email'])));
            $num = count($check_subscriber);
            if(($num==0) || ($num==1 && $check_subscriber['NewsletterSubscriber']['is_subscribed']==0))
            {
                $fieldList = array('subscriber_email','is_subscribed');
                $this->request->data['NewsletterSubscriber']['is_subscribed']=1;
                if($num==1){
                    $this->NewsletterSubscriber->id=$check_subscriber['NewsletterSubscriber']['id'];
                }
                
                if($this->NewsletterSubscriber->save($this->request->data,false,$fieldList)){
                    $this->Session->setFlash("You Are Successfully Subscribe For Newsletter!");
                    $this->redirect("/");
                }else{
                    $this->Session->setFlash("Not Subscribed, Please Try Again!");
                    $this->redirect("/");
                }  
            }else{
              $this->Session->setFlash("You Are Already Subscribed!");
              $this->redirect("/");  
            }
       } 
    }
     
}
?>
<?php
    Class ContentsController extends AppController {
        var $name = "Contents";
        var $uses = array("Content","CompanyInfo");
        public $components = array('Email');

        public function beforeFilter() {
            parent::beforeFilter();
            if(isset($this->params['admin'])){
            }else{
                $this->Auth->allow("index","send_mail","success");
            }
        }

        public function admin_index()
        {
            $searchKey='';
            $condition_search=array();  
            @$page=($this->request->params['named']['page']!='')?$this->request->params['named']['page']:1;
            
            if ($this->request->is('post')) 
            {
                if($this->request->data['Content']['searchKey']!=''){
                    $searchKey = $this->request->data['Content']['searchKey'];
                    $condition_search = array('OR'=>array('Content.name LIKE'=>'%'.$searchKey.'%','Content.permalink LIKE'=>'%'.$searchKey.'%'));
                }elseif($this->params['named']['search']!=''){
                    $searchKey = $this->params['named']['search'];
                    $condition_search = array('OR'=>array('Content.name LIKE'=>'%'.$searchKey.'%','Content.permalink LIKE'=>'%'.$searchKey.'%'));
                }
                
            }
          
            $this->paginate = array('Content' => array('all', 'limit' => PAGING,'order' => array('Content.category_type'=>'asc','Content.sort'=>'asc')));  
            $contentList = $this->paginate('Content',$condition_search);
            $this->set("page",$page);            
            $this->set("contentList",$contentList);     
            $this->set("searchKey",$searchKey);         
        }     

        public function admin_add()
        {
            if ($this->request->is('post')) 
            {
                $msg="";
                if(empty($this->request->data["Content"]["name"])){
                    $msg="Page name cannot be empty.";
                }elseif(empty($this->request->data["Content"]["permalink"])){
                    $msg="Permalink cannot be empty.";
                }elseif(empty($this->request->data["Content"]["description"])){
                    $msg="Page description cannot be empty.";
                }

                if($msg==""){
                    $conditions = array("conditions"=>array("Content.name"=>$this->request->data["Content"]["name"]));
                    $count = $this->Content->find('count',$conditions);
                    if($count>0){
                        $this->Session->setFlash("<div class='alert alert-error'>Page Name already exist.</div>");                            
                        $this->redirect("/admin/contents/");
                    }else{
                        if($this->Content->save($this->request->data)){
                            $this->Session->setFlash("<div class='alert alert-info'>Page added successfully.</div>");
                            
                        }else{
                            $this->Session->setFlash("<div class='alert alert-error'>Page could not be added.</div>");
                            $this->redirect("/admin/contents/");
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
                $this->Session->setFlash('Invalid Product Id');
                $this->redirect('/admin/contents/index');
            }
          
            $this->Content->id = $id;
            
            if(!empty($this->request->data)){
               
                $searchKey = $this->request->data['Content']['searchKey'];
                $pagecount = $this->request->data['Content']['pagecount'];     

                $msg = "";
                if(empty($this->request->data["Content"]["name"])){
                    $msg="Page name cannot be empty.";
                }elseif(empty($this->request->data["Content"]["permalink"])){
                    $msg="Permalink cannot be empty.";
                }elseif(empty($this->request->data["Content"]["description"])){
                    $msg="Page description cannot be empty.";
                }

                if($msg==""){
                    $conditions = array("conditions"=>array("Content.name"=>$this->request->data["Content"]["name"],"Content.id <>"=>$this->Content->id));
                    $count = $this->Content->find('count',$conditions);
                    if($count>0){
                        $this->Session->setFlash("<div class='alert alert-error'>Page Name already exist.</div>");
                        $msg="Page Name already exist.";
                    
                    }else{
                        if($this->Content->save($this->request->data)) 
                        {
                            $this->Session->setFlash("<div class='alert alert-info'>Content Updated Successfully.</div>");
                            if($searchKey!=''){
                                $this->redirect("/admin/contents/index/page:".$pagecount."/search:".$searchKey);
                            }else{
                                $this->redirect("/admin/contents/index/page:".$pagecount);
                            }
                        }else{
                            $this->Session->setFlash("<div class='alert alert-error'>Page could not be updated.</div>");
                        } 
                    }

                }
            }

            @$pagecount=($this->params->query['page']!='')?$this->params->query['page']:1;
            @$searchKey=($this->params->query['search']!='')?$this->params->query['search']:'';
            $this->set("pagecount",$pagecount);
            $this->set("searchKey",$searchKey);
       
            $this->data=$this->Content->read();
        }  

        public function admin_delete($id=NULL)
        {
            $this->autoLayout=false;
            $this->autoRender=false;
            
            if(!$id){
                $this->Session->setFlash("<div class='alert alert-error'>No page Id selected for deletion.</div>"); 
                $this->redirect("/admin/contents/");
            }
            
            if($this->Content->delete($id)){   
                $this->Session->setFlash("<div class='alert alert-info'>Page is deleted successfully.</div>"); 
                $this->redirect("/admin/contents/");
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Page could not be deleted.</div>"); 
                $this->redirect("/admin/contents/");
            }
        }

        public function index()
        {
            $this->params["permalink"];
            if (empty($this->params["permalink"])) {
                $this->redirect("/");
            }
            $content = $this->Content->find('first', array('fields'=>'Content.*','conditions'=>array('Content.active'=>1,'permalink'=>$this->params["permalink"])));
            if(empty($content)){
                $this->redirect("/");
            }else{
                $this->set("content",$content);
            }
        }
        
        public function send_mail(){
            
            $adminInfoArr = $this->CompanyInfo->find("all",array("fields"=>array("name","from_email")));
            $email_template = 'Hello,<br /><br />'.$this->request->data['message'].'<br/><br/>'.$this->request->data['name'];            
            $this->Email->to = $adminInfoArr[0]['CompanyInfo']['from_email'];
            $this->Email->from=$this->request->data['name']."<".$this->request->data['email'].">";
            $this->Email->sendAs='html';
            $this->Email->subject = "Contact Us";
            $description=$email_template; 
            $this->redirect(SITE_URL.'contactus/success');
        } 
        
        public function success(){

        } 
    }
?>

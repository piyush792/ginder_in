<?php
Class BannersController extends AppController {
    var $name = "Banners";
    var $uses = array("Banner");
    var $components = array("Image"); 
    var $helpers = array("Paginator"); 

    public function beforeFilter() {
        parent::beforeFilter();
        if(isset($this->params['admin'])){
        }else{
            //$this->Auth->allow("");
        }
    }

    public function admin_index()
    {
        $this->paginate = array('Banner' => array('all', 'limit' => PAGING,'order' => array('Banner.sort'=>'asc')));
        $bannerList = $this->paginate('Banner');
        $this->set("bannerList",$bannerList);            
    }     

    public function admin_add()
    {
        if ($this->request->is('post')) 
        {
            $msg="";

            $fieldList = array("title","url_link","sort","active");
            if(empty($this->request->data["Banner"]["title"])){
                $this->Session->setFlash("<div class='alert alert-error'>Banner title cannot be empty.</div>");
            }
            $conditions = array("conditions"=>array("Banner.title"=>$this->request->data["Banner"]["title"]));
            $count = $this->Banner->find('count',$conditions);                    
            
            if($count>0){
                $this->Session->setFlash("<div class='alert alert-error'>Banner already exist.</div>");                            
            }else{
                if($this->Banner->save($this->request->data,false,$fieldList))
                {
                    $msg = "<div class='alert alert-info'>Banner is added successfully.</div>";
                    $banner_id = $this->Banner->id; 
                    if(!empty($this->request->data["Banner"]["banner_image"]['name']))
                    {
                         $imagename=$this->request->data["Banner"]["banner_image"]['name'];
                         $imagename_extn = substr($imagename, strrpos($imagename, '.')+1);

                        //upload banner
                        if($this->Image->set_paths(WWW_ROOT.HOME_BANNER_UPLOAD, WWW_ROOT.HOME_BANNER_UPLOAD))
                        {
                            $banner_image = $this->Image->upload_image('Banner.banner_image','banner_'.$banner_id.'.'.$imagename_extn);

                            if($this->request->data['Banner']['banner_image']!="" && $this->request->data['Banner']['banner_image']!=false)
                            {
                                $this->Banner->set("banner_image",$banner_image);
                                $this->Banner->id = $banner_id;
                                $this->Banner->save();
                                $msg = "<div class='alert alert-info'>Banner is added successfully.</div>";
                            }
                            else
                            {
                                $msg = "<div class='alert alert-info'>Banner image could not be added.</div>";
                            }
                        } 

                    }                            
                }  
                $this->Session->setFlash($msg);                    
                $this->redirect("/admin/banners/");    

            }                    
         }
    }   

    public function admin_edit($id=NULL)
    {
        if(!$id || !is_numeric($id)){
            $this->Session->setFlash('Invalid Id');
            $this->redirect('/admin/banners/index');
        }
        
        if($this->request->is("put")){

            $this->Banner->id = $id;           
            $fieldList = array("title","url_link","sort","active");

            if(empty($this->request->data["Banner"]["title"])){
                $msg="<div class='alert alert-error'>Banner title cannot be empty.</div>";
            }

            $conditions = array("conditions"=>array("Banner.title"=>$this->request->data["Banner"]["title"],"Banner.id <>"=>$this->Banner->id));
            $count = $this->Banner->find('count',$conditions);
            if($count>0){
                $this->Session->setFlash("<div class='alert alert-error'>Banner already exist.</div>");
            }else{
                if($this->Banner->save($this->request->data,false,$fieldList)){
                    
                    $msg = "<div class='alert alert-info'>Banner is updated successfully.</div>";
                    if(!empty($this->request->data["Banner"]["banner_image"]['name'])){
                         $imagename=$this->request->data["Banner"]["banner_image"]['name'];
                         $imagename_extn = substr($imagename, strrpos($imagename, '.')+1);
                        //upload banner
                        if($this->Image->set_paths(WWW_ROOT.HOME_BANNER_UPLOAD, WWW_ROOT.HOME_BANNER_UPLOAD)){
                            $banner_image = $this->Image->upload_image('Banner.banner_image','banner_'.$id.'.'.$imagename_extn);

                            if($this->request->data['Banner']['banner_image']!="" && $this->request->data['Banner']['banner_image']!=false){
                                $this->Banner->set("banner_image",$banner_image);
                                $this->Banner->save();
                                $msg = "<div class='alert alert-info'>Banner is updated successfully.</div>";
                            }else{
                                $msg = "<div class='alert alert-info'>Banner image could not be updated.</div>";
                            }
                        } 

                    }
                }
                $this->Session->setFlash($msg);
                $this->redirect("/admin/banners/"); 
            }
        }

        $this->data=$this->Banner->read(false,$id);
    }  

    public function admin_delete($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        
        
        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No Banner is selected for deletion.</div>"); 
            $this->redirect("/admin/banners/");
        }
        
        $bannerimage_detail=$this->Banner->find('first',array('conditions'=>array('Banner.id'=>$id)));
        $image_path  = WWW_ROOT.HOME_BANNER_UPLOAD.$bannerimage_detail['Banner']['banner_image'];
        
        if(file_exists($image_path))
        {   
            @unlink($image_path);
         
            if($this->Banner->delete($id))
            {   
                $this->Session->setFlash("<div class='alert alert-info'>Banner is deleted successfully.</div>"); 
                $this->redirect("/admin/banners/");
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Banner could not be deleted.</div>"); 
                $this->redirect("/admin/banners/");
            }
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Banner Image Not Found.</div>"); 
            $this->redirect("/admin/banners/");
        }
        
    } 

    public function admin_block($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        
        if(!$id) {
            $this->Session->setFlash("<div class='alert alert-error'>No Banner is selected for deletion.</div>"); 
            $this->redirect("/admin/banners/");
        }

        $this->Banner->id = $id;
        $this->Banner->set("active","0");
        if($this->Banner->save()){   
            $this->Session->setFlash("<div class='alert alert-info'>Banner is blocked successfully.</div>"); 
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Banner could not be blocked.</div>"); 
        }
        $this->redirect("/admin/banners/");
    } 

    public function admin_unblock($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        
        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No Banner is selected for deletion.</div>"); 
            $this->redirect("/admin/banners/");
        }

        $this->Banner->id = $id;
        $this->Banner->set("active","1");

        if($this->Banner->save()){   
            $this->Session->setFlash("<div class='alert alert-info'>Banner is unblocked successfully.</div>"); 
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Banner could not be unblocked.</div>"); 
        }
        $this->redirect("/admin/banners/");
    }
}
?>
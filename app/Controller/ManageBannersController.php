<?php
    Class ManageBannersController extends AppController {
        var $name = "ManageBanners";
        var $uses = array("ManageBanner");
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
            $this->paginate = array('ManageBanner' => array('all', 'limit' => PAGING,'order' => array('ManageBanner.sort'=>'asc')));
            $bannerList = $this->paginate('ManageBanner');
            $this->set("bannerList",$bannerList);    
        }     

        public function admin_add()
        {
            if ($this->request->is('post')) 
            {
                $msg="";
                $fieldList = array("name","sort","active","banner_link","short_description");
                if(empty($this->request->data["ManageBanner"]["name"])){
                    $this->Session->setFlash("<div class='alert alert-error'>Banner Name cannot be empty.</div>");
                }
                $conditions = array("conditions"=>array("ManageBanner.name"=>$this->request->data["ManageBanner"]["name"]));
                $count = $this->ManageBanner->find('count',$conditions);                    
                if($count>0){
                    $this->Session->setFlash("<div class='alert alert-error'>Banner already exist.</div>");                            
                }else{
                    if($this->ManageBanner->save($this->request->data,false,$fieldList))
                    {
                        $msg = "<div class='alert alert-info'>Banner is added successfully.</div>";
                        $banner_id = $this->ManageBanner->id; 
                        if(!empty($this->request->data["ManageBanner"]["banner_image"]['name']))
                        {   $imagename=$this->request->data["ManageBanner"]["banner_image"]['name'];
                            $imagename_extn = substr($imagename, strrpos($imagename, '.')+1);
                            //upload banner
                            if($this->Image->set_paths(WWW_ROOT.HOME_BANNER_UPLOAD, WWW_ROOT.HOME_BANNER_UPLOAD."thumbnail/"))
                            {
                                $banner_image = $this->Image->upload_image('ManageBanner.banner_image',$banner_id.'.'.$imagename_extn);
                                if($this->request->data['ManageBanner']['banner_image']!="" && $this->request->data['ManageBanner']['banner_image']!=false)
                                {
                                    //$this->Image->thumb(WWW_ROOT.HOME_BANNER_UPLOAD.$banner_image,WWW_ROOT.HOME_BANNER_UPLOAD."thumbnail/",BANNER_THUMB_WIDTH,BANNER_THUMB_HEIGHT);                         
                                    $this->ManageBanner->set("banner_image",$banner_image);
                                    $this->ManageBanner->id = $banner_id;
                                    $this->ManageBanner->save();
                                    $msg = "<div class='alert alert-info'>Banner is added successfully.</div>";
                                }else{
                                    $msg = "<div class='alert alert-info'>Banner image could not be added.</div>";
                                }
                            } 
                        }                            
                    }  
                    $this->Session->setFlash($msg);                    
                    $this->redirect("/admin/manage_banners/");    
                }                    
            }
        }   

        public function admin_edit($id=NULL)
        {
            if(!$id || !is_numeric($id)){
                $this->Session->setFlash('Invalid Id');
                $this->redirect('/admin/manage_banners/index');
            }     
            
            if($this->request->is("put")){
                $this->ManageBanner->id = $id;           
                $fieldList = array("name","sort","active","banner_link","short_description");
                
                if(empty($this->request->data["ManageBanner"]["name"])){
                    $msg="<div class='alert alert-error'>Banner name cannot be empty.</div>";
                }

                $conditions = array("conditions"=>array("ManageBanner.id <>"=>$this->ManageBanner->id));

                if($count>0){
                    $this->Session->setFlash("<div class='alert alert-error'>Banner already exist.</div>");
                }else{
                    if($this->ManageBanner->save($this->request->data,false,$fieldList)){
                        
                        $msg = "<div class='alert alert-info'>Banner is updated successfully.</div>";

                        if(!empty($this->request->data["ManageBanner"]["banner_image"]['name'])){
                             $imagename=$this->request->data["ManageBanner"]["banner_image"]['name'];
                             $imagename_extn = substr($imagename, strrpos($imagename, '.')+1);
                            //upload banner
                            if($this->Image->set_paths(WWW_ROOT.HOME_BANNER_UPLOAD, WWW_ROOT.HOME_BANNER_UPLOAD."thumbnail/")){
                                $banner_image = $this->Image->upload_image('ManageBanner.banner_image',$id.'.'.$imagename_extn,$this->request->data['Product']['banner_hidden']);
                                if($this->request->data['ManageBanner']['banner_image']!="" && $this->request->data['ManageBanner']['banner_image']!=false){
                                    //$this->Image->thumb(WWW_ROOT.HOME_BANNER_UPLOAD.$banner_image,WWW_ROOT.HOME_BANNER_UPLOAD."thumbnail/",BANNER_THUMB_WIDTH,BANNER_THUMB_HEIGHT);                         
                                    $this->ManageBanner->set("banner_image",$banner_image);
                                    $this->ManageBanner->save();
                                    $msg = "<div class='alert alert-info'>Banner is updated successfully.</div>";
                                }else{
                                    $msg = "<div class='alert alert-info'>Banner image could not be updated.</div>";
                                }
                            } 
                        }
                    }
                    $this->Session->setFlash($msg);
                    $this->redirect("/admin/manage_banners/"); 
                }
            }
            $this->data=$this->ManageBanner->read(false,$id);
        }  

        public function admin_delete($id=NULL)
        {
            $this->autoLayout=false;
            $this->autoRender=false;
           
            if(!$id){
                $this->Session->setFlash("<div class='alert alert-error'>No Banner is selected for deletion.</div>"); 
                $this->redirect("/admin/manage_banners/");
            }
            
            if($this->ManageBanner->delete($id)){   
                $this->Session->setFlash("<div class='alert alert-info'>Banner is deleted successfully.</div>"); 
                $this->redirect("/admin/manage_banners/");
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Banner could not be deleted.</div>"); 
                $this->redirect("/admin/manage_banners/");
            }
        } 

        public function admin_block($id=NULL)
        {
            $this->autoLayout=false;
            $this->autoRender=false;
          
            if(!$id){
                $this->Session->setFlash("<div class='alert alert-error'>No Banner is selected for deletion.</div>"); 
                $this->redirect("/admin/manage_banners/");
            }

            $this->ManageBanner->id = $id;
            $this->ManageBanner->set("active","0");

            if($this->ManageBanner->save()){   
                $this->Session->setFlash("<div class='alert alert-info'>Banner is blocked successfully.</div>"); 
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Banner could not be blocked.</div>"); 
            }
            $this->redirect("/admin/manage_banners/");
        } 

        public function admin_unblock($id=NULL)
        {
            $this->autoLayout=false;
            $this->autoRender=false;
           
            if(!$id){
                $this->Session->setFlash("<div class='alert alert-error'>No Banner is selected for deletion.</div>"); 
                $this->redirect("/admin/manage_banners/");
            }

            $this->ManageBanner->id = $id;
            $this->ManageBanner->set("active","1");
            if($this->ManageBanner->save()){   
                $this->Session->setFlash("<div class='alert alert-info'>Banner is unblocked successfully.</div>"); 
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Banner could not be unblocked.</div>"); 
            }
            $this->redirect("/admin/manage_banners/");
        }
    }
?>
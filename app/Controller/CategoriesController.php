<?php
Class CategoriesController extends AppController {
    var $name = "Categories";
    var $uses = array("Category","CategoriesProduct");
    
    public function beforeFilter() {
        parent::beforeFilter();
        if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {

        }else{
            $this->Auth->allow("index");
        }
    }

    public function admin_index()
    {
        $this->Category->bindModel(array('hasMany'=>array('SubCategory'=>array( 'className'  => 'Category','foreignKey' => 'parent_id'))),false);
        $this->paginate = array('Category' => array('all', 'limit' => PAGING, 'recursive'=>2,'conditions'=>array('Category.parent_id'=>0) ,'order' => array('Category.id' => 'asc')));
        $categoryList = $this->paginate('Category');
        
        $this->set(compact("categoryList"));
    }   

    public function index($type=null)
    {
        $this->render=false;
        $category_list = $this->Category->find("threaded",array("conditions"=>array("parent_id"=>0,"active"=>1)));   
        $this->set('categoryList',$category_list);  
        $this->render("category_list");            
    }  

    public function admin_add($parent_id=0)
    {
        if($this->request->is('post')) 
        {
            $msg="";
            if(empty($this->request->data["Category"]["name"])){
                $msg="Category name cannot be empty.";
            }

            if($msg=="")
            {
                $count = $this->Category->find('count',array("conditions"=>array("Category.name"=>$this->request->data["Category"]["name"],"Category.parent_id"=>$this->request->data["Category"]["parent_id"])));
                if($count>0){
                    $this->Session->setFlash("<div class='alert alert-error'>Category already exist.</div>");
                    $this->redirect("/admin/categories/");
                }else{
                    
                    if($this->Category->save($this->request->data)){
                        $this->Session->setFlash("<div class='alert alert-info'>Category added successfully.</div>");
                        $this->redirect("/admin/categories/");
                    }else{
                        $this->Session->setFlash("<div class='alert alert-error'>Category could not be created.</div>");
                        $this->redirect("/admin/categories/");
                    } 
                }
            }
            $this->Session->setFlash($msg);
        }
        
        $catlist = $this->Category->find("all",array("fields"=>array("id","name"),"conditions"=>array("parent_id"=>0,"active"=>1),"order"=>"Category.name"));
        $catoptions = array("0"=>"--Select--");
        
        for($i=0;$i<count($catlist);$i++)
        {
            $catoptions[$catlist[$i]['Category']['id']] = $catlist[$i]['Category']['name'];
        }
        
        $this->set("catoptions",$catoptions);
        $this->set("parent_id",$parent_id);
    }   

    public function admin_edit($id=NULL)
    {
        if(!$id || !is_numeric($id)){
            $this->Session->setFlash('Invalid Category Id');
            $this->redirect('/admin/categories/index');
        }
        
        if(!empty($this->request->data)){
            
            $this->Category->id = $id;           
            $fieldList = array('parent_id','name','active');  // for updating specific fields
            $msg = "";
            
            if(empty($this->request->data["Category"]["name"])){
                $msg="Product name cannot be empty.";
            }

            if($msg == ""){               
                
                $conditions = array("conditions"=>array("Category.name"=>$this->request->data["Category"]["name"],"Category.parent_id"=>$this->request->data["Category"]["parent_id"],"Category.id <>"=>$this->Category->id));

                $count = $this->Category->find('count',$conditions);
                
                if($count>0){
                    $this->Session->setFlash("<div class='alert alert-error'>Category already exist.</div>");
                    $this->redirect("/admin/categories/");
                }else{
                    
                    if($this->Category->save($this->request->data,false,$fieldList)) {
                        $this->Session->setFlash("<div class='alert alert-info'>Category is updated successfully.</div>");
                        $this->redirect("/admin/categories/");
                    }else{
                        $this->Session->setFlash("<div class='alert alert-error'>Category could not be updated.");
                    } 
                }
            }
        }

        $catlist = $this->Category->find("all",array("fields"=>array("id","name"),"conditions"=>array("parent_id"=>0,"active"=>1),"order"=>"Category.name"));
    
        $catoptions = array("0"=>"--Select--");
        
        for($i=0;$i<count($catlist);$i++){
            $catoptions[$catlist[$i]['Category']['id']] = $catlist[$i]['Category']['name'];
        }

        $this->data=$this->Category->read(false,$id);
        $this->set("catoptions",$catoptions);
    }  

    public function admin_delete($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
      
        $this->Category->bindModel(array('hasMany' => array("CategoriesProduct"=>array('dependent' => true))),false);
        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No Category selected for deletion.</div>"); 
            $this->redirect("/admin/categories/");
        }
        
        if($this->beforeDelete($id)){
            if($this->Category->delete($id,true)){   
                $this->Session->setFlash("<div class='alert alert-info'>Category deleted successfully.</div>"); 
                $this->redirect("/admin/categories/");
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Category could not be deleted.</div>"); 
                $this->redirect("/admin/categories/");
            } 
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Category with child could not be deleted.</div>"); 
            $this->redirect("/admin/categories/");
        }
    }
    
    
    public function beforeDelete($id)
    {
        $childRecords=$this->Category->find('count', array('conditions'=>array('Category.parent_id'=>$id)));
        
        if($childRecords > 0){
            return false;
        }else{
            return true;
        }
    }
    
    public function admin_sort_menu() 
     {
        foreach($this->request->data['Category'] as $menu)
        {
            $this->Category->id=$menu['id'];
            $this->Category->saveField("position",$menu['position']);
        }
        $this->redirect("/admin/categories/"); 
    }

}
?>
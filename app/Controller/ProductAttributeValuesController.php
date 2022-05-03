<?php
Class ProductAttributeValuesController extends AppController
{
    var $name = "ProductAttributeValues";
    var $uses = array("ProductAttributeValue","ProductAttributeRelations");
    public $components = array('Search',"DropDown");
   
    public function beforeFilter() {
        parent::beforeFilter();
        if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {
        }else{
            $this->Auth->allow("index");
        }
    }

    public function admin_searchurl()
    {
        $searchStr = "";
        if(isset($this->params['named']['sort']) && $this->params['named']['sort'] != "" && isset($this->params['named']['direction']) && $this->params['named']['direction'] != "")
        {
            $searchStr.= '/sort:'.$this->params['named']['sort'].'/direction:'.$this->params['named']['direction'];
        }

        if(isset($this->params['url']['active']) && $this->params['url']['active'] !="")
        {
            $searchStr.= '/active:'.$this->params['url']['active'];
        }

        if(isset($this->params['url']['created']) && $this->params['url']['created'] !="")
        {
            list($month,$day,$year) =  split('/',$this->params['url']['created']);
            $searchStr.= '/created:'.date($year.'-'.$month.'-'.$day);
        }
        if(isset($this->params['url']['keyword']) && $this->params['url']['keyword'] !="")
        {
            $searchStr.= '/keyword:'.$this->params['url']['keyword'];
        }

        if(isset($this->params['url']['post_attribute_id']) && $this->params['url']['post_attribute_id'] !="")
        {
            $searchStr.= '/post_attribute_id:'.$this->params['url']['post_attribute_id'];
        }

        $this->redirect('/admin/product_attribute_values/index'.$searchStr);
    }

    public function admin_index()
    {
        if(isset($this->params['named']['sort']) && $this->params['named']['sort'] != "" && isset($this->params['named']['direction']) && $this->params['named']['direction'] != "")
        {
            $action = 'searchurl/sort:'.$this->params['named']['sort'].'/direction:'.$this->params['named']['direction'];
        }else{
            $action =  'searchurl';
        }
        $this->set(compact("action"));

        $this->set("reset_button",$this->params->base.'/'.$this->params['prefix'].'/'.$this->params['controller'].'/index');

        $this->paginate = array(
        'ProductAttributeValue' => array(
        'limit' => PAGING,
        'order' => array('ProductAttributeValue.id DESC'),
        'fields' => array('ProductAttributeValue.id','ProductAttributeValue.name','ProductAttributeValue.active','ProductAttribute.attribute_code'),
        'joins' => array(
            array(
            'table' => 'product_attributes',
            'alias' => 'ProductAttribute',
            'type' => 'INNER',
            'conditions' => array('ProductAttribute.id=ProductAttributeValue.attribute_id')
            )
        )
        )
        );

        $conditions = array();

        if(isset($this->params['named']['keyword'])){
            $searchKey = $this->params['named']['keyword'];
            $conditions['ProductAttributeValue.name LIKE'] = '%'.$searchKey.'%';
        }

        if(isset($this->params['named']['post_attribute_id'])){
            $searchKey = $this->params['named']['post_attribute_id'];
            $conditions['ProductAttributeValue.attribute_id ='] = $searchKey;
        }

        if(isset($this->params['named']['active'])){
            $searchKey = $this->params['named']['active'];
            $conditions['ProductAttributeValue.active ='] = $searchKey;
        }

        $contentList = $this->paginate('ProductAttributeValue' ,$conditions);
        if(isset($this->params['named']['sort'])){
            $sortBy = $this->params['named']['sort'];
            $sortOrder = $this->params['named']['direction'];
            $contentList = Set::sort($contentList, '{n}.'.$sortBy, $sortOrder);
        }
        $this->set("contentList",$contentList);
        $prodAttributes = $this->DropDown->getProductAttributes();
        $this->set(compact("prodAttributes"));
    }

    public function  admin_show_category($id=NULL)
    {
        if(($id=='' || !is_numeric($id)) && empty($this->request->data)){
            $this->Session->setFlash('Invalid Plan Id');
            $this->redirect('/admin/product_attribute_values');
        }

        $AttributesArray = $this->Category->find('all', array(
            'fields' => array('Category.id', 'Category.name', 'c2.name'),
            'joins' => array(
                    array(
                    'table' => 'categories_product_attribute_values',
                    'alias' => 'cpav',
                    'type' => 'INNER',
                    'conditions' => array('cpav.category_id=Category.id'),
                    ),
                    array(
                        'table' => 'categories',
                        'alias' => 'c2',
                        'type' => 'INNER',
                        'conditions' => array('c2.id=Category.parent_id'),
                    ),    
                    array(
                        'table' => 'product_attribute_values',
                        'alias' => 'ProductAttributeValue',
                        'type' => 'INNER',
                        'conditions' => array('ProductAttributeValue.id=cpav.product_attribute_value_id'),
                        'order' => 'ProductAttributeValue.sort_order'
                    )
            ),
            'conditions' => array('ProductAttributeValue.id'=>$id, 'ProductAttributeValue.active' => 1),
            'order' => 'Category.name asc',
        ));

        $groupByCategory = array();
        foreach($AttributesArray as $key=>$value) {
            $groupByCategory[$value['c2']['name']][] = array("id"=>$value['Category']['id'], "name"=>$value['Category']['name']);
        }
        // echo "<pre>";
        // print_r($groupByCategory);
        // exit;
        $this->set('groupByCategory', $groupByCategory);
    }

    public function admin_add()
    {
        $ProductAttributesList = $this->DropDown->getProductAttributes();
        $this->set(compact("ProductAttributesList"));

        $this->ProductAttributeValue->bindModel(array('hasAndBelongsToMany' => array("Category")), false);

        if($this->request->is('post')){
        
            $msg="";
            if($msg==""){
                $conditions = array("conditions"=>array("ProductAttributeValue.name"=>$this->request->data["ProductAttributeValue"]["name"]));
                $count = $this->ProductAttributeValue->find('count',$conditions);

                if($count>0){
                    $this->Session->setFlash("<div class='alert alert-error'>Name already exist.</div>");
                }else{
                    if($this->ProductAttributeValue->save($this->request->data)){
                        $this->Session->setFlash("<div class='alert alert-info'>Data added successfully.</div>");
                        $this->redirect("/admin/product_attribute_values/");
                    }else{
                        $this->Session->setFlash("<div class='alert alert-error'>Data could not be added.</div>");
                        $this->redirect("/admin/product_attribute_values/");
                    }
                }
            }else{
                $this->Session->setFlash($msg);
            }
        }

        $category_list = $this->Category->find("threaded", array("conditions" => array("active" => 1)));
        $categories = array();
        for ($i = 0; $i < count($category_list); $i++) {
            $categories[$category_list[$i]['Category']['id']] = $category_list[$i]['Category']['name'];
            for ($j = 0; $j < count($category_list[$i]['children']); $j++) {
                $categories[$category_list[$i]['children'][$j]['Category']['id']] = '---' . $category_list[$i]['children'][$j]['Category']['name'];
            }
        }
        $this->set('categories', $categories);
    }

    public function admin_edit($id=NULL)
    {
        if(!$id || !is_numeric($id)){
            $this->Session->setFlash('Invalid Plan Id');
            $this->redirect('/admin/product_attribute_values/index');
        }
     
        $ProductAttributesList = $this->DropDown->getProductAttributes();
        $this->set(compact("ProductAttributesList"));

        $this->ProductAttributeValue->bindModel(array('hasAndBelongsToMany' => array("Category")), false);

        //PaymentPlanlps
        $this->ProductAttributeValue->id = $id;
        if(!empty($this->request->data))
        {
            $msg = "";
            if($msg == "")
            {
                $conditions = array("conditions"=>array("ProductAttributeValue.name"=>"<>'".$this->request->data["ProductAttributeValue"]["name"]."'"));
                $count = $this->ProductAttributeValue->find('count',$conditions);
        
                if($count > 0){
                    $this->Session->setFlash("<div class='alert alert-error'>Name already exist.</div>");
                }else{
                    if($this->ProductAttributeValue->save($this->request->data)){

                        $this->Session->setFlash("<div class='alert alert-info'>Data is updated successfully.</div>");
                        $this->redirect("/admin/product_attribute_values/");
                    }else{
                        $this->Session->setFlash("<div class='alert alert-error'>Data could not be updated.</div>");
                    }
                }
            }
        }
        $this->data=$this->ProductAttributeValue->read();
        $contentlpsListdata = $this->ProductAttributeValue->find("all",array("fields"=>array("ProductAttributeValue.name"),"conditions"=>array("ProductAttributeValue.attribute_id = '".$id."'")));
        $this->set(compact("contentlpsListdata"));

        $category_list = $this->Category->find("threaded", array("conditions" => array("Category.active" => 1)));
        $categories = array();
        for ($i = 0; $i < count($category_list); $i++) {
            $categories[$category_list[$i]['Category']['id']] = $category_list[$i]['Category']['name'];
            for ($j = 0; $j < count($category_list[$i]['children']); $j++) {
                $categories[$category_list[$i]['children'][$j]['Category']['id']] = '---' . $category_list[$i]['children'][$j]['Category']['name'];
            }
        }
        $this->set('categories', $categories);
    }

    public function admin_delete($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;

        if(!$id) {
            $this->Session->setFlash("<div class='alert alert-error'>No Data Id selected for deletion.</div>");
            $this->redirect("/admin/product_attribute_values/");
        }
        
        if($this->ProductAttributeValue->delete($id)){
            $this->ProductAttributeValue->deleteAll(array("attribute_id"=>$id));
            $this->ProductAttributeRelations->deleteAll(array("attribute_value_id"=>$id)); 
            $this->Session->setFlash("<div class='alert alert-info'>Data is deleted successfully.</div>");
            $this->redirect("/admin/product_attribute_values/");
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Data could not be deleted.</div>");
            $this->redirect("/admin/product_attribute_values/");
        }
    }
}
?>
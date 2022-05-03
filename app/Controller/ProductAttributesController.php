<?php
Class ProductAttributesController extends AppController
{
    var $name = "ProductAttributes";
    var $uses = array("ProductAttribute","ProductAttributeValue","ProductAttributeRelation");
    public $components = array('Search');
  
    public function beforeFilter() {
        parent::beforeFilter();
        if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {
        }else
        {
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

        $this->redirect('/admin/product_attributes/index'.$searchStr);
    }

    public function admin_index($id=NULL)
    {
        // echo "id: ".$id; exit;
        if(isset($this->params['named']['sort']) && $this->params['named']['sort'] != "" && isset($this->params['named']['direction']) && $this->params['named']['direction'] != "")
        {
            $action = 'searchurl/sort:'.$this->params['named']['sort'].'/direction:'.$this->params['named']['direction'];
        }else{
            $action =  'searchurl';
        }
        $this->set(compact("action"));

        $this->set("reset_button",$this->params->base.'/'.$this->params['prefix'].'/'.$this->params['controller'].'/index');

        $this->paginate = array('ProductAttribute' => array('limit' => PAGING,'order' => array('ProductAttribute.id DESC'),'fields' => array('ProductAttribute.id','ProductAttribute.active','ProductAttribute.attribute_code')));
        $conditions = array();
        
        if(isset($this->params['named']['keyword'])){
            $searchKey = $this->params['named']['keyword'];
            $conditions['ProductAttribute.attribute_code LIKE'] = '%'.$searchKey.'%';
        }
        if(isset($this->params['named']['active'])){
            $searchKey = $this->params['named']['active'];
            $conditions['ProductAttribute.active ='] = $searchKey;
        }

        $contentList = $this->paginate('ProductAttribute' ,$conditions);
        if(isset($this->params['named']['sort'])){
            $sortBy = $this->params['named']['sort'];
            $sortOrder = $this->params['named']['direction'];
            $contentList = Set::sort($contentList, '{n}.'.$sortBy, $sortOrder);
        }
        $this->set("contentList",$contentList);
    }
    
    public function admin_add()
    {
        $this->ProductAttribute->bindModel(array('hasAndBelongsToMany' => array("Category")), false);
        
        if(!empty($this->request->data))
        {
            if($this->ProductAttribute->save($this->request->data)){
                $this->Session->setFlash("<div class='alert alert-info'>Data is added successfully.</div>");
                $this->redirect('/admin/product_attributes');
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Data could not be added.</div>");
                $this->redirect('/admin/product_attributes');
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

    public function  admin_edit($id=NULL)
    {
        if(($id=='' || !is_numeric($id)) && empty($this->request->data)){
            $this->Session->setFlash('Invalid Plan Id');
            $this->redirect('/admin/product_attributes');
        }
        
        $this->ProductAttribute->bindModel(array('hasAndBelongsToMany' => array("Category")), false);

        $this->ProductAttribute->id = $id;
        
        if(!empty($this->request->data)){
            if($this->ProductAttribute->save($this->request->data))
            {
                $this->Session->setFlash("<div class='alert alert-info'>Data is updated successfully.</div>");
                $this->redirect('/admin/product_attributes');
            }else{
                $this->Session->setFlash("<div class='alert alert-error'>Data could not be updated.</div>");
            }
        }

        $this->data=$this->ProductAttribute->read();
        $contentlpsListdata = $this->ProductAttribute->find("all",array("fields"=>array("ProductAttribute.attribute_code"),"conditions"=>array("ProductAttribute.id = '".$id."'")));
        $this->set(compact("contentlpsListdata"));

        $category_list = $this->Category->find("threaded", array("conditions" => array("Category.active" => 1)));
        $categories = array();
        for ($i = 0; $i < count($category_list); $i++) {
            $categories[$category_list[$i]['Category']['id']] = $category_list[$i]['Category']['name'];
            for ($j = 0; $j < count($category_list[$i]['children']); $j++) {
                $categories[$category_list[$i]['children'][$j]['Category']['id']] = '-------' . $category_list[$i]['children'][$j]['Category']['name'];
            }
        }

        // echo "<pre>";
        // print_r($categories);
        // exit;
        $this->set('categories', $categories);
    }

    public function  admin_show_category($id=NULL)
    {
        if(($id=='' || !is_numeric($id)) && empty($this->request->data)){
            $this->Session->setFlash('Invalid Plan Id');
            $this->redirect('/admin/product_attributes');
        }

        $AttributesArray = $this->Category->find('all', array(
            'fields' => array('Category.id', 'Category.name', 'c2.name'),
            'joins' => array(
                    array(
                    'table' => 'categories_product_attributes',
                    'alias' => 'cpa',
                    'type' => 'INNER',
                    'conditions' => array('cpa.category_id=Category.id'),
                    ),
                    array(
                        'table' => 'categories',
                        'alias' => 'c2',
                        'type' => 'INNER',
                        'conditions' => array('c2.id=Category.parent_id'),
                    ),    
                    array(
                        'table' => 'product_attributes',
                        'alias' => 'ProductAttribute',
                        'type' => 'INNER',
                        'conditions' => array('ProductAttribute.id=cpa.product_attribute_id'),
                        'order' => 'ProductAttributeValue.sort_order'
                    )
            ),
            'conditions' => array('ProductAttribute.id'=>$id, 'ProductAttribute.active' => 1),
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

    public function admin_delete($id=NULL)
    {
        if(!$id) {
            $this->Session->setFlash("<div class='alert alert-error'>No Data Id selected for deletion.</div>");
            $this->redirect('/admin/product_attributes');
        }
        if($this->ProductAttribute->delete($id)){
            $this->ProductAttributeValue->deleteAll(array("attribute_id"=>$id));
            $this->ProductAttributeRelation->deleteAll(array("attribute_value_id"=>$id)); 
            $this->Session->setFlash("<div class='alert alert-info'>Data is deleted successfully.</div>");
            $this->redirect('/admin/product_attributes');
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Data could not be deleted.</div>");
            $this->redirect('/admin/product_attributes');
        }
    }

}
?>
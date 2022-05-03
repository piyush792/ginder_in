<?php
App::uses('CakeTime','Utility');
App::uses('CakeEmail', 'Network/Email');
Class ProductsController extends AppController {
var $name = "Products";
var $uses = array("Product","ProductAttribute","ProductAttributeRelation","ProductAttributeValue","Category","CategoriesProduct","WishList","User",
                   "ProductImage","EmailTemplate","Rating");
var $components = array('Image',"ZipLocator","File"); 
var $helpers = array("Paginator"); 

    public function beforeFilter() {
        parent::beforeFilter();
        if ((isset($this->request->params['prefix']) && ($this->request->params['prefix'] == 'admin'))) {
        }else{
            $this->Auth->allow("view","product_list",'product_popup',"detail","wish_list",'check_quantity','search','searchajax');
        }
    }

    public function admin_index()
    {
        $condition_search = '';
        $searchKey='';
        $page = 1;

        if(!empty($this->request->data)){
            if($this->request->data['Product']['searchKey']!='')
            {
                $searchKey = $this->request->data['Product']['searchKey'];
                $condition_search = array('OR'=>array('Product.name LIKE'=>'%'.$searchKey.'%','Product.description LIKE'=>'%'.$searchKey.'%'));
            } 
            elseif($this->request->params['named']['search']!='')
            {
                $searchKey = $this->request->params['named']['search'];
                $condition_search = array('OR'=>array('Product.name LIKE'=>'%'.$searchKey.'%','Product.description LIKE'=>'%'.$searchKey.'%'));
            }
        }    
        
        $fieldArr =array('Product.id','Product.name','Product.price','Product.active','Category.name as cat_name');
                        $conditions = array("conditions"=>array($condition_search),
                        'limit' => PAGING,
                        'fields'=>$fieldArr,
                        'order' =>'Product.id DESC',
                        'group'=> 'Product.id',           
                        "joins"=>array(            
                        array('table' => 'categories_products',
                        'alias' => 'CategoryProduct',
                        'type' => 'LEFT',
                        'conditions' => array('CategoryProduct.product_id = Product.id')),
                        array('table' => 'categories',
                        'alias' => 'Category',
                        'type' => 'LEFT',
                        'conditions' => array('Category.id = CategoryProduct.category_id')
                        )
                        ));
         
        $this->paginate = $conditions;
        $productList = $this->paginate('Product');
        $this->set("page",$page);            
        $this->set("productList",$productList);            
        $this->set("searchKey",$searchKey);   
    }     

    public function admin_add()
    {
        
        $this->Product->bindModel(array('hasAndBelongsToMany'=>array("Category")),false);
        if(!empty($this->request->data)){
            $fieldList = array('article_no','sku','name','description','price','price_actual','metal','weight','finishing','measure_band','measure_width','measure_height',
                               'cirumference','stone_length','stone_width','stone_depth','new_product','featured_product','active','Category.name as cat_name');            
            
            $msg = "";
            ////////////////////// ADD PRODUCT IMAGES START ////////////////////////////
            if(!empty($this->request->data["Product"]["image"]['name'])){
                if($this->Image->set_paths(WWW_ROOT.PRODUCT_IMAGE_UPLOAD, WWW_ROOT.PRODUCT_IMAGE_UPLOAD,WWW_ROOT .PRODUCT_IMAGE_UPLOAD.'/thumbnail/'))
                {
                    $this->request->data['Product']['image'] = $this->Image->upload_image('Product.image');
                    if($this->request->data['Product']['image']!="" && $this->request->data['Product']['image']!=false)
                    {
                        $this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->request->data['Product']['image'],WWW_ROOT.PRODUCT_IMAGE_UPLOAD."thumbnail/",PRODUCT_THUMB_WIDTH,PRODUCT_THUMB_HEIGHT);
                        //$this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->request->data['Product']['image'],WWW_ROOT.PRODUCT_IMAGE_UPLOAD."large/",PRODUCT_BIG_WIDTH,PRODUCT_BIG_HEIGHT);
                        $fieldList[] = 'image';
                    }else{
                        $msg = 'Product image wrong file type.';
                    }
                } 
            }  ////////////////////// ADD PRODUCT IMAGES END //////////////////////////// 
            
            if($msg == ""){
                if($this->Product->save($this->request->data,false,$fieldList)){
                    $pro_id= $this->Product->id;
                    
                    ////////////////////// ADD GALLERY IMAGES START ////////////////////////////
                    foreach($this->request->data['ProductImage'] as $key=>$value){
                        if($value['product_image']['name']!="" && $value['product_image']['error'] == UPLOAD_ERR_OK){
                            $file_name = $this->microtime_float().$value['product_image']['name'];
                            if(move_uploaded_file($value['product_image']['tmp_name'],WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$file_name)){
                                if($this->Image->set_paths(WWW_ROOT.PRODUCT_IMAGE_UPLOAD,WWW_ROOT.PRODUCT_IMAGE_UPLOAD)){
                                    $this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$file_name,WWW_ROOT.PRODUCT_IMAGE_UPLOAD."thumbnail/",PRODUCT_THUMB_WIDTH,PRODUCT_THUMB_HEIGHT);
                                    //$this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$file_name,WWW_ROOT.PRODUCT_IMAGE_UPLOAD."large/",PRODUCT_BIG_WIDTH,PRODUCT_BIG_HEIGHT);
                                } 
                                $this->request->data['ProductImage'][$key]['product_id'] = $pro_id;
                                $this->request->data['ProductImage'][$key]['product_image'] = $file_name;
                            }else{
                                unset($this->request->data['ProductImage'][$key]);
                            }
                        }else{
                            unset($this->request->data['ProductImage'][$key]);
                        }
                    }
                    if(count($this->request->data['ProductImage'])>0){
                    $this->ProductImage->saveAll($this->request->data['ProductImage']);    
                    }   ////////////////////// ADD GALLERY IMAGES END ////////////////////////////
                    
                    // ADD ATTRIBUTES FOR PRODUCT START/////////////////
                    if(count($this->request->data['attributes'])>0){
                        foreach($this->request->data['attributes'] as $key=>$value){
                          if(count($value)>0){
                               foreach($value as $attribute_value_id){
                                   $this->ProductAttributeRelation->create();
                                   $attrdata['ProductAttributeRelation']['product_id']=$pro_id;
                                   $attrdata['ProductAttributeRelation']['attribute_id']=$key;
                                   $attrdata['ProductAttributeRelation']['attribute_value_id']=$attribute_value_id;
                                   $this->ProductAttributeRelation->save($attrdata); 
                               } 
                          }                  
                        }    
                    } // ADD ATTRIBUTES FOR PRODUCT END/////////////////

                    $this->Session->setFlash("<div class='alert alert-info'>Product added successfully.</div>");
                    if($searchKey!=''){
                        $this->redirect("/admin/products/index/page:".$pagecount."/search:".$searchKey);
                    }else{
                        $this->redirect("/admin/products/index/page:".$pagecount);
                    }

                }else {
                    $this->Session->setFlash("<div class='alert alert-error'>Product could not be added.</div>");
                }
            }
            $this->Session->setFlash("<div class='alert alert-error'>".$msg."</div>");
        }
        
        $category_list = $this->Category->find("threaded",array("conditions"=>array("active"=>1)));
        $categories=array();
        for($i=0;$i<count($category_list);$i++){
            $categories[$category_list[$i]['Category']['id']] = $category_list[$i]['Category']['name'];
            for($j=0;$j<count($category_list[$i]['children']);$j++){
                $categories[$category_list[$i]['children'][$j]['Category']['id']] ='---'.$category_list[$i]['children'][$j]['Category']['name']; 
            }
        }
        $this->set('categories',$categories);
        
        //ATTRIBUTES LIST START///////////////////////////////////
        $AttributesArray = $this->ProductAttribute->find('all',array(
                                    'fields' => array('ProductAttribute.id','ProductAttribute.attribute_code','ProductAttributeValue.id','ProductAttributeValue.name','ProductAttributeValue.color_code','ProductAttributeValue.attribute_id'),
                                    'joins' => array(array(
                                                        'table' => 'product_attribute_values',
                                                        'alias' => 'ProductAttributeValue',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeValue.attribute_id=ProductAttribute.id','ProductAttributeValue.active'=> 1),
                                                        'order'=>'ProductAttributeValue.sort_order'                                                                               
                                                        )
                                                 ), 
                                    'conditions' => array('ProductAttribute.active'=> 1),
                                    'order'=>'ProductAttribute.sort_order',
                                    ));
        
         $ProductAttributes = array();
         foreach($AttributesArray as $values){
            $id = $values['ProductAttribute']['id'];
            $ProductAttributes[$id] = array(
              'id' => $id ,
              'name' => $values['ProductAttribute']['attribute_code']
            );
            foreach($AttributesArray as $newVal){
                if($id==$newVal['ProductAttributeValue']['attribute_id']){
                    $ProductAttributes[$id][$values['ProductAttribute']['attribute_code']][$newVal['ProductAttributeValue']['id']] = array(
                                                                                        'id' => $newVal['ProductAttributeValue']['id'],
                                                                                        'name'=> $newVal['ProductAttributeValue']['name']
                                                                                        );
                }
            }
        }
        $this->set('ProductAttributes',$ProductAttributes);
        /////ATTRIBUTES LIST END/////////////////////////
    } 

    public function admin_edit($product_id=NULL)
    {            
        $searchKey = "";
        $pagecount = "";
        
        $this->Product->bindModel(array('hasAndBelongsToMany'=>array("Category")),false);
        $product_detail = $this->Product->findById($product_id);
        if(!empty($this->request->data))
        { 
            $fieldList = array('article_no','sku','name','description','price','price_actual','metal','weight','finishing','measure_band','measure_width','measure_height',
                               'cirumference','stone_length','stone_width','stone_depth','new_product','featured_product','active','Category.name as cat_name');            
                               
            $this->Product->id = $product_id; 
            $searchKey = $this->request->data['Product']['searchKey'];
            $pagecount = $this->request->data['Product']['pagecount'];
            
            $msg = "";
            
            if(!empty($this->request->data["Product"]["image"]['name'])){
                
                $image_path  = WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$product_detail['Product']['image'];
                $image_path2 = WWW_ROOT.PRODUCT_IMAGE_UPLOAD.'/thumbnail/'.$product_detail['Product']['image'];
                //$image_path3 = WWW_ROOT.PRODUCT_IMAGE_UPLOAD.'/large/'.$product_detail['Product']['image'];
                //if(file_exists($image_path) && file_exists($image_path2) && file_exists($image_path3)){   
                if(file_exists($image_path) && file_exists($image_path2)){                       
                    @unlink($image_path);
                    @unlink($image_path2); 
                    //@unlink($image_path3);
                }
                
                //upload photo
                if($this->Image->set_paths(WWW_ROOT.PRODUCT_IMAGE_UPLOAD,WWW_ROOT.PRODUCT_IMAGE_UPLOAD.'thumbnail/'))
                {
                    $this->request->data['Product']['image'] = $this->Image->upload_image('Product.image');
                    if($this->request->data['Product']['image']!="" && $this->request->data['Product']['image']!=false){
                        $this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->request->data['Product']['image'],WWW_ROOT.PRODUCT_IMAGE_UPLOAD."thumbnail/",PRODUCT_THUMB_WIDTH,PRODUCT_THUMB_HEIGHT);
                        //$large = $this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$this->request->data['Product']['image'],WWW_ROOT.PRODUCT_IMAGE_UPLOAD."large/",PRODUCT_BIG_WIDTH,PRODUCT_BIG_HEIGHT);
                        $fieldList[] = 'image';
                    }else{
                        $msg = 'Product image wrong file type.';
                    }
                } 
            }

            if($msg=="")
            {
                if($this->Product->save($this->request->data,false,$fieldList))
                {
                    $product_id= $this->Product->id;
                    foreach($this->request->data['ProductImage'] as $key=>$value)
                    {
                        if($value['product_image']['name']!="" && $value['product_image']['error']==UPLOAD_ERR_OK){
                            $file_name = $this->microtime_float().$value['product_image']['name'];
                            if(move_uploaded_file($value['product_image']['tmp_name'],WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$file_name)){
                                if($this->Image->set_paths(WWW_ROOT.PRODUCT_IMAGE_UPLOAD,WWW_ROOT.PRODUCT_IMAGE_UPLOAD)){
                                    $this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$file_name,WWW_ROOT.PRODUCT_IMAGE_UPLOAD."thumbnail/",PRODUCT_THUMB_WIDTH,PRODUCT_THUMB_HEIGHT);
                                    //$this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$file_name,WWW_ROOT.PRODUCT_IMAGE_UPLOAD."large/",PRODUCT_BIG_WIDTH,PRODUCT_BIG_HEIGHT);
                                } 
                                $this->request->data['ProductImage'][$key]['product_image'] = $file_name;                              
                                $this->request->data['ProductImage'][$key]['product_id'] = $product_id;                              
                            }else{
                                unset($this->request->data['ProductImage'][$key]);
                            }
                        }else{
                            unset($this->request->data['ProductImage'][$key]);
                        }
                    }
                    if(count($this->request->data['ProductImage'])>0){
                    $this->ProductImage->saveAll($this->request->data['ProductImage']);    
                    }
                    
                    
                    $this->ProductAttributeRelation->deleteAll(array('ProductAttributeRelation.product_id' =>$product_id));  
                    
                    // ADD ATTRIBUTES FOR PRODUCT START/////////////////
                    if(count($this->request->data['attributes'])>0){
                        foreach($this->request->data['attributes'] as $key=>$value){
                          if(count($value)>0){
                               foreach($value as $attribute_value_id){
                                   $this->ProductAttributeRelation->create();
                                   $attrdata['ProductAttributeRelation']['product_id']=$product_id;
                                   $attrdata['ProductAttributeRelation']['attribute_id']=$key;
                                   $attrdata['ProductAttributeRelation']['attribute_value_id']=$attribute_value_id;
                                   $this->ProductAttributeRelation->save($attrdata); 
                               } 
                          }                  
                        }    
                    } // ADD ATTRIBUTES FOR PRODUCT END/////////////////
                    
                    $this->Session->setFlash("<div class='alert alert-info'>Product is updated successfully.</div>");
                    
                    if($searchKey!=''){
                        $this->redirect("/admin/products/index/page:".$pagecount."/search:".$searchKey);
                    }else{
                        $this->redirect("/admin/products/index/page:".$pagecount);
                    }
                }else {
                    $this->Session->setFlash("<div class='alert alert-error'>Product could not be updated.</div>");
                }
            }
            $this->Session->setFlash("<div class='alert alert-error'>".$msg."</div>");

        }
        
        
        $this->request->data=$product_detail;

        $category_list = $this->Category->find("threaded",array("conditions"=>array("Category.active"=>1)));
        $categories=array();
        for($i=0;$i<count($category_list);$i++){
            $categories[$category_list[$i]['Category']['id']] = $category_list[$i]['Category']['name'];
            for($j=0;$j<count($category_list[$i]['children']);$j++){
                $categories[$category_list[$i]['children'][$j]['Category']['id']] ='---'.$category_list[$i]['children'][$j]['Category']['name']; 
            }
        }
        $this->set('categories',$categories);
        $this->set('pagecount', $pagecount);
        $this->set('searchKey', $searchKey);
        $galleryimage=$this->ProductImage->find('all',array('conditions'=>array('ProductImage.product_id'=>$product_id)));
        $this->set("galleryimage",$galleryimage);
        
        //ATTRIBUTES LIST///////////////////////////////////
        $AttributesArray = $this->ProductAttribute->find('all',array(
                                    'fields' => array('ProductAttribute.id','ProductAttribute.attribute_code','ProductAttributeValue.id','ProductAttributeValue.name','ProductAttributeValue.color_code','ProductAttributeValue.attribute_id'),
                                    'joins' => array(array(
                                                        'table' => 'product_attribute_values',
                                                        'alias' => 'ProductAttributeValue',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeValue.attribute_id=ProductAttribute.id','ProductAttributeValue.active'=> 1),
                                                        'order'=>'ProductAttributeValue.sort_order'                                                                               
                                                        )
                                                 ), 
                                    'conditions' => array('ProductAttribute.active'=> 1),
                                    'order'=>'ProductAttribute.sort_order',
                                    ));
        
         $ProductAttributes = array();
         foreach($AttributesArray as $values){
            $id = $values['ProductAttribute']['id'];
            $ProductAttributes[$id] = array(
              'id' => $id ,
              'name' => $values['ProductAttribute']['attribute_code']
            );
            foreach($AttributesArray as $newVal){
                if($id==$newVal['ProductAttributeValue']['attribute_id']){
                    $ProductAttributes[$id][$values['ProductAttribute']['attribute_code']][$newVal['ProductAttributeValue']['id']] = array(
                                                                                        'id' => $newVal['ProductAttributeValue']['id'],
                                                                                        'name'=> $newVal['ProductAttributeValue']['name']
                                                                                        );
                }
            }
        }
        $this->set('ProductAttributes',$ProductAttributes);
        $Selected_Attributes = $this->ProductAttributeRelation->find('list',array('fields'=>array('ProductAttributeRelation.id','ProductAttributeRelation.attribute_value_id'),'conditions'=>array('ProductAttributeRelation.product_id' =>$product_id)));
        $this->set('Selected_Attributes',$Selected_Attributes);
        //////////////////////////////  
    }  

    function admin_galleryimage_delete($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        $galleryimage_detail=$this->ProductImage->find('first',array('conditions'=>array('ProductImage.id'=>$id)));
        $image_path  = WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$galleryimage_detail['ProductImage']['product_image'];
        $image_path2 = WWW_ROOT.PRODUCT_IMAGE_UPLOAD.'/thumbnail/'.$galleryimage_detail['ProductImage']['product_image'];
        //$image_path3 = WWW_ROOT.PRODUCT_IMAGE_UPLOAD.'/large/'.$galleryimage_detail['ProductImage']['product_image'];

        //if(file_exists($image_path) && file_exists($image_path2) && file_exists($image_path3))
        if(file_exists($image_path) && file_exists($image_path2))
        {   
            @unlink($image_path);
            @unlink($image_path2); 
            //@unlink($image_path3); 

            if($this->ProductImage->delete($id)){
                $this->Session->setFlash("<div class='alert alert-error'>Product Gallery Image Deleted Successfully.</div>"); 
                $this->redirect("/admin/products/edit/".$galleryimage_detail['ProductImage']['product_id']);
            }else{
                $this->Session->setFlash("Product Gallery Image Can't Deleted, Please Try Again !."); 
                $this->redirect("/admin/products/edit/".$galleryimage_detail['ProductImage']['product_id']);
            }
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Product Gallery Image Not Found.</div>"); 
            $this->redirect("/admin/products/edit/".$galleryimage_detail['ProductImage']['product_id']);
        }
    }

    public function admin_delete($product_id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        
        if(!$product_id){
            $this->Session->setFlash("<div class='alert alert-error'>No Product selected for deletion.</div>"); 
            $this->redirect("/admin/products/");
        }
        
        if($this->Product->mydelete($product_id)){
            $this->Session->setFlash("<div class='alert alert-info'>Product deleted successfully.</div>"); 
            $this->redirect("/admin/products/");
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>Product could not be deleted.</div>"); 
            $this->redirect("/admin/products/");
        }
    }

    public function admin_inactive($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
       
        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No product is selected for inactive.</div>"); 
            $this->redirect("/admin/");
        }

        $this->Product->id = $id;
        $this->Product->set("active","0");
     
        if($this->Product->save())
        {
            $this->Session->setFlash("<div class='alert alert-info'>This Product is inactive successfully.</div>");
            if($searchKey!=''){
                $this->redirect("/admin/products/index/page:".$pagecount."/search:".$searchKey);
            }else{
                $this->redirect("/admin/products/index/page:".$pagecount);
            }
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>This Product is not inactive ? Try Again.</div>");
        }
    } 

    public function admin_active($id=NULL)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        
        if(!$id){
            $this->Session->setFlash("<div class='alert alert-error'>No product is selected for active.</div>"); 
            $this->redirect("/admin/");
        }

        $this->Product->id = $id;
        $this->Product->set("active","1");

        if($this->Product->save())
        {
            $this->Session->setFlash("<div class='alert alert-info'>This Product is active successfully.</div>");
            if($searchKey!=''){
                $this->redirect("/admin/products/index/page:".$pagecount."/search:".$searchKey);
            }else{
                $this->redirect("/admin/products/index/page:".$pagecount);
            }
        }else{
            $this->Session->setFlash("<div class='alert alert-error'>This Product is not active ? Try Again.</div>");
        }
    }

    public function admin_product_upload($id=Null)
    {
       if($this->request->data)
       {
        // UPLOAD FEED PRODUCTS TO DATABASE
        if(!empty($this->request->data["Product"]["csvfile"]['name'])){
            $file_name = 'product_file.csv';  
            $file_path = WWW_ROOT.PRODUCT_FILE_UPLOAD.$file_name;
            
            if($this->request->data["Product"]["csvfile"]['name']!="" && $this->request->data["Product"]["csvfile"]['error']==UPLOAD_ERR_OK){
                if(move_uploaded_file($this->request->data['Product']['csvfile']['tmp_name'],$file_path)){
                    if(file_exists($file_path)){
                        $handle = fopen($file_path,"r");
                        $firstRow=1;
                        $lines_to_skip=1;
                        while(($dataRow=fgetcsv($handle,100000,"\t"))!==FALSE){
                            if($firstRow>$lines_to_skip){
                                $data=array();
                                $product_images=array();
                                $data['Product']['article_no']=$dataRow[1];
                                $data['Product']['sku']=$dataRow[2];
                                $data['Product']['name']=$dataRow[3];
                                $data['Product']['description']=$dataRow[4];
                                $data['Product']['price']=$dataRow[5];
                                $data['Product']['price_actual']=$dataRow[6];
                                $data['Product']['metal']=$dataRow[7];
                                $data['Product']['weight']=$dataRow[8];
                                $data['Product']['finishing']=$dataRow[9];
                                $data['Product']['measure_band']=$dataRow[10];
                                $data['Product']['measure_width']=$dataRow[11];
                                $data['Product']['measure_height']=$dataRow[12];
                                $data['Product']['cirumference']=$dataRow[13];
                                $data['Product']['stone_length']=$dataRow[14];
                                $data['Product']['stone_width']=$dataRow[15];
                                $data['Product']['stone_depth']=$dataRow[16];
                                $data['Product']['new_product']=$dataRow[17];
                                $data['Product']['featured_product']=$dataRow[18];
                                $data['Product']['active']= $dataRow[19];
                                
                                $product_images = explode(',',$dataRow[20]);
                                $productimages_upload = $product_images;
                                $product_mainimage = array_shift($product_images);
                                $data['Product']['image']=$product_mainimage;
                                
                                $product_data=$this->Product->find('first',array("fields"=>array("Product.id,Product.article_no"),'conditions'=>array('Product.article_no'=>$dataRow[1])));

                                if(count($product_data['Product'])>0){
                                    $this->Product->id=$product_data['Product']['id'];
                                    $this->CategoriesProduct->deleteAll(array('CategoriesProduct.product_id' =>$product_data['Product']['id']),false);
                                    $this->ProductImage->deleteAll(array('ProductImage.product_id' =>$product_data['Product']['id']),false);    
                                }else{
                                    $this->Product->create();  
                                }
                                $this->Product->set($data);
                                if($this->Product->save($data)){
                                    $product_id=$this->Product->id;
                                    
                                    //START UPDATE PRODUCT CATEGORY MANAGEMENT 
                                    $this->CategoriesProduct->create();
                                    $Product_Categories=explode(',',$dataRow[0]);
                                    foreach($Product_Categories as $category_id){
                                        if(!empty($category_id)){
                                            $catdata=array();
                                            $this->CategoriesProduct->create();
                                            $catdata['CategoriesProduct']['product_id']=$product_id; 
                                            $catdata['CategoriesProduct']['category_id']=$category_id;
                                            $this->CategoriesProduct->set($catdata); 
                                            $this->CategoriesProduct->save($catdata);
                                        }    
                                    }
                                    //END UPDATE PRODUCT CATEGORY MANAGEMENT 
                                    
                                    //START UPDATE PRODUCT GALLERY IMAGE MANAGEMENT
                                    if(count($product_images)>0){
                                      foreach($product_images as $imagename){
                                        $gallerydata=array();  
                                        $this->ProductImage->create();
                                        $gallerydata['ProductImage']['product_id']=$product_id; 
                                        $gallerydata['ProductImage']['product_image']=$imagename;
                                        $this->ProductImage->set($gallerydata); 
                                        $this->ProductImage->save($gallerydata);
                                      }  
                                    }
                                    
                                    if(count($productimages_upload)>0){
                                        foreach($productimages_upload as $image){
                                            if($this->Image->set_paths(WWW_ROOT.PRODUCT_IMAGE_UPLOAD,WWW_ROOT.PRODUCT_IMAGE_UPLOAD)){
                                                $this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$image,WWW_ROOT.PRODUCT_IMAGE_UPLOAD."thumbnail/",PRODUCT_THUMB_WIDTH,PRODUCT_THUMB_HEIGHT);
                                                //$this->Image->thumb(WWW_ROOT.PRODUCT_IMAGE_UPLOAD.$image,WWW_ROOT.PRODUCT_IMAGE_UPLOAD."large/",PRODUCT_BIG_WIDTH,PRODUCT_BIG_HEIGHT);
                                            }
                                        }
                                    }
                                    //END UPDATE PRODUCT GALLERY IMAGE MANAGEMENT 
                                }
                            }
                            $firstRow++;
                        }
                    }
                }
            }               
        }
        
        
        // UPLOAD FEED PRODUCTS ATTRIBUTES TO DATABASE
        if(!empty($this->request->data["Product"]["attributecsvfile"]['name']) && $this->request->data["Product"]["attributecsvfile"]['name']!="" && $this->request->data["Product"]["attributecsvfile"]['error']==UPLOAD_ERR_OK){
            $file_name = 'product_attribute_file.csv';  
            $file_path = WWW_ROOT.PRODUCT_FILE_UPLOAD.$file_name;
            if(move_uploaded_file($this->request->data['Product']['attributecsvfile']['tmp_name'],$file_path)){
                if(file_exists($file_path)){
                    $handle = fopen($file_path,"r");
                    $firstRow=1;
                    $lines_to_skip=1;
                    $article_no=0;
                    while(($dataRow=fgetcsv($handle,100000,"\t"))!==FALSE){
                        if($firstRow>$lines_to_skip){
                            $product_data=$this->Product->find('first',array("fields"=>array("Product.id,Product.article_no"),'conditions'=>array('Product.article_no'=>$dataRow[0])));
                            if(count($product_data['Product'])>0){
                                $product_id=$product_data['Product']['id'];
                                if($article_no!=$dataRow[0]){
                                    $this->ProductAttributeRelation->deleteAll(array('ProductAttributeRelation.product_id'=>$product_id));     
                                }
                                $article_no=$product_data['Product']['article_no'];
                                
                                $ProductAttribute = $this->ProductAttribute->findByAttributeCode($dataRow[1]);
                                $attribute_id = $ProductAttribute['ProductAttribute']['id'];
                                
                                $ProductAttributeValue = $this->ProductAttributeValue->findByName($dataRow[2]);
                                $attribute_value_id = $ProductAttributeValue['ProductAttributeValue']['id'];
                                
                                $this->ProductAttributeRelation->create();
                                $attrdata['ProductAttributeRelation']['product_id']=$product_id;
                                $attrdata['ProductAttributeRelation']['attribute_id']=$attribute_id;
                                $attrdata['ProductAttributeRelation']['attribute_value_id']=$attribute_value_id;
                                $attrdata['ProductAttributeRelation']['quantity']=$dataRow[3];
                                $this->ProductAttributeRelation->set($attrdata); 
                                $this->ProductAttributeRelation->save($attrdata);
                            }
                        }
                        $firstRow++;
                  } // END OF WHILE
                }
             }   
        } // END OF ATTRIBUTE ADD
        $this->Session->setFlash("<div class='alert alert-info'>Product csv file uploaded successfully.</div>");
        $this->redirect("/admin/products/");
       } 
    }

    public function admin_product_report()
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        $filename='product_report.csv';
        header("Pragma: private");
        header("Cache-control: private, must-revalidate");
        header("Content-type: text/csv");
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        
        $fieldArr = array('id','article_no','sku','name','description','price','price_actual','metal','weight','finishing','measure_band','measure_width','measure_height','cirumference','stone_length','stone_width','stone_depth','new_product','featured_product','active','image');
        $productList = $this->Product->find("all",array("fields"=>$fieldArr));
        
        $seperator="\t";
        $csvcontent='';
        $csvcontent.= "Category".$seperator."Article_No".$seperator."Sku#".$seperator."Product_Name".$seperator."Description".$seperator."Price".$seperator."Price_Actual".$seperator."Metal".$seperator."Weight".$seperator."Finishing".$seperator."Measurement_Band".$seperator."Measurement_Width".$seperator."Measurement_Height".$seperator."Circumference".$seperator."Stone_Length".$seperator."Stone_Width".$seperator."Stone_Depth".$seperator."New_Product".$seperator."Featured_Product".$seperator."Active".$seperator."Image"."\n";
        
        for($i=0;$i<count($productList);$i++){
            $pro_id=$productList[$i]['Product']['id'];
            // ADD CATEGORY FOR THE PRODUCT
            $categorylist = $this->CategoriesProduct->find("all",array("fields"=>array("CategoriesProduct.category_id"),"conditions"=>array("CategoriesProduct.product_id"=>$pro_id)));
            $category = "";
            for($j=0;$j<count($categorylist);$j++){
                $category.=$categorylist[$j]['CategoriesProduct']['category_id'].",";
            }
            $category=substr($category,0,strlen($category)-1);
            ///////////////////////////////////////////////////////
            
            // ADD PRODUCT IMAGES FOR THE PRODUCT
            $product_images = $productList[$i]['Product']['image'];
            $gallerylist = $this->ProductImage->find("all",array("fields"=>array("ProductImage.product_image"),"conditions"=>array("ProductImage.product_id"=>$pro_id)));
            for($k=0;$k<count($gallerylist);$k++){
                $product_images.=','.$gallerylist[$k]['ProductImage']['product_image'];
            }
            ///////////////////////////////////////////////////////
            
            $csvcontent.= $category.$seperator.$productList[$i]['Product']['article_no'].$seperator.$productList[$i]['Product']['sku'].$seperator.$productList[$i]['Product']['name'].$seperator.$productList[$i]['Product']['description'].$seperator.$productList[$i]['Product']['price'].$seperator.$productList[$i]['Product']['price_actual'].$seperator.$productList[$i]['Product']['metal'].$seperator.$productList[$i]['Product']['weight'].$seperator.$productList[$i]['Product']['finishing'].$seperator.$productList[$i]['Product']['measure_band'].$seperator.$productList[$i]['Product']['measure_width'].$seperator.$productList[$i]['Product']['measure_height'].$seperator.$productList[$i]['Product']['cirumference'].$seperator.$productList[$i]['Product']['stone_length'].$seperator.$productList[$i]['Product']['stone_width'].$seperator.$productList[$i]['Product']['stone_depth'].$seperator.$productList[$i]['Product']['new_product'].$seperator.$productList[$i]['Product']['featured_product'].$seperator.$productList[$i]['Product']['active'].$seperator.$product_images."\n";
        }
        echo $csvcontent; 
        exit;
    }
    
    public function admin_product_attribute_report()
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        $filename='product_attribute_report.csv';
        header("Pragma: private");
        header("Cache-control: private, must-revalidate");
        header("Content-type: text/csv");
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        
        $fieldArr = array('id','article_no');
        $productList = $this->Product->find("all",array("fields"=>$fieldArr));
        
        $seperator="\t";
        $csvcontent='';
        $csvcontent.= "Article_No".$seperator."Attribute_Name".$seperator."Attribute_Value_Name".$seperator."Quantity"."\n";
        
        for($i=0;$i<count($productList);$i++){
            $product_id=$productList[$i]['Product']['id'];
            $article_no=$productList[$i]['Product']['article_no'];
            
            $ProductAttributelist = $this->ProductAttributeRelation->find("all",array("conditions"=>array("ProductAttributeRelation.product_id"=>$product_id),'order'=>'ProductAttributeRelation.product_id'));
            for($j=0;$j<count($ProductAttributelist);$j++){
                $attribute_id=$ProductAttributelist[$j]['ProductAttributeRelation']['attribute_id'];
                $attribute_value_id=$ProductAttributelist[$j]['ProductAttributeRelation']['attribute_value_id'];
                $quantity=$ProductAttributelist[$j]['ProductAttributeRelation']['quantity'];
                
                $ProductAttribute = $this->ProductAttribute->findById($attribute_id);
                $attribute_name = $ProductAttribute['ProductAttribute']['attribute_code'];
                
                $ProductAttributeValue = $this->ProductAttributeValue->findById($attribute_value_id);
                $attribute_value_name = $ProductAttributeValue['ProductAttributeValue']['name'];
                
                $csvcontent.= $article_no.$seperator.$attribute_name.$seperator.$attribute_value_name.$seperator.$quantity."\n";
            }
        }
        echo $csvcontent; 
        exit;
    }

    public function view($category_id=null){ 
    }

    public function product_list($parent_category_id=null)
    {
        $this->autoLayout=false;
        
        //////////CHECK POST DATA
        if($this->request->data){
            $ArrayPostData = $this->request->data;
            $this->Session->write('SessionLeftFilter',$ArrayPostData);
        }else{
            $ArrayPostData = array();
        }
        //////////////////////////////////////////
        
        ////// CHECK PARENT CATEGORY
        if(!empty($parent_category_id)){
            if($parent_category_id!=($this->Session->read('Session_ParentId'))){
                $this->Session->write('Session_ParentId',$parent_category_id);
                $this->Session->delete('SessionLeftFilter');
            }  
            $main_category_data = $this->Category->find('first',array('fields' => array('Category.id','Category.name'),'conditions' => array('Category.id'=>$parent_category_id)));
            $this->set('main_category_data',$main_category_data);
        }
        //////////////////////////////////////////
        
        ////// CHECK FOR SUBCATEGORY
        $AllCategoryArray=array();
        $AllSubCategoryArray=array();
        if(!empty($parent_category_id)){
            $AllCategoryArray[]=$parent_category_id;
            
            $SubCategory_list = $this->Category->find('list',array('fields' => array('Category.id','Category.name'),'conditions' => array('Category.parent_id'=>$parent_category_id)));
            foreach($SubCategory_list as $key => $values){
                $AllCategoryArray[] = $key;
                $AllSubCategoryArray[]=$key;
            } 
        }
        //////////////////////////////////////////
        
        // CHECK FOR SUBCATEGORY WHICH HAVE ACTIVE PRODUCTS
        $conditions = array("Category.active" => 1, "Category.id"=>$AllSubCategoryArray);
        $conditionsSubQuery[] = '`CategoriesProduct`.`category_id`=`Category`.`id`';
        $conditionsSubQuery[] = '`Product`.`active`= 1';
        $db = $this->Product->getDataSource();
        $subQuery = $db->buildStatement(
                        array(
                        'fields' => array('count(*)'),
                        'table' => $db->fullTableName($this->Product),
                        'alias' => 'Product',
                        'limit' => null,
                        'offset' => null,
                        'joins' => array(
                            array('table' => 'categories_products',
                                'alias' => 'CategoriesProduct',
                                'type' => 'INNER',
                                'conditions' => array('CategoriesProduct.product_id = Product.id'))
                        ),
                        'conditions' => $conditionsSubQuery,
                        'order' => null,
                        'group' => null
                            ), $this->Product
                    );
        $conditions[] = $db->expression('(' . $subQuery . ') > 0');
        $this->Category->virtualFields['product_count']=$subQuery;
        $list_subcategory = $this->Category->find("all", array("fields" => array('DISTINCT Category.id','Category.name', 'Category.product_count'),"conditions" => $conditions));
        $this->set('list_subcategory',$list_subcategory);
        ///////////////////////////////////////////////////////////////  
         
        
        ////// CHECK SESSION FILTER VALUES
        $Session_SubCategory= array();
        $ArrayRelationId=array();
        if(is_array($this->Session->read('SessionLeftFilter.Product')))
        {
            $ArraySessionChecked = $this->Session->read('SessionLeftFilter.Product');
            foreach($ArraySessionChecked as $keySess => $valSess)
            {
                $keyname = explode("_",$keySess);     
                if($valSess!=0 && $keySess!='price_search' && $keyname[0]=='subcat'){
                    $Session_SubCategory[]= $valSess;
                }elseif($valSess!=0 && $keySess!='price_search' && $keyname[0]!='subcat'){
                    $ArrayRelationId[] = $valSess;
                }
            }     
        }
        //////////////////////////////////////////
        
        // CHECK FOR SUB CATEGORY SELECTION BY FILER 
        if(count($Session_SubCategory)>0){
           $AllCategoryArray=$Session_SubCategory;
        }
        $ProductsId_Array = $this->Product->find('list', 
                                                array("fields" => array('Product.id'),
                                                'joins' => array(array(
                                                           'table' => 'categories_products',
                                                            'alias' => 'CategoriesProduct',
                                                            'type' => 'INNER',
                                                            'conditions' => array('CategoriesProduct.product_id = Product.id')
                                                            )
                                                        ),
                                                         "conditions" => array("Product.active" => 1,
                                                                               'CategoriesProduct.category_id'=>$AllCategoryArray
                                                                         ),
                                                        'group'=>'Product.id'
                                                     )
                                               );
        ////////// CHECK MAX AND MIN PRICE START
        $PriceArray = $this->Product->find('first',array('fields'=> array('MIN(Product.price) AS Min','MAX(Product.price) AS Max'),'conditions' => array('Product.id'=>$ProductsId_Array)));
        
        $MinimumPrice=$PriceArray[0]['Min'];
        $MaximumPrice=$PriceArray[0]['Max'];
        
        $stepmove = round(($MaximumPrice-$MinimumPrice)/50);
        $this->set('stepmove',$stepmove);
        
        $this->set('price_min',$MinimumPrice); 
        $this->set('price_max',$MaximumPrice);
        
        if(!empty($ArraySessionChecked['price_search']))
        {
            $ps= explode(',',$ArraySessionChecked['price_search']);
            $MinimumPrice=$ps[0];
            $MaximumPrice=$ps[1];
            $this->set('price_start',$ps[0]);  
            $this->set('price_end',$ps[1]);
        }else{
            $this->set('price_start',$MinimumPrice);  
            $this->set('price_end',$MaximumPrice);  
        }
        ////////// CHECK MAX AND MIN PRICE END
        
        $AttributesArray = $this->ProductAttribute->find('all',array(
                                    'fields' => array('ProductAttribute.id','ProductAttribute.attribute_code','ProductAttributeValue.id','ProductAttributeValue.name','ProductAttributeValue.color_code','ProductAttributeValue.attribute_id'),
                                    'joins' => array(array(
                                                        'table' => 'product_attribute_values',
                                                        'alias' => 'ProductAttributeValue',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeValue.attribute_id=ProductAttribute.id',
                                                                               'ProductAttributeValue.active'=> 1)
                                                        ),
                                                        array(
                                                        'table' => 'product_attribute_relations',
                                                        'alias' => 'ProductAttributeRelation',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeRelation.product_id'=>$ProductsId_Array,
                                                                               'ProductAttributeRelation.attribute_value_id=ProductAttributeValue.id'
                                                                        )
                                                        
                                                        )
                                                 ), 
                                    'conditions' => array('ProductAttribute.active'=> 1),
                                    'order'=>'ProductAttribute.sort_order',
                                    ));
        
         $arrayLeftValues = array();
         foreach($AttributesArray as $values){
            $id = $values['ProductAttribute']['id'];
            $arrayLeftValues[$id] = array(
              'id' => $id ,
              'name' => $values['ProductAttribute']['attribute_code']
            );
            foreach($AttributesArray as $newVal){
                if($id==$newVal['ProductAttributeValue']['attribute_id'])
                {
                    $arrayLeftValues[$id][$values['ProductAttribute']['attribute_code']][$newVal['ProductAttributeValue']['id']] = array(
                                                                                        'id' => $newVal['ProductAttributeValue']['id'],
                                                                                        'name'=> $newVal['ProductAttributeValue']['name']
                                                                                        );
                }
            }
        }
        
        $this->set('leftArr',$arrayLeftValues);
        /////////////////////////////////////////////////////////
        
        
        if(count($ArrayRelationId)>0){
          $AttributeValuesArray=array(
                                    'table' => 'product_attribute_relations',
                                    'alias' => 'ProductAttributeRelation',
                                    'type' => 'INNER',
                                    'conditions' => array('ProductAttributeRelation.product_id = Product.id',
                                                           'ProductAttributeRelation.attribute_value_id'=>$ArrayRelationId
                                                          )
                                    );  
        }else{
           $AttributeValuesArray='';
        }
        
                                    
        
        if(!empty($ArraySessionChecked['order_by'])){
            if($ArraySessionChecked['order_by']=='newest'){
                $orderby=array("Product.created"=>'DESC');    
            }elseif($ArraySessionChecked['order_by']=='highest'){
                $orderby=array('Product.price'=> 'DESC' );   
            }elseif($ArraySessionChecked['order_by']=='lowest'){
                $orderby=array('Product.price'=> 'ASC' );   
            }elseif($ArraySessionChecked['order_by']=='rating'){
                $orderby=array('Product.rating'=> 'DESC' );   
            }
        }else{
            $orderby=array("Product.created"=>'DESC');    
        }
        
        $this->paginate = array('Product' =>array('all', 
                                                 "fields" => array('DISTINCT Product.id','Product.name','Product.image','Product.description','Product.price','Product.price_actual','Product.new_product'/*,'Product.rating_avg'*/),
                                                 'limit' => 9,
                                                 'order' =>$orderby,    
                                                 'joins' => array(array(
                                                            'table' => 'categories_products',
                                                            'alias' => 'CategoriesProduct',
                                                            'type' => 'INNER',
                                                            'conditions' => array('CategoriesProduct.product_id = Product.id')
                                                            ),
                                                                $AttributeValuesArray
                                                            ),
                                                 'conditions'=> array("Product.active" => 1,
                                                                       'CategoriesProduct.category_id'=>$AllCategoryArray,
                                                                       'Product.price BETWEEN ? AND ?'=> array($MinimumPrice,$MaximumPrice),
                                                                       ),
                                                                       'group'=>'Product.id'
                                                     ));
        
        $list_products = $this->paginate('Product');
        $this->set('productListArray',$list_products);
        ///////////////////////////////////////////////////////////////////
        
        //echo '<pre>';
        //print_r($this->Session->read('SessionLeftFilter'));
        //print_r($arrayLeftValues);
        //exit;
    }

    public function product_popup($id)
    {
       $this->autoLayout=false;
       
       $this->Product->bindModel(array('hasMany'=> array('ProductImage'=> array('foreignKey'=>'product_id','fields'=>array('ProductImage.*'),'order'=>array('ProductImage.id'=>'ASC')))));
       $productDetail = $this->Product->find('first',array('conditions'=>array('Product.active'=>1,'Product.id'=>$id)));  
       
       $AttributesArray = $this->ProductAttribute->find('all',array(
                                    'fields' => array('ProductAttribute.id','ProductAttribute.attribute_code','ProductAttributeValue.id','ProductAttributeValue.name','ProductAttributeValue.color_code','ProductAttributeValue.attribute_id'),
                                    'joins' => array(array(
                                                        'table' => 'product_attribute_values',
                                                        'alias' => 'ProductAttributeValue',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeValue.attribute_id=ProductAttribute.id',
                                                                               'ProductAttributeValue.active'=> 1)
                                                        ),
                                                        array(
                                                        'table' => 'product_attribute_relations',
                                                        'alias' => 'ProductAttributeRelation',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeRelation.product_id'=>$id,
                                                                               'ProductAttributeRelation.attribute_value_id=ProductAttributeValue.id'
                                                                        )
                                                        
                                                        )
                                                 ), 
                                    'conditions' => array('ProductAttribute.active'=> 1),
                                    'order'=>'ProductAttribute.sort_order',
                                    ));
        
         $ProductAttributes = array();
         foreach($AttributesArray as $values){
            $id = $values['ProductAttribute']['id'];
            $ProductAttributes[$id] = array(
              'id' => $id ,
              'name' => $values['ProductAttribute']['attribute_code']
            );
            foreach($AttributesArray as $newVal){
                if($id==$newVal['ProductAttributeValue']['attribute_id'])
                {
                    $ProductAttributes[$id][$values['ProductAttribute']['attribute_code']][$newVal['ProductAttributeValue']['id']] = array(
                                                                                        'id' => $newVal['ProductAttributeValue']['id'],
                                                                                        'name'=> $newVal['ProductAttributeValue']['name']
                                                                                        );
                }
            }
        }
        
        $this->set("productDetail",$productDetail);
        $this->set("ProductAttributes",$ProductAttributes);
        /////////// Quantity
        /*$qty=array();
        for($i=1; $i<=10; $i++){
          $qty[$i]=$i;  
        }
        $this->set("quantity",$qty); */
        /*echo '<pre>';
        print_r($productDetail);*/
       
    }

    public function detail($productId)
    {
       $this->Product->bindModel(array('hasAndBelongsToMany' => array("Category"))); 
       $this->Product->bindModel(array('hasMany'=> array('ProductImage'=> array('foreignKey'=>'product_id','fields'=>array('ProductImage.*'),'order'=>array('ProductImage.id'=>'ASC')))));
       $productDetail = $this->Product->find('first',array('recursive'=>2,'conditions'=>array('Product.active'=>1,'Product.id'=>$productId)));  
      
       $AttributesArray = $this->ProductAttribute->find('all',array(
                                    'fields' => array('ProductAttribute.id','ProductAttribute.attribute_code','ProductAttributeValue.id','ProductAttributeValue.name','ProductAttributeValue.color_code','ProductAttributeValue.attribute_id'),
                                    'joins' => array(array(
                                                        'table' => 'product_attribute_values',
                                                        'alias' => 'ProductAttributeValue',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeValue.attribute_id=ProductAttribute.id',
                                                                               'ProductAttributeValue.active'=> 1)
                                                        ),
                                                        array(
                                                        'table' => 'product_attribute_relations',
                                                        'alias' => 'ProductAttributeRelation',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeRelation.product_id'=>$productId,
                                                                               'ProductAttributeRelation.attribute_value_id=ProductAttributeValue.id'
                                                                        )
                                                        
                                                        )
                                                 ), 
                                    'conditions' => array('ProductAttribute.active'=> 1),
                                    'order'=>'ProductAttribute.sort_order',
                                    ));
        
            
         $ProductAttributes = array();
         foreach($AttributesArray as $values){
            $id = $values['ProductAttribute']['id'];
            $ProductAttributes[$id] = array(
              'id' => $id ,
              'name' => $values['ProductAttribute']['attribute_code']
            );
            foreach($AttributesArray as $newVal){
                if($id==$newVal['ProductAttributeValue']['attribute_id'])
                {
                    $ProductAttributes[$id][$values['ProductAttribute']['attribute_code']][$newVal['ProductAttributeValue']['id']] = array(
                                                                                        'id' => $newVal['ProductAttributeValue']['id'],
                                                                                        'name'=> $newVal['ProductAttributeValue']['name']
                                                                                        );
                }
            }
        }
        
        $this->set("productDetail",$productDetail);
        $this->set("ProductAttributes",$ProductAttributes);
        ////////////////////////////////////////////////////////////////////////////////
        
        // FOR SIMILAR PRODUCTS CODE START
        if(count($productDetail['Category'])>0){
            for($j=0;$j<count($productDetail['Category']);$j++){
                $CategoryArray[$j]=$productDetail['Category'][$j]['id'];
            }
        }
        
        $fieldArr =array('Product.id','Product.name','Product.price','Product.price_actual','Product.image');
        $conditions = array("conditions"=>array('Category.id'=>$CategoryArray,'Product.id <>'=>$productId),
                            'limit' => 4,
                            'fields'=>$fieldArr,
                            'order' =>'Product.name DESC',
                            'group'=> 'Product.id',           
                            "joins"=>array( 
                            array('table' => 'categories_products',
                            'alias' => 'CategoryProduct',
                            'type' => 'INNER',
                            'conditions' => array('CategoryProduct.product_id = Product.id')),
                            array('table' => 'categories',
                            'alias' => 'Category',
                            'type' => 'INNER',
                            'conditions' => array('Category.id = CategoryProduct.category_id')
                            )
                            ));

        $similar_products = $this->Product->find("all",$conditions);
        $this->set("similar_products",$similar_products);
        // FOR SIMILAR PRODUCTS CODE END
        
        $reviews = $this->Rating->find('all', array('conditions' => array('Rating.product_id'=>$productId),'limit'=>5,'order' =>'Rating.id DESC'));
        $this->set("reviews",$reviews);
        
        $user_id = $this->Session->read('userId');
        $user_review = $this->Rating->find('first', array('conditions' => array('Rating.product_id'=>$productId,'Rating.user_id'=>$user_id)));
        $this->set("user_review",$user_review);
        
        //// CHECK FOR PARENT CATEGORY SHOWN IN DETAIL PAGE FOR BREADCUM
        $categoryInfo = $this->Category->find('all',array('fields' => array('Category.parent_id'),'conditions' => array('Category.id'=>$CategoryArray[0])));
        if($categoryInfo[0]['Category']['parent_id']==0)
        $ParentCategoryId=$CategoryArray[0];
        else
        $ParentCategoryId=$categoryInfo[0]['Category']['parent_id'];
        $cat_name = $this->Category->find('first',array('fields'=>array('Category.id','Category.name'),'conditions'=>array('Category.id'=>$ParentCategoryId)));
        $this->set('cat_name',$cat_name);
        ///////////////////////////////////////////////////
    }

    public function wish_list($product_id=null)
    {               
        $this->autoLayout=false;
        $this->autoRender=false;
        
        $user_id = $this->Session->read('userId');
        $product_id = $product_id;

        $wishlist_detail = $this->WishList->find('first', array('conditions'=> array('user_id'=>$user_id,'product_id'=>$product_id)));            
        
        if(count($wishlist_detail)==0){
            $this->request->data['WishList']['user_id']=$user_id;
            $this->request->data['WishList']['product_id']=$product_id;

            $fieldList = array('user_id','product_id');  // for updating specific fields

            if($this->WishList->save($this->request->data,false,$fieldList)){
                echo '<span style="color: #00ABE7;">Added product in your Wishlist Successfully !</span>';
            }else {
                 echo '<span style="color: #FF0000;">Product not added in your Wishlist, Please try again !</span>';
            }
        }else{
            echo '<span style="color: #FF0000;">This product is already in your Wishlist !</span>';
        }
    }

    public function email_to_friend($product_id=null)
    {
        $this->autoLayout=false;
        
        if ($this->request->is('post') && !empty($this->request->data)) {
            $user_id = $this->Session->read('userId');
            $user_data = $this->User->find('first', array('conditions' => array('User.id' =>$user_id)));
            $email = $this->request->data['Product']['email_id'];
            $email_ids = explode(',',$email);
            $user_message = $this->request->data['Product']['message'];
            $product_link = SITE_URL.'products/detail/'.$product_id;
            
            if($_SERVER['HTTP_HOST']!='localhost'){
                
                $email_template = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.id' =>3)));
                if(empty($email_template)){
                    $mess = '<span style="color: #FF0000;">Email Template Doesn\'t exist !</span>';
                }else{
                    foreach($email_ids as $emailId){
                        $email = new CakeEmail();
                        $email->from(array($user_data['User']['email'] => $user_data['User']['firstname'].' '.$user_data['User']['lastname']));
                        $email->to(array($emailId =>''));
                        $email->emailFormat('html');
                        $email->subject($email_template['EmailTemplate']['subject']);
                        $description = $email_template['EmailTemplate']['content'];
                        $description = str_replace('##product_link##','<a href="'.$product_link.'">'.__('Click Here').'</a>', $description);
                        $description = str_replace('##user_message##', $user_message, $description);
                        $email->send($description);
                    }
                    $mess = '<span style="color: #00ABE7;">Email Successfully Send !</span>';
                }
            }
            echo $mess;
            exit;
         }
    }
    
    public function rating($product_id=null)
    {
       $this->autoLayout=false;
       $this->autoRender=false;
       
       if($this->Rating->save($this->request->data)){
           $overall = $this->request->data['Rating']['overall'];
           $comfort = $this->request->data['Rating']['comfort']; 
           $style = $this->request->data['Rating']['style'];  
           $avg_rating=round(($overall+$comfort+$style)/3);
           $product_rating = $this->Product->find('first',array('fields'=> array('rating'),'conditions'=>array('Product.id'=>$product_id)));
           $rating = $product_rating['Product']['rating']+$avg_rating;
           
           $this->Product->id=$product_id;
           $this->Product->saveField("rating",$rating);
           
           $this->Session->setFlash('<span style="color: #00ABE7;">Thanks for your review !</span>'); 
           $this->redirect("/products/detail/".$product_id);
       }else{
            $this->Session->setFlash('<span style="color: #FF0000;">Review not saved, Please try again !</span>'); 
            $this->redirect("/products/detail/".$product_id);
       }
    }
    
    public function check_quantity($product_id=null,$attribute_value_id=null,$quantity=null)
    {
        $this->autoLayout=false;
        $this->autoRender=false;
        
        if(!empty($product_id) && !empty($attribute_value_id)){
          if(empty($quantity)){
          $quantity=1;    
          }
        
          $ProductAttributeDetail = $this->ProductAttributeRelation->find("first",
                                                array("conditions"=>array("ProductAttributeRelation.product_id"=>$product_id,
                                                                           "ProductAttributeRelation.attribute_id"=>SIZE_ID,
                                                                           "ProductAttributeRelation.attribute_value_id"=>$attribute_value_id)));
           
          $product_quantity = $ProductAttributeDetail['ProductAttributeRelation']['quantity'];
          if(empty($product_quantity))
          $product_quantity=0;
          
          if($product_quantity>=$quantity)
          echo $product_quantity.'-1';
          else
          echo $product_quantity.'-0';;
       } 
       exit;
    }
    
    public function search(){
        if($this->request->data){
           $this->Session->write('Sess_Keyword',$this->request->data['Product']['keyword']); 
        }
    }

    public function searchajax()
    {
        $this->autoLayout=false;
        
        $keyword = $this->Session->read('Sess_Keyword');
        
        //////////CHECK POST DATA
        if($this->request->data){
            $ArrayPostData = $this->request->data;
            $this->Session->write('SessionLeftFilter',$ArrayPostData);
        }else{
            $ArrayPostData = array();
        }
        //////////////////////////////////////////
        
        ////// CHECK SESSION KEYWORD 
        if($keyword!=($this->Session->read('Session_Key'))){
          $this->Session->write('Session_Key',$keyword);
          $this->Session->delete('SessionLeftFilter');        
        }
        ///////////////////////////////////////////////////////////////  
         
        ////// CHECK SESSION FILTER VALUES
        $Session_SubCategory= array();
        $ArrayRelationId=array();
        if(is_array($this->Session->read('SessionLeftFilter.Product')))
        {
            $ArraySessionChecked = $this->Session->read('SessionLeftFilter.Product');
            foreach($ArraySessionChecked as $keySess => $valSess)
            {
                $keyname = explode("_",$keySess);     
                if($valSess!=0 && $keySess!='price_search' && $keyname[0]=='subcat'){
                    $Session_SubCategory[]= $valSess;
                }elseif($valSess!=0 && $keySess!='price_search' && $keyname[0]!='subcat'){
                    $ArrayRelationId[] = $valSess;
                }
            }     
        }
        //////////////////////////////////////////
        
        // CHECK FOR SUB CATEGORY SELECTION BY FILER 
        if(count($Session_SubCategory)>0){
           $AllCategoryArray=$Session_SubCategory;
        }
        $ProductsId_Array = $this->Product->find('list', 
                                                array("fields" => array('Product.id'),
                                                'joins' => array(array(
                                                           'table' => 'categories_products',
                                                            'alias' => 'CategoriesProduct',
                                                            'type' => 'INNER',
                                                            'conditions' => array('CategoriesProduct.product_id = Product.id')
                                                            )
                                                        ),
                                                         "conditions" => array("Product.active" => 1,
                                                                               "OR"=>array("Product.sku LIKE"=>'%'.$keyword.'%',"Product.name LIKE"=>'%'.$keyword.'%')
                                                                         ),
                                                        'group'=>'Product.id'
                                                     )
                                               );
        ////////// CHECK MAX AND MIN PRICE START
        $PriceArray = $this->Product->find('first',array('fields'=> array('MIN(Product.price) AS Min','MAX(Product.price) AS Max'),'conditions' => array('Product.id'=>$ProductsId_Array)));
        
        $MinimumPrice=$PriceArray[0]['Min'];
        $MaximumPrice=$PriceArray[0]['Max'];
        
        $stepmove = round(($MaximumPrice-$MinimumPrice)/50);
        $this->set('stepmove',$stepmove);
        
        $this->set('price_min',$MinimumPrice); 
        $this->set('price_max',$MaximumPrice);
        
        if(!empty($ArraySessionChecked['price_search']))
        {
            $ps= explode(',',$ArraySessionChecked['price_search']);
            $MinimumPrice=$ps[0];
            $MaximumPrice=$ps[1];
            $this->set('price_start',$ps[0]);  
            $this->set('price_end',$ps[1]);
        }else{
            $this->set('price_start',$MinimumPrice);  
            $this->set('price_end',$MaximumPrice);  
        }
        ////////// CHECK MAX AND MIN PRICE END
        
        $AttributesArray = $this->ProductAttribute->find('all',array(
                                    'fields' => array('ProductAttribute.id','ProductAttribute.attribute_code','ProductAttributeValue.id','ProductAttributeValue.name','ProductAttributeValue.color_code','ProductAttributeValue.attribute_id'),
                                    'joins' => array(array(
                                                        'table' => 'product_attribute_values',
                                                        'alias' => 'ProductAttributeValue',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeValue.attribute_id=ProductAttribute.id',
                                                                               'ProductAttributeValue.active'=> 1)
                                                        ),
                                                        array(
                                                        'table' => 'product_attribute_relations',
                                                        'alias' => 'ProductAttributeRelation',
                                                        'type' => 'INNER',
                                                        'conditions' => array('ProductAttributeRelation.product_id'=>$ProductsId_Array,
                                                                               'ProductAttributeRelation.attribute_value_id=ProductAttributeValue.id'
                                                                        )
                                                        
                                                        )
                                                 ), 
                                    'conditions' => array('ProductAttribute.active'=> 1),
                                    'order'=>'ProductAttribute.sort_order',
                                    ));
        
         $arrayLeftValues = array();
         foreach($AttributesArray as $values){
            $id = $values['ProductAttribute']['id'];
            $arrayLeftValues[$id] = array(
              'id' => $id ,
              'name' => $values['ProductAttribute']['attribute_code']
            );
            foreach($AttributesArray as $newVal){
                if($id==$newVal['ProductAttributeValue']['attribute_id'])
                {
                    $arrayLeftValues[$id][$values['ProductAttribute']['attribute_code']][$newVal['ProductAttributeValue']['id']] = array(
                                                                                        'id' => $newVal['ProductAttributeValue']['id'],
                                                                                        'name'=> $newVal['ProductAttributeValue']['name']
                                                                                        );
                }
            }
        }
        
        $this->set('leftArr',$arrayLeftValues);
        /////////////////////////////////////////////////////////
        
        
        if(count($ArrayRelationId)>0){
          $AttributeValuesArray=array(
                                    'table' => 'product_attribute_relations',
                                    'alias' => 'ProductAttributeRelation',
                                    'type' => 'INNER',
                                    'conditions' => array('ProductAttributeRelation.product_id = Product.id',
                                                           'ProductAttributeRelation.attribute_value_id'=>$ArrayRelationId
                                                          )
                                    );  
        }else{
           $AttributeValuesArray='';
        }
        
                                    
        
        if(!empty($ArraySessionChecked['order_by'])){
            if($ArraySessionChecked['order_by']=='newest'){
                $orderby=array("Product.created"=>'DESC');    
            }elseif($ArraySessionChecked['order_by']=='highest'){
                $orderby=array('Product.price'=> 'DESC' );   
            }elseif($ArraySessionChecked['order_by']=='lowest'){
                $orderby=array('Product.price'=> 'ASC' );   
            }elseif($ArraySessionChecked['order_by']=='rating'){
                $orderby=array('Product.rating'=> 'DESC' );   
            }
        }else{
            $orderby=array("Product.created"=>'DESC');    
        }
        
        $this->paginate = array('Product' =>array('all', 
                                                 "fields" => array('DISTINCT Product.id','Product.name','Product.image','Product.description','Product.price','Product.price_actual','Product.new_product'/*,'Product.rating_avg'*/),
                                                 'limit' => 9,
                                                 'order' =>$orderby,    
                                                 'joins' => array(array(
                                                            'table' => 'categories_products',
                                                            'alias' => 'CategoriesProduct',
                                                            'type' => 'INNER',
                                                            'conditions' => array('CategoriesProduct.product_id = Product.id')
                                                            ),
                                                                $AttributeValuesArray
                                                            ),
                                                 'conditions'=> array("Product.active" => 1,
                                                                       "OR"=>array("Product.sku LIKE"=>'%'.$keyword.'%',"Product.name LIKE"=>'%'.$keyword.'%'),
                                                                       'Product.price BETWEEN ? AND ?'=> array($MinimumPrice,$MaximumPrice),
                                                                       ),
                                                                       'group'=>'Product.id'
                                                     ));
        
        $list_products = $this->paginate('Product');
        $this->set('productListArray',$list_products);
        ///////////////////////////////////////////////////////////////////
    }   

} // END OF CLASS
?>
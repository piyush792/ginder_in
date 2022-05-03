<?php
  class DropDownComponent extends Component 
  {  
    var $components = array('Session');
    //used for get all blogs with name
    function getBlogs()
    {
      $listArr = array(); 
      $this->Blogs = ClassRegistry::init('Blogs');
      $options['joins'] = array(  
        array(  
          'table' => 'bloglps',  
          'alias' => 'Bloglps',  
          'type' => 'INNER',
          'conditions' => array('Bloglps.blog_id = Blogs.id',)  
        )  
      );
      $options['conditions']['Bloglps.language_id'] = $this->Session->read('languageid');
      $options['fields'] = array('Blogs.id','Bloglps.name');
      $listArr = $this->Blogs->find('list', $options); 
      return $listArr;
    }

    //used for get all blogs with name
    function getBlogsByUserId()
    {
      $listArr = array(); 
      $this->Blogs = ClassRegistry::init('Blogs');
      $options['joins'] = array(  
        array(  
          'table' => 'bloglps',  
          'alias' => 'Bloglps',  
          'type' => 'INNER',
          'conditions' => array('Bloglps.blog_id = Blogs.id',)  
        )  
      );
      $options['conditions']['Bloglps.language_id'] = $this->Session->read('languageid');
      $options['conditions']['Blogs.user_id'] = $this->Session->read('userId');

      $options['fields'] = array('Blogs.id','Bloglps.name');
      $listArr = $this->Blogs->find('list', $options); 
      return $listArr;
    }

    //used for get all posts with name
    function getPosts()
    {
      $listArr = array();
      $this->Posts = ClassRegistry::init('Posts');
      $options['joins'] = array(  
        array(  
          'table' => 'postlps',  
          'alias' => 'Postlps',  
          'type' => 'INNER',
          'conditions' => array('Postlps.post_id = Posts.id',)  
        )  
      );
      $options['conditions']['Postlps.language_id'] = $this->Session->read('languageid');
      $options['fields'] = array('Posts.id','Postlps.name');
      $listArr = $this->Posts->find('list', $options);
      return $listArr;         

    }

    //used for get all Blog Cateories with name
    function getBlogCategories()
    {
      $listArr = array();
      $this->BlogCats = ClassRegistry::init('BlogCats');
      $options['joins'] = array(  
        array(  
          'table' => 'blog_catlps',  
          'alias' => 'BlogCatlps',  
          'type' => 'INNER',
          'conditions' => array('BlogCatlps.blog_id = BlogCats.id',)  
        )  
      );
      $options['conditions']['BlogCatlps.language_id'] = $this->Session->read('languageid');
      $options['fields'] = array('BlogCats.id','BlogCatlps.name');
      $listArr = $this->BlogCats->find('list', $options); 
      return $listArr;          
    }

    //used for get all posts with name
    function getRoles()
    {
      $listArr = array();
      $this->Roles = ClassRegistry::init('Roles');
      $options['conditions']['status'] = '1';
      $options['fields'] = array('id','name');
      $listArr = $this->Roles->find('list', $options);
      return $listArr;         

    }

    //used for get all posts with name
    function getApplications()
    {
      $listArr = array();
      $this->Applications = ClassRegistry::init('Applications');
      $options['conditions']['active'] = '1';
      $options['fields'] = array('id','name');
      $listArr = $this->Applications->find('list', $options);
      return $listArr;         
    }

    //used for get all posts with name
    function getEshopsByUserId()
    {
      $listArr = array();
      $this->Eshops = ClassRegistry::init('Eshops');
      $options['conditions']['active'] = '1';
      $options['conditions']['user_id'] = $this->Session->read('userId');
      $options['fields'] = array('id','name');
      $listArr = $this->Eshops->find('list', $options);
      return $listArr;         
    }

    //used for get all posts with name
    function getAllCategories()
    {
      $all_categories = array();
      $this->Category = ClassRegistry::init('Category');
      $this->Categorylps = ClassRegistry::init('Categorylps');


      $joins_cat = array(
        'table' => 'categorylps',
        'alias' => 'Categorylps',
        'type' => 'INNER',
        'conditions' => array('Categorylps.category_id = Category.id')
      );

      $this->Category->bindModel(array('hasMany'=>array('SubCategory'=>array('className'  => 'Category','foreignKey'=>'parent_id','conditions'=>array('SubCategory.active'=>1)))));
      $listArr = $this->Category->find("all", array("fields" => array("Category.id","Categorylps.name"), 'joins' => array($joins_cat),"conditions" => array("language_id" => $this->Session->read('languageid'),"parent_id" => 0, "active" => 1)));


      for ($i = 0; $i < count($listArr); $i++) 
      { 
        if (count($listArr[$i]['SubCategory']) > 0) 
        {
          for ($j = 0; $j < count($listArr[$i]['SubCategory']); $j++) 
          {

            //$all_categories[$listArr[$i]['Category']['id']] =  $listArr[$i]['Categorylps']['name'];     
            $listArrlpsName  = $this->Categorylps->find("first",array("fields"=>array("Categorylps.category_id, Categorylps.name"),"conditions"=>array("Categorylps.category_id = '".$listArr[$i]['SubCategory'][$j]['id']."'","Categorylps.language_id='".$this->Session->read('languageid')."'")));
            //$all_categories[$listArr[$i]['Categorylps']['name']][$listArrlpsName['Categorylps']['category_id']] =  $listArrlpsName['Categorylps']['name'];

            $all_categories[$listArr[$i]['Categorylps']['name']][$listArrlpsName['Categorylps']['category_id']] =  $listArrlpsName['Categorylps']['name'];        

            $listArrlpsSubSubName  = $this->Category->find("all",array("fields"=>array("Category.id, Categorylps.name"), 'joins' => array($joins_cat), "conditions"=>array("Category.parent_id = '".$listArrlpsName['Categorylps']['category_id']."'","Categorylps.language_id='".$this->Session->read('languageid')."'")));

            foreach($listArrlpsSubSubName as $subSubCat)
            {
              $all_categories[$listArrlpsName['Categorylps']['name']][$subSubCat['Category']['id']] = $subSubCat['Categorylps']['name']; 

            } 

          }
        }    
      } 

      //$all_categories = array('Category'=>array('1'=>'SubCategory'),'SubCategory'=>array(1=>'text',2=>'tttt'));          

      return $all_categories;         

    }


    //used for get all posts with name
    function getAllThemes()
    {
      $all_categories = array();
      $this->Theme = ClassRegistry::init('Theme');



      $joins_cat = array(
        'table' => 'themeslps',
        'alias' => 'Themeslps',
        'type' => 'INNER',
        'conditions' => array('Themeslps.theme_id = Theme.id')
      );

      $listArr = $this->Theme->find("list", array("fields" => array("Theme.id","Themeslps.name"), 'joins' => array($joins_cat),"conditions" => array("language_id" => $this->Session->read('languageid'), "active" => 1)));

      return $listArr;         
    }

    // get all price ranges 
    function getAllPriceRanges() {

      $this->PriceRanges = ClassRegistry::init('PriceRanges');
      $priceRanges = $this->PriceRanges->find('all', array(
          'order' => 'PriceRanges.sort_order'
        ));

      return $priceRanges;
    }

    // get total number of items in each category
    function getCategoryTotalItems($catIds) 
    {
      $this->CategoriesProducts = ClassRegistry::init('CategoriesProducts');
      if(is_array($catIds)) {
        $inCat = implode($catIds,",");  
      }else{
        $inCat = $catIds; 
      }

      $total_items = $this->CategoriesProducts->find('all', array(
          'fields' => array("CategoriesProducts.id"),
          'joins' => array(
              array(
                'table' => 'products',
                'alias' => 'Products',
                'type' => 'INNER',
                'conditions' => array('Products.id = CategoriesProducts.product_id')
              )
            ),
          'conditions' => array('CategoriesProducts.category_id in ('.$inCat.')','Products.active=1')
        ));
      return count($total_items);
    }

    // get array of all subcategory ids in a parent category
    function getSubCategoryArray($catId) {
      $subCatArray = array();
      $this->Category = ClassRegistry::init('Category');
      $subCatArr = $this->Category->find('all', array(
          'fields' => array("Category.id"),
          'conditions' => array("Category.parent_id" => $catId)
        ));

      foreach($subCatArr as $value):
        array_push($subCatArray,$value['Category']['id']); 
        endforeach;

      return $subCatArray;
    }

    function getParentCategory($catId) {

      $this->Category = ClassRegistry::init('Category');
      $catArr = $this->Category->find('first', array(
          'fields' => array("Category.parent_id,Category.permalink"),
          'conditions' => array("Category.id" => $catId)
        ));

      return $catArr['Category']['parent_id'];
    }

    //used for get all blogs with name
    function getProductAttributes()
    {
      $listArr = array(); 
      $this->ProductAttributes = ClassRegistry::init('ProductAttributes');
      /*$options['joins'] = array(  
        array(  
          'table' => 'product_attribute_values',  
          'alias' => 'ProductAttributeValue',  
          'type' => 'INNER',
          'conditions' => array('ProductAttributeValue.attribute_id = ProductAttributes.id')  
        )  
      );*/
      //$options['conditions']['ProductAttributelps.language_id'] = $this->Session->read('languageId');
      $options['fields'] = array('ProductAttributes.id','ProductAttributes.attribute_code');
      $listArr = $this->ProductAttributes->find('list', $options); 
      return $listArr;
    }

    //get setting
    function getConfigSettings($field) {

      if($field == ""){
        return;  
      }

      $this->Settings = ClassRegistry::init('Settings');
      $settingArr = $this->Settings->find('first', array(
          'fields' => array($field),
          'conditions' => array()
        ));

      return $settingArr['Settings'][$field];
    }

    //used for get all posts with name
    function getAllDeliveryMethods()
    {
      $listArr = array();
      $this->DeliveryMethods = ClassRegistry::init('DeliveryMethods');

      $options['joins'] = array(  
        array(  
          'table' => 'delivery_methodlps',  
          'alias' => 'DeliveryMethodlps',  
          'type' => 'INNER',
          'conditions' => array('DeliveryMethodlps.delivery_method_id = DeliveryMethods.id',)  
        )  
      );
      $options['conditions']['DeliveryMethodlps.language_id'] = $this->Session->read('languageid');
      $options['fields'] = array('DeliveryMethods.id','DeliveryMethodlps.name');
      $listArr = $this->DeliveryMethods->find('list', $options);
      return $listArr;         

    }


    //used for get all payment methods with name
    function getAllPaymentMethods()
    {
      $listArr = array();
      $this->PaymentMethods = ClassRegistry::init('PaymentMethods');

      $options['joins'] = array(  
        array(  
          'table' => 'payment_methodlps',  
          'alias' => 'PaymentMethodlps',  
          'type' => 'INNER',
          'conditions' => array('PaymentMethodlps.payment_method_id = PaymentMethods.id',)  
        )  
      );
      $options['conditions']['PaymentMethodlps.language_id'] = $this->Session->read('languageid');
      $options['fields'] = array('PaymentMethods.id','PaymentMethodlps.name');
      $listArr = $this->PaymentMethods->find('list', $options);
      return $listArr;         

    }


    //used for get all payment methods with name
    function getAllProcessingTimes()
    {
      $listArr = array();
      $this->ProcessingTimes = ClassRegistry::init('ProcessingTimes');

      $options['conditions']['ProcessingTimes.active'] = 1;
      $options['fields'] = array('ProcessingTimes.id','ProcessingTimes.description');
      $listArr = $this->ProcessingTimes->find('list', $options);
      return $listArr;         

    }

    //used for get all payment methods with name
    function getAllCountries()
    {
      $listArr = array();
      $this->Countries = ClassRegistry::init('Countries');

      //$options['conditions']['ProcessingTimes.active'] = 1;
      $options['fields'] = array('Countries.id','Countries.countryname');
      $listArr = $this->Countries->find('list', $options);
      return $listArr;         

    }  


    //used for get all payment methods with name
    function getOptionalCountries($countryArr=array())
    {
      $listArr = array();
      $this->Countries = ClassRegistry::init('Countries');

      $options['conditions']['Countries.id NOT'] = $countryArr;
      $options['fields'] = array('Countries.id','Countries.countryname');

      $listArr = $this->Countries->find('list', $options);
      return $listArr;         

    }


    /**************
    *
    *Function userWiseCategory
    *Role: get category for user darshboard
    **/

    function getUserWiseCategory(){
      $userId = $this->Session->read('userId');
      $listArr = array();
      $this->BlogCats = ClassRegistry::init('BlogCats');
      $options['joins'] = array(  
        array(  
          'table' => 'blog_catlps',  
          'alias' => 'BlogCatlps',  
          'type' => 'INNER',
          'conditions' => array('BlogCatlps.blog_id = BlogCats.id',),
        )  , array('table' => 'blogs',
          'alias' => 'Blogs',
          'type' => 'INNER',
          'conditions' => array('Blogs.blog_cat=BlogCats.id')
        )
      );
      $options['conditions']['BlogCatlps.language_id'] = $this->Session->read('languageid');
      $options['conditions']['Blogs.user_id'] = $userId;
      $options['fields'] = array('BlogCats.id','BlogCatlps.name');
      $listArr = $this->BlogCats->find('list', $options); 
      return $listArr;  

    }

    function getCurrenciesList()
    {
      $currencylist=ClassRegistry::init('currencies')->find('all',array('fields'=>array('DISTINCT name','id'),'order'=>array('currencies.name ASC')));

      //print_r($countrylist);
      $currencies=array(''=>__('-Select Currency-'));

      foreach($currencylist as $key=>$currency)
      {
        $currencies[$currency['currencies']['id']]=$currency['currencies']['name'];               
      }

      return array('currencies'=>$currencies);
    }  

  }  
?>

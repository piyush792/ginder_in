<?php

// App::uses('GeocodeLib', 'Tools.Lib');
// $this->Geocode = new GeocodeLib();
// $this->Geocode->setOptions(array('host' => 'de')); //optional - you can set it to your country's top level domain.
// if ($this->Geocode->geocode('12345 Cityname', $settings)) {
//     $result = $this->Geocode->getResult();
// }

Class HomesController extends AppController {

    var $name = "Homes";
    var $uses = array("Banner", "ManageBanner", "Product", "Category", "CategoriesProduct", "Rating", "AverageRating", "ProductImages");

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->params['admin'])) {
            
        } else {
            $this->Auth->allow("index", "index_list", "index_featured");
        }
    }

    public function index($category_id = null) {
        
    }

    public function index_list($cat_id = null) {        
        // echo $cat_id; exit;
        // if($this->request->is('post')){
        //     // $this->autoLayout = false;
        //     // $this->autoRender = false;
        //     echo "<pre>";
        //     print_r($this->request->data);
        // }
        //$this->autoLayout = false;

        $cat_id = '';     //only uncomment this line to serach by location to featured and recent ADs

        //featured ads
        $fieldArr = array('DISTINCT Product.id', 'Product.name', 'Product.price', 'Product.image', 'City.name','ProductImages.product_image');
        $options = array("conditions" => array('Product.active' => 1, 'Product.featured_product' => 1, 'Category.active' => 1),
            'limit' => 15,
            'fields' => $fieldArr,
            'group' => 'Product.id',
            'order' => 'City.name="'.$cat_id.'" DESC, Product.modified DESC',            
            "joins" => array(
                array('table' => 'categories_products',
                    'alias' => 'CategoriesProduct',
                    'type' => 'INNER',
                    'conditions' => array('CategoriesProduct.product_id = Product.id')),
                array('table' => 'product_images',
                    'alias' => 'ProductImages',
                    'type' => 'LEFT',
                    'conditions' => array('ProductImages.product_id = Product.id')),
                array('table' => 'product_contacts',
                    'alias' => 'ProductContacts',
                    'type' => 'INNER',
                    'conditions' => array('ProductContacts.product_id = Product.id')),
                array('table' => 'cities',
                    'alias' => 'City',
                    'type' => 'INNER',
                    'conditions' => array('City.id = ProductContacts.city')),
                array('table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array('Category.id = CategoriesProduct.category_id'))
        ));
        $this->paginate = array('Product' => $options);
        $featuredList = $this->paginate('Product');
        // echo "<pre>";
        // print_r($featuredList);
        // exit;
        $this->set("featuredList", $featuredList);

        //recent ads
        $fieldArr = array('DISTINCT Product.id', 'Product.name', 'Product.price', 'Product.image', 'City.name', 'ProductImages.product_image');
        $options = array("conditions" => array('Product.active' => 1, 'Product.featured_product' => 0, 'Category.active' => 1),
            'limit' => 15,
            'fields' => $fieldArr,
            'group' => 'Product.id',
            'order' => 'City.name="'.$cat_id.'" DESC, Product.modified DESC',
            "joins" => array(
                array('table' => 'categories_products',
                    'alias' => 'CategoriesProduct',
                    'type' => 'INNER',
                    'conditions' => array('CategoriesProduct.product_id = Product.id')),
                array('table' => 'product_images',
                    'alias' => 'ProductImages',
                    'type' => 'LEFT',
                    'conditions' => array('ProductImages.product_id = Product.id')),
                array('table' => 'product_contacts',
                    'alias' => 'ProductContacts',
                    'type' => 'INNER',
                    'conditions' => array('ProductContacts.product_id = Product.id')),
                array('table' => 'cities',
                    'alias' => 'City',
                    'type' => 'INNER',
                    'conditions' => array('City.id = ProductContacts.city')),
                array('table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'INNER',
                    'conditions' => array('Category.id = CategoriesProduct.category_id')
                )
        ));
        $this->paginate = array('Product' => $options);        
        $recentList = $this->paginate('Product');
        // echo "<pre>";
        // print_r($recentList); exit;
        $this->set("recentList", $recentList);
    }

    public function index_featured($cat_id='147') {
        $this->autoLayout = false;        
    }

}
?>

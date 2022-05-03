<?php

Class HomesController extends AppController {

    var $name = "Homes";
    var $uses = array("Banner", "ManageBanner", "Product", "Category", "CategoriesProduct", "Rating", "AverageRating");

    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->params['admin'])) {
            
        } else {
            $this->Auth->allow("index", "index_featured");
        }
    }

    public function index($cat_id = null) {
        //featured ads
        $fieldArr = array('DISTINCT Product.id', 'Product.name', 'Product.price', 'Product.image', 'City.name','ProductImages.product_image');
        $options = array("conditions" => array('Product.active' => 1, 'Product.featured_product' => 1, 'Category.active' => 1),
            'limit' => 15,
            'fields' => $fieldArr,
            'group' => 'Product.id',
            'order' => 'Product.modified DESC',
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
        $this->set("featuredList", $featuredList);

        //recent ads
        $fieldArr = array('DISTINCT Product.id', 'Product.name', 'Product.price', 'Product.image', 'City.name', 'ProductImages.product_image');
        $options = array("conditions" => array('Product.active' => 1, 'Product.featured_product' => 0, 'Category.active' => 1),
            'limit' => 15,
            'fields' => $fieldArr,
            'group' => 'Product.id',
            'order' => 'Product.modified DESC',
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
        $this->set("recentList", $recentList);
    }

    public function index_featured($cat_id='147') {
        $this->autoLayout = false;

        
    }

}
?>

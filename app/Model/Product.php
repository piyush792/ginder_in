<?php
App::uses('AuthComponent', 'Controller/Component');
class Product extends AppModel {
    public $name = 'Product';
    
    function mydelete($product_id)
    {
        if(!empty($product_id)){ 
            
            $product=$this->find("first",array("conditions"=>array("Product.id"=>$product_id),"recursive"=>-1));
           
            $this->bindModel(array('hasMany' => array(
            "CategoriesProduct"=>array('dependent' => true),
            "PromoteItem"=>array('dependent' => true),
            "UserComment"=>array('dependent' => true),
            "UserQuestion"=>array('dependent' => true),
            "Rating"=>array('dependent' => true),
            "AverageRating"=>array('dependent' => true)
            )),false);
            
            if(!empty($product["Product"]["image"]) && file_exists(WWW_ROOT . 'images/product_images/'.$product["Product"]["image"]))
            {
                unlink(WWW_ROOT . 'images/product_images/'.$product["Product"]["image"]);
            }
             if(!empty($product["Product"]["sample_img1"]) && file_exists(WWW_ROOT . 'images/product_images/'.$product["Product"]["sample_img1"]))
            {
                unlink(WWW_ROOT . 'images/product_images/'.$product["Product"]["sample_img1"]);
            }
             if(!empty($product["Product"]["sample_img2"]) && file_exists(WWW_ROOT . 'images/product_images/'.$product["Product"]["sample_img2"]))
            {
                unlink(WWW_ROOT . 'images/product_images/'.$product["Product"]["sample_img2"]);
            }
             if(!empty($product["Product"]["sample_img3"]) && file_exists(WWW_ROOT . 'images/product_images/'.$product["Product"]["sample_img3"]))
            {
                unlink(WWW_ROOT . 'images/product_images/'.$product["Product"]["sample_img3"]);
            }
            
             if(!empty($product["Product"]["sample_img4"]) && file_exists(WWW_ROOT . 'images/product_images/'.$product["Product"]["sample_img4"]))
            {
                unlink(WWW_ROOT . 'images/product_images/'.$product["Product"]["sample_img4"]);
            } 
            
            if(!empty($product["Product"]["prod_file"]) && file_exists(WWW_ROOT . 'files/product_files/'.$product["Product"]["prod_file"]))
            {
                unlink(WWW_ROOT . 'files/product_files/'.$product["Product"]["prod_file"]);
            } 
            
            if(!empty($product["Product"]["preview"]) && file_exists(WWW_ROOT . 'files/product_previews/'.$product["Product"]["image"]))
            {
                unlink(WWW_ROOT . 'files/product_previews/'.$product["Product"]["preview"]);
            }
            
            return $this->delete($product_id,true);                
        }
        else
        return false;            
    }
   
}
?>
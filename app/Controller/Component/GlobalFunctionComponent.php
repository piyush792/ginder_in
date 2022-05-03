<?php
class GlobalFunctionComponent extends Component {  

  function getSellerName($id=null)
  {
      $sellerData=ClassRegistry::init('users')->find('first',array('fields'=>array('firstname','lastname'),"conditions"=>array("id"=>$id)));
      //print_r($sellerData);
      return $sellerData['users']['firstname']." ".$sellerData['users']['lastname'];
  }
  
  function getUserIdByProduct($id=null)
  {
      $productData=ClassRegistry::init('products')->find('first',array('fields'=>array('user_id'),"conditions"=>array("id"=>$id)));
      //print_r($sellerData);
      return $productData['products']['user_id'];
  }
 
  function getData($id=null,$table=null,$fields=array())
    {
        $dataArray=array();
        //if(trim($id)!='' && $id!=0 && $table!='' && count($fields)>0)
        if($table!='' && count($fields)>0)
        {
            if(trim($id)!='' && $id!=0)
            {
               $condition=array("conditions"=>array("id"=>$id)); 
               $DataArr=ClassRegistry::init($table)->find('first',array('fields'=>$fields,$condition));
            }else
            {
               $DataArr=ClassRegistry::init($table)->find('first',array('fields'=>$fields));    
            }
            //print_r($sellerData);
            return $DataArr;
        }
        else
        {
            return $dataArray;
        }

    }        
}  
?>

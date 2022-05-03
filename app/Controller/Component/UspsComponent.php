<?php
class UspsComponent extends Component {
    public $components = array('Session');
    
   /* function startup(&$controller){
               $this->controller =& $controller;
    }
    */
    public function uspsrate($arrProd = '1'){
        //print_r($prodId);
        if(!App::import('Vendor', 'Usps/usps')){
            echo "Error Loading USPS API";
        }
        $this->CompanyInfos = ClassRegistry::init('CompanyInfos');
        $this->Products = ClassRegistry::init('Products');
        $this->Users = ClassRegistry::init('Users');
        
        $arrOriginalZip = $this->CompanyInfos->find('all',array(
                                            'fields' => 'CompanyInfos.zip',
                                            'conditions' => array('CompanyInfos.id=1')
                                              ));
                                                
       $orizinalZip = $arrOriginalZip[0]['CompanyInfos']['zip'];
       
       $prodInfo = $this->Products->find('all', array(
                                                    'fields' => 'Products.measure_length,Products.measure_width,Products.measure_height,Products.weight',
                                                    'conditions' => array('Products.id'=>$arrProd)
                                                    ));
       $weight = 0;
       foreach($prodInfo as $val){
            $weight+=$val['Products']['weight'];
       }
       $height = $prodInfo[0]['Products']['measure_height'];
       $width = $prodInfo[0]['Products']['measure_width'];
       $length = $prodInfo[0]['Products']['measure_length'];
       //$weight = $prodInfo[0]['Products']['weight'];
       $userId = $this->Session->read('userId');
       $userInfo = $this->Users->find('all',array(
                                                'fields' => array('Users.firstname','Users.lastname','Users.zip_code_id'),
                                                'condition' => array('Users.id='.$userId)
                                                ));
       $userZip = $userInfo[0]['Users']['zip_code_id'];
       $firstName = $userInfo[0]['Users']['firstname'];
       $lastName = $userInfo[0]['Users']['lastname'];
       
        
        $usps = new Usps();
        $usps->setServers("http://production.shippingapis.com/ShippingAPI.dll");
        $usps->setUserName("213WEBVI6347");
        $usps->setPass("818OP01LI463");
        $usps->setService("All");
        $usps->setDestZip($userZip);
        $usps->setOrigZip($orizinalZip);
        $usps->setWeight($weight,0);
        //$usps->setPerimeter($height,$width,$length);
        $usps->setPerimeter();
        $usps->setContainer("Electronic Merchandise Return Service");
        $usps->setCountry("USA");
        $usps->setMachinable("true");
        $usps->setSize("REGULAR");
        // newly added
        $usps->setOption("RIGHTWINDOW");
        $usps->setCustomer($firstName.' '.$lastName);
        $price = $usps->getPrice(); // for price API
      //  print_r($price);
        
        return $price->list;
        return false;
    }
}
?>
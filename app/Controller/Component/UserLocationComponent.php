<?php
class UserLocationComponent extends Component {  
  function getUserLocationDD($zip_code_id)
  {
        $user_loc=ClassRegistry::init('ZipCode')->find('all',array('fields'=>array('id','zip_code','city','state_prefix','country','state_name'),'conditions'=>array('id'=>$zip_code_id)));        
        $country_list=ClassRegistry::init('ZipCode')->find('all',array('fields'=>'DISTINCT ZipCode.country','order'=>array('ZipCode.country ASC')));
        $countries=array(''=>'-Select Country-');            
        foreach($country_list as $country)
        {
            $countries[$country['ZipCode']['country']]=$country['ZipCode']['country'];               
        }
        //$countries['other']='Other - Please Specify';
        
        $state_list=ClassRegistry::init('ZipCode')->find('all',array('fields'=>array('DISTINCT state_name','state_prefix'),'conditions'=>array('country'=>$user_loc[0]['ZipCode']['country'],'state_prefix !='=>''),'order'=>array('ZipCode.state_name ASC')));
        $states=array(''=>'-Select State-');
        foreach($state_list as $state)
        {
            $states[$state['ZipCode']['state_prefix']]=$state['ZipCode']['state_name'];               
        }
        $city_list=ClassRegistry::init('ZipCode')->find('all',array('fields'=>array('DISTINCT city'),'conditions'=>array('country'=>$user_loc[0]['ZipCode']['country'],'state_prefix'=>$user_loc[0]['ZipCode']['state_prefix']),'order'=>array('ZipCode.city ASC')));
        $cities=array(''=>'-Select City-');
        foreach($city_list as $city)
        {
            $cities[$city['ZipCode']['city']]=$city['ZipCode']['city'];               
        }
        
        $zipcode_list=ClassRegistry::init('ZipCode')->find('all',array('fields'=>array('DISTINCT zip_code'),'conditions'=>array('country'=>$user_loc[0]['ZipCode']['country'],'state_prefix'=>$user_loc[0]['ZipCode']['state_prefix']),'order'=>array('ZipCode.zip_code ASC')));
        $zipcodes=array(''=>'-Select Postal Code-');
        foreach($zipcode_list as $zipcode)
        {
            $zipcodes[$zipcode['ZipCode']['zip_code']]=$zipcode['ZipCode']['zip_code'];               
        }        
        return array('user_loc'=>$user_loc,'countries'=>$countries,'states'=>$states,'cities'=>$cities,'zipcodes'=>$zipcodes);
  }
  
  function getStatesList($country=null)
  {
        $state_list=ClassRegistry::init('states')->find('all',array('fields'=>array('DISTINCT state','abv'),'conditions'=>array("state!=''"),'order'=>array('states.state ASC')));
        
        //print_r($state_list);
        $states=array(''=>'-Select State-');
        
        foreach($state_list as $key=>$state)
        {
            $states[$state['states']['abv']]=$state['states']['state'];               
        }
        
        return $states;
  }
  
  function getCountriesList()
  {
        $countrylist=ClassRegistry::init('countries')->find('all',array('fields'=>array('DISTINCT countryname','code'),'order'=>array('countries.countryname ASC')));
        
        //print_r($countrylist);
        $countries=array(''=>'-Select Country-');
        
        foreach($countrylist as $key=>$country)
        {
            $countries[$country['countries']['code']]=$country['countries']['countryname'];               
        }
        
        return $countries;
  }
}  
?>

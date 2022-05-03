<?php
class ZipLocatorComponent extends Component {  
  
    public function distance($zipOne,$zipTwo)
    {
        $ziploc = ClassRegistry::init('zip_codes')->find('all', array("conditions"=>array("zip_code",$zipOne)));
        //$query = "SELECT * FROM storelocator WHERE zipcode ='$zipOne'";

        if(count($ziploc)> 0)
        {
            return "First Zip Code not found";
        }
        else
        {
            $lat1 = $ziploc['lat'];
            $lon1 = $ziploc['lon'];   
        }
        

        $ziploc2 = ClassRegistry::init('zip_codes')->find('all', array("conditions"=>array("zip_code",$zipTwo)));
        //$query = "SELECT * FROM storelocator WHERE zipcode ='$zipOne'";

        if(count($ziploc2)> 0)
        {
            return "Second Zip Code not found";
        }
        else
        {
            $lat2 = $ziploc2['lat'];
            $lon2 = $ziploc2['lon'];   
        }
        


        /* Convert all the degrees to radians */
        $lat1 = $this->deg_to_rad($lat1);
        $lon1 = $this->deg_to_rad($lon1);
        $lat2 = $this->deg_to_rad($lat2);
        $lon2 = $this->deg_to_rad($lon2);


        /* Find the deltas */
        $delta_lat = $lat2 - $lat1;
        $delta_lon = $lon2 - $lon1;


        /* Find the Great Circle distance */
        $temp = pow(sin($delta_lat/2.0),2) + cos($lat1) * cos($lat2) * pow(sin($delta_lon/2.0),2);


        $EARTH_RADIUS = 3956;
        $distance = $EARTH_RADIUS * 2 * atan2(sqrt($temp),sqrt(1-$temp));

        return $distance;

    } // end func  
    
    
    public function deg_to_rad($deg)
    {
        $radians = 0.0;
        $radians = $deg * M_PI/180.0;
        return($radians);
    }
    
    
    public function inradius($zip,$radius)
    {
        
        $ziploc = ClassRegistry::init('Storelocator')->find('all', array("fields"=>array("lat","lon"),"conditions"=>array("zipcode='".$zip."'")));
        
        //print_r($ziploc);
        
        //echo count($ziploc);
        $zipArray = array();
        if(count($ziploc) > 0)
        {
            $lat=$ziploc[0]['Storelocator']['lat'];
            $lon=$ziploc[0]['Storelocator']['lon'];
            
            $ziploc2 = ClassRegistry::init('Storelocator')->find('all', array("fields"=>array("zipcode","(POW((69.1*(lon-\"$lon\")*cos($lat/57.3)),\"2\")+POW((69.1*(lat-\"$lat\")),\"2\")) as distance"),"conditions"=>array("(POW((69.1*(lon-\"$lon\")*cos($lat/57.3)),\"2\")+POW((69.1*(lat-\"$lat\")),\"2\")) < ($radius)"),"order"=>array("distance")));
            //$query="SELECT zipcode,(POW((69.1*(lon-\"$lon\")*cos($lat/57.3)),\"2\")+POW((69.1*(lat-\"$lat\")),\"2\")) as zip FROM storelocator WHERE (POW((69.1*(lon-\"$lon\")*cos($lat/57.3)),\"2\")+POW((69.1*(lat-\"$lat\")),\"2\"))<($radius*$radius) order by zip";
            
            //echo "<pre>";
            //print_r($ziploc2);
            
            
            if(count($ziploc2) > 0)
            {
                for($i=0;$i<count($ziploc2);$i++)
                {
                    $zipArray[$i]=array("zip"=>$ziploc2[$i]['Storelocator']['zipcode'],"distance"=>$ziploc2[$i]['0']['distance']);
                }
            }
        }else{
            return array(); //Zip Code not found
        }
     return $zipArray;
    } // end func
}  
?>

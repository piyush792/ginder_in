<?php
$this->start('inline');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function showPosition(position) {
          console.log("test: ", position);
          // x.innerHTML ="Latitude: " +position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
          //Create query for the API.
          var latitude = "latitude=" + position.coords.latitude;
          var longitude = "&longitude=" + position.coords.longitude;
          var query = latitude + longitude + "&localityLanguage=en";
          console.log("query: ", query);

          const Http = new XMLHttpRequest();
          var bigdatacloud_api ="https://api.bigdatacloud.net/data/reverse-geocode-client?";
          bigdatacloud_api += query;
          Http.open("GET", bigdatacloud_api);
          Http.send();

          Http.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            console.log("myObj: ", myObj);
            // alert(myObj.locality);
            // y.innerHTML += "Postcodes =" + myObj.postcode + "<br>City = " + myObj.locality + "<br>Country = " + myObj.countryName;

            var category_id=myObj.locality;
            get_index_listing(category_id);

          }
          };
        }, function errorFunction(){
              console.log("Geocoder failed");
              get_index_listing(null);
           }
        );
      } else {
        // x.innerHTML = "Geolocation is not supported by this browser.";
        console.log("Geocoder failed");
        get_index_listing(null);
      }
      
        //  jQuery(document).on('click',".sitebar input[type='checkbox']",function(){  
        //      var frmData = jQuery('#ProductProductListForm').serialize();
        //     jQuery.triggerProductsSearchForm(frmData);
        // }); 
    });

    function get_index_listing(category_id=null)
    {
         console.log("indexListing: ", category_id);
         var siteUrl= '<?php echo SITE_URL;?>';
         var url=siteUrl+"homes/index_list/"+category_id;
         jQuery('#productdata').html('<div align="center"><img  src="'+siteUrl+'img/loading_big.gif"></div>');
         jQuery.post(url,{},function(data){
            jQuery("#productdata").html(data);
        });
    }   

  //  jQuery.triggerProductsSearchForm = function(frmData)
  //  {
  //      var siteUrl= '<?php //echo SITE_URL;?>';
  //      var param='<?php //echo $this->request->params['pass'][0];?>';
  //      var url=siteUrl+"homes/index/"+param;
  //       jQuery.ajax({
  //          type:'POST',
  //               url: url,
  //               data:frmData,
  //               dataType:'text',
  //               beforeSend:function(){
  //                  jQuery('.card').html('<img  src="'+siteUrl+'img/loading.gif">');
  //               },success:function(responseData,status,XMLHttpRequest){
  //                   var result = responseData;
  //                  jQuery('#productdata').html(result);
  //               }
  //           });
  //   };
</script>   
<?php
$this->end();
?> 
<div class="pagewrap">
  <nav id='productdata'></nav>
</div>
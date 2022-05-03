<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ginder.in</title>
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" media="all">
<link href="css/bootstrap-grid.min.css" type="text/css" rel="stylesheet" media="all">
<link href="css/ginder-in-style.css" type="text/css" rel="stylesheet" media="all">
<link href="css/jquery.bxslider.css" type="text/css" rel="stylesheet" media="all">
<link href="css/fonts-glyphicon.css" type="text/css" rel="stylesheet" media="all">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.bxslider.js"></script>
<!--<script src="js/matchMedia.js"></script>
<script src="js/matchMedia.addListener.js"></script>-->
<script src="js/jquery.bxslider.min.js"></script>

<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

<script>
$(document).ready(function(){
if($(window).width() > 1280){
 	slider = $('.premiumbxslider').bxSlider({
slideWidth: 1200,
        minSlides: 5,
        maxSlides: 5,
        slideMargin: 0,
responsive: true,
        pager: false
   });	
} else if($(window).width() > 767){
 	slider = $('.premiumbxslider').bxSlider({
slideWidth: 768,
        minSlides: 3,
        maxSlides: 3,
        slideMargin: 0,
responsive: true,
        pager: false
   });
} else{
slider = $('.premiumbxslider').bxSlider({
slideWidth: 500,
minSlides: 1,
maxSlides: 1,
slideMargin: 0,
responsive: true,
controls: false,
pager: false
});	
}

    $(".btn-favourite").click(function(){
        $(this).children('span').addClass('glyphicon-star selected-favourite').removeClass('glyphicon-star-empty');
    });

$('[data-toggle="tooltip"]').tooltip(); 

/* Global Navigation on close click for resposnive design start*/
$('.navbar-toggler').click(function(){
$('body').addClass("fixedPosition");
});

$("#ctrl-navbar-close, .mobile-global-navbar-overlay").click(function(){
        $("#collapsibleNavbar").removeClass('show');
$('body').removeClass("fixedPosition");	
    });
/* Global Navigation on close click for resposnive design end*/	

/* Mobile search control */
$('#mobile-search-ctrl').hide();

$('#SearchModal-MobTab').click(function(){
$('#mobile-search-ctrl').show();

});
$("#mobile-search-close").click(function(){
$('#mobile-search-ctrl').hide();
});
/* Mobile search control end */

/* Mobile filter control start */
$('#ctrl-mobile-filter').click(function(){
$('#ctrl-filter-sidebar').show();
});
$('#ctrl-filter-close').click(function(){
$('#ctrl-filter-sidebar').hide();
});
/* Mobile filter control end */	

/* spam pop-up start */
$(".report-spam-wrapper").click(function(){
$('.modal-form-content').show();	
$('.confirmation-msg-wrapper').hide();	
});

$(".btn-modal-teritory").click(function(){	
$('#SpamReportModal').modal('hide');
});

$(".confirmation-button").click(function(){	
$('#SpamReportModal').modal('hide');	
});

$('.confirmation-msg-wrapper').hide();

$("#btn-submit-request").click(function(){
$('.confirmation-msg-wrapper').show();
$('.modal-form-content').hide();
});
/* spam pop-up end */
});
</script>
</head>
<body>
<!-- Mobile search modal start -->
<div id="mobile-search-ctrl" class="mobile-search-control"> <span id="mobile-search-close" class="glyphicon glyphicon-remove-circle"></span>
  <input type="search" placeholder="I am looking for..." class="field-search">
  <button class="btn-search"><img src="images/icon-search.png"></button>
</div>
<!-- Mobile search modal end --> 
<!--  login modal start -->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="registration-features-col">
          <header class="heading">Benefits</header>
          <ul>
            <li>Publish multiple ads in <span class="highlight-text">Free</span></li>
            <li>Provide <span class="highlight-text">personalise dashboard</span> to manage posted ads after registration</li>
            <li>Provide ability to Share ads with friends on <span class="highlight-text">social networking</span> </li>
          </ul>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <div class="login-signup-wrapper">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item"> <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Login</a> </li>
            <li class="nav-item"> <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Register</a> </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <form class="form-signup">
                <div class="form-label-group">
                  <input type="text" class="form-control" id="label-email" placeholder="Enter your registered email id">
                  <label for="label-email">Email</label>
                </div>
                <div class="form-label-group">
                  <input type="password" class="form-control" id="label-password" placeholder="Enter your password">
                  <label for="label-password">Password</label>
                </div>
                <div class="form-label-group">
                  <input type="button" class="button button-primary" value="Login">
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <form class="form-signup">
                <div class="form-label-group">
                  <input type="text" class="form-control" id="label-reg-email" placeholder="Enter your email id">
                  <label for="label-reg-email">Email</label>
                </div>
                <div class="form-label-group">
                  <input type="password" class="form-control" id="label-reg-password" placeholder="Enter your password">
                  <label for="label-reg-password">Password</label>
                </div>
                <div class="form-label-group">
                  <input type="password" class="form-control" id="label-regconf-password" placeholder="Enter your password">
                  <label for="label-regconf-password">Confirm Password</label>
                </div>
                <div class="form-label-group">
                  <input type="button" class="button button-primary" value="Register">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="single-signup-wrapper">
          <div class="single-signup-content">
            <div class="regular-text">Sign in With</div>
            <button class="icon-gmail-signup"><img src="images/icon-gmail-login.png"> Gmail Account</button>
            <button class="icon-facebook-signup"><img src="images/icon-facebook-login.png"> Facebook Account</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- login modal end -->
<header class="page-header container-fluid">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"> <span class="glyphicon glyphicon-menu-hamburger"></span> </button>
  <a href="index.html" class="brand-logo"><img src="images/brand-logo.png"></a>
  <div class="mobile-ctrl-header">
    <div class="search-wrapper">
      <div class="mobtab-search-bar">
        <div class="btn-search" id="SearchModal-MobTab"><span class="glyphicon glyphicon-search"></span></div>
      </div>
      <div class="desktop-search-bar">
        <input type="text" placeholder="Search for electronics, appliance, furniture, vehicles..." class="input-search">
        <select class="input-location">
          <option selected>location</option>
          <option value="Andaman &amp; Nicobar Islands"> Andaman &amp; Nicobar Islands</option>
          <option value="Andhra Pradesh"> Andhra Pradesh</option>
          <option value="Arunachal Pradesh"> Arunachal Pradesh</option>
          <option value="Assam"> Assam</option>
          <option value="Bihar"> Bihar</option>
          <option value="Chandigarh"> Chandigarh</option>
          <option value="Chattisgarh"> Chattisgarh</option>
          <option value="Dadra &amp; Nagar Haveli"> Dadra &amp; Nagar Haveli</option>
          <option value="Daman &amp; Diu"> Daman &amp; Diu</option>
          <option value="Delhi"> Delhi</option>
          <option value="Goa"> Goa</option>
          <option value="Gujarat"> Gujarat</option>
          <option value="Haryana"> Haryana</option>
          <option value="Himachal Pradesh"> Himachal Pradesh</option>
          <option value="Jammu &amp; Kashmir"> Jammu &amp; Kashmir</option>
          <option value="Jharkhand"> Jharkhand</option>
          <option value="Karnataka"> Karnataka</option>
          <option value="Kerala"> Kerala</option>
          <option value="Lakshadweep"> Lakshadweep</option>
          <option value="Madhya Pradesh"> Madhya Pradesh</option>
          <option value="Maharashtra"> Maharashtra</option>
          <option value="Manipur"> Manipur</option>
          <option value="Meghalaya"> Meghalaya</option>
          <option value="Mizoram"> Mizoram</option>
          <option value="Nagaland"> Nagaland</option>
          <option value="Orissa"> Orissa</option>
          <option value="Pondicherry"> Pondicherry</option>
          <option value="Punjab"> Punjab</option>
          <option value="Rajasthan"> Rajasthan</option>
          <option value="Sikkim"> Sikkim</option>
          <option value="Tamil Nadu"> Tamil Nadu</option>
          <option value="Telangana"> Telangana</option>
          <option value="Tripura"> Tripura</option>
          <option value="Uttarakhand"> Uttarakhand</option>
          <option value="Uttar Pradesh"> Uttar Pradesh</option>
          <option value="West Bengal"> West Bengal</option>
          <option value="Ahmedabad">Ahmedabad</option>
          <option value="Bangalore">Bangalore</option>
          <option value="Chandigarh">Chandigarh</option>
          <option value="Chennai">Chennai</option>
          <option value="Coimbatore">Coimbatore</option>
          <option value="Delhi">Delhi</option>
          <option value="Hyderabad">Hyderabad</option>
          <option value="Kochi">Kochi</option>
          <option value="Kolkata">Kolkata</option>
          <option value="Mumbai">Mumbai</option>
          <option value="Pune">Pune</option>
          <option value="Gurgaon">Gurgaon</option>
          <option value="Jaipur">Jaipur</option>
          <option value="Lucknow">Lucknow</option>
          <option value="Noida">Noida</option>
          <option value="NaviMumbai">NaviMumbai</option>
          <option value="Trivandrum">Trivandrum</option>
        </select>
        <button class="btn-search">Search</button>
      </div>
    </div>
    <div class="login-wrapper">
      <div class="mobile-login"> <img  data-toggle="modal" data-target="#LoginModal" src="images/mob-userlogin.png"> </div>
      <div class="desktop-login"> <img data-toggle="modal" data-target="#LoginModal" src="images/btn-login.png"> </div>
    </div>
    <div class="post-ad-wrapper">
      <button class="btn-post-ad" onClick="window.location.href='post-an-ad.html'">Post an Ad</button>
    </div>
  </div>
</header>
<!-- global navigation start -->
<div class="global-navbar collapse" id="collapsibleNavbar">
  <div class="mobile-global-navbar-overlay"></div>
  <div id="ctrl-navbar-close" class="navbar-close"><span class="glyphicon glyphicon-remove"></span></div>
  <div class="navbar-items-wrapper"> <a href="index.html">Home</a>
    <div class="global-navbar-dropdown">
      <div class="dropbtn">Electronics  &amp; Appliance <i class="fa fa-caret-down"></i> </div>
      <div class="global-navbar-dropdown-content">
        <div class="header">
          <h2>Electronics & Appliance</h2>
        </div>
        <div class="row">
          <div class="column">
            <ul>
              <li><a href="#">Accessories</a></li>
              <li><a href="#">Air-Conditioners</a></li>
              <li><a href="#">Blu-Ray</a></li>
              <li><a href="#">Cameras</a></li>
              <li><a href="#">Computers</a></li>
              <li><a href="#">Laptops</a></li>
              <li><a href="#">Lights</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Parts</a></li>
              <li><a href="#">Phones</a></li>
              <li><a href="#">Printers</a></li>
              <li><a href="#">Tablets</a></li>
              <li><a href="#">Tools</a></li>
              <li><a href="#">DVD</a></li>
              <li><a href="#">Dishwashers</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Dryers</a></li>
              <li><a href="#">Fridges</a></li>
              <li><a href="#">Gas Tops</a></li>
              <li><a href="#">Iron</a></li>
              <li><a href="#">Ovens</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="global-navbar-dropdown">
      <div class="dropbtn active-nav">Home, Furniture &amp; Pets<i class="fa fa-caret-down"></i> </div>
      <div class="global-navbar-dropdown-content">
        <div class="header">
          <h2>Jobs</h2>
        </div>
        <div class="row">
          <div class="column">
            <ul>
              <li><a href="#">Beds</a></li>
              <li><a href="#">Chairs</a></li>
              <li><a href="#">Cupboards</a></li>
              <li><a href="#">Dining</a></li>
              <li><a href="#">Drawers and Closets</a></li>
              <li><a href="#">Outdoor Furnitures</a></li>
              <li><a href="#">Parts</a></li>
              <li><a href="#">Sofas</a></li>
              <li><a href="#">Tables</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Tools</a></li>
              <li><a href="#">Birds</a></li>
              <li><a href="#">Cats</a></li>
              <li><a href="#">Cows</a></li>
              <li><a href="#">Dogs</a></li>
              <li><a href="#">Fishes</a></li>
              <li><a href="#">Horses</a></li>
              <li><a href="#">Lost Pets</a></li>
              <li><a href="#">Pet Care</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Pet Food</a></li>
              <li><a href="#">Pet Products</a></li>
              <li><a href="#">Pet Sitting</a></li>
              <li><a href="#">Pet Trainer</a></li>
              <li><a href="#">Rabbits</a></li>
              <li><a href="#">Household Items</a></li>
              <li><a href="#">Others</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="global-navbar-dropdown">
      <div class="dropbtn">Jobs<i class="fa fa-caret-down"></i> </div>
      <div class="global-navbar-dropdown-content">
        <div class="header">
          <h2>Jobs</h2>
        </div>
        <div class="row">
          <div class="column">
            <ul>
              <li><a href="#">Accountancy</a></li>
              <li><a href="#">Administrative Work</a></li>
              <li><a href="#">Agriculuture</a></li>
              <li><a href="#">Astrology</a></li>
              <li><a href="#">Computers</a></li>
              <li><a href="#">Automotives</a></li>
              <li><a href="#">Banking</a></li>
              <li><a href="#">Beauticians</a></li>
              <li><a href="#">Botany</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Call Centers</a></li>
              <li><a href="#">Carpenter</a></li>
              <li><a href="#">Cashiers</a></li>
              <li><a href="#">Cleaner</a></li>
              <li><a href="#">Community Work</a></li>
              <li><a href="#">Construction and Development</a></li>
              <li><a href="#">Consultation Services</a></li>
              <li><a href="#">Content Writer</a></li>
              <li><a href="#">Data Entry</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Delivery and collection</a></li>
              <li><a href="#">Design and Architecture</a></li>
              <li><a href="#">Driver</a></li>
              <li><a href="#">Education and Training</a></li>
              <li><a href="#">Entertainment</a></li>
              <li><a href="#">Faculty Jobs</a></li>
              <li><a href="#">Government Jobs</a></li>
              <li><a href="#">Health Services</a></li>
              <li><a href="#">Hospitality</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">HR</a></li>
              <li><a href="#">Information Technology</a></li>
              <li><a href="#">Labour</a></li>
              <li><a href="#">Manufacturing and Transport</a></li>
              <li><a href="#">Entertainment</a></li>
              <li><a href="#">Marketing</a></li>
              <li><a href="#">Mining</a></li>
              <li><a href="#">Nursing</a></li>
              <li><a href="#">Office Assistance</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Part-Time Jobs</a></li>
              <li><a href="#">Placements Consultants</a></li>
              <li><a href="#">Property Management</a></li>
              <li><a href="#">Receptionist</a></li>
              <li><a href="#">Research</a></li>
              <li><a href="#">Sales</a></li>
              <li><a href="#">Security</a></li>
              <li><a href="#">Sports</a></li>
              <li><a href="#">Tourism</a></li>
              <li><a href="#">Traders</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="global-navbar-dropdown">
      <div class="dropbtn">Vehciles<i class="fa fa-caret-down"></i> </div>
      <div class="global-navbar-dropdown-content">
        <div class="header">
          <h2>Vehciles</h2>
        </div>
        <div class="row">
          <div class="column">
            <ul>
              <li><a href="#">Cars</a></li>
              <li><a href="#">Commercial Vehicles</a></li>
              <li><a href="#">Motorcycles</a></li>
              <li><a href="#">Scooters</a></li>
              <li><a href="#">Bicycles</a></li>
              <li><a href="#">Spare Parts</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="global-navbar-dropdown">
      <div class="dropbtn">Service For Sale<i class="fa fa-caret-down"></i> </div>
      <div class="global-navbar-dropdown-content">
        <div class="header">
          <h2>Service For Sale</h2>
        </div>
        <div class="row">
          <div class="column">
            <ul>
              <li><a href="#">Accounting and Finance</a></li>
              <li><a href="#">Advertising</a></li>
              <li><a href="#">Astrologer</a></li>
              <li><a href="#">Automotive</a></li>
              <li><a href="#">Builders</a></li>
              <li><a href="#">Catering</a></li>
              <li><a href="#">Child Care</a></li>
              <li><a href="#">Cleaning</a></li>
              <li><a href="#">Computers</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Constructions</a></li>
              <li><a href="#">Driving Classes</a></li>
              <li><a href="#">Education</a></li>
              <li><a href="#">Electronics</a></li>
              <li><a href="#">Event Planner</a></li>
              <li><a href="#">Furniture</a></li>
              <li><a href="#">Gardening</a></li>
              <li><a href="#">Health and Beauty</a></li>
              <li><a href="#">Interior Design and Decoration</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Legal</a></li>
              <li><a href="#">Loan and Insurace</a></li>
              <li><a href="#">Locksmiths</a></li>
              <li><a href="#">Maid and Housekeeping</a></li>
              <li><a href="#">Packers and Movers</a></li>
              <li><a href="#">Painting</a></li>
              <li><a href="#">Parlour and Salon</a></li>
              <li><a href="#">Pest Control</a></li>
              <li><a href="#">Plumbing</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Rental Vehicles</a></li>
              <li><a href="#">Repairs</a></li>
              <li><a href="#">Restaurants and Bars</a></li>
              <li><a href="#">Retail</a></li>
              <li><a href="#">Taxis and Drivers</a></li>
              <li><a href="#">Tourism</a></li>
              <li><a href="#">Translation</a></li>
              <li><a href="#">Transportation</a></li>
              <li><a href="#">Tree Cutting</a></li>
            </ul>
          </div>
          <div class="column">
            <ul>
              <li><a href="#">Web Service</a></li>
              <li><a href="#">AutoMobiles</a></li>
              <li><a href="#">Franchisee</a></li>
              <li><a href="#">Hospitality</a></li>
              <li><a href="#">Retail</a></li>
              <li><a href="#">Others</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="global-navbar-dropdown">
      <div class="dropbtn">Reals Estate<i class="fa fa-caret-down"></i> </div>
      <div class="global-navbar-dropdown-content">
        <div class="header">
          <h2>Real Estate</h2>
        </div>
        <div class="row">
          <div class="column">
            <ul>
              <li><a href="#">Commercials</a></li>
              <li><a href="#">Flat Share and House Share</a></li>
              <li><a href="#">Houses and Apartments</a></li>
              <li><a href="#">Land</a></li>
              <li><a href="#">PGs and Hostels </a></li>
              <li><a href="#">Realestate Agents</a></li>
              <li><a href="#">Rental Properties</a></li>
              <li><a href="#">Business for sale</a></li>
              <li><a href="#">Others</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="global-navbar-dropdown">
      <div class="dropbtn">Matrimonial<i class="fa fa-caret-down"></i> </div>
      <div class="global-navbar-dropdown-content">
        <div class="header">
          <h2>Matrimonial</h2>
        </div>
        <div class="row">
          <div class="column">
            <ul>
              <li><a href="#">Bride</a></li>
              <li><a href="#">Groom</a></li>
              <li><a href="#">Marraige Halls</a></li>
              <li><a href="#">Matrimonial Services</a></li>
              <li><a href="#">Others</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="global-navbar-dropdown">
      <div class="dropbtn">Education &amp; Books<i class="fa fa-caret-down"></i> </div>
      <div class="global-navbar-dropdown-content">
        <div class="header">
          <h2>Education &amp; Books</h2>
        </div>
        <div class="row">
          <div class="column">
            <ul>
              <li><a href="#">Assignments</a></li>
              <li><a href="#">Career Counselling</a></li>
              <li><a href="#">Coaching Center</a></li>
              <li><a href="#">Distance Learning</a></li>
              <li><a href="#">Music and Dance Classes</a></li>
              <li><a href="#">Overseas Learning</a></li>
              <li><a href="#">Books</a></li>
              <li><a href="#">Others</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="global-navbar-dropdown">
      <div class="dropbtn">Sports, Fitness &amp; Hobbies<i class="fa fa-caret-down"></i> </div>
      <div class="global-navbar-dropdown-content">
        <div class="header">
          <h2>Sports, Fitness &amp; Hobbies</h2>
        </div>
        <div class="row">
          <div class="column">
            <ul>
              <li><a href="#">Gym and Fitness</a></li>
              <li><a href="#">Musical Instruments</a></li>
              <li><a href="#">Other Hobbies</a></li>
              <li><a href="#">Sport Equipment</a></li>
              <li><a href="#">Others</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- global navigation end -->
<div class="clearfix"></div>
<div class="page-breadcrumb"> <span class="page-breadcrumb-item"><a href="index.html" class="anchor-black header-anchor">Home</a></span> <span class="page-breadcrumb-item">Home, Furniture & Pets</span> <span class="page-breadcrumb-currentitem">Beds</span> </div>
<div class="middle-content-advert"> 
  
  <!-- product image section start -->
  <div class='product-page-left-sidebar'>
    <div class='product-large-image'> <img src='images/product-detail-img.png'> </div>
    <div class='product-thumbnail-image-wrapper'>
      <ul>
        <li class='thumbnail-img'><img src="images/uploaded-img-1.jpg"></li>
        <li class='thumbnail-img'><img src="images/uploaded-img-2.jpg"></li>
        <li class='thumbnail-img'><img src="images/uploaded-img-3.jpg"></li>
        <li class='thumbnail-img'><img src="images/uploaded-img-4.jpg"></li>
      </ul>
    </div>
  </div>
  <!-- product image section end --> 
  
  <!-- product details section start -->
  <section class='product-page-right-sidebar'>
    <header>
      <h1 class='product-title'>Spacewood Joy Queen Size Bed (Woodpore Finish, Natural Wenge)</h1>
    </header>
    <div class='product-owner-details'>
      <div class='left-sidebar'>
        <div class='owner-heading'>Owner Details</div>
        <div class='owner-title'>Diamond Furniture Palace</div>
        <div class="owner-location">Location: New Delhi</div>
      </div>
      <div class='right-sidebar'>
        <div class='title'>Enter security code to view owner contact details</div>
        <div class='captcha-wrapper'> <span class='captcha-code'>WDSJL</span>
          <input type='text' class='captcha-field'/>
          <button class="captcha-submit">Submit</button>
        </div>
      </div>
    </div>
    
    <!-- product attribute start -->
    <section class='product-attribute-wrapper'>
      <div class="attribute-heading">Product Details</div>
      <ul class='product-attribute-content'>
        <li class='attribute-item'>
          <div class='attribute-label'>Brand:</div>
          <div class='attribute-value'>Nilkamal</div>
        </li>
        <li class='attribute-item'>
          <div class='attribute-label'>Bed Size:</div>
          <div class='attribute-value'>Queen Size</div>
        </li>
        <li class='attribute-item'>
          <div class='attribute-label'>Price:</div>
          <div class='attribute-value'><span class="product-price">Rs. 10,244</span> <Span class="price-tag">Fixed price</span></div>
        </li>
        <li class='attribute-item'>
          <div class='attribute-label'>Color:</div>
          <div class='attribute-value'>Beige</div>
        </li>
      </ul>
    </section>
    <!-- product attribute end --> 
    
    <!-- product description start -->
    <section class='prdouct-description-wrapper'>
      <div class="prdouct-description-heading">Product Descripttion:</div>
      <ul class='product-description-content'>
        <li>Product Dimensions: Length (204 cm), Width (157 cm), Height (72 cm) </li>
        <li>Primary Material: Engineered Wood</li>
        <li>Color: Natural Wenge, Finish: Woodpore, Style: Modern</li>
        <li>Bed Size: Queen, Recommended mattress size- 60x78 inches</li>
        <li>Assembly Required: The product requires carpenter assembly and will be provided by the seller</li>
        <li>Warranty: 36 months on manufacturing defect as per warranty card terms and conditions </li>
        <li>Spacewood Joy queen bed is designed to offer you the best comfort and gives your bedroom an elegant touch</li>
      </ul>
    </section>
    <!-- product description end --> 
    
    <!-- product share start -->
    <div class="product-share-wrapper"> <span class="product-share-heading">Share at:</span> <span><a href="#"><img src="images/icon-facebook.png"></a></span> <span><a href="#"><img src="images/icon-twitter.png"></a></span> <span><a href="#"><img src="images/icon-pinterest.png"></a></span> <span><a href="#"><img src="images/icon-instagram.png"></a></span> </div>
    <!-- product share end --> 
    
    <!--  spam report pop-up start -->
    <div class="modal fade" id="SpamReportModal" tabindex="-1" role="dialog" aria-labelledby="SpamReportModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
          <div class="modal-form-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>          
            <div class="modal-title">Report Spam</div>
                <div class="modal-overview">
                We always ensure to serves our users better. But still if any content is inappropriate,  spam, 
against community and person please share your thoughts with us.
                </div>
                <div class="modal-form">
                <div class="modal-form-row">
                        <textarea class="ctrl-multiline"></textarea>
                    </div>
                <div class="modal-form-row">                    
                    <div class="col-sm-12 col-lg-5 modal-form-col float-left"><input type="text" placeholder="Name *" class="ctrl-singleline" />
                        <div class="warning-wrapper-field error-msg-field">
                        <span class="glyphicon glyphicon-alert"></span> Cannot leave name field blank.
                        </div>
                        </div>
                    <div class="col-sm-12 col-lg-5 modal-form-col modal-rightcol-field float-left"><input type="text" placeholder="Email *" class="ctrl-singleline" />
                        <div class="warning-wrapper-field error-msg-field">
                        <span class="glyphicon glyphicon-alert"></span> Cannot leave email field blank.
                        </div>

                        </div>                        
                    </div>
                    <div  class="modal-form-footer">
                    <button class="btn-primary btn-mid-size" id="btn-submit-request">Send Message</button> <button class="btn-teritory btn-mid-size btn-modal-teritory">Close</button>
                        
                    </div>
                </div>
           </div>
                <!-- thanks for the confirmation message start -->
                <div class="confirmation-msg-wrapper">
                <div class="confirmation-icon-wrapper success-msg"><span class="glyphicon glyphicon-ok"></span></div>
                    <div class="confirmation-title success-title">Thanks for sharing your feedback.</div>
                    <div class="confirmation-message">Our support team will look into this and contact you with an update.</div>
                    <div class="confirmation-button"><button class="btn-teritory">Ok</button></div>
                </div>
                <!-- thanks for the confirmation message end -->                
          </div>
        </div>
      </div>
    </div>
    <!--  spam report pop-up end -->
    
    
    <!-- product spam report stop-->    
    <div class="report-spam-wrapper" data-toggle="modal" data-target="#SpamReportModal" >Report Spam</div>
    <!-- product spam report end -->
    
  </section>
  <!-- product details section end -->
</div>

<!-- premium section start -->
<section class="product-premium-ads-wrapper">
  <header>
    <h2 class="section-heading">Premium ads related to this category</h2>
  </header>
  <ul class="premiumbxslider">
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-1.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">3-Piece Hudson Table Group</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-2.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">50" Class Philips Smart 4K UHD TV 120Hz 3HDMI Inputs</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-3.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Twin Bunkbed with Staircase & Mattress Set</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-4.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Apple iPhone 6s (Space Grey, 32 GB)</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-5.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Samsung 212 L Direct Cool Single Door 3 Star Refrigerator</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-6.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Used Maruti Suzuki Ritz [2013-2017]</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-1.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">3-Piece Hudson Table Group</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-2.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">50" Class Philips Smart 4K UHD TV 120Hz 3HDMI Inputs</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-3.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Twin Bunkbed with Staircase & Mattress Set</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-4.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Apple iPhone 6s (Space Grey, 32 GB)</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-5.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Samsung 212 L Direct Cool Single Door 3 Star Refrigerator</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-6.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Used Maruti Suzuki Ritz [2013-2017]</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-1.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">3-Piece Hudson Table Group</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-2.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">50" Class Philips Smart 4K UHD TV 120Hz 3HDMI Inputs</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-3.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Twin Bunkbed with Staircase & Mattress Set</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-4.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Apple iPhone 6s (Space Grey, 32 GB)</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-5.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Samsung 212 L Direct Cool Single Door 3 Star Refrigerator</a> </div>
      </div>
    </li>
    <li>
      <div class="card"> <img class="card-img-top" src="images/images-6.jpg" alt="Card image cap">
        <div class="btn-favourite" data-toggle="tooltip"  data-placement="bottom"title="Save in favourites"><span class="glyphicon glyphicon-star-empty"></span></div>
        <div class="card-body"> <a class="card-title" href="#">Used Maruti Suzuki Ritz [2013-2017]</a> </div>
      </div>
    </li>
  </ul>
</section>
<!-- premium section end --> 

<!--- previous and next product start -->
<section class="product-prev-next-wrapper">
<a href="#" class="product-previous-ad"><span class="glyphicon glyphicon-chevron-left"></span> Previous Ad: <span class="previous-ad-label">Batrat Steel Furniture</span></a>
   	<a href="#" class="product-next-ad">Next Ad: <span class="next-ad-label">Amit Furniture & Interior</span> <span class="glyphicon glyphicon-chevron-right"></span> </a>
</section>
<!--- previous and next product end -->

<!-- footer section start -->
<section class="footer-wrapper">
  <div class="footer-links-wrapper">
    <div class='col-sm-12 col-lg-3 footer-links' >
      <header>
        <h2 class="section-heading">Information</h2>
      </header>
      <ul>
        <li><a href="#">About us</a></li>
        <li><a href="#">Policy</a></li>
        <li><a href="#">Help</a></li>
        <li><a href="#">Report Spam</a></li>
      </ul>
    </div>
    <div class='col-sm-12 col-lg-3 footer-links' >
      <header>
        <h2 class="section-heading">Site Features</h2>
      </header>
      <ul>
        <li><a href="#">Promote your ad!</a></li>
        <li><a href="#">Premium Account</a></li>
        <li><a href="#">XML Feed Upload</a></li>
      </ul>
    </div>
    <div class='col-sm-12 col-lg-3 footer-links' >
      <header>
        <h2 class="section-heading">Site Features</h2>
      </header>
      <ul>
        <li><a href="#">Promote your ad!</a></li>
        <li><a href="#">Premium Account</a></li>
        <li><a href="#">XML Feed Upload</a></li>
      </ul>
    </div>
    <div class='col-sm-12 col-lg-3 footer-links' >
      <header>
        <h2 class="section-heading">Follow us</h2>
      </header>
      <div> <span><a href="#"><img src="images/icon-facebook.png"></a></span> <span><a href="#"><img src="images/icon-twitter.png"></a></span> <span><a href="#"><img src="images/icon-pinterest.png"></a></span> <span><a href="#"><img src="images/icon-instagram.png"></a></span> </div>
    </div>
  </div>
  <div class="footer-logo"><img src="images/brand-logo.png"</div>
  <div class="footer-brand-location"> <span><a href="#">Australia</a></span> <span><a href="#">Brazil</a></span> <span><a href="#">Canada</a></span> <span><a href="#">China</a></span> <span><a href="#">France</a></span> <span><a href="#">Germany</a></span> <span><a href="#">Italy</a></span> <span><a href="#">India</a></span> <span><a href="#">Japan</a></span> <span><a href="#">Mexico</a></span> <span><a href="#">Netherlands</a></span> <span><a href="#">Spain</a></span> <span><a href="#">United Kingdom</a></span> <span><a href="#">United States</a></span> </div>
  <div class="copy-right">All copyrights reserved @ 2016- Ginder - Local Classified Ads</div>
</section>
<!-- footer section end -->

<div class="modal fade" id="imInterestedModal" tabindex="-1" role="dialog" aria-labelledby="imInterestedModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
          <div class="modal-form-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>          
            <div class="modal-title">Send Query to</div>
                <div class="modal-overview">
                <b>Diamond Furniture Palace</b>
                </div>
                <div class="modal-form">
                <div class="modal-form-row">
                        <textarea class="ctrl-multiline"></textarea>
                    </div>
                <div class="modal-form-row">                    
                    <div class="col-sm-12 col-lg-5 modal-form-col float-left"><input type="text" placeholder="Name *" class="ctrl-singleline" />
                        <div class="warning-wrapper-field error-msg-field">
                        <span class="glyphicon glyphicon-alert"></span>Cannot leave name field blank.
                        </div>
                        </div>
                    <div class="col-sm-12 col-lg-5 modal-form-col modal-rightcol-field float-left"><input type="text" placeholder="Email *" class="ctrl-singleline" />
                        <div class="warning-wrapper-field error-msg-field">
                        <span class="glyphicon glyphicon-alert"></span> Cannot leave email field blank.
                        </div>

                        </div>                        
                    </div>
                <div class="modal-form-row">                    
                    <div class="col-sm-12 col-lg-5 modal-form-col float-left"><input type="text" placeholder="Mobile" class="ctrl-singleline" />
                        </div>
                    <div class="col-sm-12 col-lg-5 modal-form-col modal-rightcol-field float-left"><input type="text" placeholder="Offer" class="ctrl-singleline" />
                        </div>                        
                    </div>                    
                    <div  class="modal-form-footer">
                    <button class="btn-primary btn-mid-size iminterested-button" id="iminterested-submit-button">Send Message</button> <button class="btn-teritory btn-mid-size btn-modal-teritory">Close</button>
                        
                    </div>
                </div>
           </div>
                <!-- thanks for the confirmation message start -->
                <div class="confirmation-msg-wrapper" id="im-interested-conf">
                <div class="confirmation-icon-wrapper success-msg"><span class="glyphicon glyphicon-ok"></span></div>
                    <div class="confirmation-title success-title">Your message has been sent.</div>
                    <div class="confirmation-message">Check your <strong>My Account Inbox</strong> to view sent and recevided messages after login</div>
                    <div class="confirmation-button"><button class="btn-teritory">Ok</button></div>
                </div>
                <!-- thanks for the confirmation message end -->                
          </div>
        </div>
      </div>
    </div>
    
<div class='im-interested-panel' data-toggle="modal" data-target="#imInterestedModal" ></div>
<!-- I am interested panel end -->

</body>
</html>
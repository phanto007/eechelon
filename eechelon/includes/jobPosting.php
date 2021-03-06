<!DOCTYPE HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0 minimal-ui" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'>
    
<title>eechelon</title>

<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" type="text/css" href="styles/skin.css">
<link rel="stylesheet" type="text/css" href="styles/framework.css">
<link rel="stylesheet" type="text/css" href="styles/font-awesome.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.min.css">
<style type="text/css">
#map {
        height: 100%;
      }

      html, body {
        height: 50%;
        margin: 0;
        padding: 0;
      }
</style>
    
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/plugins.js"></script>
<script type="text/javascript" src="scripts/customlogin.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.min.js"></script>


</head>

<body>
<div id="page-transitions">
    
<div class="page-preloader page-preloader-dark">
    <img class="page-preload" src="images/preload.gif">
</div>
            
<div id="page-content" class="page-content header-clear">
    <div id="page-content-scroll">

    <div class="content material-no-bottom">
            <div class="select-box">
                    <select name="dtype" id="dtype" onchange="resetMap()">
	                    <option class="select-title" value="">Select Delivery Type</option>
	                    <option value="1">Purchase and deliver</option>
	                    <option value="2">Pickup and deliver</option>
	                </select>
            </div>
    </div>


       <div id="map" style="max-height: 300px;"></div>
       
       <div class="content">
            <div class="one-half-responsive">
                <div class="container no-bottom">
                    <div class="contact-form no-bottom"> 
                        <div class="formSuccessMessageWrap" id="formSuccessMessageWrap">
                            <div class="notification-medium bg-green-light">
                                <h1>Success!</h1>
                                <a href="#" class="hide-notification"><i class="fa fa-times"></i></a>
                            </div>
                        </div>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="contactForm" id="contactForm">
                            <fieldset>
                                <div class="formValidationError bg-red-dark" id="contactNameFieldError">
                                    <p class="center-text uppercase small-text color-white">Job title is required!</p>
                                </div> 

                                <div class="formValidationError bg-red-dark" id="contactMessageTextareaError">
                                    <p class="center-text uppercase small-text color-white">Job description is empty!</p>
                                </div>           
                                <div class="formValidationError bg-red-dark" id="contactEmailFieldError">
                                    <p class="center-text uppercase small-text color-white">Mail address required!</p>
                                </div> 
                                <div class="formValidationError bg-red-dark" id="contactEmailFieldError2">
                                    <p class="center-text uppercase small-text color-white">Mail address must be valid!</p>
                                </div>
                                <br> <br>

                                <div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="contactNameField">Job Title: <span>(required)</span></label>
                                    <input type="text" name="jobtitle" value="" class="contactField requiredField" id="contactNameField"/>
                                </div>
                                <input type="hidden" name="startcoordinate" id="startcoordinate" value="" required />
                                <input type="hidden" name="endcoordinate" id="endcoordinate" value="" required/>

                                <div class="formTextareaWrap">
                                    <label class="field-title contactMessageTextarea" for="contactMessageTextarea">Description: <span>(required)</span></label>
                                    <textarea name="details" class="contactTextarea requiredField" id="contactMessageTextarea"></textarea>
                                </div>
                                <div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="contactNameField">Time Limit: <span>(required)</span></label>
                                    <input type="text" name="timelimit" value="" class="contactField requiredField" id="contactNameField"/>
                                </div>
                                <div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="contactNameField">Package Worth: <span>(required)</span></label>
                                    <input type="text" name="packageworth" value="" class="contactField requiredField" id="contactNameField"/>
                                </div>
                                <div class="formFieldWrap">
                                    <label class="field-title contactNameField" for="contactNameField">Delivery Fee: <span>(required)</span></label>
                                    <input type="text" name="deliveryfee" value="" class="contactField requiredField" id="contactNameField"/>
                                </div>
                                <div class="formSubmitButtonErrorsWrap contactFormButton">
                                    <input type="submit" class="buttonWrap button button-green contactSubmitButton" id="contactSubmitButton" value="Request" data-formId="contactForm"/>
                                </div>
                            </fieldset>
                        </form>       
                    </div>
                </div>
            </div>
            <div class="decoration hide-if-responsive"></div>
            <div class="one-half-responsive contact-information last-column">         
            </div>
        </div>
        <div class="decoration decoration-margins"></div>
        
    </div>  
</div>          
</div>

</div>

<script>

 

var map;
var markers = [];
var latLng1;
var latLng2;
var count = 0;



function initMap() {
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;

  var center = {lat: 23.825, lng: 90.366};

  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: center,
    mapTypeId: 'terrain'
  });
  directionsDisplay.setMap(map);

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      map.setCenter(pos);
      center  = pos;
      
      
    });
  } else {
    alert("Permission denied.");

   
  }



google.maps.event.addListener(map , 'click', function(event) {
	document.getElementById("startcoordinate").value = "";
    document.getElementById("endcoordinate").value = "";
	var e = document.getElementById("dtype");
	var strUser = e.options[e.selectedIndex].value;
	if(strUser==1){
	  deleteMarkers();
      addMarker(event.latLng, 'Drop');
      latLng1 = event.latLng;
      count = count + 1;
      document.getElementById("startcoordinate").value = "0";
      document.getElementById("endcoordinate").value = latLng1;
	}
	if(strUser==2){
		if(count<1){
	      deleteMarkers();
	      addMarker(event.latLng, 'Drop');
	      latLng1 = event.latLng;
	      count = count + 1;
	    }else if(count<2){
	      addMarker(event.latLng, 'Pickup');
	      latLng2 = event.latLng;
	      count = count + 1;
	      calculateAndDisplayRoute(directionsService, directionsDisplay);
	      count = 0;
	      document.getElementById("startcoordinate").value = latLng2;
	      document.getElementById("endcoordinate").value = latLng1;
	  }
	    
	}
   

});

  
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  directionsService.route({
    origin: latLng1,
    destination: latLng2,
    travelMode: 'WALKING'
  }, function(response, status) {
    if (status === 'OK') {
      directionsDisplay.setDirections(response);
      directionsDisplay.setOptions( { suppressMarkers: true } );
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}


// Adds a marker to the map and push to the array.
function addMarker(location, label) {
  var marker = new google.maps.Marker({
    position: location,
    label: label,
    map: map
  });
  markers.push(marker);
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
  setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  markers = [];
}
function resetMap(){
	deleteMarkers();
	count = 0;
	document.getElementById("startcoordinate").value = "";
    document.getElementById("endcoordinate").value = "";
}


    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFSfWLCMeD_XidejU2qSYavKfVs5r3irE&callback=initMap">
    </script>
    <script type='text/javascript'>
    function succesfulMessage(){
    swal(
        'Request posted successfully!'
    )
    }

</script>


</body>
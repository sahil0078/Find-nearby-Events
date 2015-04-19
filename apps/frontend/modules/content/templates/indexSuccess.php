<!DOCTYPE html>
<html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>

 function initialize() {
    geocoder = new google.maps.Geocoder();



  }

function getCityFromLatLng(lat, lng) {

    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      city = '';
	if (status == google.maps.GeocoderStatus.OK) {
		city = results[5].formatted_address;
		loc = results[2].formatted_address;
      }
	console.log(results);
        var url = 'getEvent?lat=' +lat +'&long='+lng;
	 if(loc!=''){
        url += '&loc='+loc;   
        }
	 if(city!=''){
        url += '&city='+city;   
        }
        makeRequest(url); 
    });
  }

$( document ).ready( function(){
	getLocation();
	initialize();
}
 );

var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(withLocationParameter,withoutLocationParameter);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function withLocationParameter(position) {
  	lat = position.coords.latitude;
	lng = position.coords.longitude;
	city = getCityFromLatLng(lat, lng);
    //x.innerHTML="Latitude: " + position.coords.latitude + 
    //"<br>Longitude: " + position.coords.longitude;  

/*	if(city!=''){
	url += '&city='+city;	
	}
    	var url = 'getEvent?lat=' + position.coords.latitude +'&long='+position.coords.longitude;
	makeRequest(url);*/
}

function withoutLocationParameter(position) {
	 var url = 'getEvent';
	makeRequest(url);
}

function makeRequest(url){
	$.get(url, function(data) { 
		console.log(data);
		data = JSON.parse(data);
		for(var i = 0; i < data.length;i++){
                	$("#results").append('<a href='+data[i].url+'> '+data[i].title+'</a></br>');
        	}	
	});
}

</script>
<body>
<div id = 'results'></div>

</body>
</html>

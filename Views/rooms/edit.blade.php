{!! Form::open(array('url'=>'#', 'class'=>'form-signup', 'files' => true)) !!}
	<h2 class="form-signup-heading">Room</h2>

	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>

	{!! Form::text('room_name', $room['room_name'], array('class'=>' form-control', 'placeholder'=>'Room Name')) !!}
	{!! Form::text('room_village', $room['room_village'], array('class'=>' form-control', 'placeholder'=>'Village')) !!}
	{!! Form::select('user_id', $allUsers, $room['user_id']) !!}
	{!! Form::file('room_photo', '', array('class'=>' form-control', 'placeholder'=>'Photo')) !!}
	
	<br>
	<input type="text" class="form-control" id="findAddress">
	<div id="map_canvas" style="width:100%; height: 200px;"></div>
	{!! Form::hidden('room_lat', $room['room_lat'], array('class'=>' form-control', 'id'=>'room_lat') ) !!}
	{!! Form::hidden('room_lng', $room['room_lng'], array('class'=>' form-control', 'id'=>'room_lng') ) !!}


	{!! Form::hidden('room_id', $room['room_id']) !!}
	
	{!! Form::submit('Save Room', array('class'=>'btn btn-large btn-primary btn-block'))!!}
{!! Form::close() !!}



<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript">
	var map;
	var geocoder;
	var marker;
	$(document).ready(function () {
		geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng({{ $room['room_lat'] }}, {{ $room['room_lng'] }});
		var myOptions = { zoom: 10, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP };
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 
		marker = new google.maps.Marker({
			map: map,
			position: latlng,
			draggable:true
		});
		google.maps.event.addListener(marker, 'dragend', function() 
		{
			geocodePosition(marker.getPosition());
		});
		jQuery("#findAddress").change(relocateMap);
	}); 
	function relocateMap(){
		var address = jQuery("#findAddress").val();
		geocoder.geocode( { 'address': address}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
		    map.setCenter(results[0].geometry.location);
		    marker.setPosition(results[0].geometry.location);
		    jQuery("#room_lat").val(results[0].geometry.location.lat());
		    jQuery("#room_lng").val(results[0].geometry.location.lng());
		  } else {
		    alert("Geocode was not successful for the following reason: " + status);
		  }
		});
	}
	
	

	function geocodePosition(pos) 
	{
	   geocoder = new google.maps.Geocoder();
	   geocoder.geocode({latLng: pos}, 
		    function(results, status) 
		    {
		        if (status == google.maps.GeocoderStatus.OK) 
		        {
		           	jQuery("#room_lat").val(results[0].geometry.location.lat());
		    		jQuery("#room_lng").val(results[0].geometry.location.lng());
		        } 
		    }
		);
	}
</script>


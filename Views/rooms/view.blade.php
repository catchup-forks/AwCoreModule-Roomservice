<div class="row">
	<div class="col-sm-4 col-xs-12">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-bed"></i>
					<span>Room Details</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if($is_admin)
				<a href="{{ URL::to('rooms/edit/'.$room['room_id']) }}" class="btn btn-default pull-right"><span class="fa fa-edit"></span> Edit</a>
				@endif
				@if(isset($room['room_lat']) && $room['room_lat']!= "" && $room['room_lng'] != "")
				<h3 id="open_map" class="btn btn-default pull-right"><span class="fa fa-map-marker"></span> Map</h3>
				@endif
				<h2>{{ $room['room_name'] }}</h2>
				<h3>{{ $room['room_village'] }}</h3>
				<h3>Owner: {{ $room['owner_name'] }}</h3>
				<h3>Balance: {{ $room['balance'] }}</h3>
			</div>
		</div>	
	</div>
	<div class="col-sm-4 col-xs-12">
		@if(isset($room['room_photo']) && $room['room_photo']!="")
			<img src="{{ URL::to('uploads/rooms') }}/{{ $room['room_photo'] }}" class="room_photo" style="max-width:100%; max-height: 250px; height: auto;">
		@endif
	</div>
	<div class="col-sm-4 col-xs-12">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-bed"></i>
					<span>Room Chat</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if($roomChat)
					@foreach($roomChat as $chat)
						<p class="room-chat">
							<strong>{{ $chat['room_chat'] }}</strong>
							<em>{{ $chat['user_name'] }} - {{ $chat['chat_date'] }}</em>
						</p>
					@endforeach
				@else
					<h3>No chat</h3>
				@endif
				{!! Form::open(array('url'=>'/rooms/addchat', 'class'=>'form-chat')) !!}
					{!! Form::text('add_chat', '', array('class'=>' form-control', 'placeholder'=>'Add Chat', 'style'=>'width:60%; display:inline-block;')) !!}
					{!! Form::hidden('room_id', $room['room_id']) !!}
					{!! Form::submit('Add Chat', array('class'=>'btn btn-small btn-primary btn-inline'))!!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-4 col-xs-12">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-star"></i>
					<span>Active bookings</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if($roomBookings_active)
					<table class="table table-striped table-condensed fixed">
						<tr>
							<th>Status</th>
							<th>Period</th>
							<th>Guests</th>
							<th>Notes</th>
						</tr>
						@foreach($roomBookings_active as $book)
						<tr>
							<td><a href="{{ URL::to('roombookings/edit/'.$book['room_book_id']) }}"><span class="fa fa-edit"></span></a> ID:{{$book['room_book_id']}} <br> {{$book['status_name']}}</td>
							<td>In: {{$book['room_book_start']}}<br>Out: {{$book['room_book_end']}}</td>
							<td>{{$book['room_book_name']}} x {{$book['room_book_ppl']}}<br>{{$book['room_book_email']}}</td>
							<td>{{$book['room_book_notes']}}</td>
						</tr>
						@endforeach
					</table>
				@else
				<h3>No active bookings</h3>
				@endif
			</div>
		</div>	
	</div>
	<div class="col-lg-4 col-sm-6 col-xs-12">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-money"></i>
					<span>Payments and Charges</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if($is_admin)
				<a href="{{ URL::to('roomcharges/new/'.$room['room_id']) }}"><span class="fa fa-plus"></span>Add Charge</a>
				@endif
				<a href="{{ URL::to('rooms/exportcharges/'.$room['room_id']) }}" class="pull-right" target="_blank"><span class="fa fa-download"></span>Export</a>
				@if(! Input::has("allcharge"))
					Showing 10 <a href="{{ URL::to('rooms/view/'.$room['room_id'].'?allcharge=1') }}" class=""><span class="fa fa-search"></span> All Charges</a>
				@endif
				@if(is_array($roomCharges) && count($roomCharges) )
					<table class="table table-striped table-condensed">
						<tr>
							<th>Date</th>
							<th>Amount</th>
							<th>Notes</th>
							@if($is_admin)
							<th>Edit</th>
							@endif
						</tr>
						@foreach($roomCharges as $charge)
						<tr>
							<td>{{$charge['room_charge_date']}}</td>
							<td>{{$charge['room_charge_amount']}}</td>
							<td>{{$charge['room_charge_desc']}}</td>
							@if($is_admin)
							<td><a href="{{ URL::to('roomcharges/edit/'.$charge['room_charge_id']) }}"><span class="fa fa-edit"></span></a></td>
							@endif
						</tr>
						@endforeach
					</table>
				@else
				<h3>No Charges</h3>
				@endif
			</div>
		</div>	
	</div>
	<div class="col-lg-4 col-sm-6 col-xs-12">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-dashboard"></i>
					<span>Meter Readings</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if($is_admin)
				<a href="{{ URL::to('roommeters/new/'.$room['room_id']) }}"><span class="fa fa-plus"></span>Add Meter Reading</a>
				@endif
				@if(! Input::has("allmeter"))
					Showing 10 <a href="{{ URL::to('rooms/view/'.$room['room_id'].'?allmeter=1') }}" class=""><span class="fa fa-search"></span> All Readings</a>
				@endif
				@if(is_array($roomMeters) && count($roomMeters) )
					<table class="table table-striped table-condensed">
						<tr>
							<th>Date</th>
							<th>Type</th>
							<th>Amount</th>
							<th>Notes</th>
							@if($is_admin)
							<th>Edit</th>
							@endif
						</tr>
						@foreach($roomMeters as $meter)
						<tr>
							<td>{{$meter['room_meter_date']}}</td>
							<td>{{$meter['room_meter_type_name']}}</td>
							<td>{{$meter['room_meter_value']}}</td>
							<td>{{$meter['room_meter_notes']}}</td>
							@if($is_admin)
							<td><a href="{{ URL::to('roommeters/edit/'.$meter['room_meter_id']) }}"><span class="fa fa-edit"></span></a></td>
							@endif
						</tr>
						@endforeach
					</table>
				@else
				<h3>No Meter Readings</h3>
				@endif
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-calendar"></i>
					<span>Upcoming bookings</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				<a href="{{ URL::to('roombookings/new/'.$room['room_id']) }}"><span class="fa fa-plus"></span>Add Booking</a>
				@if(is_array($roomBookings_future) && count($roomBookings_future) )
					<table class="table table-striped table-condensed">
						<tr>
							<th>ID</th>
							<th>Status</th>
							<th>Check In</th>
							<th>Check Out</th>
							<th>Guests</th>
							<th>Name</th>
							<th>Email</th>
							<th>Notes</th>
							<th>Edit</th>
						</tr>
						@foreach($roomBookings_future as $book)
						<tr>
							<td>{{$book['room_book_id']}}</td>
							<td>{{$book['status_name']}}</td>
							<td>{{$book['room_book_start']}}</td>
							<td>{{$book['room_book_end']}}</td>
							<td>{{$book['room_book_ppl']}}</td>
							<td>{{$book['room_book_name']}}</td>
							<td>{{$book['room_book_email']}}</td>
							<td>{{$book['room_book_notes']}}</td>
							<td><a href="{{ URL::to('roombookings/edit/'.$book['room_book_id']) }}"><span class="fa fa-edit"></span></a></td>
						</tr>
						@endforeach
					</table>
				@else
				<h3>No Upcoming bookings</h3>
				@endif
			</div>
		</div>	
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-calendar"></i>
					<span>Past bookings</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if(is_array($roomBookings_past) && count($roomBookings_past) )
					<table class="table table-striped table-condensed">
						<tr>
							<th>ID</th>
							<th>Status</th>
							<th>Check In</th>
							<th>Check Out</th>
							<th>Guests</th>
							<th>Name</th>
							<th>Email</th>
							<th>Notes</th>
							<th>Edit</th>
						</tr>
						@foreach($roomBookings_past as $book)
						<tr>
							<td>{{$book['room_book_id']}}</td>
							<td>{{$book['status_name']}}</td>
							<td>{{$book['room_book_start']}}</td>
							<td>{{$book['room_book_end']}}</td>
							<td>{{$book['room_book_ppl']}}</td>
							<td>{{$book['room_book_name']}}</td>
							<td>{{$book['room_book_email']}}</td>
							<td>{{$book['room_book_notes']}}</td>
							<td><a href="{{ URL::to('roombookings/edit/'.$book['room_book_id']) }}"><span class="fa fa-edit"></span></a></td>
						</tr>
						@endforeach
					</table>
				@else
				<h3>No past bookings</h3>
				@endif
			</div>
		</div>	
	</div>
</div>

@if(isset($room['room_lat']) && $room['room_lat']!= "" && $room['room_lng'] != "")
<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript">
    var map;
	var geocoder;
	var marker;
	var mapint = 0;
	$(document).ready(function () {
		
		
		$('#open_map').on('click', function(){
			mapint+=1;
			$("body").append('<div id="map_canvas'+mapint+'" style="position:relative;width:100%; height:250px;"></div>');	
			var form = $("#map_canvas"+mapint);	
			OpenModalBox('Location', form);
			
			geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng({{ $room['room_lat'] }}, {{ $room['room_lng'] }});
			var myOptions = { zoom: 12, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP };
			map = new google.maps.Map(document.getElementById("map_canvas"+mapint), myOptions); 
			marker = new google.maps.Marker({
				map: map,
				position: latlng
			});	
				
		});
		
	}); 
</script>
@endif

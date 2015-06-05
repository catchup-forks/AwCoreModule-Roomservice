{!! Form::open(array('url'=>'#', 'class'=>'form-signup', 'files'=>true)) !!}
	<h2 class="form-signup-heading">Meter Reading - {{ $roomMeterTypes[$roomMeter['room_meter_type_id']]['room_meter_type_name'] }} - {{ $room['room_name'] }}</h2>

	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	
	
	{!! Form::text('room_meter_value',$roomMeter['room_meter_value'], array('class'=>' form-control', 'placeholder'=>'Meter Reading')) !!}
	{!! Form::text('room_meter_notes',$roomMeter['room_meter_notes'], array('class'=>' form-control', 'placeholder'=>'Notes')) !!}
	{!! Form::select('room_meter_type_id', $roomMeterTypesSel, $roomMeter['room_meter_type_id'], array('class'=>' form-control', 'placeholder'=>'Meter Type')) !!}
	{!! Form::file('room_meter_photo', array('class'=>' form-control', 'placeholder'=>'Photo')) !!}
	@if(isset($roomMeter['room_meter_photo']) && $roomMeter['room_meter_photo']!="")
		<img src="{{ URL::to('uploads/meters') }}/{{ $roomMeter['room_meter_photo'] }}" class="room_meter_photo" >
	@endif
	

	{!! Form::hidden('room_id', $roomMeter['room_id']) !!}
	{!! Form::hidden('room_meter_id', $roomMeter['room_meter_id']) !!}
	
	{!! Form::submit('Save Meter Reading', array('class'=>'btn btn-large btn-primary btn-block'))!!}
	
	{!! link_to('rooms/view/'.$roomMeter['room_id'], 'Cancel', array('class'=>'btn btn-default btn-block'))!!}
{!! Form::close() !!}

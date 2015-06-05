{!! Form::open(array('url'=>'#', 'class'=>'form-signup')) !!}
	<h2 class="form-signup-heading">Booking - {{ $room['room_name'] }}</h2>

	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	
	@if(is_array($roomMeterTypes) && count($roomMeterTypes))
		@foreach($roomMeterTypes as $type)
			{{$type['room_meter_type_name']}}
			{!! Form::text('meter_value_'.$type['room_meter_type_id'],'', array('class'=>' form-control', 'placeholder'=>'Meter Reading')) !!}
			{!! Form::text('meter_notes_'.$type['room_meter_type_id'],'', array('class'=>' form-control', 'placeholder'=>'Notes')) !!}
			{!! Form::text('meter_photo_'.$type['room_meter_type_id'],'', array('class'=>' form-control', 'placeholder'=>'Photo')) !!}
		@endforeach
	@endif
	

	{!! Form::hidden('room_id', $roomMeter['room_id']) !!}
	
	{!! Form::submit('Save Room', array('class'=>'btn btn-large btn-primary btn-block'))!!}
{!! Form::close() !!}

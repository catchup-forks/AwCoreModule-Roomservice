{!! Form::open(array('url'=>'#', 'class'=>'form-signup')) !!}
	<h2 class="form-signup-heading">Meter Type</h2>

	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>

	{!! Form::text('room_meter_type_name', $metertypes['room_meter_type_name'], array('class'=>' form-control', 'placeholder'=>'Meter Type Name')) !!}
	

	{!! Form::hidden('room_meter_type_id', $metertypes['room_meter_type_id']) !!}
	
	{!! Form::submit('Save Meter Type', array('class'=>'btn btn-large btn-primary btn-block'))!!}
{!! Form::close() !!}

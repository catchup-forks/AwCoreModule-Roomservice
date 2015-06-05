{!! Form::open(array('url'=>'#', 'class'=>'form-signup')) !!}
	<h2 class="form-signup-heading">Charges - {{ $room['room_name'] }}</h2>

	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	Charge date
	{!! Form::text('room_charge_date', $roomCharge['room_charge_date'], array('class'=>' form-control datepicker', 'placeholder'=>'Charge Date')) !!}
	Amount
	{!! Form::input('number', 'room_charge_amount', $roomCharge['room_charge_amount'], array('class'=>' form-control', 'placeholder'=>'Amount')) !!}
	Description
	{!! Form::text('room_charge_desc', $roomCharge['room_charge_desc'], array('class'=>' form-control', 'placeholder'=>'Description')) !!}

	{!! Form::hidden('room_id', $roomCharge['room_id']) !!}
	{!! Form::hidden('room_charge_id', $roomCharge['room_charge_id']) !!}
	
	{!! Form::submit('Save Charge', array('class'=>'btn btn-large btn-primary btn-block'))!!}
	
	{!! link_to('rooms/view/'.$roomCharge['room_id'], 'Cancel', array('class'=>'btn btn-default btn-block'))!!}
{!! Form::close() !!}

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".datepicker").datepicker({
		dateFormat: "dd-mm-yy"
	});
});
</script>

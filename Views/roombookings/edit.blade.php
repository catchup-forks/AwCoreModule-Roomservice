{!! Form::open(array('url'=>'#', 'class'=>'form-signup')) !!}
	<h2 class="form-signup-heading">Booking - {{ $room['room_name'] }}</h2>

	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
	Checkin date
	{!! Form::text('room_book_start', $roomBooking['room_book_start'], array('class'=>' form-control datepicker', 'placeholder'=>'Start Date')) !!}
	Checkout Date
	{!! Form::text('room_book_end', $roomBooking['room_book_end'], array('class'=>' form-control datepicker', 'placeholder'=>'End Date')) !!}
	Number of Guests
	{!! Form::input('number', 'room_book_ppl', $roomBooking['room_book_ppl'], array('class'=>' form-control', 'placeholder'=>'Number of guests')) !!}
	Guest Name
	{!! Form::text('room_book_name', $roomBooking['room_book_name'], array('class'=>' form-control', 'placeholder'=>'Guest Name')) !!}
	Guest Email
	{!! Form::email('room_book_email', $roomBooking['room_book_email'], array('class'=>' form-control', 'placeholder'=>'Guest Email')) !!}
	Deposit Due
	{!! Form::input('number', 'room_book_deposit_due', $roomBooking['room_book_deposit_due'], array('class'=>' form-control', 'placeholder'=>'Deposit Due')) !!}
	Deposit Collected
	{!! Form::input('number', 'room_book_deposit_collected', $roomBooking['room_book_deposit_collected'], array('class'=>' form-control', 'placeholder'=>'Deposit collected')) !!}
	Deposit Returned
	{!! Form::input('number', 'room_book_deposit_returned', $roomBooking['room_book_deposit_returned'], array('class'=>' form-control', 'placeholder'=>'Deposit returned')) !!}
	Status
	{!! Form::select('room_book_status', $all_status, $roomBooking['room_book_status'], array('class'=>' form-control', 'placeholder'=>'Status')) !!}
	Notes
	{!! Form::textarea('room_book_notes', $roomBooking['room_book_notes'], array('class'=>' form-control', 'placeholder'=>'Notes')) !!}

	{!! Form::hidden('room_id', $roomBooking['room_id']) !!}
	{!! Form::hidden('room_book_id', $roomBooking['room_book_id']) !!}
	
	{!! Form::submit('Save Room', array('class'=>'btn btn-large btn-primary btn-block'))!!}
{!! Form::close() !!}

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".datepicker").datepicker({
		dateFormat: "dd-mm-yy"
	});
});
</script>

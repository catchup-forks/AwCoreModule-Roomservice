<style type="text/css">
tr.greenrow, .table-striped > tbody > tr.greenrow:nth-child(odd) > td {background:rgb(143,253,143);}
tr.orangerow, .table-striped > tbody > tr.orangerow:nth-child(odd) > td {background:rgb(255,178,102);}
</style>

<div class="row">
	<div class="col-xs-12 col-md-3">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-bed"></i>
					<span>Checkins</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if(is_array($checkins) && count($checkins))
					<table class="table table-striped table-condensed fixed">
						<tr><th>Room</th><th>Status</th><th>Checkin</th></tr>
					@foreach($checkins as $row)
						<tr
						@if($row['room_book_status'] >=50)
						class='greenrow'
						@elseif($row['room_book_status'] <10)
						class='orangerow'
						@endif
						>
							<td rowspan="2"><a href="{!! URL::to('rooms/view/'.$row['room_id']) !!}" title="{{ $row['room_village'] }}">{{ $row['room_name'] }}</a></td>
							<td><a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" >{{ $row['status_name'] }}</td>
							<td><a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" title="Checkout on {{ $row['room_book_end'] }}">{{ $row['room_book_start'] }}</td>
						</tr><tr
						@if($row['room_book_status'] >=50)
						class='greenrow'
						@elseif($row['room_book_status'] <10)
						class='orangerow'
						@endif
						>
							<td colspan="2" style="border-top: none; max-width:100%; white-space: normal;">
								<a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" title="{{ $row['room_book_email'] }}">{{ $row['room_book_name'] }} ({{ $row['room_book_ppl'] }} ppl)
							</td>
						</tr>
					@endforeach
					</table>
				@else
					No Upcoming Checkins
				@endif
			</div>
		</div>	
	</div>
	<div class="col-xs-12 col-md-3">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-share"></i>
					<span>Checkouts</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if(is_array($checkouts) && count($checkouts))
					<table class="table table-striped table-condensed fixed">
						<tr><th>Room</th><th>Status</th><th>Checkout</th></tr>
					@foreach($checkouts as $row)
						<tr
						@if($row['room_book_status'] >=99)
						class='greenrow'
						@elseif($row['room_book_status'] <10)
						class='orangerow'
						@endif
						>							
							<td rowspan="2"><a href="{!! URL::to('rooms/view/'.$row['room_id']) !!}" title="{{ $row['room_village'] }}">{{ $row['room_name'] }}</a></td>
							<td><a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" >{{ $row['status_name'] }}</td>
							<td><a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" title="Checked in {{ $row['room_book_start'] }}">{{ $row['room_book_end'] }}</td>
						</tr>
						<tr
						@if($row['room_book_status'] >=99)
						class='greenrow'
						@elseif($row['room_book_status'] <10)
						class='orangerow'
						@endif
						>							
							<td colspan="2" style="border-top: none; max-width:100%; white-space: normal;">
								<a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" title="{{ $row['room_book_email'] }}">{{ $row['room_book_name'] }} ({{ $row['room_book_ppl'] }} ppl)
							</td>
						</tr>
					@endforeach
					</table>
				@else
					No Upcoming Check outs
				@endif
			</div>
		</div>	
	</div>
	<div class="col-xs-12 col-md-4">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-flag"></i>
					<span>Latest Requests</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if(is_array($latest) && count($latest))
					<table class="table table-striped table-condensed fixed">
						<tr><th>Room</th><th>Status</th><th>Created</th><th>Checkin</th></tr>
					@foreach($latest as $row)
						<tr
						@if($row['room_book_status'] >=20)
						class='greenrow'
						@endif
						>							
							<td rowspan="2"><a href="{!! URL::to('rooms/view/'.$row['room_id']) !!}" title="{{ $row['room_village'] }}">{{ $row['room_name'] }}</a></td>
							<td><a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" >{{ $row['status_name'] }}</td>
							<td><a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" title="Check in {{ $row['room_book_start'] }}"><?php
							if(date("Y-m-d", strtotime($row['created_at'])) == date("Y-m-d")){echo(date("H:i:s", strtotime($row['created_at'])));}
							else{echo( date("jS M Y", strtotime($row['created_at'])) );}
							?></td>
							<td><a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" title="Checkout on {{ $row['room_book_end'] }}">{{ $row['room_book_start'] }}</td>
						</tr>
						<tr
						@if($row['room_book_status'] >=20)
						class='greenrow'
						@endif
						>							
							<td colspan="3" style="border-top: none; max-width:100%; white-space: normal;">
								<a href="{!! URL::to('roombookings/edit/'.$row['room_book_id']) !!}" title="{{ $row['room_book_email'] }}">{{ $row['room_book_name'] }} ({{ $row['room_book_ppl'] }} ppl)
							</td>
						</tr>
					@endforeach
					</table>
				@else
					No Recent Requests
				@endif
			</div>
		</div>	
	</div>
	<div class="col-xs-12 col-md-2">
		<div class="box " style="opacity: 1; z-index: 1999; left: 0px; top: 0px;">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-money"></i>
					<span>Balances</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					<a class="expand-link"><i class="fa fa-expand"></i></a>
					<a class="close-link"><i class="fa fa-times"></i></a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content no-padding">
				@if(is_array($balances) && count($balances))
					<table class="table table-striped table-condensed">
						<tr><th>Room</th><th>Balance</th></tr>
					@foreach($balances as $row)
						<tr>
							<td><a href="{!! URL::to('rooms/view/'.$row['room_id']) !!}" title="{{ $row['room_village'] }}">{{ $row['room_name'] }}</a></td>
							<td><a href="{!! URL::to('rooms/view/'.$row['room_id']) !!}" title="{{ $row['owner_name'] }}">{{ number_format($row['balance']) }}</a></td>
						</tr>
					@endforeach
					</table>
				@else
					No Properties
				@endif
			</div>
		</div>	
	</div>
</div>

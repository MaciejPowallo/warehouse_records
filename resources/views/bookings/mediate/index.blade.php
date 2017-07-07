@extends('master')
	@section('title')
		Wykaz rezerwacji
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Rezerwacje zakończone</p>	
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>
    	</div>

    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk dodania nowego wpisu -->
                   	@include('panel.button.add_button',['controller'=>'BookingsController@create', 'name'=>'rezerwację'])

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'BookingsMediator@index'])

				<!-- Niezatwierdzone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'BookingsController@index', 'name' => 'Niezatwierdzone'])

				<!-- W realizacji -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'BookingsApprover@index', 'name' => 'W realizacji'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table class="table table-bordered col-xs-12">
					<thead>
						<tr>
			        		<th>Nr dokumentu</th>			        		
			        		<th>Lokalizacja</th>
			        		<th>Pracownik odbierający</th>
			        		<th>Termin zamówienia</th>
			        		<th>Data utworzenia</th>
			        		<th>Odpowiedź</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'bookings/mediate', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'bookings/mediate', 'name'=>'search_location_name', 'type'=>Request::get('search_location_name') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'bookings/mediate', 'name'=>'search_name_booked', 'type'=>Request::get('search_name_booked') ])
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'bookings/mediate', 'name'=>'search_delivery_date', 'type'=>Request::get('search_delivery_date')])			
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'bookings/mediate', 'name'=>'search_booking_date', 'type'=>Request::get('search_booking_date') ])			
			        		</td>
			        		<td></td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($bookings as $booking)
						<tbody>
							@if($booking->accepted == 0) 
								<tr class="name">
							        <td class="c1">{{ $booking->doc_numb }}</td>
							        <td class="c1">{{ $booking->location->location_name }}</td>
							        <td class="c1">{{ $booking->name_booked }}</td>
							        <td class="c1">{{ $booking->delivery_date }}</td>
							        <td class="c1">{{ $booking->created_at->format('Y-m-d') }}</td>
							        <td class="c1" style="text-align: center;">
							        <i class="fa fa-minus-square red_text fa-2x" aria-hidden="true"></i>
							        </td>
									<!-- Przyciski -->
	                   				@include('panel.button.preview_button',['controller'=>'BookingsMediator@show', 'route'=>$booking->id])
								</tr>
	 						@endif
							@if($booking->accepted == 1)
								<tr class="name">
							        <td class="c2">{{ $booking->doc_numb }}</td>
							        <td class="c2">{{ $booking->location->location_name }}</td>
							        <td class="c2">{{ $booking->name_booked }}</td>
							        <td class="c2">{{ $booking->delivery_date }}</td>
							        <td class="c2">{{ $booking->created_at->format('Y-m-d') }}</td>
							        <td class="c2" style="text-align: center;">
							        <i class="fa fa-check-square green_text fa-2x" aria-hidden="true"></i>
							        </td>
									<!-- Przyciski -->
	                   				@include('panel.button.preview_button',['controller'=>'BookingsMediator@show', 'route'=>$booking->id])
								</tr>
							@endif
						</tbody>
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $bookings->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
@extends('master')
	@section('title')
		Wykaz rezerwacji
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Rezerwacje w realizacji</p>	
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
                   	@include('panel.button.clearsearch_button', ['controller'=>'BookingsApprover@index'])

				<!-- Niezatwierdzone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'BookingsController@index', 'name' => 'Niezatwierdzone'])

				<!-- Zakończone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'BookingsMediator@index', 'name' => 'Zakończone'])
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
			        		<th class="col_hidden" colspan="2">Autor wpisu</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'bookings/approved', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'bookings/approved', 'name'=>'search_location_name', 'type'=>Request::get('search_location_name') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'bookings/approved', 'name'=>'search_name_booked', 'type'=>Request::get('search_name_booked') ])
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'bookings/approved', 'name'=>'search_delivery_date', 'type'=>Request::get('search_delivery_date')])			
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'bookings/approved', 'name'=>'search_booking_date', 'type'=>Request::get('search_booking_date') ])			
			        		</td>
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'bookings/approved', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td></td>
						</tr>
					</thead>

					@foreach($bookings as $booking)
						<tbody>
							<tr class="name">
						        <td>{{ $booking->doc_numb }}</td>
						        <td>{{ $booking->location->location_name }}</td>
						        <td>{{ $booking->name_booked }}</td>
						        <td>{{ $booking->delivery_date }}</td>
						        <td>{{ $booking->created_at->format('Y-m-d') }}</td>
						        <td class="col_hidden">{{ $booking->user->name }}</td>
						        <td class="col_hidden">{{ $booking->user->surname }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'BookingsApprover@show', 'route'=>$booking->id])
							</tr>
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
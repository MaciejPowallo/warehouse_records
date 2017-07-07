@extends('master')
	@section('title')
		Wykaz niezatwierdzonych rezerwacji
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2"><b class="red_text">Niezatwierdzone</b> rezerwacje		
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>

			<!-- Widomośc z sesji -->
    		@if(Session::has('mes_booking_delete'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_booking_delete') }}</div>
    		@endif
    	</div>

    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk dodania nowego wpisu -->
                   	@include('panel.button.add_button',['controller'=>'BookingsController@create', 'name'=>'rezerwację'])

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'BookingsController@index'])

				<!-- W realizacji -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'BookingsApprover@index', 'name' => 'W realizacji'])

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
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'bookings', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'bookings', 'name'=>'search_location_name', 'type'=>Request::get('search_location_name') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'bookings', 'name'=>'search_name_booked', 'type'=>Request::get('search_name_booked') ])
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'bookings', 'name'=>'search_delivery_date', 'type'=>Request::get('search_delivery_date')])			
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'bookings', 'name'=>'search_booking_date', 'type'=>Request::get('search_booking_date') ])			
			        		</td>
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'bookings', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td></td>
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
                   				@include('panel.button.edit_button',['controller'=>'BookingsController@show', 'route'=>$booking->id])
                   				@include('panel.delete',['controller'=>'BookingsController@destroy', 'name' => $booking ,'route'=>$booking->id])

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
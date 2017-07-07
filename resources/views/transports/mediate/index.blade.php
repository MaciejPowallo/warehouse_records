@extends('master')
	@section('title')
		Wykaz transportów
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Transporty zakończone</p>	
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
                   	@include('panel.button.add_button',['controller'=>'Return_transportsController@create', 'name'=>'transport'])

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'Return_transportsMediator@index'])

				<!-- Niezatwierdzone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'Return_transportsController@index', 'name' => 'Niezatwierdzone'])

				<!-- W realizacji -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'Return_transportsApprover@index', 'name' => 'W realizacji'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table class="table table-bordered col-xs-12">
					<thead>
						<tr>
			        		<th>Nr dokumentu</th>			        		
			        		<th>Lokalizacja</th>
			        		<th>Kierowca</th>
			        		<th>Nr rejestracyjny</th>
			        		<th>Data transportu</th>
			        		<th>Data utworzenia</th>
			        		<th colspan="2">Pracownik</th>
			        		<th>Odpowiedź</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'transports/mediate', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'transports/mediate', 'name'=>'search_location_name', 'type'=>Request::get('search_location_name') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'transports/mediate', 'name'=>'search_driver', 'type'=>Request::get('search_driver') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'transports/mediate', 'name'=>'search_vehicle', 'type'=>Request::get('search_vehicle') ])
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'transports/mediate', 'name'=>'search_transport_date', 'type'=>Request::get('search_transport_date')])			
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'transports/mediate', 'name'=>'search_created_date', 'type'=>Request::get('search_created_date') ])			
			        		</td>
							<!-- td -->
                   				@include('panel.searchemployeename',['table'=>'transports/mediate', 'type1'=>Request::get('search_name_empl'), 'type2'=>Request::get('search_surname_empl') ])	
							<!-- /td -->
			        		<td></td>
			        		<td></td>
						</tr>
					</thead>
					@foreach($transports as $transport)
						<tbody>
							@if($transport->accepted == 0) 
								<tr class="name">
							        <td class="c1">{{ $transport->doc_numb }}</td>
							        <td class="c1">{{ $transport->location->location_name }}</td>
							        <td class="c1">{{ $transport->driver }}</td>
							        <td class="c1">{{ $transport->vehicle }}</td>
							        <td class="c1">{{ $transport->transport_date }}</td>
							        <td class="c1">{{ $transport->created_at->format('Y-m-d') }}</td>
							        <td class="c1">{{ $transport->employee->name_empl }}</td>
							        <td class="c1">{{ $transport->employee->surname_empl }}</td>
							        <td class="c1" style="text-align: center;">
							        <i class="fa fa-minus-square red_text fa-2x" aria-hidden="true"></i>
							        </td>
									<!-- Przyciski -->
	                   				@include('panel.button.preview_button',['controller'=>'Return_transportsMediator@show', 'route'=>$transport->id])
								</tr>
	 						@endif
							@if($transport->accepted == 1)
								<tr class="name">
							        <td class="c2">{{ $transport->doc_numb }}</td>
							        <td class="c2">{{ $transport->location->location_name }}</td>
							        <td class="c2">{{ $transport->driver }}</td>
							        <td class="c2">{{ $transport->vehicle }}</td>
							        <td class="c2">{{ $transport->transport_date }}</td>
							        <td class="c2">{{ $transport->created_at->format('Y-m-d') }}</td>
							        <td class="c2">{{ $transport->employee->name_empl }}</td>
							        <td class="c2">{{ $transport->employee->surname_empl }}</td>
							        <td class="c2" style="text-align: center;">
							        <i class="fa fa-check-square green_text fa-2x" aria-hidden="true"></i>
							        </td>
									<!-- Przyciski -->
	                   				@include('panel.button.preview_button',['controller'=>'Return_transportsMediator@show', 'route'=>$transport->id])
								</tr>
							@endif
						</tbody>
					@endforeach	
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $transports->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
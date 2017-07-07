@extends('master')
	@section('title')
		Wykaz niezatwierdzonych transportów
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2"><b class="red_text">Niezatwierdzone</b> transporty		
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>

			<!-- Widomośc z sesji -->
    		@if(Session::has('mes_transport_delete'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_transport_delete') }}</div>
    		@endif
    	</div>

    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk dodania nowego wpisu -->
                   	@include('panel.button.add_button',['controller'=>'Return_transportsController@create', 'name'=>'transport'])

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'Return_transportsController@index'])

				<!-- W realizacji -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'Return_transportsApprover@index', 'name' => 'W realizacji'])

				<!-- Zakończone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'Return_transportsMediator@index', 'name' => 'Zakończone'])
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
			        		<th class="col_hidden" colspan="2">Autor wpisu</th>
			        		<th></th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'transports', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'transports', 'name'=>'search_location_name', 'type'=>Request::get('search_location_name') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'transports', 'name'=>'search_driver', 'type'=>Request::get('search_driver') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'transports', 'name'=>'search_vehicle', 'type'=>Request::get('search_vehicle') ])
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'transports', 'name'=>'search_transport_date', 'type'=>Request::get('search_transport_date')])			
			        		</td>
			        		<td>
                   				@include('panel.searchdate',['table'=>'transports', 'name'=>'search_created_date', 'type'=>Request::get('search_created_date') ])			
			        		</td>
							<!-- td -->
                   				@include('panel.searchemployeename',['table'=>'transports', 'type1'=>Request::get('search_name_empl'), 'type2'=>Request::get('search_surname_empl') ])	
							<!-- /td -->
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'transports', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td></td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($transports as $transport)
						<tbody>
							<tr class="name">
						        <td>{{ $transport->doc_numb }}</td>
						        <td>{{ $transport->location->location_name }}</td>
						        <td>{{ $transport->driver }}</td>
						        <td>{{ $transport->vehicle }}</td>
						        <td>{{ $transport->transport_date }}</td>
						        <td>{{ $transport->created_at->format('Y-m-d') }}</td>
						        <td>{{ $transport->employee->name_empl }}</td>
						        <td>{{ $transport->employee->surname_empl }}</td>
						        <td class="col_hidden">{{ $transport->user->name }}</td>
						        <td class="col_hidden">{{ $transport->user->surname }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.edit_button',['controller'=>'Return_transportsController@show', 'route'=>$transport->id])
                   				@include('panel.delete',['controller'=>'Return_transportsController@destroy', 'name' => $transport ,'route'=>$transport->id])

							</tr>
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
@extends('master')
	@section('title')
		Wykaz miejsc użytkowania
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Wykaz miejsc użytkowania				
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>

			<!-- Widomośc z sesji -->
    		@if(Session::has('mes_location_add'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_location_add') }}</div>
    		@endif

    		@if(Session::has('mes_location_delete'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_location_delete') }}</div>
    		@endif
    	</div>

    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk dodania nowego wpisu -->
                   	@include('panel.button.add_button',['controller'=>'LocationsController@create', 'name'=>'lokalizację'])

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'LocationsController@index']) 
				</div>
			</div>  	
			<div class="table-responsive">
				<table id="tableSearch" class="table table-bordered col-xs-12">

					<thead>
						<tr>
			        		<th>Nazwa</th>
			        		<th class="col_hidden">Kraj</th>
			        		<th class="col_hidden">Miejscowość</th>
			        		<th class="col_hidden">Ulica</th>
			        		<th class="col_hidden">Nr budynku</th>
			        		<th class="col_hidden">Kod pocztowy</th>
			        		<th class="col_hidden" colspan="2">Imię i nazwisko autora</th>
			        		<th></th>
			        		<th></th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'locations', 'name'=>'search_name', 'type'=>Request::get('search_name') ])
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'locations', 'name'=>'search_country', 'type'=>Request::get('search_country') ])
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'locations', 'name'=>'search_city', 'type'=>Request::get('search_city') ])		
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'locations', 'name'=>'search_street', 'type'=>Request::get('search_street') ])			
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'locations', 'name'=>'search_street_number', 'type'=>Request::get('search_street_number') ])			
			        		</td>
			        		<td class="col_hidden" >
                   				@include('panel.search',['table'=>'locations', 'name'=>'search_postcode', 'type'=>Request::get('search_postcode') ])	
			        		</td>
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'locations', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td></td>
			        		<td></td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($locations as $location)
						<tbody>
							<tr class="name">
						        <td>{{ $location->location_name }}</td>
						        <td class="col_hidden">{{ $location->country }}</td>
						        <td class="col_hidden">{{ $location->city }}</td>
						        <td class="col_hidden">{{ $location->street }}</td>
						        <td class="col_hidden">{{ $location->street_number }}</td>
						        <td class="col_hidden">{{ $location->postcode }}</td>
						        <td class="col_hidden">{{ $location->user->name }}</td>
						        <td class="col_hidden">{{ $location->user->surname }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'LocationsController@show', 'route'=>$location->id])
                   				@include('panel.button.edit_button',['controller'=>'LocationsController@edit', 'route'=>$location->id])
                   				@include('panel.button.delete_button',['controller'=>'LocationsDeleter@edit', 'route'=>$location->id])
							</tr>
						</tbody>
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $locations->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
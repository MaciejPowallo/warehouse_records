@extends('master')
	@section('title')
		Wykaz dezaktywowanych kontrahentów
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Wykaz nieaktywnych kontrahentów
				<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>	
    	</div>
    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'ContractorsDeleter@index'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table id="tableSearch" class="table table-bordered col-xs-12">

					<thead>
						<tr>
			        		<th>Identyfikator</th>
			        		<th>Nazwa</th>
			        		<th class="col_hidden">Kraj</th>
			        		<th class="col_hidden">Miejscowość</th>
			        		<th class="col_hidden">Ulica</th>
			        		<th class="col_hidden">Nr budynku</th>
			        		<th class="col_hidden">Kod pocztowy</th>
			        		<th class="col_hidden">Telefon</th>
			        		<th class="col_hidden">E-mail</th>
			        		<th class="col_hidden">NIP</th>
			        		<th class="col_hidden">REGON</th>
			        		<th class="col_hidden" colspan="2">Imię i nazwisko autora</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_nametag', 'type'=>Request::get('search_nametag') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_name', 'type'=>Request::get('search_name') ])
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_country', 'type'=>Request::get('search_country') ])
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_city', 'type'=>Request::get('search_city') ])		
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_street', 'type'=>Request::get('search_street') ])			
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_street_number', 'type'=>Request::get('search_street_number') ])			
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_postcode', 'type'=>Request::get('search_postcode') ])	
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_telephone', 'type'=>Request::get('search_telephone') ])	
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_email', 'type'=>Request::get('search_email') ])	
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_nip', 'type'=>Request::get('search_nip') ])	
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'contractors/delete', 'name'=>'search_regon', 'type'=>Request::get('search_regon') ])	
			        		</td>
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'contractors/delete', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td></td>
						</tr>
					</thead>

					@foreach($contractors as $contractor)
						<tbody>
							<tr class="name">
						        <td>{{ $contractor->nametag }}</td>
						        <td>{{ $contractor->name_contractor }}</td>
						        <td class="col_hidden">{{ $contractor->country }}</td>
						        <td class="col_hidden">{{ $contractor->city }}</td>
						        <td class="col_hidden">{{ $contractor->street }}</td>
						        <td class="col_hidden">{{ $contractor->street_number }}</td>
						        <td class="col_hidden">{{ $contractor->postcode }}</td>
						        <td class="col_hidden">{{ $contractor->telephone }}</td>
						        <td class="col_hidden">{{ $contractor->email }}</td>
						        <td class="col_hidden">{{ $contractor->nip }}</td>
						        <td class="col_hidden">{{ $contractor->regon }}</td>
						        <td class="col_hidden">{{ $contractor->user->name }}</td>
						        <td class="col_hidden">{{ $contractor->user->surname }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'ContractorsDeleter@show', 'route'=>$contractor->id])
							</tr>
						</tbody>	
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $contractors->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
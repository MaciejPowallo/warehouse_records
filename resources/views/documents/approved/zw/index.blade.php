@extends('master')
	@section('title')
		Wykaz zwrotów na magazyn
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Zwroty na magazyn (ZW)			
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
                   	@include('panel.button.add_button',['controller'=>'Zw_documentsController@create', 'name'=>'ZW'])
                   	
				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'Zw_documentsApprover@index'])

				<!-- Niezatwierdzone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'Zw_documentsController@index', 'name' => 'Lista niezatwierdzonych'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table class="table table-bordered col-xs-12">
					<thead>
						<tr>
			        		<th>Nr dokumentu</th>			        		
			        		<th>Lokalizacja</th>
			        		<th colspan="2">Imię i nazwisko pracownika</th>
			        		<th class="col_hidden" colspan="2">Imię i nazwisko autora</th>
			        		<th>Data utworzenia</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'/documents/approved/zw', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'documents/approved/zw', 'name'=>'search_location_name', 'type'=>Request::get('search_location_name') ])
			        		</td>
							<!-- td -->
                   				@include('panel.searchemployeename',['table'=>'documents/approved/zw', 'type1'=>Request::get('search_name_empl'), 'type2'=>Request::get('search_surname_empl') ])	
							<!-- /td -->
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'documents/approved/zw', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td>
                   				@include('panel.search',['table'=>'documents/approved/zw', 'name'=>'search_zw_date', 'type'=>Request::get('search_zw_date') ])			
			        		</td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($zw_documents as $zw_document)
						<tbody>
							<tr class="name">
						        <td>{{ $zw_document->doc_numb }}</td>
						        <td>{{ $zw_document->location->location_name }}</td>
						        <td>{{ $zw_document->employee->name_empl }}</td>
						        <td>{{ $zw_document->employee->surname_empl }}</td>
						        <td class="col_hidden">{{ $zw_document->user->name }}</td>
						        <td class="col_hidden">{{ $zw_document->user->surname }}</td>
						        <td>{{ $zw_document->updated_at->format('Y-m-d') }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'Zw_documentsApprover@show', 'route'=>$zw_document->id])
							</tr>
						</tbody>
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $zw_documents->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
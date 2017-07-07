@extends('master')
	@section('title')
		Wykaz przyjęć magazynowych
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Przyjęcia magazynowe (PZ)				
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
                   	@include('panel.button.add_button',['controller'=>'Pz_documentsController@create', 'name'=>'PZ'])
                   	
				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'Pz_documentsApprover@index'])

				<!-- Niezatwierdzone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'Pz_documentsController@index', 'name' => 'Lista niezatwierdzonych'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table id="tableSearch" class="table table-bordered col-xs-12">

					<thead>
						<tr>
			        		<th>Nr dokumentu</th>
			        		<th>Nr kontrahenta</th>
			        		<th>Nazwa kontrahenta</th>
			        		<th colspan="2">Imię i nazwisko autora</th>
			        		<th>Data dostawy</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'/documents/approved/pz', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'documents/approved/pz', 'name'=>'search_nametag', 'type'=>Request::get('search_nametag') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'documents/approved/pz', 'name'=>'search_name_contractor', 'type'=>Request::get('search_name_contractor') ])		
			        		</td>
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'documents/approved/pz', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td>
                   				@include('panel.search',['table'=>'documents/approved/pz', 'name'=>'search_pz_date', 'type'=>Request::get('search_pz_date') ])			
			        		</td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($pz_documents as $pz_document)
						<tbody>
							<tr class="name">
						        <td>{{ $pz_document->doc_numb }}</td>
						        <td>{{ $pz_document->contractor->nametag }}</td>
						        <td>{{ $pz_document->contractor->name_contractor }}</td>
						        <td>{{ $pz_document->user->name }}</td>
						        <td>{{ $pz_document->user->surname }}</td>
						        <td>{{ $pz_document->pz_date }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'Pz_documentsApprover@show', 'route'=>$pz_document->id])
							</tr>
						</tbody>
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $pz_documents->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
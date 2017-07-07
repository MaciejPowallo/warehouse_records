@extends('master')
	@section('title')
		Wykaz likwidacji
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Likwidacje (LT)				
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
                   	@include('panel.button.add_button',['controller'=>'Lt_documentsController@create', 'name'=>'LT'])
                   	
				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'Lt_documentsApprover@index'])

				<!-- Niezatwierdzone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'Lt_documentsController@index', 'name' => 'Lista niezatwierdzonych'])
				</div>
			</div>  

			<div class="table-responsive">
				<table class="table table-bordered col-xs-12">

					<thead>
						<tr>
			        		<th>Nr dokumentu</th>
			        		<th>Przyczyna</th>
			        		<th class="col_hidden" colspan="2">Imię i nazwisko autora</th>
			        		<th>Data utworzenia</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'/documents/lt', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'/documents/lt', 'name'=>'search_cause', 'type'=>Request::get('search_cause') ])
			        		</td>
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'documents/lt', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td>
                   				@include('panel.search',['table'=>'documents/lt', 'name'=>'search_lt_date', 'type'=>Request::get('search_lt_date') ])			
			        		</td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($lt_documents as $lt_document)
						<tbody>
							<tr class="name">
						        <td>{{ $lt_document->doc_numb }}</td>
						        <td>{{ str_limit($lt_document->cause, $limit=25) }}</td>
						        <td class="col_hidden">{{ $lt_document->user->name }}</td>
						        <td class="col_hidden">{{ $lt_document->user->surname }}</td>
						        <td>{{ $lt_document->created_at->format('Y-m-d') }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'Lt_documentsApprover@show', 'route'=>$lt_document->id])

							</tr>
						</tbody>
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $lt_documents->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
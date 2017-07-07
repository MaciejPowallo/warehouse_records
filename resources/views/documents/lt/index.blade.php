@extends('master')
	@section('title')
		Wykaz niezatwierdzonych likwidacji
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2"><b class="red_text">Niezatwierdzone</b> likwidacje (LT)				
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>

			<!-- Widomośc z sesji -->
    		@if(Session::has('mes_lt_add'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_lt_add') }}</div>
    		@endif

    		@if(Session::has('mes_lt_delete'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_lt_delete') }}</div>
    		@endif
    	</div>

    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk dodania nowego wpisu -->
                   	@include('panel.button.add_button',['controller'=>'Lt_documentsController@create', 'name'=>'LT'])

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'Lt_documentsController@index'])

				<!-- Zatwierdzone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'Lt_documentsApprover@index', 'name' => 'Lista zatwierdzonych'])
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
                   				@include('panel.button.edit_button',['controller'=>'Lt_documentsController@show', 'route'=>$lt_document->id])
                   				@include('panel.delete',['controller'=>'Lt_documentsController@destroy', 'name' => $lt_document ,'route'=>$lt_document->id])

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
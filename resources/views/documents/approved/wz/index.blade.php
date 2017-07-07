@extends('master')
	@section('title')
		Wykaz wydań magazynowych
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Wydania magazynowe (WZ/RW)				
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
                   	@include('panel.button.add_button',['controller'=>'Wz_documentsController@create', 'name'=>'WZ/RW'])
                   	
				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'Wz_documentsApprover@index'])

				<!-- Niezatwierdzone -->
                   	@include('panel.button.nonapproved_button', ['controller'=>'Wz_documentsController@index', 'name' => 'Lista niezatwierdzonych'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table class="table table-bordered col-xs-12">

					<thead>
						<tr>
			        		<th>Typ dokumentu</th>
			        		<th>Nr dokumentu</th>			        		
			        		<th>Lokalizacja</th>
			        		<th colspan="2">Imię i nazwisko pracownika</th>
			        		<th class="col_hidden" colspan="2">Imię i nazwisko autora</th>
			        		<th>Data utworzenia</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.searchtype',['table'=>'documents/approved/wz', 'name'=>'search_expend', 'type'=>Request::get('search_expend') ])		
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'/documents/approved/wz', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb')])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'documents/approved/wz', 'name'=>'search_location_name', 'type'=>Request::get('search_location_name') ])
			        		</td>
							<!-- td -->
                   				@include('panel.searchemployeename',['table'=>'documents/approved/wz', 'type1'=>Request::get('search_name_empl'), 'type2'=>Request::get('search_surname_empl') ])	
							<!-- /td -->
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'documents/approved/wz', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->

			        		<td>
                   				@include('panel.search',['table'=>'documents/approved/wz', 'name'=>'search_wz_date', 'type'=>Request::get('search_wz_date') ])			
			        		</td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($wz_documents as $wz_document)
						<tbody>
							<tr class="name">
						        <td>@if($wz_document->expend == 1) RW @endif @if($wz_document->expend == 0) WZ @endif</td>
						        <td>{{ $wz_document->doc_numb }}</td>
						        <td>{{ $wz_document->location->location_name }}</td>
						        <td>{{ $wz_document->employee->name_empl }}</td>
						        <td>{{ $wz_document->employee->surname_empl }}</td>
						        <td class="col_hidden">{{ $wz_document->user->name }}</td>
						        <td class="col_hidden">{{ $wz_document->user->surname }}</td>
						        <td>{{ $wz_document->updated_at->format('Y-m-d') }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'Wz_documentsApprover@show', 'route'=>$wz_document->id])
							</tr>
						</tbody>
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $wz_documents->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
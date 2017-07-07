@extends('master')
	@section('title')
		Wykaz grup produktów
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Wykaz grup produktów
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>

			<!-- Widomośc z sesji -->
    		@if(Session::has('mes_grade_add'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_grade_add') }}</div>
    		@endif

    	</div>
    	<div class="panel-body"> 	
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk dodania nowego wpisu -->
                   	@include('panel.button.add_button',['controller'=>'GradesController@create', 'name'=>'grupę'])

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'GradesController@index'])
				</div>
			</div>   
			<div class="table-responsive">
				<table class="table table-bordered col-xs-12">
					<thead>
						<tr>
			        		<th>Nazwa</th>
			        		<th class="col_hidden">Opis</th>
			        		<th></th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'grades', 'name'=>'search_name', 'type'=>Request::get('search_name') ])
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'grades', 'name'=>'search_description', 'type'=>Request::get('search_description') ])
			        		</td>
			        		<td></td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($grades as $grade)
						<tbody>
							<tr>
						        <td> {{ $grade->name_grade }} </a></td>
						        <td class="col_hidden"> {{ $grade->description }} </td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'GradesController@show', 'route'=>$grade->id])
                   				@include('panel.button.edit_button',['controller'=>'GradesController@edit', 'route'=>$grade->id])
							</tr>
						</tbody>
					@endforeach			
				</table>
			</div>
    	</div>
    </div>
</div>
@endsection
@extends('master')
	@section('title')
		Wykaz rodzajów produktów
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Wykaz rodzajów produktów
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>

			<!-- Widomośc z sesji -->
    		@if(Session::has('mes_type_add'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_type_add') }}</div>
    		@endif

    	</div>

    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk dodania nowego wpisu -->
                   	@include('panel.button.add_button',['controller'=>'TypesController@create', 'name'=>'rodzaj'])

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'TypesController@index'])
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
                   				@include('panel.search',['table'=>'types', 'name'=>'search_name', 'type'=>Request::get('search_name') ])
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'types', 'name'=>'search_description', 'type'=>Request::get('search_description') ])
			        		</td>
			        		<td></td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($types as $type)
						<tbody>
							<tr class="name">
						        <td><a href="{{action('TypesController@show', $type->id)}}" data-toggle="tooltip" data-placement="top" title="Zobacz"> {{ $type->name_type }} </a></td>
						        <td class="col_hidden"> {{ $type->description }} </td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'TypesController@show', 'route'=>$type->id])
                   				@include('panel.button.edit_button',['controller'=>'TypesController@edit', 'route'=>$type->id])
							</tr>
						</tbody>
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-4 col-sm-offset-4">{{ $types->links() }}	</div>
			</div>
    	</div>
    </div>
</div>
@endsection
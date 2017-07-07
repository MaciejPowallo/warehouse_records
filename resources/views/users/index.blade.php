@extends('master')
	@section('title')
		Lista użytkowników
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Użytkownicy
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>

			<!-- Widomośc z sesji -->
    		@if(Session::has('mes_user_add'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_user_add') }}</div>
    		@endif
    		@if(Session::has('mes_user_delete'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_user_delete') }}</div>
    		@endif

    	</div>
    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk dodania nowego wpisu -->
                   	@include('panel.button.add_button',['controller'=>'UsersController@create', 'name'=>'użytkownika'])

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'UsersController@index'])

				</div>
			</div>  

			<div class="table-responsive">
				<table class="table table-bordered col-xs-12">
					<thead>
						<tr>
			        		<th colspan="2">Imię i nazwisko użytkownika</th>
			        		<th>E-mail</th>
			        		<th class="col_hidden">Telefon</th>
			        		<th>Funkcja</th>
			        		<th></th>
			        		<th></th>
			        		<th></th>
						</tr>
						<tr>
							<!-- td -->
                   				@include('panel.searchusernonhidden',['table'=>'users', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td>
                   				@include('panel.search',['table'=>'users', 'name'=>'search_email', 'controller'=>'UsersController@index', 'type'=>Request::get('search_email') ])
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'users', 'name'=>'search_telephone', 'controller'=>'UsersController@index', 'type'=>Request::get('search_telephone') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'users', 'name'=>'search_function', 'controller'=>'UsersController@index', 'type'=>Request::get('search_function') ])
			        		</td>
			        		<td></td>
			        		<td></td>
			        		<td></td>
						</tr>
					</thead>

					@foreach($users as $user)
						<tbody>
							<tr>
						        <td> {{ $user->name }}</td>
						        <td> {{ $user->surname }} </td>
						        <td> {{ $user->email }} </td>
						        <td class="col_hidden"> {{ $user->telephone }} </td>	
						        <td> {{ $user->function }} </td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'UsersController@show', 'route'=>$user->id])
                   				@include('panel.button.edit_button',['controller'=>'UsersController@edit', 'route'=>$user->id])
                   				@include('panel.button.delete_button',['controller'=>'UsersDeleter@edit', 'route'=>$user->id])
							</tr>
						</tbody>
					@endforeach	
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-4 col-sm-offset-4">{{ $users->links() }}	</div>
			</div>
    	</div>
    </div>
</div>
@endsection

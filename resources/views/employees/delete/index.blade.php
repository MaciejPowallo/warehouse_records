@extends('master')
	@section('title')
		Wykaz zwolnionych pracowników
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Wykaz zwolnionych pracowników 
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
                   	@include('panel.button.clearsearch_button', ['controller'=>'EmployeesDeleter@index'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table id="tableSearch" class="table table-bordered col-xs-12">
					<thead>
						<tr>
			        		<th>PESEL</th>
			        		<th colspan="2">Imię i nazwisko pracownika</th>
			        		<th class="col_hidden">E-mail</th>
			        		<th class="col_hidden">Telefon</th>
			        		<th class="col_hidden">Stanowisko</th>
			        		<th class="col_hidden" colspan="2">Imię i nazwisko autora</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'employees/delete', 'name'=>'search_pesel', 'type'=>Request::get('search_pesel') ])
			        		</td>
							<!-- td -->
                   				@include('panel.searchemployeename',['table'=>'employees', 'type1'=>Request::get('search_name_empl'), 'type2'=>Request::get('search_surname_empl') ])	
							<!-- /td -->
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'employees/delete', 'name'=>'search_email', 'type'=>Request::get('search_email') ])		
			        		</td>
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'employees/delete', 'name'=>'search_telephone', 'type'=>Request::get('search_telephone') ])			
			        		</td>			        		
			        		<td class="col_hidden">
                   				@include('panel.search',['table'=>'employees/delete', 'name'=>'search_function', 'type'=>Request::get('search_function') ])			
			        		</td>
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'employees/delete', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td></td>
						</tr>
					</thead>
					@foreach($employees as $employee)
						<tbody>
							<tr class="name">
						        <td>{{ $employee->pesel }}</td>
						        <td>{{ $employee->name_empl }}</td>
						        <td>{{ $employee->surname_empl }}</td>
						        <td class="col_hidden">{{ $employee->email }}</td>
						        <td class="col_hidden">{{ $employee->telephone }}</td>
						        <td class="col_hidden">{{ $employee->function }}</td>
						        <td class="col_hidden">{{ $employee->user->name }}</td>
						        <td class="col_hidden">{{ $employee->user->surname }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'EmployeesDeleter@show', 'route'=>$employee->id])
							</tr>
						</tbody>
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $employees->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
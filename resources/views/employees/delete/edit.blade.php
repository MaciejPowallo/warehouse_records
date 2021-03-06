@extends('master')
	@section('title')
		Dodawanie nowego kontrahenta
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">

			<!-- Widok błędów -->	
			@if(count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li> {{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			
			<!-- Formularz -->
			{!! Form::model($employee, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['EmployeesDeleter@update', $employee->id]]) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'EmployeesController@index'])

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('pesel', 'PESEL') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('pesel', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('function', 'Stanowisko') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('function', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('name_empl', 'Imię') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('name_empl', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('surname_empl', 'Nazwisko') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('surname_empl', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-2">
						{!! Form::label('disable', 'Aktywność') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('disable', TRUE ,['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-2">
						{!! Form::label('user_id', 'Id użytkownika') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('user_id', Auth::user()->id ,['class'=> 'form-control']) !!}
					</div>
				</div>

				<!-- Przyciski-->
				<div class="form-group form-show control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.confirm_button')	
                   		@include('panel.button.undo_button', ['controller'=>'EmployeesController@index'])
					</div>

				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
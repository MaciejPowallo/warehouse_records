@extends('master')
	@section('title')
		{{$employee->name_empl.' '.$employee->surname_empl}}
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">

				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12">
						<!-- Widomość z sesji -->
			    		@if(Session::has('mes_employee_update'))
			   				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_employee_update') }}</div>
			    		@endif
					</div>
				</div>
			
				<!-- Formularz -->
			{!! Form::open(['class'=>'form-horizontal marg_b100']) !!}

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('pesel', 'PESEL') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('pesel', $employee->pesel ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('function', 'Stanowisko') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('function', $employee->function ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('name_empl', 'Imię') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('name_empl', $employee->name_empl ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('surname_empl', 'Nazwisko') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('surname_empl', $employee->surname_empl ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('telephone', 'Telefon') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('telephone', $employee->telephone ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('email', 'E-mail') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('email', $employee->email ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('created_at', 'Data dodania') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('created_at', $employee->created_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('updated_at', 'Ostatnia aktualizacja') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('updated_at', $employee->updated_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('name', 'Autor') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('name', $employee->user->name.' '.$employee->user->surname,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>

				<!-- Przyciski -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.edit_button',['controller'=>'EmployeesController@edit', 'route'=>$employee->id])
                   		@include('panel.button.list_button',['controller'=>'EmployeesController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
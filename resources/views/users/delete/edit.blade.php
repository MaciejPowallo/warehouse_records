@extends('master')
	@section('title')
		Usuwanie {{$user->name.' '.$employee->surname}}
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
			{!! Form::model($user, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['UsersDeleter@update', $user->id]]) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'UsersController@index'])

		<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-6 col-sm-offset-3">
						{!! Form::text('name', null, ['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-6 col-sm-offset-3">
						{!! Form::text('surname', null, ['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>	
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-6 col-sm-offset-3">
						{!! Form::text('email', ' ', ['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-6 col-sm-offset-3">
						{!! Form::text('disable', true, ['class'=> 'form-control']) !!}
					</div>
				</div>				

			<!-- Przyciski -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-9">
						{!! Form::button('<i class="fa fa-user-times marg_r10" aria-hidden="true"></i>Potwierdź usunięcie', ['class' => 'btn btn-danger ', 'type' => 'submit']) !!}
					</div>
				</div>
			{!! Form::close() !!}
		</div>	
	</div>
</div>
@endsection

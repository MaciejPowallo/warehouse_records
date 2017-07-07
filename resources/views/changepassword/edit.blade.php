@extends('master')
	@section('title')
		Edycja użytkownika {{ Auth::user()->name }}
	@endsection
@section('content')
<div class="content-position row">
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
			{!! Form::model($user, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['ChangeUserPassword@update', $user->id]]) !!}

				<!-- Wyjście z widoku-->
				<div class="form-group form-show control-label ">
					<div class="col-sm-1 col-sm-offset-11">
						<a href="{{action('UsersController@edit', $user->id)}}" class="btn btn-danger"><i class="fa fa-times " aria-hidden="true"></i></a>
					</div>
				</div>

		<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('password', 'Hasło') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::password('password', ['class'=> 'form-control pass_form', 'aria-describedby' => 'passwordHelpBlock']) !!}
						<p id="passwordHelpBlock" class="form-text text-muted">Hasło musi się składać z 8-20 znaków</p>
					</div>
				</div>		
				
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-6 col-sm-offset-2">

						{!! Form::button('<i class="fa fa-floppy-o marg_r10" aria-hidden="true"></i>Zapisz', ['class' => 'btn btn-success ', 'type' => 'submit']) !!}
						{!! Form::button('<i class="fa fa-eraser marg_r10" aria-hidden="true"></i>Wyczyść', ['class' => 'btn btn-warning ', 'type' => 'reset']) !!}
						<a href="{{action('UsersController@index')}}" class="btn btn-danger"><i class="fa fa-list-ul marg_r10" aria-hidden="true"></i>Lista</a>

					</div>
				</div>
			{!! Form::close() !!}
		</div>	
	</div>
</div>
@endsection
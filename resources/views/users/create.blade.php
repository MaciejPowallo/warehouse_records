@extends('master')
	@section('title')
		Dodawanie nowego użytkownika
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
			{!! Form::open(['url'=>'users', 'class'=>'form-horizontal marg_b100']) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'UsersController@index'])

		<!-- Pola formularza -->

				{!! Form::hidden('remember_token',  csrf_token() , ['class'=> 'form-control']) !!}

				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('name', 'Imię') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::text('name', null, ['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('surname', 'Nazwisko') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::text('surname', null, ['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('function', 'Funkcja') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::select('function', ['Administrator'=>'Administrator', 'Magazynier'=>'Magazynier', 'Kierownik'=>'Kierownik', 'Księgowy'=>'Księgowy', ], 'Księgowy', ['class' => 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('email', 'E-mail') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::text('email', null, ['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('telephone', 'Telefon') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::text('telephone', null, ['class'=> 'form-control']) !!}
					</div>
				</div>					
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('password', 'Hasło') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::password('password', ['class'=> 'form-control', 'aria-describedby' => 'passwordHelpBlock']) !!}
						<p id="passwordHelpBlock" class="form-text text-muted">Hasło musi się składać z 8-20 znaków</p>
					</div>
				</div>	
			<!-- Przyciski-->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-6 col-sm-offset-2">
                   		@include('panel.button.submit_button')
                   		@include('panel.button.reset_button')
                   		@include('panel.button.list_button',['controller'=>'UsersController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
@extends('master')
	@section('title')
		Tryb edycji {{$user->name.' '.$user->surname}}
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
			{!! Form::model($user, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['UsersController@update', $user->id]]) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'UsersController@index'])

		<!-- Pola formularza -->
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
						{!! Form::select('function', ['Administrator'=>'Administrator', 'Magazynier'=>'Magazynier', 'Kierownik'=>'Kierownik', 'Księgowy'=>'Księgowy', ], null, ['class' => 'form-control']) !!}
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
						{!! Form::label('auth', 'Uprawnienia') !!}
					</div>
					<div class="col-sm-9">
						<div class="table-responsive">
							<table class="table border_hidden">
								 <tr>
								 	<td>Administracja</td>
								 	<td>Magazyn</td>
								 	<td>Kierownictwo</td>
								 	<td>Księgowość</td>
								 </tr>
								 <tr>
								 	<td><input type="checkbox" {{ $user->hasRole('Administrator') ? 'checked' : '' }} name="Administrator" ></td>
								 	<td><input type="checkbox" {{ $user->hasRole('Magazynier') ? 'checked' : '' }} name="Magazynier"></td>
								 	<td><input type="checkbox" {{ $user->hasRole('Kierownik') ? 'checked' : '' }} name="Kierownik"></td>
								 	<td><input type="checkbox" {{ $user->hasRole('Księgowy') ? 'checked' : '' }} name="Księgowy"></td>
								 </tr>
							</table>
						</div>
					</div>
				</div>

			<!-- Przyciski -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-8 col-sm-offset-2">
                   		@include('panel.button.submit_button')
                   		@include('panel.button.undochanges_button')
                   		@include('panel.button.list_button',['controller'=>'UsersController@index'])
						<a href="{{action('ChangeUserPassword@edit', $user->id)}}" class="btn btn-warning"><i class="fa fa-exchange marg_r10" aria-hidden="true"></i>Zmiana hasła</a>
					</div>
				</div>
			{!! Form::close() !!}
		</div>	
	</div>
</div>
@endsection
@extends('master')
	@section('title')
		{{$user->name.' '.$user->surname}}
	@endsection

@section('content')
	<div class="content-position">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel-body">
					{!! Form::open(['class'=>'form-horizontal marg_b100']) !!}
						<div class="form-group form-bottom-marg control-label">
							<div class="col-sm-12">
								<!-- Widomość z sesji -->
					    		@if(Session::has('mes_user_update'))
					   				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_user_update') }}</div>
					    		@endif
							</div>
						</div>

				<!-- Pola formularza -->
						<div class="form-group form-bottom-marg control-label">
							<div class="col-sm-3">
								{!! Form::label('name', 'Imię') !!}
							</div>
							<div class="col-sm-9">
								{!! Form::text('name', $user->name ,['class'=> 'form-control', 'disabled']) !!}
							</div>
						</div>
						<div class="form-group form-bottom-marg control-label">
							<div class="col-sm-3">
								{!! Form::label('surname', 'Nazwisko') !!}
							</div>
							<div class="col-sm-9">
								{!! Form::text('surname', $user->surname ,['class'=> 'form-control', 'disabled']) !!}
							</div>
						</div>
						<div class="form-group form-bottom-marg control-label">
							<div class="col-sm-3">
								{!! Form::label('function', 'Funkcja') !!}
							</div>
							<div class="col-sm-9">
								{!! Form::text('function', $user->function ,['class'=> 'form-control', 'disabled']) !!}
							</div>
						</div>
						<div class="form-group form-bottom-marg control-label">
							<div class="col-sm-3">
								{!! Form::label('email', 'E-mail') !!}
							</div>
							<div class="col-sm-9">
								{!! Form::text('email', $user->email ,['class'=> 'form-control', 'disabled']) !!}
							</div>
						</div>
						<div class="form-group form-bottom-marg control-label">
							<div class="col-sm-3">
								{!! Form::label('telephone', 'Telefon') !!}
							</div>
							<div class="col-sm-9">
								{!! Form::text('telephone', $user->telephone ,['class'=> 'form-control', 'disabled']) !!}
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
										 	<td><input type="checkbox"  disabled {{ $user->hasRole('Administrator') ? 'checked' : '' }} name="Administrator" ></td>
										 	<td><input type="checkbox" disabled {{ $user->hasRole('Magazynier') ? 'checked' : '' }} name="Magazynier"></td>
										 	<td><input type="checkbox" disabled {{ $user->hasRole('Kierownik') ? 'checked' : '' }} name="Kierownik"></td>
										 	<td><input type="checkbox" disabled {{ $user->hasRole('Księgowy') ? 'checked' : '' }} name="Księgowy"></td>
										 </tr>
									</table>
								</div>
							</div>
						</div>
						<div class="form-group form-bottom-marg control-label">
							<div class="col-sm-3">
								{!! Form::label('created_at', 'Dodano') !!}
							</div>
							<div class="col-sm-9">
								{!! Form::text('created_at', $user->created_at ,['class'=> 'form-control', 'disabled']) !!}
							</div>
						</div>
						<div class="form-group form-bottom-marg control-label">
							<div class="col-sm-3">
								{!! Form::label('updated_at', 'Ostatnia aktualizacja') !!}
							</div>
							<div class="col-sm-9">
								{!! Form::text('updated_at', $user->updated_at ,['class'=> 'form-control', 'disabled']) !!}
							</div>
						</div>
						<div class="form-group form-bottom-marg control-label">
							<div class="col-sm-6 col-sm-offset-2">
								<a href="{{action('UsersController@edit', $user->id)}}" class="btn btn-success" ><i class="fa fa-pencil-square-o marg_10" aria-hidden="true"></i>Edytuj</a>
								<a href="{{action('UsersController@index')}}" class="btn btn-danger"><i class="fa fa-list-ul marg_10" aria-hidden="true"></i>Lista</a>
							</div>					
						</div>
					{!! Form::close() !!}
			</div>	
		</div>
	</div>	
@endsection
@extends('master')
	@section('title')
		Usuwanie kontrahenta
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
			{!! Form::model($contractor, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['ContractorsDeleter@update', $contractor->id]]) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'ContractorsController@index'])

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('nametag', 'Identyfikator') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('nametag', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('name_contractor', 'Nazwa kontrahenta') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('name_contractor', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('nip', 'NIP') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('nip', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('regon', 'REGON') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('regon', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-2">
						{!! Form::label('disable', 'Nieaktywny') !!}
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
                   		@include('panel.button.undo_button', ['controller'=>'ContractorsController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
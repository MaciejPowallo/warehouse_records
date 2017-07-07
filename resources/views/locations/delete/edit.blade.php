@extends('master')
	@section('title')
		Tryb edycji
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
			{!! Form::model($location, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['LocationsDeleter@update', $location->id]]) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'LocationsController@index'])

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('location_name', 'Nazwa lokalizacji') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('location_name', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('country', 'Adres') !!}
					</div>
					<div class="col-sm-2">
						{!! Form::text('country', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::text('postcode', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::text('city', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::text('street', null ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::text('street_number', null ,['class'=> 'form-control', 'disabled']) !!}
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
				
				<!-- Przyciski -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.confirm_button')	
                   		@include('panel.button.undo_button', ['controller'=>'LocationsController@index'])
					</div>
				</div>	
			{!! Form::close() !!}
		</div>	
	</div>
</div>

@stop
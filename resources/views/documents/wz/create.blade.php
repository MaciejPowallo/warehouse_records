@extends('master')
	@section('title')
		Dodawanie dokumentu wydania WZ
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
			<div class="row">
				<div class="col-xs-12 text-center">
				 <strong><h3>Nowe wydanie z magazynu (WZ/RW)</i></h3></strong>
				</div>
			</div>
				<!-- Formularz -->
			{!! Form::open(['url'=>'documents/wz', 'class'=>'form-horizontal marg_b100']) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'HomeController@index'])
			<div></div>

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('employee', 'Wybierz pracownika') !!}
					</div>
					<div class="col-sm-10 marg_b10">
						{!! Form::select('employee', $employee, null ,['class'=> 'form-control', 'placeholder' => ' ', 'required']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('location', 'Wybierz lokalizację') !!}
					</div>
					<div class="col-sm-10 marg_b10">
						{!! Form::select('location', $location, null ,['class'=> 'form-control', 'placeholder' => ' ', 'required']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('expend', 'Wybierz typ dokumentu') !!}
					</div>
					<div class="col-sm-10 marg_b10">
						{!! Form::select('expend', ['1'=>'Wydanie do zużycia (RW)', '0'=>'Wydanie zewnętrzne (WZ)'], null ,['class'=> 'form-control', 'placeholder' => ' ', 'required']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('description', 'Uwagi') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::textarea('description', null ,['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-2">
						{!! Form::label('approved', 'Aktywność') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('approved', '0' ,['class'=> 'form-control']) !!}
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
                   		@include('panel.button.submit_button')
                   		@include('panel.button.reset_button')
                   		@include('panel.button.list_button',['controller'=>'Wz_documentsController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
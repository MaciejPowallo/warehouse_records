@extends('master')
	@section('title')
		Dodawanie dokumentu przyjęcia PZ
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
				 <strong><h3>Nowe przyjęcie magazynowe (PZ)</i></h3></strong>
				</div>
			</div>
				<!-- Formularz -->
			{!! Form::open(['url'=>'documents/pz', 'class'=>'form-horizontal marg_b100']) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'HomeController@index'])
			<div></div>

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('nametag', 'Wybierz kontrahenta') !!}
					</div>
					<div class="col-sm-10 marg_b10">
						{!! Form::select('nametag', $nametag, null ,['class'=> 'form-control', 'placeholder' => ' ', 'required']) !!}
					</div>

				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('pz_date', 'Data dostawy') !!}
					</div>
					<div class="col-sm-10 marg_b10">
						{!! Form::date('pz_date', null ,['class'=> 'form-control', 'max' => date("Y-m-d"), 'placeholder' => "RRRR-MM-DD" ])!!}
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
                   		@include('panel.button.list_button',['controller'=>'Pz_documentsController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
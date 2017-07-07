@extends('master')
	@section('title')
		Dodawanie grupy
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
			{!! Form::open(['url'=>'grades', 'class'=>'form-horizontal marg_b100']) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'GradesController@index'])

				<!-- Pola formularza -->
				<div class="form-group form-show control-label">
					<div class="col-sm-2">
						{!! Form::label('name_grade', 'Nazwa') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('name_grade', null ,['class' => 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-show control-label">
					<div class="col-sm-2">
						{!! Form::label('description', 'Opis') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::textarea('description', null ,['class' => 'form-control', 'rows'=> '3']) !!}
					</div>
				</div>

				<!-- Przyciski-->
				<div class="form-group form-show control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.submit_button')
                   		@include('panel.button.reset_button')
                   		@include('panel.button.list_button',['controller'=>'GradesController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
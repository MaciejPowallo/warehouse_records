@extends('master')
	@section('title')
		Dodawanie nowego rodzaju
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
			{!! Form::open(['url'=>'types', 'class'=>'form-horizontal marg_b100']) !!}

				<!-- Wyjście z widoku-->
				<div class="form-group form-show control-label">
					<div class="col-sm-1 col-sm-offset-11">
						<a href="{{action('TypesController@index')}}" class="btn btn-danger"><i class="fa fa-times " aria-hidden="true"></i></a>
					</div>
				</div>

				<!-- Pola formularza -->
				<div class="form-group form-show control-label">
					<div class="col-sm-3">
						{!! Form::label('name_type', 'Nazwa') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::text('name_type', null ,['class' => 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-show control-label">
					<div class="col-sm-3">
						{!! Form::label('description', 'Opis') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::textarea('description', null ,['class' => 'form-control']) !!}
					</div>
				</div>

				<!-- Przyciski-->
				<div class="form-group form-show control-label">
					<div class="col-sm-6 col-sm-offset-3">
                   		@include('panel.button.submit_button')
                   		@include('panel.button.reset_button')
                   		@include('panel.button.list_button',['controller'=>'TypesController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
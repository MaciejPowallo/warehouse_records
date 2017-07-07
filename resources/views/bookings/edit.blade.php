@extends('master')
	@section('title')
		Dodaj nowy produkt do dokumentu
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">
			<!-- Widomośc z sesji -->
			<!-- Formularz -->
			{!! Form::model($booking, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['BookingsController@update', $booking->id]]) !!}

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('product_name', 'Wybierz produkt') !!}
					</div>
					<div class="col-sm-10 marg_b10">
						{!! Form::select('product_name[]', $product_name, null ,['class'=> 'form-control', 'placeholder' => ' ', 'required']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('quantity', 'Podaj ilość') !!}
					</div>
					<div class="col-sm-10" >
						{!! Form::number('quantity', null ,['class'=> 'form-control', 'step' => 0.001]) !!}
					</div>
				</div>
				<div class="form-group control-label form-top-marg form-bottom-marg">
					<div class="col-sm-10 col-sm-offset-2">
						<div class="alert alert-info text-left"><i class="fa fa-exclamation-triangle marg_r10 red_text" aria-hidden="true"></i>Produkty, których nie ma na liście można dopisać wraz z ilością poniżej!!!</div>
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('description', 'Uwagi') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::textarea('description', null ,['class'=> 'form-control', 'placeholder' => 'np. 1. Produkt 1 - 10szt.']) !!}
					</div>
				</div>

				<!-- Przyciski-->
				<div class="form-group form-show control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.submit_button')
                   		@include('panel.button.list_button',['controller'=>'BookingsController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
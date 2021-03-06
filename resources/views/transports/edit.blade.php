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
			{!! Form::model($transport, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['Return_transportsController@update', $transport->id]]) !!}

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
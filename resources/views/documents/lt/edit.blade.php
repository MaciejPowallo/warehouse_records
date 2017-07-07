@extends('master')
	@section('title')
		Dodaj nowy produkt do dokumentu
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">
    		@if(Session::has('mes_quantity_too_much_lt'))
				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_quantity_too_much_lt') }}</div>
    		@endif
			<!-- Formularz -->
			{!! Form::model($lt_document, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['Lt_documentsController@update', $lt_document->id]]) !!}

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
					<div class="col-sm-10">
						{!! Form::number('quantity', null ,['class'=> 'form-control', 'step' => 1 , 'autocomplete' => 'off']) !!}
					</div>
				</div>


				<!-- Przyciski-->
				<div class="form-group form-show control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.submit_button')
                   		@include('panel.button.list_button',['controller'=>'Lt_documentsController@index'])
	                   	@include('panel.button.add_new_product_button',['controller'=>'ProductsController@create'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
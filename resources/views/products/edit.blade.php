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
			{!! Form::model($product, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['ProductsController@update', $product->id]]) !!}

				<!-- Wyjście z widoku-->
                @include('panel.button.exit_button',['controller'=>'ProductsController@index'])


				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('type_id', 'Rodzaj produktu') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::select('type_id', $type_id, null ,['class'=> 'form-control', 'placeholder' => ' ', 'required']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('grade_id', 'Grupa produktu') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::select('grade_id', $grade_id, null ,['class'=> 'form-control', 'placeholder' => ' ', 'required']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('catalog_nr', 'Nr katalogowy') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('catalog_nr', null ,['class'=> 'form-control']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('product_name', 'Nazwa produktu') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('product_name', null ,['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('price', 'Cena') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('price', null ,['class'=> 'form-control', 'autocomplete' => 'off', 'id'=> 'element']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('unit', 'Jednostka') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('unit', null ,['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('description', 'Opis') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::textarea('description', null ,['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-2">
						{!! Form::label('disable', 'Aktywność') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('disable', '0' ,['class'=> 'form-control']) !!}
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
                   		@include('panel.button.undochanges_button')
                   		@include('panel.button.list_button',['controller'=>'ProductsController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
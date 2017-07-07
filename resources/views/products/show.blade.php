@extends('master')
	@section('title')
		{{$product->product_name}}
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">

				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12">
						<!-- Widomość z sesji -->
			    		@if(Session::has('mes_product_update'))
			   				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_product_update') }}</div>
			    		@endif
					</div>
				</div>

			<!-- Formularz -->
			{!! Form::open(['class'=>'form-horizontal marg_b100']) !!}
			
				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('name_type', 'Rodzaj produktu') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('name_type', $product->type->name_type ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('name_grade', 'Grupa produktu') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('name_grade', $product->grade->name_grade ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('catalog_nr', 'Nr katalogowy') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('catalog_nr', $product->catalog_nr ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('product_name', 'Nazwa produktu') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('product_name', $product->product_name ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('price', 'Cena') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('price', $product->price ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('unit', 'Jednostka') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('unit', $product->unit ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('created_at', 'Data dodania') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('created_at', $product->created_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('updated_at', 'Ostatnia aktualizacja') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('updated_at', $product->updated_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('name', 'Autor') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('name', $product->user->name.' '.$product->user->surname,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('description', 'Opis') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::textarea('description', $product->description ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>

				<!-- Przyciski -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.edit_button',['controller'=>'ProductsController@edit', 'route'=>$product->id])
                   		@include('panel.button.list_button',['controller'=>'ProductsController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>	
	</div>
</div>	
@endsection
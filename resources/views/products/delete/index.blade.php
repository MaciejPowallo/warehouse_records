@extends('master')
	@section('title')
		Wykaz usuniętych produktów
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Wykaz produktów				
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>
    	</div>

    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'ProductsDeleter@index'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table id="tableSearch" class="table table-bordered col-xs-12">

					<thead>
						<tr>
			        		<th>Nr katalogowy</th>
			        		<th>Nazwa</th>
			        		<th>Rodzaj</th>
			        		<th>Grupa</th>
			        		<th>Jednostka</th>
			        		<th class="col_hidden">Wartość</th>
			        		<th class="col_hidden" colspan="2">Imię i nazwisko autora</th>
			        		<th></th>
						</tr>
						<tr>
			        		<td>
                   				@include('panel.search',['table'=>'products/delete', 'name'=>'search_catalog_nr', 'type'=>Request::get('search_catalog_nr') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'products/delete', 'name'=>'search_product_name', 'type'=>Request::get('search_product_name') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'products/delete', 'name'=>'search_name_type', 'type'=>Request::get('search_name_type') ])		
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'products/delete', 'name'=>'search_name_grade', 'type'=>Request::get('search_name_grade') ])			
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'products/delete', 'name'=>'search_unit', 'type'=>Request::get('search_unit') ])			
			        		</td>
							<!-- td -->
                   				@include('panel.searchprice',['table'=>'products/delete', 'type1'=>Request::get('search_price_down'), 'type2'=>Request::get('search_price_up') ])	
							<!-- /td -->
							<!-- td -->
                   				@include('panel.searchuser',['table'=>'products/delete', 'type1'=>Request::get('search_user_name'), 'type2'=>Request::get('search_user_surname') ])	
							<!-- /td -->
			        		<td></td>
						</tr>
					</thead>

					@foreach($products as $product)
						<tbody>
							<tr class="name">
						        <td>{{ $product->catalog_nr }}</td>
						        <td>{{ $product->product_name }}</td>
						        <td>{{ $product->type->name_type }}</td>
						        <td>{{ $product->grade->name_grade }}</td>
						        <td>{{ $product->unit }}</td>
						        <td class="col_hidden">{{ $product->price }}</td>
						        <td class="col_hidden">{{ $product->user->name }}</td>
						        <td class="col_hidden">{{ $product->user->surname }}</td>

								<!-- Przyciski -->
                   				@include('panel.button.preview_button',['controller'=>'ProductsDeleter@show', 'route'=>$product->id])	
							</tr>
						</tbody>
					@endforeach			
				</table>
				<!-- Paginacja strony -->
				<div class="col-sm-12 text-center">{{ $products->links() }}</div>
			</div>
    	</div>
    </div>
</div>
@endsection
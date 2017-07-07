@extends('master')
	@section('title')
		Stany magazynowe
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Stany magazynowe
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>
    	</div>

    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
				<!-- Przycisk wydruku -->
	                @include('panel.button.print_button')

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'WarehouseQuantity@index'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table id="tableSearch" class="table table-bordered col-xs-12">

					<thead>
						<tr>
							<th>Lp</th>
			        		<th>Nr katalogowy</th>
			        		<th>Rodzaj</th>
			        		<th>Grupa</th>
			        		<th>Nazwa</th>
			        		<th>Ilość</th>
			        		<th>Jednostka</th>
			        		<th>Wartość</th>
						</tr>
						<tr>
							<td></td>
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/warehouse', 'name'=>'search_catalog_nr', 'type'=>Request::get('search_catalog_nr') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/warehouse', 'name'=>'search_name_type', 'type'=>Request::get('search_name_type') ])		
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/warehouse', 'name'=>'search_name_grade', 'type'=>Request::get('search_name_grade') ])			
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/warehouse', 'name'=>'search_product_name', 'type'=>Request::get('search_product_name') ])
			        		</td>
							<!-- td -->
                   				@include('panel.searchquantity',['table'=>'warehouserecords/warehouse', 'type1'=>Request::get('search_quantity_down'), 'type2'=>Request::get('search_quantity_up') ])	
							<!-- /td -->
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/warehouse', 'name'=>'search_unit', 'type'=>Request::get('search_unit') ])			
			        		</td>
							<!-- td -->
                   				@include('panel.searchprice',['table'=>'warehouserecords/warehouse', 'type1'=>Request::get('search_price_down'), 'type2'=>Request::get('search_price_up') ])	
							<!-- /td -->
						</tr>
					</thead>
					<?php $a = 1;?>
					@foreach($products as $product)
						<tbody>
							<tr class="name">
								<td style="width:5%"><?php echo $a++;  ?></td>
						        <td>{{ $product->catalog_nr }}</td>
						        <td>{{ $product->type->name_type }}</td>
						        <td>{{ $product->grade->name_grade }}</td>
						        <td>{{ $product->product_name }}</td>
						        <td>{{ $product->quantity }}</td>
						        <td>{{ $product->unit }}</td>
						        <td>{{ $product->price.' PLN'}}</td>
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
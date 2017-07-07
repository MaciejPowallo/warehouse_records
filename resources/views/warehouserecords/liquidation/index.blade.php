@extends('master')
	@section('title')
		Wykaz zlikwidowanych
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Wykaz zlikwidowanych
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
                   	@include('panel.button.clearsearch_button', ['controller'=>'LiquidationQuantity@index'])
				</div>
			</div>  	
			<div class="table-responsive">
				<table id="tableSearch" class="table table-bordered col-xs-12">

					<thead>
						<tr>
							<th>Lp</th>
							<th>Nr dokumentu</th>
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
                   				@include('panel.search',['table'=>'warehouserecords/liquidation', 'name'=>'search_doc_numb', 'type'=>Request::get('search_doc_numb') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/liquidation', 'name'=>'search_catalog_nr', 'type'=>Request::get('search_catalog_nr') ])
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/liquidation', 'name'=>'search_name_type', 'type'=>Request::get('search_name_type') ])		
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/liquidation', 'name'=>'search_name_grade', 'type'=>Request::get('search_name_grade') ])			
			        		</td>
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/liquidation', 'name'=>'search_product_name', 'type'=>Request::get('search_product_name') ])
			        		</td>
							<!-- td -->
                   				@include('panel.searchquantity',['table'=>'warehouserecords/liquidation', 'type1'=>Request::get('search_quantity_down'), 'type2'=>Request::get('search_quantity_up') ])	
							<!-- /td -->
			        		<td>
                   				@include('panel.search',['table'=>'warehouserecords/liquidation', 'name'=>'search_unit', 'type'=>Request::get('search_unit') ])			
			        		</td>
							<!-- td -->
                   				@include('panel.searchprice',['table'=>'warehouserecords/liquidation', 'type1'=>Request::get('search_price_down'), 'type2'=>Request::get('search_price_up') ])	
							<!-- /td -->
						</tr>
					</thead>
					<?php $a = 1;?>
					@foreach($products as $product)
						<tbody>
							<tr class="name">
								<td style="width:5%"><?php echo $a++;  ?></td>
							    <td>{{ $product->doc_numb }}</td>
						        <td>{{ $product->products->catalog_nr }}</td>
						        <td>{{ $product->products->type->name_type }}</td>
						        <td>{{ $product->products->grade->name_grade }}</td>
						        <td>{{ $product->products->product_name }}</td>
						        <td>{{ $product->quantity }}</td>
						        <td>{{ $product->products->unit }}</td>
						        <td>{{ $product->products->price.' PLN'}}</td>
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
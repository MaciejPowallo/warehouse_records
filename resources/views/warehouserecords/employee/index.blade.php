@extends('master')
	@section('title')
		Stany pracowników
	@endsection

@section('content')

<div class="content-position">
	<div class="panel panel-group panel-default">
    	<div class="panel-heading">
    		<p class="size-2">Stany pracowników
    			<h5> 
					@if($counter == 0) <b class="red_text">Nie znaleziono rekordów</b> @endif
					@if($counter > 0) <b>Znalezione rokordy: {{$counter}}</b> @endif
				</h5>
			</p>
    	</div>

    	<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
				<!-- Przycisk wydruku -->
	                @include('panel.button.print_button')

				<!-- Przycisk wyczyszczenia filtrów -->
                   	@include('panel.button.clearsearch_button', ['controller'=>'EmployeeQuantity@index'])
				</div>
				<div class="col-sm-8">

					@include('panel.searchemployee',['table'=>'warehouserecords/employee', 'name'=>'employee', 'type1'=>Request::get('employees'), 'type2'=>Request::get('search_catalog_nr'), 'type3'=>Request::get('search_product_name') ])
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
						</tr>
					</thead>

					<?php $a = 1; $suma =0; $b = 0 ?>
					@foreach($wzs as $wz)
						<tbody>
							
									<?php $tablica = explode("/", $wz->doc_numb); ?>

							@if(($tablica[0] == 'WZ') || ($tablica[0] == 'RW') )
								<tr class="name">
									<td class="c2" style="width:5%"><?php echo $a++;  ?></td>
							        <td class="c2">{{ $wz->doc_numb }}</td>
							        <td class="c2">{{ $wz->products->catalog_nr }}</td>
							        <td class="c2">{{ $wz->products->type->name_type }}</td>
							        <td class="c2">{{ $wz->products->grade->name_grade }}</td>
							        <td class="c2">{{ $wz->products->product_name }}</td>
							        <td class="c2">{{ $b = $wz->quantity }}</td>
							        <td class="c2">{{ $wz->products->unit }}</td>
								</tr>

							@else
								<tr class="name">
									<td class="c1" style="width:5%"><?php echo $a++;  ?></td>
							        <td class="c1">{{ $wz->doc_numb }}</td>
							        <td class="c1">{{ $wz->products->catalog_nr }}</td>
							        <td class="c1">{{ $wz->products->type->name_type }}</td>
							        <td class="c1">{{ $wz->products->grade->name_grade }}</td>
							        <td class="c1">{{ $wz->products->product_name }}</td>
							        <td class="c1">{{ $b = '-'.$wz->quantity }}</td>
							        <td class="c1">{{ $wz->products->unit }}</td>
								</tr>
							@endif
									<?php $suma += $b; ?>
						</tbody>
					@endforeach		
								<tr class="name">
								<td colspan="6" text-align="right"><strong>Ilość na stanie:</strong></td>
								<td> 
									<strong><?php echo $suma; ?> </strong>
								</td>	
								<td></td>							
								</tr>
				</table>
				<!-- Paginacja strony -->

			</div>
    	</div>
    </div>

</div>
@endsection
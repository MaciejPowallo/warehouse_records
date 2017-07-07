@extends('master')
	@section('title')
		{{$wz_document->doc_numb}}
	@endsection

@section('content')


<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">

			<div class="row">
				<div class="col-sm-6 col-xs-8 ">
				<!-- Dane firmy-->
				@include('panel.documents.name')	
				</div>
				<div class="col-sm-6 col-xs-4 text-right">
					<div><strong>Data utworzenia:</strong></div>
				{{ $wz_document->updated_at->format('d-m-Y') }}
				</div>
			</div>

			<div class="row">
				<div class="col-sm-11 text-center">
				@if($wz_document->expend == 0)
					<strong><h3>(WZ) Wydanie magazynowe:	{{ $wz_document->doc_numb }}</h3></strong>
				@endif
				@if($wz_document->expend == 1)
					<strong><h3>(RW) Rozchód wewnętrzny:	{{ $wz_document->doc_numb }}</h3></strong>
				@endif
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6  col-xs-8 text-left">
					<div><strong>Odbiorca:</strong></div> 
				 	<div>{{ $wz_document->employee->name_empl}} {{ $wz_document->employee->surname_empl}}</div>
				 	<div><i class="fa fa-phone-square" aria-hidden="true"> </i> {{ $wz_document->employee->telephone}}</div>
				 	<div><i class="fa fa-envelope" aria-hidden="true"> </i> {{ $wz_document->employee->email}}</div>
					<br/>
					<div><strong>Lokalizacja:</strong></div> 
				 	<div>{{ $wz_document->location->postcode}} {{ $wz_document->location->city}}</div>
				 	<div>ul. {{ $wz_document->location->street}} {{ $wz_document->location->street_number}}</div>
				 	<div>{{ $wz_document->location->country}}</div>
				</div>
				<div class="col-xs-4 col-sm-5 col-sm-offset-1 text-right">	
					<div class="col-xs-12 marg_b10" >
	                   	@include('panel.button.print_button')
					</div>
					<div class="col-xs-12 marg_b10" >
	                   	@include('panel.button.list_button',['controller'=>'Wz_documentsApprover@index'])
					</div>
				</div>
			</div>


			<div class="row marg_t50">
				<table class="table table-bordered col-xs-12">
					<thead>
						<tr>				        		
							<th>Lp</th>
			        		<th>Index</th>
			        		<th>Nazwa</th>
			        		<th>Ilość</th>
			        		<th>Jednostka</th>
			        		<th>Cena</th>
			        		<th>Wartość</th>
						</tr>
					</thead>

					<?php $a = 1; $suma= 0; $b=0; $c=0;?>
					@foreach ($wz_document->products as $product) 
						<tbody>
							<tr class="name">
								<td style="width:5%"><?php echo $a++;  ?></td>
						        <td style="width:30%">{{ $product->catalog_nr }}</td>
						        <td style="width:15%">{{ $product->product_name }}</td>
						        <td style="width:10%">{{ $product->pivot->quantity }}</td>
						        <td style="width:10%">{{ $product->unit }}</td>
						        <td style="width:15%">{{ $product->price }} PLN</td>
						        <td style="width:15%">{{ $b = round($product->price * $product->pivot->quantity, 2) }} PLN</td>
						        <?php $suma += $b;?>
							</tr>
						</tbody>
					@endforeach
				</table>
				<div class="col-xs-12 text-right"><strong>Suma: <?php echo $suma;  ?> PLN</strong></div>
			</div>

			<!-- Uwagi-->
			<div class="row marg_t50">
				<div class="table-bordered col-sm-12 col-xs-12 text-left signature">
					<strong> Uwagi: </strong>
					<div>{{ $wz_document->description }}</div>
				</div>
			</div>

			<!-- Podpis pod dokumentem -->
			<div class="row marg_t50 marg_b100">
				<div class="table-bordered col-sm-3 col-xs-5 text-center signature">
					<div>{{ $wz_document->user->name }} {{ $wz_document->user->surname }}</div>
					<div><strong> Wystawił: </strong></div>
				</div>

				<div class="table-bordered col-sm-offset-6 col-sm-3 col-xs-offset-2 col-xs-5 text-center signature">
					<div>{{ $wz_document->employee->name_empl}} {{ $wz_document->employee->surname_empl }}</div>
					<div><strong> Odebrał: </strong></div>
				</div>
			</div>
		</div>	
	</div>
</div>	
@endsection
@extends('master')
	@section('title')
		{{$pz_document->doc_numb}}
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
				{{ $pz_document->updated_at->format('d-m-Y') }}
				</div>
			</div>

			<div class="row">
				<div class="col-sm-11 text-center">
				 <strong><h3>(PZ) Przyjęcie magazynowe:	{{ $pz_document->doc_numb }}</h3></strong>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6  col-xs-8 text-left">
					<div><strong>Kontrahent:</strong></div> 
				 	<div>{{ $pz_document->contractor->name_contractor}}</div>
				 	<div>ul. {{ $pz_document->contractor->street}} {{ $pz_document->contractor->street_number}}</div>
				 	<div>{{ $pz_document->contractor->postcode}} {{ $pz_document->contractor->city}}</div>
				 	<div>NIP: {{ $pz_document->contractor->nip}}</div>
				 	<div>REGON: {{ $pz_document->contractor->regon}}</div>
				</div>
				<div class="col-xs-4 col-sm-5 col-sm-offset-1 text-right">	
					<div class="col-xs-12 marg_b10" >
	                   	@include('panel.button.print_button')
					</div>
					<div class="col-xs-12 marg_b10" >
	                   	@include('panel.button.list_button',['controller'=>'Pz_documentsApprover@index'])
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
					@foreach ($pz_document->products as $product) 
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
					<div>{{ $pz_document->description }}</div>
				</div>
			</div>

			<!-- Podpis pod dokumentem -->
			<div class="row marg_t50 marg_b100">
				<div class="table-bordered col-sm-3 col-xs-5 text-center signature">
					<div>{{ $pz_document->user->name }} {{ $pz_document->user->surname }}</div>
					<div><strong> Wystawił: </strong></div>
				</div>

				<div class="table-bordered col-sm-offset-6 col-sm-3 col-xs-offset-2 col-xs-5 text-center signature always_hidden">
					<div> <br/></div>
					<div><strong> Odebrał: </strong></div>
				</div>
			</div>
		</div>	
	</div>
</div>	
@endsection
@extends('master')
	@section('title')
		{{$booking->doc_numb}}
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
				{{ $booking->created_at->format('d-m-Y') }}
				</div>
			</div>

			<div class="row">
				<div class="col-sm-11 text-center">
				 <strong><h3>Rezerwacja numer:	{{ $booking->doc_numb }} <i class="red_text">(Niezatwierdzona)</i></h3></strong>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6  col-xs-8 text-left">
					<div><strong>Odbiorca:</strong></div> 
				 	<div>{{ $booking->name_booked}}</div>
					<br/>
					<div><strong>Lokalizacja:</strong></div> 
				 	<div>{{ $booking->location->postcode}} {{ $booking->location->city}}</div>
				 	<div>ul. {{ $booking->location->street}} {{ $booking->location->street_number}}</div>
				 	<div>{{ $booking->location->country}}</div>
				</div>
				<div class="col-xs-4 col-sm-5 col-sm-offset-1 text-right">	
					<div class="col-xs-12 marg_b10" >
	                   	@include('panel.button.add_product_button',['controller'=>'BookingsController@edit', 'route'=>$booking->id, 'name' => 'Dodaj produkt'])
					</div>
					<div class="col-xs-12 marg_b10" >
	                   	@include('panel.button.document_list_button',['controller'=>'BookingsController@index'])
					</div>
					<div class="col-xs-12 marg_b10" >
	                   	@include('panel.button.approved_button',['controller'=>'BookingsApprover@edit', 'route'=>$booking->id])
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
						</tr>
					</thead>

					<?php $a = 1;?>
					@foreach ($booking->products as $product) 
						<tbody>
							<tr class="name">
								<td style="width:5%"><?php echo $a++;  ?></td>
						        <td style="width:30%">{{ $product->catalog_nr }}</td>
						        <td style="width:30%">{{ $product->product_name }}</td>
						        <td style="width:20%">{{ $product->pivot->quantity }}</td>
						        <td style="width:15%">{{ $product->unit }}</td>
							</tr>
						</tbody>
					@endforeach
				</table>
			</div>

			<!-- Uwagi-->
			<div class="row marg_t50">
				<div class="table-bordered col-sm-12 col-xs-12 text-left signature">
					<strong> Uwagi: </strong>
					<div>{{ $booking->description }}</div>
				</div>
			</div>

			<!-- Podpis pod dokumentem -->
			<div class="row marg_t50 marg_b100">
				<div class="table-bordered col-sm-3 col-xs-5 text-center signature">
					<div>{{ $booking->user->name }} {{ $booking->user->surname }}</div>
					<div><strong> Utworzył: </strong></div>
				</div>

				<div class="table-bordered col-sm-offset-6 col-sm-3 col-xs-offset-2 col-xs-5 text-center signature always_hidden">
					<div> <br/></div>
					<div><strong> Zatwierdził: </strong></div>
				</div>
			</div>
		</div>	
	</div>
</div>	
@endsection
@extends('master')
	@section('title')
		{{$transport->doc_numb}}
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
				{{ $transport->created_at->format('d-m-Y') }}
				</div>
			</div>

			<div class="row">
				<div class="col-sm-11 text-center">
				 <strong><h3>Transport numer:	{{ $transport->doc_numb }} @if($transport->accepted == 0)<i class="red_text">(Transport odrzucony)</i>@endif</h3></strong>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6  col-xs-8 text-left">
					<div><strong>Zwraca na magazyn:</strong></div> 
				 	<div>{{ $transport->employee->name_empl}} {{ $transport->employee->surname_empl}}</div>
				 	<div><i class="fa fa-phone-square" aria-hidden="true"> </i> {{ $transport->employee->telephone}}</div>
				 	<div><i class="fa fa-envelope" aria-hidden="true"> </i> {{ $transport->employee->email}}</div>
					<br/>
					<div><strong>Lokalizacja:</strong></div> 
				 	<div>{{ $transport->location->postcode}} {{ $transport->location->city}}</div>
				 	<div>ul. {{ $transport->location->street}} {{ $transport->location->street_number}}</div>
				 	<div>{{ $transport->location->country}}</div>
				</div>
				<div class="col-xs-4 col-sm-5 col-sm-offset-1 text-right">	
					<div class="col-xs-12 marg_b10" >
	                   	@include('panel.button.list_button',['controller'=>'Return_transportsMediator@index'])
					</div>
					<div class="col-xs-12 marg_b10" >
	                   	@include('panel.button.print_button')
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
					@foreach ($transport->products as $product) 
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
					<div>{{ $transport->description }}</div>
				</div>
			</div>

			<!-- Powód odmowy-->
			@if($transport->accepted == 0)
			<div class="row marg_t50">
				<div class="table-bordered col-sm-12 col-xs-12 text-left signature">
					<strong> Powód odrzucenia transportu: </strong>
					<div>{{ $transport->reason_refusal }}</div>
				</div>
			</div>
			@endif

			<!-- Podpis pod dokumentem -->
			<div class="row marg_t50 marg_b100">
				<div class="table-bordered col-sm-3 col-xs-4 text-center signature">
					<div>{{ $transport->user->name }} {{ $transport->user->surname }}</div>
					<div><strong> Utworzył: </strong></div>
				</div>

				<div class="table-bordered col-sm-4 col-sm-offset-1 col-xs-4 text-center signature">
					<div><strong>Kierowca: </strong> {{ $transport->driver }}</div>
					<div><strong>Pojazd: </strong> {{ $transport->vehicle }}</div>
				</div>

				<div class="table-bordered col-sm-offset-1 col-sm-3 col-xs-4 text-center signature">
					<div><div>{{ $transport->approved_by }}  <small>{{$transport->created_at->format('d-m-Y')}}</small> </div></div>
					<div><strong> Zatwierdził: </strong></div>
				</div>
			</div>
		</div>	
	</div>
</div>	
@endsection
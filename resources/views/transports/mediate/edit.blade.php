@extends('master')
	@section('title')
		Zatwierdź dokument
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">

			<!-- Formularz -->
			{!! Form::model($transport, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['Return_transportsMediator@update', $transport->id]]) !!}

				<!-- Pola formularza -->
			<div class="row">
				<div class="col-sm-11 text-center">
				 <strong><h3>Odpowiedź na dukument rezerwacji:	{{ $transport->doc_numb }}</h3></strong>
				</div>
			</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('accepted', 'Odpowiedź') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::select('accepted', ['1' => 'Potwierdzam', '0' => 'Odrzucam'], null, ['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('reason_refusal', 'Powód odmowy') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::textarea('reason_refusal', null ,['class'=> 'form-control', 'placeholder' => 'w przypadku odrzucenia rezerwacji wpisz powód odmowy']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('description', 'Uwagi') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::textarea('description', null ,['class'=> 'form-control', 'placeholder' => 'Dopisz ewentualne uwagi do dokumentu']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-2">
						{!! Form::label('approved_by', 'Nazwa potwierdzającego') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('approved_by', Auth::user()->name.' '.Auth::user()->surname ,['class'=> 'form-control']) !!}
					</div>
				</div>

				<!-- Przyciski-->
				<div class="form-group form-show control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.submit_button')
                   		@include('panel.button.undo_approved_button',['controller'=>'Return_transportsApprover@show', 'route'=>$transport->id])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
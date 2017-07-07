@extends('master')
	@section('title')
		Zatwierdź dokument
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">

			<!-- Formularz -->
			{!! Form::model($zw_document, [ 'method'=>'PATCH', 'class'=>'form-horizontal marg_b100', 'action'=>['Zw_documentsApprover@update', $zw_document->id]]) !!}

				<!-- Pola formularza -->
			<div class="row">
				<div class="col-sm-11 text-center">
				 <strong><h3>Czy na pewno chcesz zatwiedzić zwrot o numerze:	{{ $zw_document->doc_numb }}</h3></strong>
				</div>
			</div>
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-2">
						{!! Form::label('approved', 'Czy zatwierdzony?') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('approved', '1' ,['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label always_hidden">
					<div class="col-sm-2">
						{!! Form::label('user_id', 'Id użytkownika') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('user_id', Auth::user()->id ,['class'=> 'form-control']) !!}
					</div>
				</div>


				<!-- Przyciski-->
				<div class="form-group form-show control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.submit_button')
                   		@include('panel.button.undo_approved_button',['controller'=>'Zw_documentsController@show', 'route'=>$zw_document->id])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
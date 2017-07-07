@extends('master')
	@section('title')
		{{$contractor->name_contractor}}
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">

				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12">
						<!-- Widomość z sesji -->
			    		@if(Session::has('mes_contractor_update'))
			   				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_contractor_update') }}</div>
			    		@endif
					</div>
				</div>
			
				<!-- Formularz -->
			{!! Form::open(['class'=>'form-horizontal marg_b100']) !!}

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('country', 'Państwo') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('country', $contractor->country ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('nametag', 'Identyfikator') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('nametag', $contractor->nametag ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('name_contractor', 'Nazwa kontrahenta') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('name_contractor', $contractor->name_contractor ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('city', 'Miasto') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('city', $contractor->city ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('postcode', 'Kod pocztowy') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('postcode', $contractor->postcode ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('street', 'Ulica') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('street', $contractor->street ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('street_number', 'Numer budynku') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('street_number', $contractor->street_number ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('telephone', 'Telefon') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('telephone', $contractor->telephone ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('email', 'E-mail') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('email', $contractor->email ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('nip', 'NIP') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('nip', $contractor->nip ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('regon', 'REGON') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('regon', $contractor->regon ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('created_at', 'Data dodania') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('created_at', $contractor->created_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('updated_at', 'Ostatnia aktualizacja') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('updated_at', $contractor->updated_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('name', 'Autor') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('name', $contractor->user->name.' '.$contractor->user->surname,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('description', 'Opis') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::textarea('description', $contractor->description ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>

				<!-- Przyciski -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.edit_button',['controller'=>'ContractorsController@edit', 'route'=>$contractor->id])
                   		@include('panel.button.list_button',['controller'=>'ContractorsController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>	
</div>
@endsection
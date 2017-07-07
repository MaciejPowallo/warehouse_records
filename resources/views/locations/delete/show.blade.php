@extends('master')
	@section('title')
		{{$location->location_name}}
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">

			<!-- Formularz -->
			{!! Form::open(['class'=>'form-horizontal marg_b100']) !!}

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('location_name', 'Nazwa lokalizacji') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('location_name', $location->location_name ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('country', 'Państwo') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('country', $location->country ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('city', 'Miasto') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('city', $location->city ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('postcode', 'Kod pocztowy') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('postcode', $location->postcode ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('street', 'Ulica') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('street', $location->street ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('street_number', 'Numer budynku') !!}
					</div>		
					<div class="col-sm-4">
						{!! Form::text('street_number', $location->street_number ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('name', 'Imię i nazwisko autora') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::text('name', $location->user->name.' '.$location->user->surname,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('created_at', 'Data dodania') !!}
					</div>
					<div class="col-sm-4 marg_b10">
						{!! Form::text('created_at', $location->created_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
					<div class="col-sm-2">
						{!! Form::label('updated_at', 'Ostatnia aktualizacja') !!}
					</div>
					<div class="col-sm-4">
						{!! Form::text('updated_at', $location->updated_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-2">
						{!! Form::label('description', 'Opis') !!}
					</div>
					<div class="col-sm-10">
						{!! Form::textarea('description', $location->description ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>

				<!-- Przyciski -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.list_button',['controller'=>'LocationsDeleter@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>	
	</div>
</div>	
@endsection
@extends('master')
	@section('title')
		{{$type->name_type}}
	@endsection

@section('content')
<div class="content-position">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel-body">
			{!! Form::open(['class'=>'form-horizontal marg_b100']) !!}
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12">
						<!-- Widomość z sesji -->
			    		@if(Session::has('mes_type_update'))
			   				<div class="alert alert-success text-left"><i class="fa fa-check-square-o fa-2x" aria-hidden="true"></i>{{ Session::get('mes_type_update') }}</div>
			    		@endif
					</div>
				</div>

				<!-- Pola formularza -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('name_type', 'Nazwa') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::text('name_type', $type->name_type ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('description', 'Opis') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::textarea('description', $type->description ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('created_at', 'Dodano') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::text('created_at', $type->created_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-3">
						{!! Form::label('updated_at', 'Ostatnia aktualizacja') !!}
					</div>
					<div class="col-sm-9">
						{!! Form::text('updated_at', $type->updated_at ,['class'=> 'form-control', 'disabled']) !!}
					</div>
				</div>

				<!-- Przyciski -->
				<div class="form-group form-bottom-marg control-label">
					<div class="col-sm-12 text-center">
                   		@include('panel.button.edit_button',['controller'=>'TypesController@edit', 'route'=>$type->id])
                   		@include('panel.button.list_button',['controller'=>'TypesController@index'])
					</div>
				</div>
			{!! Form::close() !!}
		</div>	
	</div>
</div>	
@endsection
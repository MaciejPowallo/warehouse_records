<td>
	{!! Form::model($name, [ 'method'=>'DELETE', 'class'=>'form-horizontal', 'action'=>[$controller, $route]]) !!}

		{!! Form::button('<i class="fa fa-times-circle-o marg_r10" aria-hidden="true"></i><ins class="col_hidden">Usuń</ins>', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}

	{!! Form::close() !!}
</td>
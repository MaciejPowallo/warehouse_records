{!! Form::open(['method'=>'GET','url'=>$table,'class'=>'','role'=>'']) !!}
    <td>
	    <div class="input-group custom-search-form">

    		<input type="number" style="width:50%" name="search_quantity_down" class="form-control search" @if(isset($type1)) value="{{$type1}}" @endif placeholder="&#xF002; od " min="0" step="0.001">
	    	<input type="number" style="width:50%" name="search_quantity_up" class="form-control search" @if(isset($type2)) value="{{$type2}}" @endif placeholder="&#xF002; do " min="0.001" step="0.001">
	        <span class="input-group-btn ">
	        	<button type="submit" class="btn btn-default-sm button_search "><i class="fa fa-search fa-2x"></i></button>   
	        </span>
	    </div>
    </td>
{!! Form::close() !!}
{!! Form::open(['method'=>'GET','url'=>$table,'class'=>'','role'=>'']) !!}
    <td style="border:0">
    	<input type="text" name="search_name_empl" @if(isset($type1)) value="{{$type1}}" @endif class="form-control search" placeholder="&#xF002; imię ">
    </td>
    <td style="border:0">
	    <div class="input-group custom-search-form">
	    	<input type="text" name="search_surname_empl" @if(isset($type2)) value="{{$type2}}" @endif class="form-control search" placeholder="&#xF002; nazwisko ">
	        <span class="input-group-btn">
	        	<button type="submit" class="btn btn-default-sm button_search"><i class="fa fa-search fa-2x"></i></button>   
	        </span>
	    </div>
    </td>
{!! Form::close() !!}
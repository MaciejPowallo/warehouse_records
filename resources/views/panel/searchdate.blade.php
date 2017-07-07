{!! Form::open(['method'=>'GET','url'=>$table,'class'=>'','role'=>$name]) !!}
    <div class="input-group custom-search-form">
    	<input type="text" name="{{$name}}" @if(isset($type)) value="{{$type}}" @endif class="form-control search" placeholder="rrrr-mm-dd" >
        <span class="input-group-btn">
        	<button type="submit" class="btn btn-default-sm button_search">
            <i class="fa fa-search fa-2x"></i></button>   
        </span>
    </div>
{!! Form::close() !!}
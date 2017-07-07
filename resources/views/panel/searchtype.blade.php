{!! Form::open(['method'=>'GET','url'=>$table,'class'=>'','role'=>$name]) !!}
    <div class="input-group custom-search-form">


<select name="{{$name}}"  style="width:90px" class="form-control search" placeholder="&#xF002; ...">
  <option @if($type == 1) selected @endif value="1">RW</option>
  <option @if($type == 0) selected @endif value="0">WZ</option>
</select>
        <span class="input-group-btn">
        	<button type="submit" class="btn btn-default-sm button_search">
            <i class="fa fa-search fa-2x"></i></button>   
        </span>
    </div>
{!! Form::close() !!}
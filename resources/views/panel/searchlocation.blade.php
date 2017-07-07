{!! Form::open(['method'=>'GET','url'=>$table,'class'=>'','role'=>$name]) !!}
    <div class="input-group custom-search-form">

<div class="col-sm-6" style="padding: 0; ">
		{!! Form::select('locations', $location, $type1 ,['class'=> 'form-control', 'placeholder' => 'Wybierz lokalizację']) !!}
</div>

<div class="col-sm-3" style="padding: 0; ">
		{!! Form::text('search_catalog_nr',  $type2 ,['class'=> 'form-control', 'placeholder' => 'Podaj numer kat. produktu']) !!}
</div>
<div class="col-sm-3" style="padding: 0; ">
		{!! Form::text('search_product_name',  $type3 ,['class'=> 'form-control', 'placeholder' => 'Podaj nazwę produktu']) !!}
</div>

        <span class="input-group-btn" style="padding: 0; ">
        	<button type="submit" class="btn btn-default-sm button_search">
            <i class="fa fa-search fa-3x"></i></button>   
        </span>
    </div>
{!! Form::close() !!}